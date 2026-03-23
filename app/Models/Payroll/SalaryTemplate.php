<?php

namespace App\Models\Payroll;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SalaryTemplate extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'salary_templates';

    protected $casts = [
        'config' => 'array',
        'meta' => 'array',
    ];

    public function records(): HasMany
    {
        return $this->hasMany(SalaryTemplateRecord::class, 'salary_template_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function structures(): HasMany
    {
        return $this->hasMany(SalaryStructure::class, 'salary_template_id');
    }

    public function scopeByTeam(Builder $query)
    {
        $teamId = $teamId ?? session('team_id');

        $query->whereTeamId($teamId);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('salary_template')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
