@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Coupon</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Update Coupon </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Coupon</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.category.update' , ['id' => $coupon->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">

                        <div class="border  p-3">
                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="name">Name ({{ $lang->name }}) </label>
                                <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="Enter Name" value=" {{isset($coupon->translate($lang->code)->name) ? $coupon->translate($lang->code)->name : ''}} ">
                                @error('name.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                        </div>
                        <br>








                            <div class="border  p-3">
                            @foreach($langs as $index => $lang)


                                <div class="form-group">
                                    <label for="small_des">Small Description ({{$lang->name}})</label>
                                    <input name="small_des[{{$lang->code}}]" class="form-control" value="{{isset($coupon->translate($lang->code)->small_des) ? $coupon->translate($lang->code)->small_des :''}}"/>


                                    @error('small_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                            </div>
                            <br>

                            <div class="border  p-3">
                        @foreach($langs as $index => $lang)


                            <div class="form-group">
                                <label for="image">Description ({{$lang->name}})</label>
                                <textarea name="des[{{$lang->code}}]" class="ckeditor">
                                    @if (isset($coupon->translate($lang->code)->des))
                                    {!! $coupon->translate($lang->code)->des !!}  
                                    @endif
                                   
                                </textarea>

                                @error('des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date" required value="{{ $coupon->start_date }}">
                                @error('start_date')
                                <div class="text-danger">{{ $errors->first('start_date') }}</div>
                                @enderror
                            </div>
    
    
                
    
    
    
    
    
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date" required value="{{ $coupon->end_date }}">
                                @error('end_date')
                                <div class="text-danger">{{ $errors->first('end_date') }}</div>
                                @enderror
                            </div>





                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="photo" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">Choose Image</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/coupons/'. $coupon->photo)}}" width="150px" height="150px">

                            @error('photo')
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @enderror
                        </div>














                    </div>



                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> Submit</button>
                    </div>


                </form>
            </div>

        </div>
    </section>
@endsection


