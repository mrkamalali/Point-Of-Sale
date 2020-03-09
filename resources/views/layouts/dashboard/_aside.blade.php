<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ auth()->user()->image_path }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p style="margin-top: 10px">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                <a href=""><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">

            <li>
                <a href="{{ route('admin.index') }}"><i class="fa fa-th"></i><span>@lang('site.dashboard')</span></a>
            </li>

            @if(auth()->user()->hasPermission('read_users'))
                <li>
                    <a href="{{ route('users.index') }}"><i class="fa fa-user"></i><span>@lang('site.users')</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_categories'))
                <li>
                    <a href="{{ route('categories.index') }}"><i
                            class="fa fa-list-alt"></i><span>@lang('site.categories')</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_products'))
                <li>
                    <a href="{{ route('products.index') }}"><i
                            class="fa fa-product-hunt"></i><span>@lang('site.products')</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_clients'))
                <li>
                    <a href="{{ route('clients.index') }}"><i
                            class="fa fa-user"></i><span>@lang('site.clients')</span></a>
                </li>
            @endif

            @if(auth()->user()->hasPermission('read_orders'))
                <li>
                    <a href="{{ route('orders.index') }}"><i
                            class="fa fa-first-order"></i><span>@lang('site.orders')</span></a>
                </li>
            @endif



        </ul>

    </section>

</aside>

