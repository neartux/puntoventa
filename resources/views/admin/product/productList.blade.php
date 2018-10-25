@extends('admin.layouts.app')

@section('content')
    <div ng-cloak class="page-content" data-ng-app="Product" data-ng-controller="ProductController as ctrl" data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Productos</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Productos</span>
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
                               data-ng-click="ctrl.showCreateProduct();">
                                <i class="fa fa-plus"></i>
                                Crear Producto
                            </a>

                        </div>
                    </div>
                    <div class="row">

                            <div class="col-sm-12" data-ng-if="!ctrl.productList.data.length">
                                <div class="alert alert-success">
                                    <strong>Aviso!</strong> No se han creado productos. </div>
                            </div>

                            <div class="col-sm-12" data-ng-if="ctrl.productList.data.length>0">

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

                                <table dt-column-defs="ctrl.dtColumnDefs" datatable="ng" dt-instance="ctrl.dtInstance"
                                       dt-options="ctrl.dtOptions" class="table table-bordered table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descripcion</th>
                                        <th>Precio compra</th>
                                        <th>Precio venta</th>
                                        <th>Stock</th>
                                        <th>Precio Inv.</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="odd gradeX" data-ng-repeat="product in ctrl.productList.data">
                                        <td>
                                            @{{ product.code}}
                                        </td>
                                        <td>
                                            @{{ product.description  }}
                                        </td>
                                        <td>
                                            @{{ product.purchase_price | currency }}
                                        </td>
                                        <td>
                                            @{{ product.sale_price | currency }}
                                        </td>
                                        <td>
                                            <span ng-class="{'text-primary':product.current_stock> product.minimum_stock, 'text-danger':product.current_stock<=product.minimum_stock}"> 
                                                @{{ product.current_stock  }}
                                            </span>
                                        </td>
                                        <td>
                                            @{{ (product.purchase_price * product.current_stock) < 0 ? 0 : (product.purchase_price * product.current_stock) | currency }}
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-xs blue"
                                                data-ng-click="ctrl.showEditProduct($index, product)">
                                                <i class="icon-note"></i>
                                                Modificar
                                            </a>
                                            <a href="javascript:;" class="btn btn-xs green"
                                                data-ng-click="ctrl.showEditStock($index, product)">
                                                <i class="icon-note"></i>
                                                Stock
                                            </a>
                                            <a href="javascript:;" class="btn btn-xs red"
                                                data-ng-click="ctrl.deleteProduct($index, product.id)">
                                                <i class="icon-trash"></i>
                                                Eliminar
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

        <div class="modal fade bs-modal-md" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form name="productForm" novalidate>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title bold">@{{ ctrl.titleFormAction }}</h4>
                        </div>
                        <div class="modal-body profile-userpic">

                            <div class="portlet light mb-n">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.code.$invalid && !productForm.code.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Código</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="code" data-ng-model="ctrl.productTO.code"
                                                    class="form-control" required id="codeProduct" maxlength="50">
                                                <span ng-show="productForm.code.$invalid && !productForm.code.$pristine"
                                                    class="help-block">El código es requerido.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.description.$invalid && !productForm.description.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Descripción</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="description" data-ng-model="ctrl.product.description"
                                                    class="form-control" required id="descriptionProduct" maxlength="50">
                                                <span ng-show="productForm.description.$invalid && !productForm.description.$pristine"
                                                    class="help-block">El nombre es requerido.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.description.$invalid && !productForm.description.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Departamento</label>
                                            <br>
                                            <div class="col-md-12">
                                                <select name="deparment" id="deparmentProduct" class="form-control" data-ng-model="ctrl.product.deparment" required
                                                ng-options="d as d.description for d in ctrl.deparments" ></select>
                                                <span ng-show="productForm.deparment.$invalid && !productForm.deparment.$pristine"
                                                    class="help-block">El deparmento es requerido.</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.unit.$invalid && !productForm.unit.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Unidad</label>
                                            <br>
                                            <div class="col-md-12">
                                                <select name="unit" id="unitProduct" class="form-control" data-ng-model="ctrl.product.unit" required
                                                    ng-options="u as u.description for u in ctrl.unities"></select>
                                                <!-- <input type="text" name="unit" data-ng-model="ctrl.product.unit"
                                                    class="form-control" required id="unitProduct" maxlength="50"> -->
                                                <span ng-show="productForm.unit.$invalid && !productForm.unit.$pristine"
                                                    class="help-block">La unidad es requerido.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.purcharseprice.$invalid && !productForm.purcharseprice.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Precio compra</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="purcharseprice" data-ng-model="ctrl.product.purchase_price"
                                                    class="form-control" required id="purcharsepriceProduct" maxlength="50">
                                                <span ng-show="productForm.purcharseprice.$invalid && !productForm.purcharseprice.$pristine"
                                                    class="help-block">El precio de compra es requerido.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.saleprice.$invalid && !productForm.saleprice.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Precio venta</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="saleprice" data-ng-model="ctrl.product.sale_price"
                                                    class="form-control" required id="salepriceProduct" maxlength="50">
                                                <span ng-show="productForm.saleprice.$invalid && !productForm.saleprice.$pristine"
                                                    class="help-block">El precio de venta es requerido.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.wholeprice.$invalid && !productForm.wholeprice.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Precio mayoreo</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="wholesale" data-ng-model="ctrl.product.wholesale_price"
                                                    class="form-control" required id="wholesaleProduct" maxlength="50">
                                                <span ng-show="productForm.wholesale.$invalid && !productForm.wholesale.$pristine"
                                                    class="help-block">El precio mayoreo es requerido.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.stock.$invalid && !productForm.stock.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Stock</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="stock" data-ng-model="ctrl.product.current_stock"
                                                    class="form-control" required id="stockProduct" maxlength="50">
                                                <span ng-show="productForm.stock.$invalid && !productForm.stock.$pristine"
                                                    class="help-block">El stock es requerido.</span>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : productForm.minimunstock.$invalid && !productForm.minimunstock.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Mínimo Stock</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="minimunstock" data-ng-model="ctrl.product.minimum_stock"
                                                    class="form-control" required id="minimunstockProduct" maxlength="50">
                                                <span ng-show="productForm.minimunstock.$invalid && !productForm.minimunstock.$pristine"
                                                    class="help-block">El mínimo de stock es requerido.</span>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
                            <button type="button" data-ng-disabled="productForm.$invalid" class="btn green"
                                    data-ng-click="ctrl.validateProduct(productForm.$valid)">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        

        <div class="modal fade bs-modal-sm" id="stockModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form name="stockForm" novalidate>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title bold">@{{ ctrl.titleFormAction }}</h4>
                        </div>
                        <div class="modal-body profile-userpic">

                            <div class="portlet light mb-n">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{ 'has-error' : stockForm.code.$invalid && !stockForm.code.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Código</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="code" data-ng-model="ctrl.product.code"
                                                    class="form-control" required id="codeProduct" maxlength="50" ng-disabled="true">
                                                <span ng-show="stockForm.code.$invalid && !stockForm.code.$pristine"
                                                    class="help-block">El código es requerido.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{ 'has-error' : stockForm.description.$invalid && !stockForm.description.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Descripción</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="description" data-ng-model="ctrl.product.description"
                                                    class="form-control" required id="descriptionProduct" maxlength="50" ng-disabled="true">
                                                <span ng-show="stockForm.description.$invalid && !stockForm.description.$pristine"
                                                    class="help-block">El nombre es requerido.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{ 'has-error' : stockForm.adjusmentReason.$invalid && !stockForm.adjusmentReason.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Razón de ajuste</label>
                                            <br>
                                            <div class="col-md-12">
                                                <!-- <input type="text" name="adjusmentReason" data-ng-model="ctrl.product.adjusmentReason"
                                                    class="form-control" required id="adjusmentReasonroduct" maxlength="50" ng-disabled="true">-->
                                                <select name="adjusmentReason" id="adjusmentReason" class="form-control" data-ng-model="ctrl.product.adjusmentReason" required
                                                    ng-options="a as a.description for a in ctrl.adjusmentReasons">
                                                    <option value="">Seleccionar</option>
                                                    </select>
                                                <span ng-show="stockForm.adjusmentReason.$invalid && !stockForm.adjusmentReason.$pristine"
                                                    class="help-block">Razon de ajuste es requerido.</span>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{'has-success' : ctrl.product.current_stock>ctrl.product.minimum_stock, 'has-error' : productForm.stock.$invalid && !productForm.stock.$pristine }">
                                            <label for="adjustQuantity"
                                                class="col-md-12 control-label bold">Stock</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="stock" data-ng-model="ctrl.product.current_stock"
                                                    class="form-control" data-ng-class="{ 'has-error': ctrl.product.current_stock=<ctrl.product.minimum_stock }" required id="stockProduct" maxlength="50">
                                                <span ng-show="productForm.stock.$invalid && !productForm.stock.$pristine"
                                                    class="help-block">El stock es requerido.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
                            <button type="button" data-ng-disabled="stockForm.$invalid" class="btn green"
                                    data-ng-click="ctrl.validateStock(stockForm.$valid)">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-section')
    <script src="{{ asset('assets/scripts/product/ProductController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/product/ProductProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>

    <!-- <script type="text/javascript">
        $(document).ready(function () {
            $('#ProductModal').on('shown.bs.modal', function() {
                $("#descriptionProduct").focus();
            });
        });
    </script> -->
@endsection