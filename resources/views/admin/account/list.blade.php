@extends('admin.layouts.master');

@section('title', 'Category List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admin list</h2>
                            </div>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('admin#list') }}" method="GET">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search..."
                                        value="{{ request('key') }}">
                                    <button class="btn bg-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-1 bg-white shadow-sm p-2 text-center offset-10">
                        <h3><i class="fa-solid fa-database mr-2"></i>{{ $admin->total() }}</h3>
                    </div>
                </div>

                {{-- @if (count($admin) != 0) --}}
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($admin as $a)
                                <tr class="tr-shadow">
                                    <td class="col-2">
                                        @if ($a->image == null)
                                            @if ($a->gender == 'male')
                                                <img
                                                    src="{{ asset('image/male-profile-picture.webp') }}"class="img-thumbnail shadow-sm">
                                            @else
                                                <img
                                                    src="{{ asset('image/female-profile-picture.webp') }}"class="img-thumbnail shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . $a->image) }}"class="img-thumbnail shadow-sm">
                                        @endif
                                    </td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->gender }}</td>
                                    <td>{{ $a->phone }}</td>
                                    <td>{{ $a->address }}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            @if (Auth::user()->id == $a->id)
                                            @else
                                                <a href="{{ route('admin#changeRole', $a->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                        title="Change Admin Role">
                                                        <i class="fa-solid fa-person-circle-minus"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('admin#delete', $a->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $admin->links() }}
                    </div>

                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
    </div>
@endsection
