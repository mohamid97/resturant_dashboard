@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Coupon</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Coupon </li>
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
                <form role="form" method="post" action="{{route('admin.coupons.store') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">

                        <div class="border  p-3">
                            @foreach($langs as $lang)
                                <div class="form-group">
                                    <label for="name">Name ({{ $lang->name }}) </label>
                                    <input type="text" name="name[{{$lang->code}}]" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name.' . $lang->code) }}">
                                    @error('name.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('name.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <br>



                        <div class="border  p-3">
                        
                                <div class="form-group">
                                    <label for="name">Percentage</label>
                                    <input type="text" name="percentage" class="form-control" id="name" placeholder="Enter Percentage" value="{{ old('percentage') }}">
                                    @error('percentage')
                                    <div class="text-danger">{{ $errors->first('percentage') }}</div>
                                    @enderror
                                </div>
                         
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                            @error('start_date')
                            <div class="text-danger">{{ $errors->first('start_date') }}</div>
                            @enderror
                        </div>


            





                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                            @error('end_date')
                            <div class="text-danger">{{ $errors->first('end_date') }}</div>
                            @enderror
                        </div>








                        <div class="border  p-3">
                            @foreach($langs as $index => $lang)


                                <div class="form-group">
                                    <label for="small_des">Small Description ({{$lang->name}})</label>
                                    <input name="small_des[{{$lang->code}}]" class="form-control"   placeholder="Enter Small Description" />
                                    @error('small_des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>


                        <div class="border  p-3">
                            @foreach($langs as $index => $lang)


                                <div class="form-group">
                                    <label>Description ({{$lang->name}})</label>
                                    <textarea name="des[{{$lang->code}}]" class="ckeditor">

                                    </textarea>

                                    @error('des.' . $lang->code)
                                    <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <br>



                        


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

                            @error('photo')
                            <div class="text-danger">{{ $errors->first('photo') }}</div>
                            @enderror
                        </div>


                        <br>









                    </div>



                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"> <i class="nav-icon fas fa-paper-plane"></i> Submit</button>
                    </div>


                </form>
            </div>

        </div>
    </section>
@endsection

