@extends('admin.layouts.master');

@section('title', 'Category List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Contact Message Page</h3>
                            </div>
                            <hr>
                            @foreach ($message as $m)
                                <div class="row ">
                                    <div class="row col-6 offset-3">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text" class="form-control"
                                                aria-required="true" aria-invalid="false" value="{{ $m->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="email" class="form-control"
                                                aria-required="true" aria-invalid="false" value="{{ $m->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="number" class="form-control "
                                                aria-required="true" aria-invalid="false" value="{{ $m->phone }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1">Address</label>
                                            <textarea name="address" id="" cols="30" rows="10" class="form-control ">{{ $m->message }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
