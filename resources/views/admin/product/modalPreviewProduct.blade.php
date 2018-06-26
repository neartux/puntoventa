<div class="modal fade bs-modal-sm" id="previewProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Detalle de producto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h5 class="mb-xs">Producto</h5>
                        <span class="font-blue-madison bold">
                                    @{{ ctrl.productTO.code }} @{{ ctrl.productTO.description }}
                                </span>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-5 pr-n pl-n">
                            <h5 class="mb-xs">Precio Compra</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.purchase_price | currency }}
                                    </span>
                        </div>
                        <div class="col-sm-7 text-right pr-n pl-n">
                            <h5 class="mb-xs">Deparmentento</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.department }}
                                    </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6 pr-n pl-n">
                            <h5 class="mb-xs">Precio venta</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.sale_price | currency }}
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
                            <h5 class="mb-xs">Precio Mayoreo</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.wholesale_price | currency }}
                                    </span>
                        </div>
                        <div class="col-sm-6 text-right pr-n pl-n">
                            <h5 class="mb-xs">Inventario Actual</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.current_stock }}
                                    </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6 pr-n pl-n"></div>
                        <div class="col-sm-6 text-right pr-n pl-n">
                            <h5 class="mb-xs">Mínimo en Inventario.</h5>
                            <span class="font-grey-mint bold">
                                        @{{ ctrl.productTO.minimum_stock }}
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>