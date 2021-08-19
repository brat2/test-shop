<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    protected $user_id = 3;
    protected $cart_id;
    public function __construct()
    {
        $this->cart_id = User::find($this->user_id)->cart->id;
    }

    public function show($id = null)
    {
        $id = $id ?? $this->cart_id;
        return new CartResource(Cart::findOrFail($id));
    }

    public function showAll()
    {
        return CartResource::collection(Cart::paginate(5));
        $carts = Cart::all();
        foreach ($carts as $cart) {
            $res[] = $cart;
        }
        return $res;
    }

    public function add($id)
    {
        $user = User::find($this->user_id);
        if (!$this->cart_id) {
            $cart =  Cart::create(['user_id' => $this->user_id]);
            $cart->products()->attach($id, ['quantity' => 1]);
            return $cart->products;
        }

        $cart = Cart::findOrFail($this->cart_id);
        // обновляем поле `updated_at` таблицы `baskets`
        $cart->touch();

        if ($cart->products->contains($id)) {
            // если такой товар есть в корзине — изменяем кол-во
            $pivotRow = $cart->products()->where('product_id', $id)->first()->pivot;
            $quantity = $pivotRow->quantity + 1;
            $pivotRow->update(['quantity' => $quantity]);
        } else {
            // если такого товара нет в корзине — добавляем его
            $cart->products()->attach($id, ['quantity' => 1]);
        }
        return $cart->products;
    }

    public function remove()
    {
        # code...
    }
}
