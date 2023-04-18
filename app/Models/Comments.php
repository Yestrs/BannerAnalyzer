<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    public function user_id()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function website_id()
    {
        return $this->belongsTo(Searched_websites::class, 'website_id');
    }

    protected $fillable = [
        'comment',
        'stars',
        'user_id',
        'website_id',
    ];
}
