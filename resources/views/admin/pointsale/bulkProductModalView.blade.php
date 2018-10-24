<div class="modal fade" id="bulkModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title pt-n pb-n bold">Cantidad del Producto</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="m-n font-blue bold text-center">
                            @{{ ctrl.temporalProductBulk.description }}
                        </h4>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <label for="quantityProduct" class="bold">Cantidad de Producto</label>
                            <input type="text" class="form-control" id="quantityProduct"
                                   data-ng-model="ctrl.temporalProductBulk.quantity"
                                   data-ng-change="ctrl.calculateBulkImportToProduct();"
                                   data-ng-enter="ctrl.addBulkProductToSale();">
                        </div>
                        <div class="col-sm-6">
                            <label for="currentImport" class="bold">Importe</label>
                            <input type="text" class="form-control" id="currentImport"
                                   data-ng-model="ctrl.temporalProductBulk.importInBulk"
                                   data-ng-change="ctrl.calculateQuantityBulkProduct();"
                                   data-ng-enter="ctrl.addBulkProductToSale();">
                        </div>
                    </div>
                    <div class="col-sm-12 text-center">
                        <h4 class="bold">Precio Unidad = @{{ ctrl.temporalProductBulk.price | currency }}</h4>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn yellow" data-ng-click="ctrl.addBulkProductToSale();"> Aceptar</button>
            </div>
        </div>
    </div>
</div>