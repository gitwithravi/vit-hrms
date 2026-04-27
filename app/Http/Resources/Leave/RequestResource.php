<?php

namespace App\Http\Resources\Leave;

use App\Enums\Leave\IsHalfDay;
use App\Enums\Leave\RequestStatus;
use App\Http\Resources\Employee\EmployeeSummaryResource;
use App\Http\Resources\Leave\TypeResource as LeaveTypeResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\UserSummaryResource;
use Cal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'employee' => EmployeeSummaryResource::make($this->whenLoaded('employee')),
            'leave_type' => LeaveTypeResource::make($this->whenLoaded('type')),
            'requester' => UserSummaryResource::make($this->whenLoaded('requester')),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_half_day' => IsHalfDay::getLabel($this->is_half_day?->value),
            'half_day_shift' => $this->half_day_shift,
            'period' => $this->period,
            'duration' => $this->duration,
            'reason' => $this->reason,
            'alternate_arrangement' => $this->alternate_arrangement,
            'comment' => $this->comment,
            'status' => RequestStatus::getDetail($this->status),
            'can_withdraw' => auth()->check()
                && auth()->id() == $this->employee?->user_id
                && in_array($this->status, [RequestStatus::REQUESTED, RequestStatus::APPROVED])
                && $this->start_date->value > today()->toDateString(),
            'records' => RequestRecordResource::collection($this->whenLoaded('records')),
            'media_token' => $this->getMeta('media_token'),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'created_at' => Cal::dateTime($this->created_at),
            'updated_at' => Cal::dateTime($this->updated_at),
        ];
    }
}
