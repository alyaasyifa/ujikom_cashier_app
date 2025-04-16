<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'points_earned',
        'points_used',
        'total_price',
        'amount_paid',
        'change',
        'sale_date',
        'user_id',
        'member_id',
        'sales_product',
        'final_price_member'
    ];


    public function detailSale()
    {
        return $this->hasMany(DetailSale::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
