<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'image',
        'product_name',
        'price',
        'stock'
    ];

    protected $guarded = ['id'];

    public function detailSale()
    {
        return $this->hasMany(DetailSale::class);
    }


}
