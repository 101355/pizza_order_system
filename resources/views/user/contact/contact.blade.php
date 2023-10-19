@extends('user.layout.master')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Contact Page</h3>
                            </div>
                            <hr>

                            @if (session('updateSuccess'))
                                <div class="col-3 offset-8">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-check"></i> {{ session('updateSuccess') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('contact#contactCreate') }}" method="POST" enctype="multipart/form-data"
                                novalidate="novalidate">
                                @csrf

                                <div class="row col-6 offset-3">
                                    <div class="form-group ">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name"
                                            type="text"value="{{ old('name', Auth::user()->name) }}"
                                            class="form-control " aria-required="true" aria-invalid="false"
                                            placeholder="Enter Admin Name">

                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email"
                                            type="email"value="{{ old('email', Auth::user()->email) }}"
                                            class="form-control " aria-required="true" aria-invalid="false"
                                            placeholder="Enter Admin Email">

                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone"
                                            type="number"value="{{ old('phone', Auth::user()->phone) }}"
                                            class="form-control " aria-required="true" aria-invalid="false"
                                            placeholder="Enter Admin Phone">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Message</label>
                                        <textarea name="message" cols="30" rows="10"
                                            class="form-control
                                        @error('message') is-invalid
                                    @enderror"
                                            placeholder="Enter your Feedback ..."></textarea>
                                        @error('message')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="mt-3">
                                    <button id="payment-button"
                                        class="btn btn-lg bg-dark text-white btn-block col-4 offset-4">
                                        <span id="payment-button-amount">Sent</span>
                                        <i class="fa-solid fa-circle-right"></i>
                                    </button>
                                </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
