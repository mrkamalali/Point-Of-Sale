@extends('layouts.dashboard.app')
@section('title', trans('site.edit'))
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{ route('users.index') }}"><i class=""></i>@lang('site.users')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">@lang('site.edit')</h3></div>
                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('users.update' , $user->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group col-lg-6 tab-danger has-success">
                            <label>@lang('site.first_name')</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                        </div>

                        <div class="form-group col-lg-6  has-success">
                            <label>@lang('site.last_name')</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name  }}">

                        </div>

                        <div class="form-group col-lg-12 has-warning">
                            <label> <i style="margin-left: 6px" class="fa fa-envelope"></i> @lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>

                        {{-- Image --}}
                        <div class="form-group col-lg-6 has-img">
                            <label> <i style="margin-left: 6px" class="fa fa-image"></i> @lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>

                        {{-- Image  Preview--}}

                        <div class="form-group col-lg-6 has-img">
                            <label style="margin-left: 30px">@lang('site.yourPhoto')</label>
                            <img src="{{ $user->image_path }}" style="width: 100px"
                                 class="img-thumbnail image-preview" alt="">
                        </div>

                        <div class="form-group col-lg-12">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">

                                @php
                                    $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                    $permissions = ['create', 'read', 'update', 'delete'];
                                @endphp

                                <ul class="nav nav-tabs">
                                    @foreach($models as $index=>$model)
                                        <li class="{{ $index == 0 ? 'active' : '' }}"><a href="#{{ $model }}"
                                                                                         data-toggle="tab">@lang('site.'. $model )</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach($models as $index=>$model)
                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">

                                            @foreach($permissions as $permission)
                                                <label><input style="margin-left: 4px" type="checkbox"
                                                              name="permissions[]"
                                                              {{ $user->hasPermission($permission . '_' . $model) ? 'checked' : '' }}
                                                              value="{{ $permission. '_' .  $model }}">@lang('site.' . $permission )
                                                </label>

                                            @endforeach
                                        </div>
                                    @endforeach
                                </div><!-- end of tab-content -->


                            </div><!-- end of nav tabs -->
                        </div>


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
