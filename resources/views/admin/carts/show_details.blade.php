@extends('admin.layout.master')

@section('content')



        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1>Cart Details</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Card Details</li>
                    </ol>
                    </div>
                </div>
            </div>
        </section>
    <section class="content">
    <div class="container-fluid">
    <div class="row">
    <div class="col-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Details OF:</h5>
            {{ $cart->user->first_name .' '. $cart->user->last_name }}
        </div>
    
    <div class="invoice p-3 mb-3">
    
            <div class="row">
                <div class="col-12">
                    <h4>
                    <i class="fas fa-user"></i> General Information
                    <small class="float-right">Date: {{$cart->created_at }}</small>
                    </h4>
                </div>
            
            </div>
    
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
               <strong> User Information </strong>
                <address>
                Name: {{ $cart->user->first_name .' '. $cart->user->last_name }}<br>
                Phone: {{ $cart->user->phone }}<br>
                Email: {{ $cart->user->email }}
                </address>
            </div>


            <div class="col-sm-4 invoice-col">
            
                <strong>Card Details</strong>
                <address>
                
                Total Price: {{ $total_price}} EGP<br>
                Total Quantity : {{ $totla_quantity }} <br>
                
                </address>
            </div>
        

        

        
        </div>
    
    
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Gallery</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quntity</th>
                        <th>Total</th>
                    
                    </tr>
                    </thead>
                <tbody>
                    @foreach ($cart->items as $index => $item )

                    <tr>
                        <td>{{ $index  + 1  }}</td>
                        <td>


                            <div class="row" style="width:250px">

                                <div class="col-md-12">
                                    <div class="card">
                                    
                                    <div class="card-body" style="padding:0 !important;">
                                    <div id="carouselExampleIndicators{{ $index + 1 }}" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach ($item->product->gallery as $indexs => $ga)
                                       

                                            <li data-target="#carouselExampleIndicators{{ $index + 1 }}" data-slide-to="{{ $indexs }}" class=""></li>

                                        @endforeach

                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach ($item->product->gallery as $indexs => $ga)
                                            <div class="carousel-item active">
                                            <img style="height: 200px !important" class="d-block w-100" src="{{ asset('uploads/images/gallery/' . $ga->photo) }}" alt="Third slide">
                                            </div>
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators{{ $index + 1 }}" role="button" data-slide="prev">
                                    <span class="carousel-control-custom-icon" aria-hidden="true">
                                    <i class="fas fa-chevron-left"></i>
                                    </span>
                                    <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators{{ $index + 1 }}" role="button" data-slide="next">
                                    <span class="carousel-control-custom-icon" aria-hidden="true">
                                    <i class="fas fa-chevron-right"></i>
                                    </span>
                                    <span class="sr-only">Next</span>
                                    </a>
                                    </div>
                                    </div>
                                    
                                    </div>
                                    
                                    </div>
                            </div>







                        </td>
                        <td>{{ $item->product->translations[0]->name }}</td>
                        <td>{{ $item->product->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->quantity  * $item->product->price  }} EGP</td>
                    </tr>
                    @endforeach

                </tbody>
                </table>
            </div>
        
        </div>



    

    
    


    </div>
    
    </div>
    </div>
    </div>
    </section>
    





@endsection