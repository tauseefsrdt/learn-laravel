<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    {{-- Header Component --}}
    <x-header />

    <div class="container mt-4">

        <h3 class="mb-4">My Cart</h3>

        {{-- Success Message --}}
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Error Message --}}
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($cartItems->isNotEmpty())

            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                @php $lineTotal = $item->quantity * $item->product->price; @endphp
                                <tr>
                                    <td>
                                        @if (!empty($item->product->image))
                                            <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                 alt="product" class="cart-img">
                                        @else
                                            <img src="https://placehold.co/80" alt="product" class="cart-img">
                                        @endif
                                    </td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>₹{{ $item->product->price }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="fw-semibold">₹{{ number_format($lineTotal, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Remove this item from cart?');" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end">Subtotal</td>
                                <td>₹{{ number_format($subtotal, 2) }}</td>
                                <td></td>
                            </tr>
                            @if ($appliedCoupon)
                                <tr>
                                    <td colspan="4" class="text-end text-success">
                                        Discount ({{ $appliedCoupon->code }} — {{ $appliedCoupon->discount_percent }}%)
                                    </td>
                                    <td class="text-success">−₹{{ number_format($discount, 2) }}</td>
                                    <td></td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Grand Total</td>
                                <td class="fw-bold">₹{{ number_format($grandTotal, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Coupon section --}}
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body">
                    @if ($appliedCoupon)
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold text-success">
                                    Coupon "{{ $appliedCoupon->code }}" applied
                                </span>
                                <span class="text-muted ms-2">
                                    ({{ $appliedCoupon->discount_percent }}% off)
                                </span>
                            </div>
                            <form action="{{ route('cart.removeCoupon') }}" method="POST" class="mb-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Remove Coupon</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.applyCoupon') }}" method="POST"
                              class="row g-2 align-items-center mb-0">
                            @csrf
                            <div class="col-auto">
                                <label class="form-label mb-0 fw-semibold">Have a coupon?</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="code" class="form-control"
                                       placeholder="Enter coupon code" required>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-dark">Apply</button>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('coupon.index') }}" class="text-decoration-none">
                                    Manage my coupons
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

        @else
            <div class="text-center py-5">
                <h5 class="text-muted">Your cart is empty</h5>
                <a href="{{ route('home.index') }}" class="btn btn-dark mt-3">Continue Shopping</a>
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
