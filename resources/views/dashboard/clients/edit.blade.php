@extends('layouts.dashboard.app')
@section('title', trans('site.edit'))
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.clients')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{ route('clients.index') }}"><i class=""></i>@lang('site.clients')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">@lang('site.edit')</h3></div>
                <div class="box-body">
                    @include('partials._errors')

                    <form action="{{ route('clients.update', $client->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group col-lg-12 tab-danger has-success">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{ $client->name }}">
                        </div>

                        @for ($i = 0; $i < 2; $i++)
                            <div class="form-group col-lg-6 tab-danger has-warning">
                                <label>@lang('site.phone')</label>
                                <input type="text" name="phone[]" value="{{ $client->phone[$i] ?? '' }}"
                                       class="form-control">
                            </div>
                        @endfor

                        <div class="form-group col-lg-12 tab-danger has-success">
                            <label>@lang('site.edit')</label>
                            <textarea name="address" class="form-control">{{ $client->address }}</textarea>
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
