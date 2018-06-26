<div class="modal fade bs-modal-sm" id="previewStockProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Ajuste de producto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6 pr-n pl-n">
                            <h5 class="mb-xs">Producto</h5>
                            <span class="font-blue-madison bold">
                                    @{{ ctrl.productTO.code }} @{{ ctrl.productTO.description }}
                                </span>
                        </div>
                        <div class="col-sm-6 text-right pr-n pl-n">
                            <h5 class="mb-xs">Mínimo en Inventario.</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.minimum_stock }}
                                    </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6 pr-n pl-n">
                            <h5 class="mb-xs">Deparmentento</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.department }}
                                    </span>
                        </div>
                        <div class="col-sm-6 text-right pr-n pl-n">
                            <h5 class="mb-xs">Unidad</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.unit }}
                                    </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6 pr-n pl-n">
                            <h5 class="mb-xs">Precio Compra</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.purchase_price | currency }}
                                    </span>
                        </div>
                        <div class="col-sm-6 pr-n pl-n text-right">
                            <h5 class="mb-xs">Precio venta</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.sale_price | currency }}
                                    </span>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6 pr-n pl-n">
                            <h5 class="mb-xs">Precio Mayoreo</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.wholesale_price | currency }}
                                    </span>
                        </div>
                        <div class="col-sm-6 text-right pr-n pl-n">
                            <h5 class="mb-xs">Inventario Actual</h5>
                            <span class="font-blue-madison bold">
                                        @{{ ctrl.productTO.current_stock }}
                                    </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6 pl-n">
                            <h5 class="mb-xs font-yellow bold">Razon de ajuste</h5>
                            <select name="adjusmentReason" id="adjusmentReason" class="form-control"
                                    data-ng-model="ctrl.productTO.adjusmentReason" required
                                    data-ng-change="ctrl.selectReasonAdjustment();"
                                    ng-options="item as item.description for item in ctrl.adjusmentReasons.data">
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                        <div class="col-sm-6 text-right pr-n">
                            <h5 class="mb-xs font-yellow bold">Cantidad de ajuste</h5>
                            <input type="text" class="form-control numeric-field" required
                                   data-ng-model="ctrl.productTO.quantity_adjust"
                                   data-ng-change="ctrl.calculateNewQuantityStock();">
                        </div>
                    </div>
                    <div class="col-sm-12 text-center">
                        <h5 class="mb-xs font-yellow bold">Nuevo Inventario</h5>
                        <span class="bold" data-ng-class="ctrl.productTO.newQuantityStock >= 0 ? 'font-blue-madison' : 'font-red'">
                            @{{ ctrl.productTO.newQuantityStock }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" data-ng-disabled="productForm.$invalid" class="btn blue"
                        data-ng-click="ctrl.applyAdjustProduct()">Aplicar</button>
            </div>
        </div>
    </div>
</div>