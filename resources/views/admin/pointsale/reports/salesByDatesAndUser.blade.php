@extends('admin.layouts.app')

@section('content')
    <link href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />

    <div ng-cloak class="page-content" data-ng-app="ReportSale" data-ng-controller="ReportSaleController as ctrl"
         data-ng-init="ctrl.initSalesByDateAndUser('{{ URL::to('/') }}', '{{ StatusKeys::STATUS_CANCELLED }}', {{ Auth::user()->id }})">

        <h1 class="page-title bold"> Ventas Por Usuario</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
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
                            <span class="caption-subject font-dark bold uppercase">Reporte De Ventas</span>
                        </div>
                        <div class="actions btn-set">&nbsp;

                        </div>
                    </div>
                    <div class="portlet-body">

                        <div class="row" data-ng-show="!ctrl.showSales">
                            <div class="col-sm-12">
                                <form action="#" class="form-horizontal form-bordered">
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label class="control-label col-md-1 bold">Periodo</label>
                                            <div class="col-md-3">
                                                <div class="input-group" id="defaultrange">
                                                    <input type="text" class="form-control daterange">
                                                    <span class="input-group-btn">
                                                            <button class="btn default date-range-toggle" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                </div>
                                            </div>
                                            <label class="control-label col-md-1 bold" for="userId">Usuario</label>
                                            <div class="col-md-3">
                                                <select class="form-control" id="userId" data-ng-model="ctrl.dates.userId">
                                                    <option value="0">Selecciona</option>
                                                    <option value="@{{ user.id }}" data-ng-repeat="user in ctrl.users">
                                                        @{{ user.name }} @{{ user.last_name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:;" class="btn btn-primary"
                                                   data-ng-click="ctrl.findSalesByDatesAndUser();">
                                                    <i class="fa fa-search"></i>&nbsp;
                                                    Buscar
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>




                        <div class="row">
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