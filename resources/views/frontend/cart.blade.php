@php
    $cart = session()->get('cart', []);
    $qty = array_sum(array_column($cart, 'qty'));
@endphp

@php
    $total_price = 0;
@endphp

@foreach ($cart as $id => $data)
    @php
        $total_price += $data['price'] * $data['qty'];
    @endphp
@endforeach

@extends('frontend.layout')
@section('frontend_title', 'Shopping Cart')
@section('frontend_content')
    <!-- Page Header -->
    <section class="bg-secondary">
        <div class="container">
            <div class="d-flex align-items-center py-3 px-1">
                <p class="m-0"><a href="{{ route('frontend.home') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </section>

    <!-- Cart -->
    <section id="cart_list">
        <div class="container pt-5">


            @if (count($cart) > 0)
                <div class="row">

                    {{-- Cart Table --}}
                    <div class="col-lg-8 table-responsive mb-5">
                        <table class="table table-bordered text-center mb-0">
                            <thead class="bg-secondary text-dark">
                                <tr>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach ($cart as $id => $data)
                                    <tr>
                                        {{-- Product Info --}}
                                        <td class="align-middle">
                                            <div class="row align-items-center">
                                                <div class="col-4">
                                                    @if ($data['image'])
                                                        <img style="width:70px; height:70px; object-fit:cover; border-radius:6px;"
                                                            src="{{ asset($data['image']) }}"
                                                            alt="{{ $data['name'] }}">
                                                    @else
                                                        <img style="width:70px; height:70px; object-fit:cover; border-radius:6px;"
                                                            src="{{ asset('assets/img/no-image.png') }}" alt="No Image">
                                                    @endif
                                                </div>
                                                <div class="col-8 p-0 text-left">
                                                    <h6 class="mb-1">{{ Str::limit($data['name'], 28) }}</h6>
                                                    @if (!empty($data['variant_name']))
                                                        <small class="text-muted">Variant:
                                                            {{ $data['variant_name'] }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Price --}}
                                        <td class="align-middle">৳ {{ number_format($data['price'], 2) }}</td>

                                        {{-- Quantity --}}
                                        <td class="align-middle">
                                            <div class="input-group quantity mx-auto" style="width:100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-primary btn-minus"
                                                        onclick="updateQty('{{ $id }}', -1)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" id="qty_{{ $id }}"
                                                    class="form-control form-control-sm bg-secondary text-center"
                                                    value="{{ $data['qty'] }}" readonly>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-primary btn-plus"
                                                        onclick="updateQty('{{ $id }}', 1)">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Total --}}
                                        <td class="align-middle" id="total_{{ $id }}"
                                            data-price="{{ $data['price'] }}">
                                            ৳ {{ number_format($data['price'] * $data['qty'], 2) }}
                                        </td>

                                        {{-- Remove --}}
                                        <td class="align-middle">
                                            <a href="{{ route('frontend.remove.cart', $id) }}"
                                                class="btn btn-sm btn-danger" onclick="return confirm('Remove this item?')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Cart Summary --}}
                    <div class="col-lg-4">
                        <div class="card border-secondary mb-5">
                            <div class="card-header bg-secondary border-0">
                                <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3 pt-1">
                                    <h6 class="font-weight-medium">Subtotal</h6>
                                    <h6 class="font-weight-medium" id="cartSubtotal">
                                        ৳ {{ number_format($total_price, 2) }}
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-medium">Shipping</h6>
                                    <h6 class="font-weight-medium">৳ 0.00</h6>
                                </div>
                            </div>
                            <div class="card-footer border-secondary bg-transparent">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5 class="font-weight-bold">Total</h5>
                                    <h5 class="font-weight-bold" id="cartTotal">
                                        ৳ {{ number_format($total_price, 2) }}
                                    </h5>
                                </div>
                                <a href="{{ route('frontend.checkout') }}" class="btn btn-block btn-primary my-3 py-3">
                                    Proceed To Checkout
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                {{-- Cart Empty --}}
                <div class="text-center py-5">
                    <i class="fa fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Your cart is empty!</h4>
                    <a href="{{ route('frontend.home') }}" class="btn btn-primary mt-3">
                        Continue Shopping
                    </a>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('frontend_js')
    <script>
        function updateQty(cartKey, change) {
            const input = document.getElementById('qty_' + cartKey);
            const newQty = Math.max(1, parseInt(input.value) + change);
            input.value = newQty;

            // ── Row total সাথে সাথে update ────────────────
            const totalCell = document.getElementById('total_' + cartKey);
            const price = parseFloat(totalCell.dataset.price);
            totalCell.textContent = '৳ ' + (price * newQty).toFixed(2);

            // ── Cart Summary update ────────────────────────
            let subtotal = 0;
            document.querySelectorAll('[id^="total_"]').forEach(cell => {
                const cellPrice = parseFloat(cell.dataset.price);
                const cellQty = parseInt(document.getElementById('qty_' + cell.id.replace('total_', '')).value);
                subtotal += cellPrice * cellQty;
            });
            document.getElementById('cartSubtotal').textContent = '৳ ' + subtotal.toFixed(2);
            document.getElementById('cartTotal').textContent = '৳ ' + subtotal.toFixed(2);

            // ── Server এ update ───────────────────────────
            fetch('{{ route('frontend.cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        cart_key: cartKey,
                        quantity: newQty,
                    }),
                })
                .catch(err => console.error('Cart update error:', err));
        }
    </script>
@endpush
