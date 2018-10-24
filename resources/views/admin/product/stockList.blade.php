@extends('admin.layouts.app')

@section('content')
    <div ng-cloak class="page-content" data-ng-app="Product" data-ng-controller="ProductController as ctrl" data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Inventario</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Inventario</span>
                </li>
            </ul>

        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-grid font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Productos</span>
                        </div>
                        <div class="actions btn-set">

                            <a href="javascript:;" class="btn btn-circle btn-default"
                               data-ng-click="ctrl.viewCreateProduct();">
                                <i class="fa fa-plus"></i>
                                Crear Producto
                            </a>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12">

                            <div class="col-sm-12 pl-n text-center">
                                <div class="col-sm-6">
                                    <h5 class="bold">Costo del inventario</h5>
                                    <span class="bold font-blue">@{{ ctrl.inversionStockTO.total | currency }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <h5 class="bold">Cantidad de productos</h5>
                                    <span class="bold font-blue">@{{ ctrl.inversionStockTO.productos }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>


                            <table dt-options="ctrl.dtOptions" dt-columns="ctrl.dtColumns" dt-instance="ctrl.dtInstance" datatable=""
                                   class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th class="uppercase bold"></th>
                                    <th class="uppercase bold"></th>
                                    <th class="uppercase bold"></th>
                                    <th class="uppercase bold"></th>
                                    <th class="uppercase bold"></th>
                                    <th class="uppercase bold"></th>
                                </tr>
                                </thead>

                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('admin.product.modalAdjustStockProduct')

        @include('admin.product.modalPreviewProduct')

        @include('admin.product.modalProductData')

    </div>
@endsection

@section('script-section')
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/product/ProductController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/product/ProductProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/jquery.alphanum.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#dataProduct').on('shown.bs.modal', function() {
                $("#productCode").focus();
            });

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

        });

    </script>
@endsection