<?php

namespace App\Models\Attendance;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Enums\Attendance\Category as AttendanceCategory;
use App\Enums\Attendance\ProductionUnit as AttendanceProductionUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Type extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'attendance_types';

    protected $casts = [
        'category' => AttendanceCategory::class,
        'unit' => AttendanceProductionUnit::class,
        'meta' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeByTeam(Builder $query)
    {
        $query->whereTeamId(session('team_id'));
    }

    public function scopeDirect(Builder $query)
    {
        $query->whereNotIn('category', AttendanceCategory::productionBased());
    }

    public function scopeProductionBased(Builder $query)
    {
        $query->whereIn('category', AttendanceCategory::productionBased());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('attendance_type')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
