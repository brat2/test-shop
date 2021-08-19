<?php

namespace App\Http\Resources;

use App\Http\Controllers\Discount;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       return [
        'cart_id' => $this->id,
        'positions' => $this->products()->count(),
        'quantity' => Discount::getDiscount($this)['quantity'],
        'discount' => Discount::getDiscount($this)['discount'],
        'products' => ProductResource::collection($this->products),

    ];
    }
}
