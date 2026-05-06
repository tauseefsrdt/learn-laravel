<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where('user_id', Auth::id())->latest()->get();
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return view('coupon.index', compact('coupons', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->where('user_id', $request->user_id),
            ],
            'discount_percent' => 'required|integer|min:1|max:100',
            'expires_at' => 'nullable|date|after:today',
        ]);

        Coupon::create([
            'user_id' => $data['user_id'],
            'code' => strtoupper($data['code']),
            'discount_percent' => $data['discount_percent'],
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        return redirect()->route('coupon.index')->with('success', 'Coupon created for the selected user!');
    }

    public function destroy($id)
    {
        Coupon::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return redirect()->route('coupon.index')->with('success', 'Coupon deleted!');
    }
}
