@extends('admin.layouts.app')

@section('content')

    <style>
        .easy-autocomplete-container ul {
            margin-top: 8px !important;
        }
        .easy-autocomplete {
            width: 100% !important;
        }
    </style>

    <div ng-cloak class="page-content" data-ng-app="PointSale" data-ng-controller="PointSaleController as ctrl"
         data-ng-init="ctrl.init('{{ URL::to('/') }}', '{{ ApplicationKeys::CLIENT_GENERAL_PUBLIC }}', '{{ ApplicationKeys::BULK_PRODUCT }}')">

        @include('admin.pointsale.openCajaView')

        <div data-ng-show="ctrl.caja.isOpen" style="display: none;" class="element-hide">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <h1 class="bold">
                                    <i class="icon-basket font-dark font-blue"></i>
                                    <span class="caption-subject font-dark bold uppercase fnt-sz-20 font-blue">
                                        Punto de Venta
                                    </span>
                                </h1>
                            </div>
                            <div class="actions btn-set">
                                <a href="javascript:;" class="icon-btn btn yellow border-blue-chambray"
                                   data-ng-show="ctrl.ventaCompleta.products.length"
                                    data-ng-click="ctrl.confirmApplyWholesalePrice();">
                                    <i class="icon-tag mt-xs fnt-sz-25"></i>
                                    <div class="color-white bold mb-n mt-n"> Mayoreo </div>
                                </a>

                                <a href="javascript:;" class="icon-btn btn green-haze border-blue-chambray mr-xl"
                                   data-ng-click="ctrl.showToDiscountToSale();"
                                   data-ng-show="ctrl.ventaCompleta.products.length">
                                    <i class="mt-xs fnt-sz-25 bold">%</i>
                                    <div class="color-white bold mb-n mt-xs" style="margin-top: -10px !important"> Descuento </div>
                                </a>

                                @role('admin')
                                    <a href="javascript:;" class="icon-btn btn btn blue-chambray border-blue-chambray ml-xl"
                                       data-ng-click="ctrl.findPreviewWithdrawal();">
                                        <i class="icon-share-alt mt-xs fnt-sz-25"></i>
                                        <div class="color-white bold mb-n mt-n"> Retiro </div>
                                    </a>
                                @endrole

                                <a href="javascript:;" class="icon-btn btn btn red-intense border-blue-chambray"
                                    data-ng-click="ctrl.findPreviewCloseCaja();">
                                    <i class="icon-drawer mt-xs fnt-sz-25"></i>
                                    <div class="color-white bold mb-n mt-n"> Cerrar Caja </div>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">


                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12 pr-n pl-n">

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="bold">Producto</label>

                                        <div class="input-group" data-ng-show="!ctrl.productSearchMode">
                                            <div class="input-icon">
                                                <i class="fa fa-barcode"></i>
                                                <input class="form-control" type="text" id="productId" placeholder="código de producto"
                                                       data-ng-model="ctrl.codeProduct" data-ng-enter="ctrl.findProductByCode();">
                                            </div>
                                            <span class="input-group-btn">
                                            <button id="genpassword" class="btn btn-primary" type="button"
                                                    data-ng-click="ctrl.activateSearchMode(true);">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                        </div>

                                        <div class="input-group" data-ng-show="ctrl.productSearchMode">
                                            <div class="input-icon">
                                                <i class="fa fa-dropbox"></i>
                                                <input style="width: 100% !important;" class="form-control" type="text" id="productIdSearch"
                                                       data-ng-model="ctrl.codeProduct" data-ng-enter="ctrl.findProductByCode();">
                                            </div>
                                            <span class="input-group-btn">
                                            <button id="genpassword" class="btn btn-primary" type="button"
                                                    data-ng-click="ctrl.activateSearchMode(false);">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                        </div>

                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <label class="bold">Cliente</label>
                                        <div class="input-group" data-ng-show="!ctrl.clientSearchMode">
                                            <input type="text" class="form-control" readonly
                                                   data-ng-model="ctrl.ventaCompleta.client.completeName">
                                            <span class="input-group-btn">
                                                <button class="btn blue" type="button" data-ng-click="ctrl.enableSearchModeClient(true);">
                                                    <i class="icon-user"></i>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="input-group" data-ng-show="ctrl.clientSearchMode">
                                            <input type="text" class="form-control" id="clientId"
                                                   data-ng-model="ctrl.ventaCompleta.client.completeName"
                                                   data-ng-enter="ctrl.findClientById(ctrl.clientId);">
                                            <span class="input-group-btn">
                                                <button class="btn blue" type="button" data-ng-click="ctrl.enableSearchModeClient(false);">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="row mt-xl" data-ng-show="ctrl.ventaCompleta.products.length">

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-xl">

                                    <div class="table-responsive">

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr class="bold">
                                                <th width="5%">&nbsp;</th>
                                                <th width="10%">Código</th>
                                                <th>Descripción</th>
                                                <th width="8%">Precio</th>
                                                <th width="4%">M</th>
                                                <th width="4%" class="text-center">% Desc.</th>
                                                <th width="10%">Cantidad</th>
                                                <th width="5%">Importe</th>
                                                <th width="5%">Existencia</th>
                                            </tr>
                                            </thead>
                                            <tbody data-ng-repeat="product in ctrl.ventaCompleta.products" data-ng-click="ctrl.setInputQuantity($index)">

                                            <tr data-ng-if="!product.isBulkProduct" data-ng-class="product.isElementSelected ? 'bg-default bg-font-default' : ''">
                                                <td>
                                                    <span data-ng-click="ctrl.deleteProductToSale($index)" class="font-red set-cursor-pointer">
                                                        <i class="icon-trash"></i>
                                                    </span>
                                                </td>
                                                <td>@{{ product.code }}</td>
                                                <td>@{{ product.description }}</td>
                                                <td>@{{ product.price | currency }}</td>
                                                <td>
                                                    <span data-ng-if="!product.apply_wholesale" class="set-cursor-pointer"
                                                          data-ng-click="ctrl.applyWholesalePrice(true, $index);"
                                                          data-toggle="tooltip" data-placement="top" title="Applicar precio mayoreo">
                                                        <i class="icon-ban font-yellow"></i>
                                                    </span>
                                                    <span data-ng-if="product.apply_wholesale" class="set-cursor-pointer"
                                                          data-ng-click="ctrl.applyWholesalePrice(false, $index);"
                                                          data-toggle="tooltip" data-placement="top" title="Remover precio mayoreo">
                                                        <i class="icon-check font-blue"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span data-ng-class="product.apply_discount && product.percent_discount > 0 ? 'font-blue' : 'font-yellow'"
                                                            class="set-cursor-pointer"
                                                            data-ng-click="ctrl.showDiscountByProduct(product);"
                                                          data-toggle="tooltip" data-placement="top" title="Aplicar descuento">
                                                        @{{ product.percent_discount }} %
                                                    </span>
                                                </td>
                                                <td><input type="number" class="form-control quantity-@{{ $index }} numeric-field"
                                                           data-ng-model="ctrl.ventaCompleta.products[$index].quantity"
                                                           data-ng-change="ctrl.calculateTotals();"
                                                           data-ng-blur="ctrl.productOnBlur();"
                                                           data-ng-focus="ctrl.focusProductInput($index);"
                                                           min="1"></td>
                                                <td>@{{ product.price * product.quantity | currency }}</td>
                                                <td>
                                                    <span data-ng-class="(product.current_stock-product.quantity) <= product.minimum_stock ? 'font-red' : 'font-blue'"
                                                          class="font-red bold set-cursor-pointer" title="Agregar @{{ product.description }} a pedido"
                                                          data-ng-click="ctrl.addProductToOrder(product.id);">
                                                        @{{ product.current_stock - product.quantity }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr data-ng-if="product.isBulkProduct">
                                                <td>
                                                    <span data-ng-click="ctrl.deleteProductToSale($index)" class="font-red set-cursor-pointer">
                                                        <i class="icon-trash"></i>
                                                    </span>
                                                </td>
                                                <td>@{{ product.code }}</td>
                                                <td>@{{ product.description }}</td>
                                                <td>@{{ product.price | currency }}</td>
                                                <td>
                                                    <span data-ng-if="!product.apply_wholesale" class="set-cursor-pointer"
                                                          data-ng-click="ctrl.applyWholesalePrice(true, $index);"
                                                          data-toggle="tooltip" data-placement="top" title="Applicar precio mayoreo">
                                                        <i class="icon-ban font-yellow"></i>
                                                    </span>
                                                    <span data-ng-if="product.apply_wholesale" class="set-cursor-pointer"
                                                          data-ng-click="ctrl.applyWholesalePrice(false, $index);"
                                                          data-toggle="tooltip" data-placement="top" title="Remover precio mayoreo">
                                                        <i class="icon-check font-blue"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span data-ng-class="product.apply_discount && product.percent_discount > 0 ? 'font-blue' : 'font-yellow'"
                                                          class="set-cursor-pointer"
                                                          data-ng-click="ctrl.showDiscountByProduct(product);"
                                                          data-toggle="tooltip" data-placement="top" title="Aplicar descuento">
                                                        @{{ product.percent_discount }} %
                                                    </span>
                                                </td>
                                                <td>
                                                    @{{ product.quantity | number: 2 }}
                                                    <i class="icon-login" data-ng-click="ctrl.updateBulkProductQuantities($index);"
                                                       title="Actualiza cantidad"></i>
                                                </td>
                                                <td>@{{ (product.price * product.quantity) | currency }}</td>
                                                <td>
                                                    <span data-ng-class="(product.current_stock-product.quantity) <= product.minimum_stock ? 'font-red' : 'font-blue'"
                                                          class="bold set-cursor-pointer" title="Agregar @{{ product.description }} a pedido"
                                                          data-ng-click="ctrl.addProductToOrder(product.id);">
                                                        @{{ product.current_stock - product.quantity | number: 2 }}
                                                    </span>
                                                </td>
                                            </tr>

                                            </tbody>
                                            <tfoot>
                                            <tr class="bold">
                                                <td colspan="3" rowspan="2">Total de productos: @{{ ctrl.ventaCompleta.totalProducts | number: 2 }}</td>
                                                <td colspan="5" class="text-right">Total Descuento:</td>
                                                <td class="text-right">@{{ ctrl.ventaCompleta.total_discount | currency }}</td>
                                            </tr>
                                            <tr class="bold">
                                                <td colspan="5" class="text-right">Total a Pagar:</td>
                                                <td class="text-right">@{{ ctrl.ventaCompleta.total | currency }}</td>
                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label class="bold">Comentarios</label>
                                    <textarea class="form-control" data-ng-model="ctrl.ventaCompleta.comments"></textarea>
                                </div>

                                <div class="col-md-8 col-sm-8 col-xs-12 text-right">

                                    <a href="javascript:;" class="icon-btn btn blue border-blue-chambray ml-xl"
                                       data-ng-click="ctrl.paySale();">
                                        <i class="fa fa-money mt-xs fnt-sz-25"></i>
                                        <div class="color-white bold mb-n mt-n"> Pagar Venta </div>
                                    </a>

                                </div>


                            </div>



                        </div>
                    </div>

                </div>
            </div>

        </div>



        @include('admin.pointsale.payModalView')

        @include('admin.pointsale.productDiscountModalView')

        @include('admin.pointsale.saleDiscountModalview')

        @include('admin.pointsale.closeCajaModalView')

        @include('admin.pointsale.ticketView')

        @include('admin.pointsale.bulkProductModalView')

        @include('admin.pointsale.withdrawalCajaModalView')

        @include('admin.pointsale.withDrawalsModalView')


    </div>

@endsection

@section('script-section')
    <script src="{{ asset('assets/global/plugins/jquery.printarea.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/jquery.alphanum.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/easy-autocomplete/jquery.easy-autocomplete.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/PointSaleController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/PointSaleProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/order/OrderProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/ticket/TicketProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/common/angularCommon.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            $(".element-hide").css("display", "block");

            $('#payModal').on('shown.bs.modal', function() {
                $(".importe-venta").focus();
            });

            $('#bulkModal').on('shown.bs.modal', function() {
                setTimeout(function () {
                    $("#quantityProduct").focus();
                },800);
            });

            $('#saleDiscountModal').on('shown.bs.modal', function() {
                $("#percentDiscountSale").focus();
                var value = $("#percentDiscountSale").val();
                if(value <= 0) {
                    $("#percentDiscountSale").val('');
                }
            });

            $('#productDiscountModal').on('shown.bs.modal', function() {
                $("#percentDiscountByProduct").focus();
                var value = $("#percentDiscountByProduct").val();
                if(value <= 0) {
                    $("#percentDiscountByProduct").val('');
                }
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

            $('[data-toggle="tooltip"]').tooltip();

        });

    </script>
@endsection