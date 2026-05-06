<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class MyCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where('user_id', Auth::id())->latest()->get();
        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        return view('my-coupon.index',compact('coupons', 'users'));
    }
}
