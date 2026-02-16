<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="bg-dark  d-flex justify-content-center text-white py-3">
        <h1>Laravel Crud 12</h1>
    </div>
    <div class="container mt-2">
        <div class="row">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark" href="{{ route('products.index') }}">Back</a>
            </div>
            <div class="card p-0 mt-2">
                <div class="card-header bg-dark text-white">
                    <h4>Edit Product</h4>
                </div>
                <div class="card-body shadow-lg">
                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" id="name" value="{{ old('name', $product->name) }}"
                                placeholder="Name">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image" id="image">

                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @if (!empty($product->image))
                            <img class="rounded mb-2" src="{{ asset('uploads/products/' . $product->image) }}"
                                alt="product" width="150">
                        @endif
                        {{-- SKU --}}
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku"
                                id="sku" value="{{ old('sku', $product->sku) }}" placeholder="SKU">

                            @error('sku')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror"
                                name="price" id="price" value="{{ old('price', $product->price) }}"
                                placeholder="Price">

                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status"
                                class="form-select @error('status') is-invalid @enderror">

                                <option {{ $product->status === 'Active' ? 'selected' : '' }} value="Active"
                                    {{ old('status') == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option {{ $product->status === 'Inactive' ? 'selected' : '' }} value="Inactive"
                                    {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-dark">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
