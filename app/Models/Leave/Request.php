<?php

namespace App\Models\Leave;

use App\Casts\DateCast;
use App\Concerns\HasDatePeriod;
use App\Concerns\HasFilter;
use App\Concerns\HasMedia;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Contracts\Mediable;
use App\Enums\Leave\HalfDayShift;
use App\Enums\Leave\IsHalfDay;
use App\Enums\Leave\RequestStatus;
use App\Helpers\CalHelper;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Throwable;

class Request extends Model implements Mediable
{
    use HasFilter, HasUuid, HasMeta, HasMedia, HasDatePeriod, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'leave_requests';

    protected $casts = [
        'half_day_shift' => HalfDayShift::class,
        'is_half_day' => IsHalfDay::class,
        'status' => RequestStatus::class,
        'start_date' => DateCast::class,
        'end_date' => DateCast::class,
        'config' => 'array',
        'meta' => 'array',
    ];

    public function getModelName(): string
    {
        return 'LeaveRequest';
    }

    public function setHalfDayShiftAttribute($value)
    {
        if (empty($value)) {
            $value = HalfDayShift::NA->value;
        }
        try {
            $value = HalfDayShift::from($value)->value;
        } catch (Throwable) {
            $value = HalfDayShift::NA->value;
        }
        $this->attributes['half_day_shift'] = $value;
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'leave_type_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_id');
    }

    public function records(): HasMany
    {
        return $this->hasMany(RequestRecord::class, 'leave_request_id');
    }

    public function getPeriodAttribute()
    {
        return CalHelper::getPeriod($this->start_date->value, $this->end_date->value);
    }

    public function getDurationAttribute()
    {
        if (!$this->is_half_day?->positive()) {
            return CalHelper::getDuration($this->start_date->value, $this->end_date->value, 'day');
        }
        $duration = Carbon::parse($this->start_date->value)
                ->diffInDays(Carbon::parse($this->end_date->value)) + 1;

        return max($duration/2, 0).' '.trans('list.durations.days');
    }

    public function scopeByTeam(Builder $query)
    {
        $query->whereHas('employee', function ($q) {
            $q->byTeam();
        });
    }

    public function scopeFindByUuidOrFail(Builder $query, string $uuid)
    {
        return $query->whereUuid($uuid)
            ->with(['employee' => fn ($q) => $q->basic()])
            ->getOrFail(trans('leave.request.request'));
    }

    public function scopeFindDetailByUuidOrFail(Builder $query, string $uuid, $field = 'message')
    {
        return $query->whereUuid($uuid)
            ->addSelect([
                'comment' => RequestRecord::select('comment')
                    ->whereColumn('leave_request_id', 'leave_requests.id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1),
            ])
            ->with(['employee' => fn ($q) => $q->detail(), 'type', 'records'])
            ->getOrFail(trans('leave.request.request'), $field);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('leave_request')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
