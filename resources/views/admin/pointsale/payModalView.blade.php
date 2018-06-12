<div class="modal fade bs-modal-sm" id="payModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title pt-n pb-n bold">Pago Venta</h4>
            </div>
            <div class="modal-body">

                <div class="row text-center">
                    <div class="col-sm-12">
                        <h3 class="m-n text-info bold">Importe Total</h3>
                        <span class="text-bold fnt-sz-20 bold">@{{ ctrl.ventaCompleta.total | currency }}</span>

                    </div>
                    <div class="col-sm-12">
                        <h3 class="text-info bold">Monto</h3>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <input type="text" data-ng-model="ctrl.ventaCompleta.amount_pay" class="form-control numeric-field fnt-sz-20 importe-venta"
                                   data-ng-change="ctrl.calculaCambioVenta();" data-ng-enter="ctrl.createSale();"
                                   style="width: 100%;"/>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                    <div class="col-sm-12">
                        <h3 class="text-info bold">Cambio</h3>
                        <span class="text-bold fnt-sz-20 bold">@{{ ctrl.ventaCompleta.cambio | currency }}</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>