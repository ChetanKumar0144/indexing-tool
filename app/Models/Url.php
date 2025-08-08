<?php

// app/Models/Url.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['website_id', 'path', 'status', 'response', 'indexed_at'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
