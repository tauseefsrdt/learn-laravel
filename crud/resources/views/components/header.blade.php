@php
    use App\Models\Cart;
    use Illuminate\Support\Facades\Auth;

    $cartCount = Auth::check()
        ? (int) Cart::where('user_id', Auth::id())->sum('quantity')
        : 0;
@endphp

<div class="bg-dark d-flex justify-content-between align-items-center text-white py-3 px-4">
    
    <a href="{{ url('/') }}" class="text-white text-decoration-none">
        <h1 class="mb-0">Laravel Crud 12</h1>
    </a>

    @auth
        <div class="d-flex align-items-center gap-3">

            <span>{{ auth()->user()->name }}</span>

            <a href="{{ url('/products') }}" class="btn btn-light btn-sm">
                All Products
            </a>

            <a href="{{ route('my-coupon.index') }}" class="btn btn-light btn-sm">
                My Coupons
            </a>

            {{-- Cart Icon --}}
            <a href="{{ route('cart.index') }}" class="position-relative text-white text-decoration-none fs-5">
                🛒

                @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            {{-- Logout --}}
            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>

        </div>
    @endauth

</div>