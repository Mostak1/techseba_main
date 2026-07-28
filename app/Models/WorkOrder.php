<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'title',
        'description',
        'total_budget',
        'due_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(WorkOrderPayment::class);
    }

    // Helper to calculate total paid amount
    public function getPaidAmountAttribute()
    {
        return $this->payments()->where('status', 'confirmed')->sum('amount');
    }

    // Helper to update the due amount automatically
    public function updateDueAmount()
    {
        $totalPaid = $this->paid_amount;
        $this->due_amount = max(0, $this->total_budget - $totalPaid);
        $this->save();
    }
}
