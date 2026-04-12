<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConditionReport extends Model
{
    protected $fillable = [
        'item_id', 'reported_by', 'condition_before', 'condition_after',
        'description', 'photo', 'report_date',
    ];

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
        ];
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function reportedByUser()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
