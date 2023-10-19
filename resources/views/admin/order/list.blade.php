@extends('admin.layouts.master');

@section('title', 'Category List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    {{-- <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                    </div> --}}



                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h4>
                        </div>                        
                    </div> --}}
                    <div class="row mt-2 mb-2">
                        <div class="col-1 bg-white shadow-sm p-2 text-center offset-10">
                            <h3><i class="fa-solid fa-database mr-2"></i>{{ count($order) }}</h3>
                        </div>
                    </div>
                    <form action="{{ route('admin#changeStatus') }}" method="get">
                        @csrf
                        <div class="d-flex">
                            <label for="" class="mt-1 me-2">Order Status</label>
                            <select name="orderStatus" class="form-control col-2">
                                <option value="">All</option>
                                <option value="0"@if (request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1"@if (request('orderStatus') == '1') selected @endif>Accept</option>
                                <option value="2"@if (request('orderStatus') == '2') selected @endif>Reject</option>
                            </select>
                            <button type="submit" class="btn btn-sm ms-3 bg-primary text-white"><i
                                    class="fa-solid fa-magnifying-glass me-3"></i>Search</button>
                        </div>
                    </form>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($order as $o)
                                    <tr class="tr-shadow">
                                        <input type="hidden" class="orderId" value="{{ $o->id }}">
                                        <td>{{ $o->user_id }}</td>
                                        <td>{{ $o->user_name }}</td>
                                        <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin#listInfo', $o->order_code) }}"
                                                class="text-primary">{{ $o->order_code }}</a>
                                        </td>
                                        <td>{{ $o->total_price }} Kyats</td>
                                        <td>
                                            <select name="status" class="form-control statusChange">
                                                <option value="0" @if ($o->status == 0) selected @endif>
                                                    Pending</option>
                                                <option value="1" @if ($o->status == 1) selected @endif>
                                                    Accept</option>
                                                <option value="2" @if ($o->status == 2) selected @endif>
                                                    Reject</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function() {
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();
            //     console.log($status);
            //     $.ajax({
            //         type: 'get',
            //         url: '/order/ajax/status',
            //         data: {
            //             'status': $status,
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             $list = '';
            //             for ($i = 0; $i < response.length; $i++) {

            //                 $months = ['January', 'February', 'March', 'April', 'May', 'June',
            //                     'July', 'August', 'September', 'October', 'November',
            //                     'December'
            //                 ];
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $finalDate = $months[$dbDate.getMonth()] + "-" + $dbDate.getDate() +
            //                     "-" + $dbDate.getFullYear();

            //                 if (response[$i].status == 0) {
            //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0" selected>Pending</option>
        //                         <option value="1" >Accept</option>
        //                         <option value="2" >Reject</option>
        //                     </select>
        //                     `
            //                 } else if (response[$i].status == 1) {
            //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0" >Pending</option>
        //                         <option value="1" selected>Accept</option>
        //                         <option value="2" >Reject</option>
        //                     </select>
        //                     `
            //                 } else if (response[$i].status == 2) {
            //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0" >Pending</option>
        //                         <option value="1" >Accept</option>
        //                         <option value="2" selected>Reject</option>
        //                     </select>
        //                     `
            //                 }


            //                 $list += `
        //                    <tr class="tr-shadow">
        //                     <input type="hidden" class="orderId" value="${response[$i].id}">
        //                             <td> ${response[$i] . user_id} </td>
        //                             <td> ${response[$i] . user_name} </td>
        //                             <td> ${$finalDate} </td>
        //                             <td> ${response[$i] . order_code} </td>
        //                             <td> ${response[$i] . total_price}  Kyats</td>
        //                             <td> ${$statusMessage} </td>
        //                         </tr>
        //                     `;
            //             }
            //             $('#dataList').html($list);
            //         }
            //     })
            // })


            // change status
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find('.orderId').val();
                $.ajax({
                    type: 'get',
                    url: '/order/ajax/change/status',
                    data: {
                        'status': $currentStatus,
                        'orderId': $orderId,
                    },
                    dataType: 'json',
                })
            })
        })
    </script>
@endsection
