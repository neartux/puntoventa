@extends('admin.layouts.app')

@section('content')

    <div ng-cloak class="page-content" data-ng-app="ReportSale" data-ng-controller="ReportSaleController as ctrl"
        data-ng-init="ctrl.init('{{ URL::to('/') }}', '{{ StatusKeys::STATUS_CANCELLED }}')">

        <h1 class="page-title bold"> Ventas Caja Abierta</h1>
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
                            <span class="caption-subject font-dark bold uppercase">Ventas del Día</span>
                        </div>
                        <div class="actions btn-set">&nbsp;
                            <span data-ng-if="ctrl.sales.data.length" class="bold mr font-yellow">
                                Total Ventas: @{{ ctrl.sales.data.length }}
                            </span>
                            <span data-ng-if="ctrl.sales.data.length" class="bold mr font-blue">
                                Total: @{{ ctrl.sales.totalA | currency }}
                            </span>
                            <span data-ng-if="ctrl.sales.data.length" class="bold ml font-red">
                                Monto Canceladas: @{{ ctrl.sales.totalAmountCancelled | currency }}
                            </span>
                            <span data-ng-if="ctrl.sales.data.length" class="bold ml font-blue">
                                Monto Ventas: @{{ ctrl.sales.totalAmount | currency }}
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">


                        <div class="row">

                            <div class="col-sm-12" data-ng-show="!ctrl.sales.data.length">
                                <div class="alert alert-success">
                                    <strong>Aviso!</strong> No se han realizado ventas. </div>
                            </div>

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
    <script src="{{ asset('assets/scripts/pointsale/reports/ReportSaleController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/reports/ReportSaleProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/ticket/TicketProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@endsection