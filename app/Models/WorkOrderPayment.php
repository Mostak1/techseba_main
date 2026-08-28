<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'amount',
        'payment_method',
        'transaction_id',
        'payment_date',
        'status',
        'notes',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
