@extends('admin.layout.master')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Orders </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">

        <div class="card card-info">

            <div class="card-header">
                <h3 class="card-title">All Orders</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Quntity</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Payment Method</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @forelse($orders as $index => $order)
            
                        <tr>
                            <td>{{ $index + 1  }} </td>
                            <td>{{$order->user->first_name }}</td>
                            <td>{{$order->user->last_name }}</td>
                            <td>{{$order->items->sum('quantity') }}</td>
                            <td>
                             @if ($order->status == 'pending')
                               <span class="badge badge-primary">Pending</span>
                             @elseif ($order->status == 'proceed')
                               <span class="badge badge-info">Proceed</span>
                             @elseif ($order->status == 'on way')
                               <span class="badge badge-warning">On Way</span>
                            @elseif ($order->status == 'finshed')
                               <span class="badge badge-success">Finshed</span>
                            @elseif ($order->status == 'canceled')
                            <span class="badge badge-danger">Canceled</span>
                             @endif   
                            </td>

                            <td>
                                @if ($order->payment_status == 'paid')
                                  <span class="badge badge-success">Paid</span>
                                @elseif ($order->payment_status == 'unpaid')
                                  <span class="badge badge-danger">Unpaid</span>
                                @endif   
                               </td>
                          

                            <td>
                                @if ($order->payment_method == 'cash')
                                    <span class="badge badge-success">Cahs</span>
                                @elseif ($order->payment_method == 'paymob')
                                <span class="badge badge-success">Paymob</span>
                                @elseif ($order->payment_method == 'other')
                                <span class="badge badge-success">Other</span>
                                @elseif ($order->payment_method == 'paypal')
                                <span class="badge badge-success">Paypal</span>
                                @endif   
                            </td>
                            <td>
                                <a href="{{route('admin.orders.delete' ,  ['id' => $order->id])}}">
                                    <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> Remove</button>
                                </a>


                                <a href="{{route('admin.orders.show_details' ,  ['id' => $order->id])}}">
                                    <button class="btn btn-sm btn-primary"><i class="nav-icon fas fa-eye"></i> Show</button>
                                </a>

                                <a href="{{route('admin.orders.edit_status' ,  ['id' => $order->id])}}">
                                    <button class="btn btn-sm btn-primary"><i class="nav-icon fas fa-eye"></i> Edit Status</button>
                                </a>

                            </td>

                        </tr>
                    @empty
                            <tr>
                                <td colspan="3"> No Data</td>
                            </tr>
                    @endforelse


                    </tbody>
                </table>

                    <!-- Pagination Links -->
    <div>
        {{ $orders->links() }}
    </div>

            </div>

        </div>
    </div>
</section>
@endsection