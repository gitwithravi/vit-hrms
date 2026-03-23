<?php

namespace App\Http\Resources\Payroll;

use App\Enums\Payroll\PayHeadType;
use App\Http\Resources\Employee\EmployeeSummaryResource;
use App\Support\Evaluator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class SalaryStructureResource extends JsonResource
{
    use Evaluator;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'employee' => EmployeeSummaryResource::make($this->whenLoaded('employee')),
            'effective_date' => $this->effective_date,
            'template' => SalaryTemplateResource::make($this->whenLoaded('template')),
            $this->mergeWhen($this->relationLoaded('records'), [
                'records' => $this->getRecords($request),
            ]),
            'net_earning' => $this->net_earning,
            'net_deduction' => $this->net_deduction,
            'net_salary' => $this->net_salary,
            'description' => $this->description,
            'created_at' => \Cal::dateTime($this->created_at),
            'updated_at' => \Cal::dateTime($this->updated_at),
        ];
    }

    private function getRecords($request)
    {
        if (! $request->show_record) {
            return [];
        }

        $salaryTemplate = $this->template;

        $payHeads = [];

        foreach ($this->records as $record) {
            $code = $salaryTemplate->records->firstWhere('pay_head_id', $record->pay_head_id)?->payHead?->code;
            $payHeads[$code] = $record->amount->value;
        }

        $records = [];
        foreach ($salaryTemplate->records as $record) {
            $payHead = $record->payHead;

            if (in_array($record->type->value, PayHeadType::userInput())) {
                $amount = Arr::get($payHeads, $payHead->code, 0);
            } elseif ($record->type->value == PayHeadType::COMPUTATION->value) {
                $computation = $record->computation;
                foreach ($payHeads as $code => $value) {
                    $computation = str_replace('#'.$code.'#', $value, $computation);
                }

                $evaluation = $this->evaluate($computation);

                if ($evaluation === 'invalid') {
                    throw ValidationException::withMessages(['message' => trans('payroll.salary_template.invalid_computation')]);
                }

                $payHeads[$record->payHead->code] = $evaluation;

                $amount = $evaluation;
            } else {
                $amount = '-';
            }

            $records[] = [
                'uuid' => $record->uuid,
                'pay_head' => [
                    'uuid' => $payHead->uuid,
                    'name' => $payHead->name,
                    'code' => $payHead->code,
                    'category' => $payHead->category,
                ],
                'enable_user_input' => $record->enable_user_input,
                'type' => $record->type,
                'computation' => $record->computation,
                'amount' => \Price::from($amount),
            ];
        }

        return $records;
    }
}
