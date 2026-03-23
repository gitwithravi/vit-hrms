<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class TransactionPaymentResource extends JsonResource
{
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
            'amount' => $this->amount,
            'ledger_name' => $this->ledger_name,
            'ledger_uuid' => $this->ledger_uuid,
            'ledger' => LedgerResource::make($this->whenLoaded('ledger')),
            $this->mergeWhen($this->relationLoaded('method'), [
                'method_uuid' => $this->method->uuid,
                'method_name' => $this->method->name,
                'has_instrument_number' => $this->method->getConfig('has_instrument_number'),
                'has_instrument_date' => $this->method->getConfig('has_instrument_date'),
                'has_clearing_date' => $this->method->getConfig('has_clearing_date'),
                'has_bank_detail' => $this->method->getConfig('has_bank_detail'),
                'has_reference_number' => $this->method->getConfig('has_reference_number'),
                'instrument_number' => Arr::get($this->details, 'instrument_number'),
                'instrument_date' => \Cal::date(Arr::get($this->details, 'instrument_date')),
                'clearing_date' => \Cal::date(Arr::get($this->details, 'clearing_date')),
                'bank_detail' => Arr::get($this->details, 'bank_detail'),
                'reference_number' => Arr::get($this->details, 'reference_number'),
            ]),
            'description' => $this->description,
            'created_at' => \Cal::dateTime($this->created_at),
            'updated_at' => \Cal::dateTime($this->updated_at),
        ];
    }
}
