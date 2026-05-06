<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->quantity * $item->product->price;
        }

        $appliedCoupon = null;
        $discount = 0;

        if ($couponId = session('applied_coupon_id')) {
            $appliedCoupon = Coupon::where('user_id', $userId)
                                    ->where('id', $couponId)
                                    ->first();

            if (!$appliedCoupon || $appliedCoupon->isExpired()) {
                session()->forget('applied_coupon_id');
                $appliedCoupon = null;
            } else {
                $discount = round($subtotal * $appliedCoupon->discount_percent / 100, 2);
                $discount = min($discount, $subtotal);
            }
        }

        $grandTotal = $subtotal - $discount;

        return view('cart.index', compact('cartItems', 'subtotal', 'discount', 'grandTotal', 'appliedCoupon'));
    }

    public function add($id)
    {
        $userId = Auth::id();

        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove($id)
    {
        Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('user_id', Auth::id())
                        ->where('code', strtoupper($request->code))
                        ->first();

        if (!$coupon) {
            return redirect()->route('cart.index')->with('error', 'Invalid coupon code.');
        }

        if ($coupon->isExpired()) {
            return redirect()->route('cart.index')->with('error', 'This coupon has expired.');
        }

        session(['applied_coupon_id' => $coupon->id]);

        return redirect()->route('cart.index')->with('success', "Coupon {$coupon->code} applied!");
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon_id');

        return redirect()->route('cart.index')->with('success', 'Coupon removed.');
    }
}
