<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comments;


class Searched_websites extends Model
{
    use HasFactory;


    public function comments()
    {
        return $this->hasMany(Comments::class, 'website_id', 'id');
    }

    protected $fillable = [
        'name',
        'domain',
        'data',
        'search_times',
        'first_searched_by',
        'first_searched_by_date',
        'last_searched_by',
        'last_searched_by_date',
        'points',
    ];
}