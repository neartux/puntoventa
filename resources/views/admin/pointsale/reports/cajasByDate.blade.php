@extends('admin.layouts.app')

@section('content')
    <link href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />

    <div ng-cloak class="page-content" data-ng-app="ReportSale" data-ng-controller="ReportSaleController as ctrl"
         data-ng-init="ctrl.initCajasClosed('{{ URL::to('/') }}', '{{ StatusKeys::STATUS_CANCELLED }}')">

        <h1 class="page-title bold"> Cajas Por Fecha</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="index.html">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Ventas</span>
                </li>
            </ul>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-grid font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Reporte De Cajas</span>
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
                                                        data-ng-click="ctrl.findCajasByDate();">
                                                    <i class="fa fa-search"></i>&nbsp;
                                                    Buscar
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row mb-xl mr ml" data-ng-show="ctrl.showSales">
                            <div class="col-sm-12 alert alert-success">
                                <div class="col-sm-2">
                                    <span class="bold">Folio Caja:</span>
                                    #@{{ ctrl.cajaTO.id }}
                                </div>
                                <div class="col-sm-3">
                                    <span class="bold">Fecha:</span>
                                    @{{ ctrl.cajaTO.opening_date }}
                                </div>
                                <div class="col-sm-3">
                                    <span class="bold">Cajero:</span>
                                    @{{ ctrl.cajaTO.user_close }}
                                </div>

                                <div class="col-sm-4">
                                    <span class="bold">Total:</span>
                                    @{{ ctrl.cajaTO.total_earnings | currency }}
                                    &nbsp;&nbsp;&nbsp;
                                    <span class="bold">Ganancias:</span>
                                    @{{ (ctrl.cajaTO.total_earnings-ctrl.cajaTO.total_withdrawals) | currency }}
                                </div>
                            </div>
                        </div>


                        <div class="row" data-ng-show="!ctrl.showSales">

                            <div class="col-sm-12" data-ng-show="!ctrl.cajas.data.length">
                                <div class="alert alert-success">
                                    <strong>Aviso!</strong> No hay cajas cerradas. </div>
                            </div>

                            <div class="col-sm-12" data-ng-show="ctrl.cajas.data.length">

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr class="bold">
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Usuario A.</th>
                                        <th>Usuario C.</th>
                                        <th>$ Apertura</th>
                                        <th>$ Total</th>
                                        <th>$ Retiros</th>
                                        <th>$ Ganancia</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="odd gradeX" data-ng-repeat="caja in ctrl.cajas.data">
                                        <td>@{{ caja.id }}</td>
                                        <td>@{{ caja.opening_date | date:'MM/dd/yyyy' }} / @{{ caja.close_date | date:'MM/dd/yyyy' }}</td>
                                        <td>@{{ caja.user_open }}</td>
                                        <td>@{{ caja.user_close }}</td>
                                        <td>@{{ caja.opening_amount | currency }}</td>
                                        <td>@{{ caja.total_amount | currency }}</td>
                                        <td>@{{ caja.total_withdrawals | currency }}</td>
                                        <td>@{{ (caja.total_earnings-caja.total_withdrawals) | currency }}</td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-xs blue"
                                               data-ng-click="ctrl.findSalesByCaja(caja);">
                                                <i class="icon-magnifier"></i>
                                                Ventas
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>

                        <div class="row" data-ng-show="ctrl.showSales">
                            @include('admin.pointsale.reports.salesView')
                        </div>



                    </div>
                </div>

            </div>
        </div>


        @include('admin.pointsale.reports.detailSale')

        @include('admin.pointsale.reports.ticketViewReport')
    </div>

@endsection

@section('script-section')
    <script src="{{ asset('assets/global/plugins/jquery.printarea.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/reports/ReportSaleController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/reports/ReportSaleProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/ticket/TicketProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@endsection