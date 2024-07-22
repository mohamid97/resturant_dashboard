@extends('admin.layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Offer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Update Offfer </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Offer</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.offers.update' , ['id' => $offer->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">

                        <div class="border  p-3">
                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="title">Title ({{ $lang->name }}) </label>
                                <input type="text" name="title[{{$lang->code}}]" class="form-control" id="title" placeholder="Enter Title" value=" {{isset($offer->translate($lang->code)->title) ? $offer->translate($lang->code)->title : ''}} ">
                                @error('title.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('title.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach
                        </div>
                        <br>







                            <div class="border  p-3">
                            @foreach($langs as $index => $lang)


                                <div class="form-group">
                                    <label for="small_des">Small Description ({{$lang->name}})</label>
                                    <input name="small_des[{{$lang->code}}]" class="form-control" value="{{isset($offer->translate($lang->code)->small_des) ? $offer->translate($lang->code)->small_des :''}}"/>


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
                                    @if (isset($offer->translate($lang->code)->des))
                                    {!! $offer->translate($lang->code)->des !!}  
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
                            <label for="image">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">Choose Image</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <img src="{{asset('uploads/images/offers/'. $offer->image)}}" width="150px" height="150px">

                            @error('image')
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="price">Price  </label>
                            <input type="text" name="price" class="form-control" id="price" placeholder="Enter Price" value="{{$offer->price }}">
                            @error('price')
                            <div class="text-danger">{{ $errors->first('price') }}</div>
                            @enderror
                     </div>


                     <div class="form-group">
                        <label for="old_price">Old Price  </label>
                        <input type="text" name="old_price" class="form-control" id="old_price" placeholder="Enter Old Price" value="{{ $offer->old_price }}">
                        @error('old_price')
                        <div class="text-danger">{{ $errors->first('old_price') }}</div>
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

@section('scripts')
    <script>
        $(document).ready(function(){
            // Hide the parent_id field initially
            $('#parent_id_field').hide();

            // Show/hide the parent_id field based on the selected value of type
            $('#type').change(function(){
                var selectedType = $(this).val();
                if(selectedType == 1) {
                    $('#parent_id_field').show();
                } else {
                    $('#parent_id_field').hide();
                }
            });
        });
    </script>
@endsection
