@extends('layouts.dashboard.app')
@section('title', trans('site.edit'))
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{ route('products.index') }}"><i class=""></i>@lang('site.products')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">@lang('site.edit')</h3></div>
                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('products.update', $product->id) }}" method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        {{-- Show Categories In Create Product --}}
                        <div class="form-group col-lg-12 has-success">
                            <label>@lang('site.categories') </label>
                            <select name="category_id" class="form-control">
                                <option>@lang('site.all_categories')</option>
                                @foreach($categories as $category)
                                    <option
                                        value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- End Of That --}}


                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group col-lg-12 has-success">
                                <label>@lang('site.'. $locale . '.name')</label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control"
                                       value="{{ $product->name }}">
                            </div>
                            <div class="form-group col-lg-12 has-success">
                                <label>@lang('site.'. $locale . '.description')</label>
                                <textarea name="{{ $locale }}[description]" class="form-control ckeditor">{{ $product->description }}
                                       </textarea>
                            </div>
                        @endforeach

                        {{-- Preview Image --}}
                        <div class="form-group col-lg-6 has-img">
                            <label> <i style="margin-left: 6px" class="fa fa-image"></i> @lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>

                        <div class="form-group col-lg-6 has-img">
                            <label style="margin-left: 30px">@lang('site.yourPhoto')</label>
                            <img src="{{ $product->image_path }}" style="width: 100px"
                                 class="img-thumbnail image-preview img-circle ">
                        </div>
                        {{-- End Of Preview Image --}}


                        <div class="form-group col-lg-6 has-warning">
                            <label> <i></i> @lang('site.purchase_price')</label>
                            <input type="number" name="purchase_price" step="0.01" class="form-control image"
                                   value="{{ $product->purchase_price }}">
                        </div>

                        <div class="form-group col-lg-6 has-warning">
                            <label> <i></i> @lang('site.sale_price')</label>
                            <input type="number" name="sale_price" step="0.01" class="form-control"
                                   value="{{ $product->sale_price }}">
                        </div>

                        <div class="form-group col-lg-6 has-warning">
                            <label> <i></i> @lang('site.stock')</label>
                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                        </div>


                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-primary"><i style="margin-left: 6px"
                                                                             class="fa fa-plus"></i>@lang('site.edit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>


@endsection
