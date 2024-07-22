@extends('admin.layout.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Offers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Offers </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Offers</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{route('admin.offers.store') }}"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">


                        @foreach($langs as $lang)
                            <div class="form-group">
                                <label for="title">Title ({{ $lang->name }}) </label>
                                <input type="text" name="title[{{$lang->code}}]" class="form-control" id="title" placeholder="Enter Title" value="{{ old('title.' . $lang->code) }}">
                                @error('title.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('title.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach


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

                            @error('image')
                            <div class="text-danger">{{ $errors->first('image') }}</div>
                            @enderror
                        </div>


                         <div class="form-group">
                                <label for="price">Price  </label>
                                <input type="text" name="price" class="form-control" id="price" placeholder="Enter Price" value="{{ old('price') }}">
                                @error('price')
                                <div class="text-danger">{{ $errors->first('price') }}</div>
                                @enderror
                         </div>


                         <div class="form-group">
                            <label for="old_price">Old Price  </label>
                            <input type="text" name="old_price" class="form-control" id="old_price" placeholder="Enter Old Price" value="{{ old('old_price') }}">
                            @error('old_price')
                            <div class="text-danger">{{ $errors->first('old_price') }}</div>
                            @enderror
                        </div>



                        @foreach($langs as $index => $lang)


                            <div class="form-group">
                                <label for="small_des">Small Description ({{$lang->name}})</label>
                                <input  id="small_des" class="form-control" name="small_des[{{$lang->code}}]">
                                @error('small_des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('small_des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach






                        @foreach($langs as $index => $lang)


                            <div class="form-group">
                                <label for="des">Description ({{$lang->name}})</label>
                                <textarea name="des[{{$lang->code}}]" class="ckeditor">

                                    </textarea>

                                @error('des.' . $lang->code)
                                <div class="text-danger">{{ $errors->first('des.' . $lang->code) }}</div>
                                @enderror
                            </div>
                        @endforeach






                        <div class="form-group">
                            <label>Products</label>
                            <select type="text" name="products[]" class="form-control" multiple>
                                <option value="0">Select Products</option>
                                @forelse($products as $product)
                                
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @empty
                                @endforelse

                            </select>
                            @error('products')
                            <div class="text-danger">{{ $errors->first('products') }}</div>
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

