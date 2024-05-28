<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart()
    {
        if (auth()->check()) {
            // Nếu user đã đăng nhập, sử dụng giỏ hàng từ database
            $userId = auth()->id();
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
        } else {
            // Nếu user chưa đăng nhập, sử dụng giỏ hàng từ session
            $sessionId = Session::getId();
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }
        return $cart;
    }

    public function addToCart($request, $productId)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        $cartDetail = $cart->details()->where('product_id', $productId)->first();

        if ($cartDetail) {
            $cartDetail->quantity += 1;
        } else {
            $cartDetail = new CartDetail();
            $cartDetail->product_id = $productId;
            $cartDetail->quantity = 1;
            $cart->details()->save($cartDetail);
        }

        $cartDetail->save();

        return true;
    }
    public function deleteFromCart($productId)
    {
        $cart = $this->getCart();

        $cartDetail = $cart->details()->where('product_id', $productId)->first();

        if ($cartDetail) {
            $cartDetail->delete();
        }
        return true;
    }
    public function updateFromCart($request, $productId)
    {
        $cart = $this->getCart();

        $cartDetail = $cart->details()->where('product_id', $productId)->first();

        if ($cartDetail) {
            $cartDetail->quantity = $request->quantity;
            $cartDetail->save();
        }

        return true;
    }
}
