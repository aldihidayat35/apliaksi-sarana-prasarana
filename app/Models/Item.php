<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'code', 'name', 'category_id', 'location_id', 'condition',
        'quantity', 'acquisition_date', 'acquisition_source', 'price',
        'photo', 'description',
    ];

    protected function casts(): array
    {
        return [
            'acquisition_date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function registration()
    {
        return $this->hasOne(ItemRegistration::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function conditionReports()
    {
        return $this->hasMany(ConditionReport::class);
    }

    public function activeBorrowing()
    {
        return $this->hasOne(Borrowing::class)->where('status', 'dipinjam');
    }

    public function isAvailable(): bool
    {
        return !$this->activeBorrowing()->exists() && $this->condition !== 'hilang';
    }

    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'hilang' => 'Hilang',
            default => $this->condition,
        };
    }

    public function getConditionBadgeAttribute(): string
    {
        return match ($this->condition) {
            'baik' => 'success',
            'rusak_ringan' => 'warning',
            'rusak_berat' => 'danger',
            'hilang' => 'dark',
            default => 'secondary',
        };
    }
}
