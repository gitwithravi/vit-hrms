<?php

namespace App\Models\Payroll;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Enums\Payroll\PayHeadCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PayHead extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'pay_heads';

    protected $casts = [
        'category' => PayHeadCategory::class,
        'config' => 'array',
        'meta' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeByTeam(Builder $query)
    {
        $teamId = $teamId ?? session('team_id');

        $query->whereTeamId($teamId);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('pay_head')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
