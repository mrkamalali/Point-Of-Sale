@extends('layouts.dashboard.app')
@section('title', trans('site.edit'))
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{ route('categories.index') }}"><i class=""></i>@lang('site.categories')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">@lang('site.edit')</h3></div>
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{ route('categories.update' , $category->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('put') }}


                        {{--                        --}}
                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-lg-12 has-success">
                                <label>@lang('site.' . $locale . '.name')</label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control"
                                       value="{{ $category->translate($locale)->name }}">
                            </div>
                        @endforeach
                        {{--                        --}}


                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-primary"><i style="margin-left: 6px"
                                                                             class="fa fa-edit"></i>@lang('site.edit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

@endsection
