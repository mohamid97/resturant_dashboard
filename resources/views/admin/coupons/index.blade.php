@extends('admin.layout.master')
@section('styles')
<style>
    svg{
        width: 15px !important;
    }
    nav{
        margin-top: 30px;
    }
    a{
        margin-bottom: 10px;
       display: inline-block;
    }
</style>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Coupons </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Coupons</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div>

                <a href="{{route('admin.coupons.add')}}" style="color: #FFF">
                    <button class="btn btn-info" >
                        <i class="nav-icon fas fa-plus"></i> Add New Coupon
                    </button>
                </a>

            </div>
            <br>
            <div class="card card-info">

                <div class="card-header">
                    <h3 class="card-title">All Coupons</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>name </th>
                            <th>Code </th>
                            <th>Percentage </th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody>

                        @forelse($coupons as $index => $coupon)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{asset('uploads/images/coupons/'. $coupon->image)}}" width="150px" height="150px">
                                </td>
                                <td>{{ $coupon->name }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->percentage }}</td>
                                <td>{{ $coupon->start_date }}</td>
                                <td>{{ $coupon->end_date }}</td>


                                <td>
                                    <a href="{{route('admin.coupons.edit' ,  ['id' => $coupon->id])}}">
                                        <button class="btn btn-sm btn-info"> <i class="nav-icon fas fa-edit"></i> Edit</button>
                                    </a>

                                    @if($coupon->deleted_at == null)

                                        <a href="{{route('admin.coupons.soft_delete' ,  ['id' => $coupon->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash"></i> Soft Delete</button>
                                        </a>
                                    @else
                                        <a href="{{route('admin.coupons.restore' ,  ['id' => $coupon->id])}}">
                                            <button class="btn btn-sm btn-info"><i class="nav-icon fas fa-trash-restore"></i> Restore</button>
                                        </a>
                                    @endif

                                    <a href="{{route('admin.coupons.destroy' ,  ['id' => $coupon->id])}}">
                                        <button class="btn btn-sm btn-danger"><i class="nav-icon fas fa-trash"></i> Remove</button>
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
                    <div>
                        {{ $coupons->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
