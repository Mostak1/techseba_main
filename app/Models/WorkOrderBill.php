<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'bill_number',
        'bill_type',
        'title',
        'amount',
        'due_date',
        'status',
        'payment_method',
        'transaction_id',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'payment_date' => 'datetime',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
