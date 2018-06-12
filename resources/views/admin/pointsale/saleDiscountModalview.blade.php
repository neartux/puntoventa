<div class="modal fade bs-modal-sm" id="saleDiscountModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title pt-n pb-n bold">% Descuento General</h4>
            </div>
            <div class="modal-body">

                <div class="row form-body">
                    <div class="col-sm-12 text-center">
                        <span><i class="fa fa-sort-numeric-desc font-blue mb-xl mt fnt-sz-30"></i></span>
                    </div>
                    <div class="col-sm-12 text-center">
                        <div class="form-group">
                            <label class="bold">Porcentaje de Descuento</label>
                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                <input type="text" class="form-control numeric-field" id="percentDiscountSale"
                                       data-ng-model="ctrl.discountGeneralSale"
                                       data-ng-enter="ctrl.applyDiscountToSale();">
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                <button type="button" class="btn yellow"
                        data-ng-click="ctrl.applyDiscountToSale();"><i class="icon-plus"></i> Aplicar</button>
            </div>
        </div>
    </div>
</div>