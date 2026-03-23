<?php

namespace App\Models;

use App\Casts\DateCast;
use App\Concerns\HasFilter;
use App\Concerns\HasMedia;
use App\Concerns\HasMeta;
use App\Concerns\HasUuid;
use App\Helpers\CalHelper;
use App\Models\Option;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Document extends Model
{
    use HasFactory, HasFilter, HasUuid, HasMeta, HasMedia, LogsActivity;

    protected $guarded = [];

    protected $primaryKey = 'id';

    protected $table = 'documents';

    protected $casts = [
        'start_date' => DateCast::class,
        'end_date' => DateCast::class,
        'meta' => 'array',
    ];

    public function getModelName(): string
    {
        return 'Document';
    }

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'type_id');
    }

    public function getPeriodAttribute(): string
    {
        return CalHelper::getPeriod($this->start_date->value, $this->end_date->value);
    }

    public function getDurationAttribute(): string
    {
        return CalHelper::getDuration($this->start_date->value, $this->end_date->value, 'day');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('document')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
