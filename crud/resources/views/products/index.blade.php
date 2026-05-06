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
    <x-header />
    <div class="container mt-2">
        <div class="row">
            <div class="d-flex justify-content-end">
                <a class="btn btn-dark" href="{{ route('products.create') }}">Create</a>
            </div>

            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ Session::get('erro') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card p-0 mt-2">
                <div class="card-header bg-dark text-white">
                    <h4>Products</h4>
                </div>
                <div class="card-body shadow-lg">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th width='100'>Status</th>
                                <th width='150' class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->isNotEmpty())
                                @foreach ($products as $prod)
                                    <tr>
                                        <td style="vertical-align: middle">{{ $prod->id }}</td>
                                        <td style="vertical-align: middle">
                                            @if (!empty($prod->image))
                                                <img class="rounded"
                                                    src="{{ asset('uploads/products/' . $prod->image) }}" alt="product"
                                                    width="50">
                                            @else
                                                <img class="rounded" src="https://placehold.co/400" alt="product"
                                                    width="50">
                                            @endif


                                        </td>
                                        <td style="vertical-align: middle">{{ $prod->name }}</td>
                                        <td style="vertical-align: middle">{{ $prod->sku }}</td>
                                        <td style="vertical-align: middle">{{ $prod->price }}</td>
                                        <td style="vertical-align: middle">
                                            @if ($prod->status == 'Active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <a class="btn btn-dark"
                                                href="{{ route('products.edit', $prod->id) }}">Edit</a>
                                            <form action="{{ route('products.destroy', $prod->id) }}"
                                                class="d-inline-block" method="POST" enctype="multipart/form-data"
                                                onsubmit="return confirm('Are you sure want to Delete?')"
                                                >

                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else()
                                <tr>
                                    <td colspan="7" class="text-center">No Products Found</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
