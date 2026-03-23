<?php

namespace App\Models\Company;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'departments';

    protected $casts = [
        'config' => 'array',
        'meta' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeByTeam(Builder $query, int $teamId = null)
    {
        $teamId = $teamId ?? session('team_id');

        $query->whereTeamId($teamId);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('department')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
