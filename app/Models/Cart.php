<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];
    protected $with = ['products'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot('quantity');
    }
}
