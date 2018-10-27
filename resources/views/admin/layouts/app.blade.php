<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>Punto Venta</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/global/css/fonts.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/toast/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('assets/global/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/blue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('assets/css/common.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('assets/global/plugins/easy-autocomplete/easy-autocomplete.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/easy-autocomplete/easy-autocomplete.themes.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/holdon/HoldOn.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

<div class="page-header navbar navbar-fixed-top">

    <div class="page-header-inner ">

        <div class="page-logo">
            <a href="{{ route('point_sale_view') }}">
                <h4 class="bold font-white">
                    Punto Venta
                </h4>
            </a>
            <div class="menu-toggler sidebar-toggler">

            </div>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <div class="page-top">


            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">

                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="{{ asset('assets/global/img/avatar.png') }}" />
                            <span class="username username-hide-on-mobile">
                            {{ Auth::user()->personalData->name }} {{ Auth::user()->personalData->last_name }}</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="icon-logout"></i> Log Out </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            @role('admin')
                            <li>
                                <a href="{{ route('change_password') }}">
                                    <i class="icon-lock"></i> Cambiar Password </a>
                            </li>
                            @endrole
                        </ul>
                    </li>

                </ul>
            </div>




        </div>

    </div>

</div>

<div class="clearfix"> </div>

<div class="page-container">

    <div class="page-sidebar-wrapper">

        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-grid"></i>
                        <span class="title">Catalogos</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @role('admin')
                        <li class="nav-item  ">
                            <a href="{{ route('admin_provider_list') }}" class="nav-link ">
                                <span class="title">Proveedores</span>
                            </a>
                        </li>
                        @endrole
                        <li class="nav-item  ">
                            <a href="{{ route('admin_client_list') }}" class="nav-link ">
                                <span class="title">Clientes</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{ route('admin_deparment_list') }}" class="nav-link ">
                                <span class="title">Departamentos</span>
                            </a>
                        </li>
                        @role('admin')
                            <li class="nav-item  ">
                                <a href="{{ route('users_list') }}" class="nav-link ">
                                    <span class="title">Usuarios</span>
                                </a>
                            </li>
                        @endrole
                    </ul>
                </li>
                @role('admin')
                <li class="nav-item">
                    <a href="{{ route('admin_stock_list') }}" class="nav-link nav-toggle">
                        <i class="fa fa-cube"></i>
                        <span class="title">Inventario</span>
                    </a>
                </li>
                @endrole
                <li class="nav-item">
                    <a href="{{ route('point_sale_view') }}" class="nav-link nav-toggle">
                        <i class="icon-basket-loaded"></i>
                        <span class="title">Punto de Venta</span>
                    </a>
                </li>
                
                {{--<li class="nav-item">
                    <a href="{{ route('order_list_view') }}" class="nav-link nav-toggle">
                        <i class="icon-notebook"></i>
                        <span class="title">Pedidos</span>
                    </a>
                </li>--}}

                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-bar-chart"></i>
                        <span class="title">Reportes</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('sales_caja_opened') }}" class="nav-link ">
                                <span class="title">Ventas Del Día</span>
                            </a>
                        </li>

                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('sales_by_dates') }}" class="nav-link ">
                                <span class="title">Ventas Por Fechas</span>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('sales_by_dates_and_user') }}" class="nav-link ">
                                <span class="title">Ventas Por Usuario</span>
                            </a>
                        </li>
                        @endrole

                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('cajas_closed') }}" class="nav-link ">
                                <span class="title">Cajas Cerradas</span>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </li>
                @role('admin')
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">Configuraciones</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('configuration_ticket') }}" class="nav-link ">
                                <span class="title">Ticket</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('download_bakcup_database') }}" class="nav-link ">
                                <span class="title">Descargar Backup BD</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole

            </ul>
        </div>
    </div>

    <div class="page-content-wrapper">

        @yield('content')

    </div>

</div>

<div class="page-footer">
    <div class="page-footer-inner"> 2018 &copy; Punto Venta By
        <a target="_blank" href="javascript:;">Reliable Systems</a>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
</div>


<div class="quick-nav-overlay"></div>

<!--[if lt IE 9]>
<script src="{{ asset('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ asset('assets/global/plugins/excanvas.min.js') }}"></script>
<script src="{{ asset('assets/global/plugins/ie8.fix.min.js') }}"></script>
<![endif]-->
<script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-sweetalert/ui-sweetalert.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/toast/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/holdon/HoldOn.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/scripts/common.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/angular/angular.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function()
    {
        $('#clickmewow').click(function()
        {
            $('#radio1003').attr('checked', 'checked');
        });
    })
</script>

@section('script-section')

@show

</body>

</html>