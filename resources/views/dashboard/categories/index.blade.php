@extends('layouts.dashboard.app')
@section('title', trans('site.categories'))

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active">@lang('site.categories')</li>

            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.categories')
                        <small>{{ $categories->total() }}</small></h3>

                    <form action="{{ route('categories.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                @if(auth()->user()->hasPermission('read_categories'))
                                    <input type="text" name="search" class="form-control"
                                           placeholder="@lang('site.search')" value="{{ request()->search }}">
                                    {{--                                @else--}}
                                    {{--                                    <button class="btn btn-danger disabled">@lang('site.search')</button>--}}
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if(auth()->user()->hasPermission('read_categories'))
                                    <button type="submit" class="btn btn-info"><i style="margin-left: 6px"
                                                                                  class="fa fa-search"></i>@lang('site.search')
                                    </button>

                                @endif

                                @if(auth()->user()->hasPermission('create_categories'))

                                    <a href="{{ route('categories.create') }}" class="btn btn-primary"><i
                                            style="margin-left: 6px"
                                            class="fa fa-plus"></i>@lang('site.add')</a>
                                @else
                                    <button class="btn btn-danger disabled"> @lang('site.add')</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div><!-- end of box header -->
                <div class="box-body">
                    @if(auth()->user()->hasPermission('read_categories'))
                        @if ($categories->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.products_count')</th>
                                    <th>@lang('site.related_products')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($categories as $index=>$category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->products->count() }}</td>
                                        <td><a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="btn btn-microsoft">@lang('site.related_products')</a></td>
                                        <td>

                                            @if(auth()->user()->hasPermission('update_categories'))
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                   class="btn btn-info btn-sm"><i
                                                        class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @else
                                                <button class="btn btn-danger disabled">@lang('site.edit')</button>
                                            @endif

                                            @if(auth()->user()->hasPermission('delete_categories'))
                                                {{--------------------------------}}
                                                {{--Button Delete --}}
                                                <form action="{{ route('categories.destroy', $category->id) }}"
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
                            {{ $categories->appends(request()->query())->links() }}
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
