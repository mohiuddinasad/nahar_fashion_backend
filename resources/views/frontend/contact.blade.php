@extends('frontend.layout')
@section('frontend_title', 'Contact Us')

@section('frontend_content')
    <!-- Page Header Start -->
    <section id class="bg-secondary">
        <div class="container">
            <div class="d-flex align-items-center py-3 px-1">
                <div class="d-inline-flex">
                    <p class="m-0"><a href="index.html">Home</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">Contact</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <section id="contact">
        <div class="container pt-5">
            <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">Contact
                        For Any Queries</span></h2>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="p-3 p-md-4 p-xl-5">
                        <div class="contain">
                            <h4>Contact Us</h4>
                            <p>Have any questions or need assistance?
                                Feel
                                free to reach out to us!</p>
                        </div>

                        <div class="contact-info">
                            <div class="row mb-3 py-4 align-items-center">
                                <div class="col-2 icon">
                                    <span><iconify-icon icon="ep:location" width="28"
                                            height="28"></iconify-icon></span>
                                </div>
                                <div class="col-10 p-lg-0">
                                    <h5>Address</h5>
                                    <p class="m-0">1 Kilometer ,
                                        Chandgaon , Chattogram</p>
                                </div>
                            </div>
                            <div class="row mb-3 py-4 align-items-center">
                                <div class="col-2 icon">
                                    <span><iconify-icon icon="ion:call-outline" width="28"
                                            height="28"></iconify-icon></span>
                                </div>
                                <div class="col-10 p-lg-0">
                                    <h5>Phone</h5>
                                    <p class="m-0">+8801975552455</p>
                                </div>
                            </div>
                            <div class="row mb-3 py-4 align-items-center">
                                <div class="col-2 icon">
                                    <span><iconify-icon icon="mdi:email-outline" width="28"
                                            height="28"></iconify-icon></span>
                                </div>
                                <div class="col-10 p-lg-0">
                                    <h5>Email</h5>
                                    <p class="m-0">info@naharfashion.com</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact_form p-3 p-md-4 p-xl-5">

                        <div class="form-group">
                            <form action="{{ route('dashboard.contact-store') }}" method="POST">
                                @csrf
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name"
                                    class="form-control mb-3 @error('name') is-invalid @enderror" placeholder="Your Name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone"
                                    class="form-control mb-3 @error('phone') is-invalid @enderror" placeholder="Your Phone"
                                    value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label for="message">Message</label>
                                <textarea id="message" name="message" class="form-control mb-3 @error('message') is-invalid @enderror" rows="5"
                                    placeholder="Your Message">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <!-- Contact End -->
@endsection
