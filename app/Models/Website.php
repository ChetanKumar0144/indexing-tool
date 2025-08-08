<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = ['user_id', 'domain', 'service_account_file'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function urls()
    {
        return $this->hasMany(Url::class);
    }

}
