<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Coupons</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <x-header />

    <div class="container mt-4">

        <h3 class="mb-4">My Coupons</h3>

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">

            {{-- Create form --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-3">Create Coupon</h5>

                        <form action="{{ route('coupon.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">For User</label>
                                <select name="user_id"
                                        class="form-select @error('user_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Select user --</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}"
                                            {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                            {{ $u->name }} ({{ $u->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" value="{{ old('code') }}"
                                       class="form-control @error('code') is-invalid @enderror"
                                       placeholder="e.g. SUMMER20" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Discount (%)</label>
                                <input type="number" name="discount_percent" min="1" max="100"
                                       value="{{ old('discount_percent') }}"
                                       class="form-control @error('discount_percent') is-invalid @enderror"
                                       required>
                                @error('discount_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Expires On <small class="text-muted">(optional)</small></label>
                                <input type="date" name="expires_at" value="{{ old('expires_at') }}"
                                       class="form-control @error('expires_at') is-invalid @enderror">
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-dark w-100">Create Coupon</button>
                        </form>
                    </div>
                </div>
            </div>

          

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
