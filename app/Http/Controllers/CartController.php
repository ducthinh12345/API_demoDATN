<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        $cart = $this->cartService->getCart();
        return response()->json(['message' => 'success', 'cart' => $cart], 200);
    }

    public function add(Request $request, $productId)
    {
        $cart = $this->cartService->addToCart($request, $productId);
        return response()->json(['message' => 'success'], 200);
    }

    public function remove($productId)
    {
        $cart = $this->cartService->deleteFromCart($productId);
        return response()->json(['message' => 'success'], 200);
    }

    public function update(Request $request, $productId)
    {
        $cart = $this->cartService->updateFromCart($request, $productId);
        return response()->json(['message' => 'success'], 200);
    }
}
