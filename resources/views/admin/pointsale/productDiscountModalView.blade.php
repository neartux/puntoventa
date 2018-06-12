<div class="modal fade bs-modal-sm" id="productDiscountModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title pt-n pb-n bold">% Descuento Por Producto</h4>
            </div>
            <div class="modal-body">

                <div class="row form-body">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <h5>
                                <label><span class="bold">Producto:</span> @{{ ctrl.productSelected.description }}</label>
                                <br>
                                <br>
                                <label><span class="bold">Precio Venta:</span> @{{ ctrl.productSelected.priceOriginal | currency }}</label>
                            </h5>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <hr class="mt-n mb-n">
                    </div>
                    <div class="col-sm-12 text-center">
                        <div class="form-group">
                            <label class="bold">Porcentaje de Descuento</label>
                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                <input type="text" class="form-control numeric-field" id="percentDiscountByProduct"
                                    data-ng-model="ctrl.productSelected.percent_discount"
                                    data-ng-change="ctrl.calculatePriceByPorcentage();"
                                       data-ng-enter="ctrl.applyDiscountToProduct();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="bold">Precio con Descuento</label>
                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-dollar"></i>
                                                    </span>
                                <input type="text" class="form-control numeric-field"
                                       data-ng-change="ctrl.calculatePercentage()"
                                       data-ng-model="ctrl.productSelected.price"
                                       data-ng-enter="ctrl.applyDiscountToProduct();">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                <button type="button" class="btn yellow"
                        data-ng-click="ctrl.applyDiscountToProduct();"><i class="icon-plus"></i> Aplicar</button>
            </div>
        </div>
    </div>
</div>