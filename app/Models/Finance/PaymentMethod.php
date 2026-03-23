<?php

namespace App\Models\Finance;

use App\Concerns\HasFilter;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PaymentMethod extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'payment_methods';

    protected $casts = [
        'is_payment_gateway' => 'boolean',
        'config' => 'array',
        'meta' => 'array',
    ];

    public function getConfig(string $option, mixed $default = null)
    {
        return Arr::get($this->config, $option, $default);
    }

    public function scopeByTeam(Builder $query, $teamId = null)
    {
        $teamId = $teamId ?? session('team_id');

        $query->whereTeamId($teamId);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('payment_method')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
