<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    public function user_made_by()
    {
        return $this->belongsTo(User::class, 'changes_made_by');
    }
    public function user_made_to()
    {
        return $this->belongsTo(User::class, 'changes_made_to');
    }

    protected $fillable = [
        'action',
        'data',
        'changes_made_by',
        'changes_made_to',
    ];
}
