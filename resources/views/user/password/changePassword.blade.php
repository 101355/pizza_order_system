@extends('user.layout.master')

@section('content')
    <div class="main-content mt-5">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="col-lg-4 offset-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Password</h3>
                            </div>
                            @if (session('changeSuccess'))
                                <div class="col-12">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-check me-2"></i> {{ session('changeSuccess') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            @if (session('notMatch'))
                                <div class="col-12">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-triangle-exclamation"></i> {{ session('notMatch') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <form action="{{ route('user#changePassword') }}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label mb-1">Old password</label>
                                    <input id="cc-pament" name="oldPassword" type="password"
                                        class="form-control

                                         @error('oldPassword') is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Enter your old password">
                                    @error('oldPassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">New password</label>
                                    <input id="cc-pament" name="newPassword" type="password"
                                        class="form-control @error('newPassword') is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Enter your new password">
                                    @error('newPassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Comfirm password</label>
                                    <input id="cc-pament" name="comfirmPassword" type="password"
                                        class="form-control @error('comfirmPassword') is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Enter your comfirm password">
                                    @error('comfirmPassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="row mt-3 ">
                                    <button id="payment-button" type="submit"
                                        class="btn btn-lg bg-dark text-white btn-block ">
                                        <i class="fa-solid fa-key me-2"></i></i>
                                        <span id="payment-button-amount">Change Password</span>
                                        {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}

                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
