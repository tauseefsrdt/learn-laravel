<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .product-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .product-img {
            height: 220px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card .btn {
            border-radius: 8px;
        }
    </style>
</head>

<body>

    {{-- Header Component --}}
    <x-header />

    <div class="container mt-4">

        {{-- Success Message --}}
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Product Grid --}}
        <div class="row">
            @if ($products->isNotEmpty())
                @foreach ($products as $prod)
               @if($prod->status == 'Active')
    <div class="col-md-3 col-sm-6 mb-4">

        <div class="card product-card border-0 shadow-sm h-100">

            {{-- Image --}}
            <div class="product-img">
                @if (!empty($prod->image))
                    <img src="{{ asset('uploads/products/' . $prod->image) }}" alt="product">
                @else
                    <img src="https://placehold.co/400" alt="product">
                @endif
            </div>

            <div class="card-body text-center d-flex flex-column">

                {{-- Product Name --}}
                <h6 class="fw-semibold mb-1">
                    {{ $prod->name }}
                </h6>

                {{-- Price --}}
                <p class="text-dark fw-bold mb-3">
                    ₹{{ $prod->price }}
                </p>

                {{-- Add to Cart --}}
                <a href="{{ route('cart.add', $prod->id) }}" class="btn btn-dark btn-sm mt-auto">
                    Add to Cart
                </a>

            </div>

        </div>

    </div>
@endif
                   
                @endforeach
            @else
                <div class="col-12 text-center">
                    <h5>No Products Found</h5>
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>