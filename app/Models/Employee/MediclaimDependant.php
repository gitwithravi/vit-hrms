<?php

namespace App\Models\Employee;

use App\Concerns\HasFilter;
use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MediclaimDependant extends Model
{
    use HasFilter, HasUuid, LogsActivity;

    protected $guarded = [];

    const RELATIONSHIPS = [
        'husband' => 'Husband',
        'wife' => 'Wife',
        'son' => 'Son',
        'daughter' => 'Daughter',
        'father' => 'Father',
        'mother' => 'Mother',
        'father_in_law' => 'Father-in-law',
        'mother_in_law' => 'Mother-in-law',
    ];

    const TOP_UP_OPTIONS = [
        '1_lac' => '1 Lac - 4305 + GST',
        '2_lac' => '2 Lac - 4735 + GST',
        '3_lac' => '3 Lac - 5535 + GST',
        '4_lac' => '4 Lac - 6765 + GST',
        '5_lac' => '5 Lac - 7990 + GST',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getRelationshipLabelAttribute(): string
    {
        return Arr::get(self::RELATIONSHIPS, $this->relationship, $this->relationship);
    }

    public function getTopUpLabelAttribute(): string
    {
        return Arr::get(self::TOP_UP_OPTIONS, $this->top_up, $this->top_up);
    }

    public static function relationshipOptions(): array
    {
        return collect(self::RELATIONSHIPS)
            ->map(fn ($label, $value) => compact('label', 'value'))
            ->values()
            ->all();
    }

    public static function topUpOptions(): array
    {
        return collect(self::TOP_UP_OPTIONS)
            ->map(fn ($label, $value) => compact('label', 'value'))
            ->values()
            ->all();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('mediclaim_dependant')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
