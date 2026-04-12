<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRegistration extends Model
{
    protected $fillable = [
        'item_id', 'unique_id', 'qr_code_path', 'registered_by',
        'registered_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'registered_at' => 'datetime',
        ];
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function registeredByUser()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}
