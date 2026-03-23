<?php

namespace App\Services\Employee;

use App\Enums\OptionType;
use App\Http\Resources\OptionResource;
use App\Models\Contact;
use App\Models\Employee\Employee;
use App\Models\Option;
use App\Models\Qualification;
use Illuminate\Http\Request;

class QualificationService
{
    public function preRequisite(Request $request): array
    {
        $levels = OptionResource::collection(Option::query()
            ->byTeam()
            ->whereType(OptionType::QUALIFICATION_LEVEL->value)
            ->get());

        return compact('levels');
    }

    public function findByUuidOrFail(Employee $employee, string $uuid): Qualification
    {
        return Qualification::query()
            ->whereHasMorph(
                'model',
                [Contact::class],
                function ($q) use ($employee) {
                    $q->whereId($employee->contact_id);
                }
            )
            ->whereUuid($uuid)
            ->getOrFail(trans('employee.qualification.qualification'));
    }

    public function create(Request $request, Employee $employee): Qualification
    {
        \DB::beginTransaction();

        $qualification = Qualification::forceCreate($this->formatParams($request, $employee));

        $employee->contact->qualifications()->save($qualification);

        $qualification->addMedia($request);

        \DB::commit();

        return $qualification;
    }

    private function formatParams(Request $request, Employee $employee, Qualification $qualification = null): array
    {
        $formatted = [
            'level_id' => $request->level_id,
            'course' => $request->course,
            'institute' => $request->institute,
            'affiliated_to' => $request->affiliated_to,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'result' => $request->result,
        ];

        if (! $qualification) {
            //
        }

        return $formatted;
    }

    public function update(Request $request, Employee $employee, Qualification $qualification): void
    {
        \DB::beginTransaction();

        $qualification->forceFill($this->formatParams($request, $employee, $qualification))->save();

        $qualification->updateMedia($request);

        \DB::commit();
    }

    public function deletable(Employee $employee, Qualification $qualification): void
    {
        //
    }
}
