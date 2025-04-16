<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'phone'
    ];

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

}
