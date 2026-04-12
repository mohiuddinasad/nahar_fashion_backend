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
@section('frontend_title', 'Checkout')
@push('frontend_css')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />
@endpush
@section('frontend_content')
    <!-- Page Header Start -->
    <section id class="bg-secondary">

        <div class="container">
            <div class="d-flex align-items-center py-3 px-1">
                <div class="d-inline-flex">
                    <p class="m-0"><a href="index.html">Home</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">Checkout</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header End -->
    <!-- Checkout Start -->

    <section id="checkout">
        <div class="container pt-5">
            <form action="{{ route('frontend.checkout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <h4 class="font-weight-semi-bold mb-4">Billing
                                Address</h4>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="row child_row align-items-center">
                                        <div class="col-lg-2">
                                            <label class=" d-flex mb-0" for="name">Name <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter Your Name" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row child_row align-items-center">
                                        <div class="col-lg-2">
                                            <label class=" d-flex mb-0" for="email">Email <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Enter Your Email" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row child_row align-items-center">
                                        <div class="col-lg-2">
                                            <label class=" d-flex mb-0" for="phone">Phone <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                placeholder="Enter Your Phone Number" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row child_row align-items-center">
                                        <div class="col-lg-2">
                                            <label class=" d-flex mb-0" for="address">Address
                                                <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-10">
                                            <textarea name="address" id="address" class="form-control" placeholder="Enter Your Address" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="row child_row align-items-center">
                                        <div class="col-lg-2">
                                            <label class=" d-flex mb-0" for="city">City <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="Enter Your City" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row child_row align-items-center">
                                        <div class="col-lg-2">
                                            <label class=" d-flex mb-0" for="postal">Postal
                                                Code</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" id="postal" name="postal"
                                                placeholder="Enter Your Postal Code" required>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="row child_row align-items-center">
                                        <div class="col-lg-2">
                                            <label class=" d-flex mb-0" for="comments">Comments
                                            </label>
                                        </div>
                                        <div class="col-lg-10">
                                            <textarea style="height: 120px;" name="comments" id="comments" class="form-control"
                                                placeholder="Enter Your Comments" ></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="newaccount" required>
                                        <label class="custom-control-label" for="newaccount">I agree to
                                            the
                                            <a href>terms and
                                                conditions</a>
                                            & <a href>privacy
                                                policy</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="card border-secondary mb-5">
                            <div class="card-header bg-secondary border-0">
                                <h4 class="font-weight-semi-bold m-0">Order
                                    Total</h4>
                            </div>
                            <div class="card-body">
                                <h5 class="font-weight-medium mb-3">Products</h5>

                                @forelse ($cart as $id => $data)
                                    <div class="row align-items-center justify-content-between mb-2">
                                        <div class="col-8">
                                            <div class="row align-items-center">
                                                <div class="col-4">
                                                    @if ($data['image'])
                                                        <img class="img-fluid" style=" object-fit:cover; border-radius:6px;"
                                                            src="{{ asset($data['image']) }}"
                                                            alt="{{ $data['name'] }}">
                                                    @else
                                                        <img style="width:70px; height:70px; object-fit:cover; border-radius:6px;"
                                                            src="{{ asset('assets/img/no-image.png') }}" alt="No Image">
                                                    @endif
                                                </div>
                                                <div class="col-8 p-0">
                                                    <h6 class="mb-1">{{ Str::limit($data['name'], 15) }}</h6>
                                                    <p style="font-size: 12px;" class="m-0">
                                                        {{ $data['variant_name'] ?? 'Default' }} X {{ $data['qty'] }}</p>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-3">
                                            <p class="text-right">৳ {{ $data['price'] * $data['qty'] }}</p>

                                        </div>
                                    </div>

                                @empty

                                        <div class="text-center">
                                            <h6 class="mb-3">Your cart is empty</h6>
                                @endforelse

                                <hr class="mt-0">
                                <div class="d-flex justify-content-between mb-3 pt-1">
                                    <h6 class="font-weight-medium">Subtotal</h6>
                                    <h6 class="font-weight-medium">৳ {{ number_format($total_price, 2) }}</h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-medium">Shipping</h6>
                                    <h6 class="font-weight-medium">৳ 0.00</h6>
                                </div>
                            </div>
                            <div class="card-footer border-secondary bg-transparent">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5 class="font-weight-bold">Total</h5>
                                    <h5 class="font-weight-bold">৳ {{ number_format($total_price, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card border-secondary mb-5">
                            <div class="card-header bg-secondary border-0">
                                <h4 class="font-weight-semi-bold m-0">Payment</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input checked type="radio" class="custom-control-input" name="cod"
                                            id="cod">
                                        <label class="custom-control-label" for="cod">Cash on
                                            Delivery</label>
                                    </div>

                                    <div class="uplode">
                                        <h6 class="text-dark my-3">Upload your furniture (optional)</h6>
                                        <input type="file" class="my-pond" name="images[]" multiple
                                            data-max-file-size="3MB">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer border-secondary bg-transparent">
                                <button type="submit"
                                    class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place
                                    Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout End -->
@endsection

@push('frontend_js')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- slick js  -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>

    <!-- include FilePond jQuery adapter -->
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>


    <script>
        $(function() {
            // First register any plugins

            FilePond.registerPlugin(FilePondPluginImageTransform);

            // Turn input element into a pond
            $(".my-pond").filepond({
                allowMultiple: true,
                storeAsFile: true,
            });
        });
    </script>
@endpush
