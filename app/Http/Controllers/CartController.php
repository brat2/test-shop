<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    protected $user;
    public function __construct(Request $req)
    {
        if (!$req->user) return 'You need login';
        $this->user = User::find($req->user);
    }

    public function show($id = null)
    {
        if ($id == null && $this->user->cart()->count() == 0) return 'cart does not exist';
        $id = $id ?? $this->user->cart->id;
        return new CartResource(Cart::findOrFail($this->user->cart->id));
    }

    public function showAll()
    {
        return CartResource::collection(Cart::paginate(5));
    }

    public function add($id)
    {
        if ($this->user->cart()->count() == 0) {
            $cart = Cart::create(['user_id' => $this->user->id]);
            $cart->products()->attach($id, ['quantity' => 1]);
            return new CartResource(Cart::findOrFail($this->user->cart->id));
        }

        $cart = Cart::findOrFail($this->user->cart->id);
        $cart->touch();

        if ($cart->products->contains($id)) {
            $pivotRow = $cart->products()->where('product_id', $id)->first()->pivot;
            $quantity = $pivotRow->quantity + 1;
            $pivotRow->update(['quantity' => $quantity]);
        } else {
            $cart->products()->attach($id, ['quantity' => 1]);
        }
        return new CartResource(Cart::findOrFail($this->user->cart->id));
    }

    public function remove($id)
    {
        if ($this->user->cart()->count() != 0) {
            $cart = Cart::findOrFail($this->user->cart->id);

            if ($cart->products->contains($id)) {
                $pivotRow = $cart->products()->where('product_id', $id)->first()->pivot;

                if ($pivotRow->quantity > 0) {
                    $quantity = $pivotRow->quantity - 1;
                    $pivotRow->update(['quantity' => $quantity]);
                } else {
                    $cart->products()->detach($id);
                }
                $cart->touch();
            }
            return new CartResource(Cart::findOrFail($cart->id));
        }
    }
}
