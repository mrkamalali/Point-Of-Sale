@extends('layouts.dashboard.app')
@section('title', trans('site.products'))

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active">@lang('site.products')</li>

            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.products')
                        <small>{{ $products->total() }}</small></h3>

                    <form style="margin-bottom: 20px" action="{{ route('products.index') }}" method="get">
                        <div class="row">


                            <div class="col-md-4 has-success">
                                @if(auth()->user()->hasPermission('read_products'))
                                    <input type="text" name="search" class="form-control"
                                           placeholder="@lang('site.search')" value="{{ request()->search }}">
                                    {{--                                @else--}}
                                    {{--                                    <button class="btn btn-danger disabled">@lang('site.search')</button>--}}
                                @endif
                            </div>

                            {{--Show All Categories--}}
                            <div class="col-md-4 has-success">
                                <select name="category_id" class="form-control">
                                    {{--In option you should give a value but make it empty like option below--}}
                                    <option value="">@lang('site.all_categories')</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- END OF Show All Categories--}}


                            <div class="col-md-4">
                                @if(auth()->user()->hasPermission('read_products'))
                                    <button type="submit" class="btn btn-info"><i style="margin-left: 6px"
                                                                                  class="fa fa-search"></i>@lang('site.search')
                                    </button>

                                @endif

                                @if(auth()->user()->hasPermission('create_products'))

                                    <a href="{{ route('products.create') }}" class="btn btn-primary"><i
                                            style="margin-left: 6px"
                                            class="fa fa-plus"></i>@lang('site.add')</a>
                                @else
                                    <button class="btn btn-danger disabled"> @lang('site.add')</button>
                                @endif
                            </div>


                        </div>
                    </form>
                </div><!-- end of box header -->

                <div style="margin-top: 25px" class="box-body">
                    @if(auth()->user()->hasPermission('read_products'))
                        @if ($products->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.description')</th>
                                    <th>@lang('site.category')</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.purchase_price')</th>
                                    <th>@lang('site.sale_price')</th>
                                    <th>@lang('site.profit_percent') %</th>
                                    <th>@lang('site.stock')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($products as $index=>$product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{!! $product->description !!}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td><img src="{{ $product->image_path }}" style="width: 80px; height: 80px"
                                                 class="img-thumbnail img-circle"></td>
                                        <th>{{ $product->purchase_price }}</th>
                                        <th>{{ $product->sale_price }}</th>
                                        <th>{{ $product->profit_percent }} %</th>
                                        <th style="color: red">{{ $product->stock }}</th>

                                        <td>

                                            @if(auth()->user()->hasPermission('update_products'))
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                   class="btn btn-info btn-sm"><i
                                                        class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @else
                                                <button class="btn btn-danger disabled">@lang('site.edit')</button>
                                            @endif

                                            @if(auth()->user()->hasPermission('delete_products'))
                                                {{--------------------------------}}
                                                {{--Button Delete --}}
                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                      method="post"
                                                      style="display: inline-block">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i
                                                            class="fa fa-trash"></i> @lang('site.delete')</button>
                                                </form><!-- end of form -->
                                                {{--END Of Button Delete --}}
                                                {{--------------------------------}}

                                            @else
                                                <button class="btn btn-danger disabled"> @lang('site.delete')</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table><!-- end of table -->
                            {{ $products->appends(request()->query())->links() }}
                        @else
                            <h2>@lang('site.no_data_found')</h2>
                        @endif
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif
                </div><!-- end of box body -->
            </div><!-- end of box -->
        </section><!-- end of content -->
    </div><!-- end of content wrapper -->


@endsection
