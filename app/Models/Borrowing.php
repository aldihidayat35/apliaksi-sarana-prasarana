<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'item_id', 'user_id', 'borrow_date', 'expected_return_date',
        'actual_return_date', 'return_condition', 'return_notes', 'status',
        'purpose', 'notes', 'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'expected_return_date' => 'date',
            'actual_return_date' => 'date',
        ];
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'dipinjam' => 'Dipinjam',
            'dikembalikan' => 'Dikembalikan',
            'terlambat' => 'Terlambat',
            default => $this->status,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'dipinjam' => 'primary',
            'dikembalikan' => 'success',
            'terlambat' => 'danger',
            default => 'secondary',
        };
    }

    public function getReturnConditionLabelAttribute(): ?string
    {
        if (!$this->return_condition) {
            return null;
        }

        return match ($this->return_condition) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'hilang' => 'Hilang',
            default => $this->return_condition,
        };
    }
}
