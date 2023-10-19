@extends('admin.layouts.master');

@section('title', 'Category List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <a href="{{ route('admin#orderList') }}" class="text-dark"><i class="fa-solid fa-arrow-left"></i> Back</a>

                    <div class="row col-4">
                        <div class="card mt-4">
                            <div class="card-body">
                                <h3><i class="fa-solid fa-clipboard me-3 mb-3"></i>Order Info</h3>
                                <small class="text-warning"><i class="fa-solid fa-triangle-exclamation"></i>
                                    Inclucd Delivery Charges</small>
                            </div>
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col"><i class="fa-solid fa-user me-3"></i>Customer Name</div>
                                    <div class="col">{{ strtoupper($orderList[0]->user_name) }}
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col"><i class="fa-solid fa-barcode me-3"></i>Order Code</div>
                                    <div class="col">{{ $orderList[0]->order_code }}
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col"><i class="fa-regular fa-clock me-3"></i>Order Date</div>
                                    <div class="col">{{ $orderList[0]->created_at->format('F-j-Y') }}
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col"><i class="fa-solid fa-money-bill me-3"></i>Total</div>
                                    <div class="col">{{ $order->total_price }} Kyats
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Order ID</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Order Date</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                            </tbody>
                            @foreach ($orderList as $o)
                                <tr class="tr-shadow">
                                    <td></td>
                                    <td>{{ $o->id }}</td>
                                    <td>
                                        <div class="" style="width: 300px;height:300px;"><img
                                                src="{{ asset('storage/' . $o->product_image) }}" class="img-tumbnails">
                                        </div>
                                    </td>
                                    <td>{{ $o->product_name }}</td>
                                    <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                    <td>{{ $o->qty }}</td>
                                    <td>{{ $o->total }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
