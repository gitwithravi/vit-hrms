<?php

namespace App\Models\Calendar;

use App\Casts\DateCast;
use App\Concerns\HasDatePeriod;
use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Helpers\CalHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Holiday extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, HasDatePeriod, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'holidays';

    protected $casts = [
        'start_date' => DateCast::class,
        'end_date' => DateCast::class,
        'meta' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeByTeam(Builder $query, $teamId = null)
    {
        $teamId = $teamId ?? session('team_id');

        $query->whereTeamId($teamId);
    }

    public function getDurationAttribute(): string
    {
        return CalHelper::getDuration($this->start_date->value, $this->end_date->value, 'day');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('holiday')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
