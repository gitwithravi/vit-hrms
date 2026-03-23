<?php

namespace App\Models;

use App\Concerns\HasConfig;
use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, HasConfig, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'teams';

    protected $casts = [
        'config' => 'array',
        'meta' => 'array',
    ];

    public function scopeAllowedTeams(Builder $query)
    {
        if (\Auth::check()) {
            $query->when(! \Auth::user()->is_default, function ($q) {
                $q->whereIn('id', config('config.teams', []));
            });
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('team')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
