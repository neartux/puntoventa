<div class="modal fade bs-modal-sm" id="dataProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">
                    <span class="">@{{ ctrl.titleFormAction }}</span>
                </h4>
            </div>
            <form name="productForm" novalidate>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-sm-12">
                            <h5 class="bold font-yellow uppercase mt-n">General</h5>
                            <hr class="mt-n mb-n">
                        </div>

                        <div class="col-sm-12">
                            <div class="col-sm-6 pr-n pl-n">
                                <div class="form-group mb-n" ng-class="{ 'has-error' : productForm.code.$invalid && !productForm.code.$pristine }">
                                    <h5 class="mb-xs">Código *</h5>
                                    <span class="font-blue-madison bold input-icon">
                                        <i class="fa fa-barcode"></i>
                                            <input type="text" name="code" data-ng-model="ctrl.productTO.code" minlength="2"
                                                   class="form-control input-small" required maxlength="50" id="productCode">
                                        <span ng-show="productForm.code.$invalid && !productForm.code.$pristine"
                                              class="help-block font-size11">El código es requerido</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 pr-n">
                                <div class="form-group mb-n" ng-class="{ 'has-error' : productForm.description.$invalid && !productForm.description.$pristine }">
                                <h5 class="mb-xs">Descripción *</h5>
                                <span class="font-blue-madison bold input-icon">
                                    <i class="icon-social-dropbox"></i>
                                        <input type="text" name="description" data-ng-model="ctrl.productTO.description"
                                               class="form-control" maxlength="100" required>
                                    <span ng-show="productForm.description.$invalid && !productForm.description.$pristine"
                                          class="help-block font-size11">La descripción es requerido</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="col-sm-6 pl-n">
                                <div class="form-group mb-n" ng-class="{ 'has-error' : productForm.department_id.$invalid && !productForm.department_id.$pristine }">
                                <h5 class="mb-xs">Deparmentento *</h5>
                                <span class="font-grey-mint bold input-icon">
                                    <i class="icon-grid"></i>
                                            <select name="department_id" data-ng-model="ctrl.productTO.deparment_id"
                                                    class="form-control" required>
                                                <option value="">Selecciona</option>
                                                <option value="@{{ deparment.id }}" data-ng-repeat="deparment in ctrl.deparments.data">
                                                    @{{ deparment.description }}
                                                </option>
                                            </select>
                                    <span ng-show="productForm.department_id.$invalid && !productForm.department_id.$pristine"
                                          class="help-block font-size11">Selecciona un departamento</span>
                                        </span>
                                </div>
                            </div>
                            <div class="col-sm-6 pr-n">
                                <div class="form-group mb-n" ng-class="{ 'has-error' : productForm.unit_id.$invalid && !productForm.unit_id.$pristine }">
                                <h5 class="mb-xs">Unidad *</h5>
                                <span class="font-grey-mint bold input-icon">
                                    <span class="font-grey-mint bold input-icon">
                                        <i class="icon-tag"></i>
                                            <select name="unit_id" data-ng-model="ctrl.productTO.unit_id"
                                                    class="form-control" required>
                                                <option value="">Selecciona</option>
                                                <option value="@{{ unit.id }}" data-ng-repeat="unit in ctrl.unities.data">
                                                    @{{ unit.description }}
                                                </option>
                                            </select>
                                        <span ng-show="productForm.unit_id.$invalid && !productForm.unit_id.$pristine"
                                              class="help-block font-size11">Selecciona una unidad</span>
                                        </span>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h5 class="bold font-yellow uppercase mt-lg">Precios</h5>
                            <hr class="mt-n mb-n">
                        </div>

                        <div class="col-sm-12 pr-n pl-n">
                            <div class="col-sm-6 pr-n pl-n">
                                <div class="form-group mb-n" ng-class="{ 'has-error' : productForm.purchase_price.$invalid && !productForm.purchase_price.$pristine }">
                                <h5 class="mb-xs">Precio Compra *</h5>
                                <span class="font-grey-mint bold input-icon">
                                    <i class="fa fa-dollar"></i>
                                            <input type="text" name="purchase_price" data-ng-model="ctrl.productTO.purchase_price"
                                                   class="form-control numeric-field input-small" required maxlength="8">
                                    <span ng-show="productForm.purchase_price.$invalid && !productForm.purchase_price.$pristine"
                                          class="help-block font-size11">El precio de compra es requerido</span>
                                        </span>
                                </div>
                            </div>

                            <div class="col-sm-6 pr-n">
                                <div class="form-group mb-n" ng-class="{ 'has-error' : productForm.sale_price.$invalid && !productForm.sale_price.$pristine }">
                                <h5 class="mb-xs">Precio venta *</h5>
                                <span class="font-grey-mint bold input-icon">
                                    <i class="fa fa-dollar"></i>
                                            <input type="text" name="sale_price" data-ng-model="ctrl.productTO.sale_price"
                                                   class="form-control numeric-field input-small" required maxlength="8">
                                    <span ng-show="productForm.sale_price.$invalid && !productForm.sale_price.$pristine"
                                          class="help-block font-size11">El precio de venta es requerido</span>
                                        </span>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 pr-n pl-n">
                            <div class="col-sm-6 pr-n pl-n">
                                <div class="form-group mb-n" ng-class="{ 'has-error' : productForm.wholesale_price.$invalid && !productForm.wholesale_price.$pristine }">
                                <h5 class="mb-xs">Precio Mayoreo *</h5>
                                <span class="font-grey-mint bold input-icon">
                                    <i class="fa fa-dollar"></i>
                                            <input type="text" name="wholesale_price" data-ng-model="ctrl.productTO.wholesale_price"
                                                   class="form-control numeric-field input-small" required maxlength="8">
                                    <span ng-show="productForm.wholesale_price.$invalid && !productForm.wholesale_price.$pristine"
                                          class="help-block font-size11">El precio mayoreo es requerido</span>
                                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h5 class="bold font-yellow uppercase mt-lg">Inventario</h5>
                            <hr class="mt-n mb-n">
                        </div>

                        <div class="col-sm-12 pr-n pl-n">
                            <div class="col-sm-6 pr-n pl-n">
                                <div class="form-group" ng-class="{ 'has-error' : productForm.minimum_stock.$invalid && !productForm.minimum_stock.$pristine }">
                                <h5 class="mb-xs">Mínimo en Inventario *</h5>
                                <span class="font-grey-mint bold input-icon">
                                    <i class="fa fa-inbox"></i>
                                            <input type="text" name="minimum_stock" data-ng-model="ctrl.productTO.minimum_stock"
                                                   class="form-control numeric-field input-small" required maxlength="8">
                                    <span ng-show="productForm.minimum_stock.$invalid && !productForm.minimum_stock.$pristine"
                                          class="help-block font-size11">El mínimo de inventario es requerido</span>
                                        </span>
                                </div>
                            </div>
                            <div class="col-sm-6" data-ng-show="ctrl.isCreateProduct">
                                <div class="form-group">
                                    <h5 class="mb-xs">Inventario Actual *</h5>
                                    <span class="font-grey-mint bold input-icon">
                                    <i class="icon-home"></i>
                                            <input type="text" name="current_stock" data-ng-model="ctrl.productTO.current_stock"
                                                   class="form-control numeric-field input-small" maxlength="8">
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark" data-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" data-ng-disabled="productForm.$invalid" class="btn blue"
                            data-ng-click="ctrl.validateProduct(productForm.$valid)">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>