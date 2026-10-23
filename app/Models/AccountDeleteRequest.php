<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDeleteRequest extends Model
{
    use HasFactory;

    protected $table = 'account_delete_requests';

    protected $fillable = [
        'user_id',
        'reason',
        'status',
        'action_type',
        'admin_remark',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
