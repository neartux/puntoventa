@extends('admin.layouts.app')

@section('content')
    <link href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />

    <div ng-cloak class="page-content" data-ng-app="Order" data-ng-controller="OrderController as ctrl"
         data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Pedidos Por Fecha</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Pedidos</span>
                </li>
            </ul>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-grid font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Reporte De Pedidos</span>
                        </div>
                        <div class="actions btn-set">&nbsp;
                            <a href="javascript:;" class="btn btn-circle btn-default"
                               data-ng-show="ctrl.showSales"
                               data-ng-click="ctrl.showSales = false;">
                                <i class="icon-action-undo"></i>
                                Regresar
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">

                        <div class="row" data-ng-show="!ctrl.showSales">
                            <div class="col-sm-12">
                                <form action="#" class="form-horizontal form-bordered">
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label class="control-label col-md-1 bold">Periodo</label>
                                            <div class="col-md-4">
                                                <div class="input-group" id="defaultrange">
                                                    <input type="text" class="form-control daterange">
                                                    <span class="input-group-btn">
                                                            <button class="btn default date-range-toggle" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:;" class="btn btn-primary"
                                                   data-ng-click="ctrl.findOrdersByDate();">
                                                    <i class="fa fa-search"></i>&nbsp;
                                                    Buscar
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="row" data-ng-show="ctrl.showListOrders">

                            <div class="col-sm-12" data-ng-show="!ctrl.orderList.data.length">
                                <div class="alert alert-success">
                                    <strong>Aviso!</strong> No se han encontrado pedidos. </div>
                            </div>

                            <div class="col-sm-12" data-ng-show="ctrl.orderList.data.length">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr class="bold">
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="odd gradeX" data-ng-repeat="order in ctrl.orderList.data">
                                        <td>@{{ order.id }}</td>
                                        <td>@{{ order.created_at }}</td>
                                        <td>@{{ order.user_name }}</td>
                                        <td>
                                            <span class="badge badge-danger bold uppercase"
                                                  data-ng-show="order.status_id == '{{ StatusKeys::STATUS_INACTIVE }}'">
                                                Inactivo
                                            </span>
                                            <span class="badge badge-success bold uppercase"
                                                  data-ng-show="order.status_id == '{{ StatusKeys::STATUS_OPEN }}'">
                                                Abierto
                                            </span>
                                            <span class="badge badge-info bold uppercase"
                                                  data-ng-show="order.status_id == '{{ StatusKeys::STATUS_CLOSED }}'">
                                                Cerrado
                                            </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-xs yellow"
                                               data-ng-show="order.status_id == '{{ StatusKeys::STATUS_OPEN }}'"
                                               data-ng-click="ctrl.closeOrder(order, '{{ StatusKeys::STATUS_CLOSED }}');">
                                                <i class="icon-lock"></i>
                                                Cerrar
                                            </a>
                                            <a href="javascript:;" class="btn btn-xs blue"
                                               data-ng-click="ctrl.findProductByOrderId(order);">
                                                <i class="icon-magnifier"></i>
                                                Productos
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>



                    </div>
                </div>

            </div>
        </div>

        @include('admin.order.detailsOrder')

    </div>

@endsection

@section('script-section')
    <script src="{{ asset('assets/scripts/jquery.alphanum.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/order/OrderController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/order/OrderProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        function initNumericFields() {
            $(".numeric-field").numeric({
                allowPlus           : false,
                allowMinus          : false,
                allowThouSep        : false,
                allowDecSep         : true,
                allowLeadingSpaces  : false,
                maxDigits           : 10,
                maxDecimalPlaces    : 2,
                maxPreDecimalPlaces : NaN,
                max                 : NaN,
                min                 : NaN
            });
        }
    </script>
@endsection