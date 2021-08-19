<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->id,
            'title' => $this->title,
            'slug' =>  $this->slug,
            'cost' => $this->cost,
            'quantity' => $this->whenPivotLoaded('cart_product', function () {
            return $this->pivot->quantity;
        }),
        ];
    }
}
