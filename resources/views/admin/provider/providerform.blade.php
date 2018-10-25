<div class="portlet light " data-ng-show="!ctrl.showProviderList">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-user font-dark"></i>
            <span class="caption-subject font-dark bold uppercase">Datos Del Proveedor</span>
        </div>
        <div class="actions btn-set">

            <a href="javascript:;" class="btn btn-circle btn-default"
               data-ng-click="ctrl.showProviderList = true;">
                <i class="icon-action-undo"></i>
                Regresar
            </a>

        </div>
    </div>
    <div class="portlet-body">


        <div class="row">

            <div class="col-sm-12">

                <form class="form-horizontal form-row-seperated" name="providerForm" novalidate>
                    <div class="form-body mt-xl">

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Empresa:
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control border-input" name="company_name" data-ng-model="ctrl.provider.company_name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nombres:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control border-input" name="name" data-ng-model="ctrl.provider.name"
                                           required>
                                    <span ng-show="providerForm.name.$invalid && !providerForm.name.$pristine"
                                          class="text-danger">Los nombres son requeridos.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Apellidos:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control border-input" name="last_name"
                                           data-ng-model="ctrl.provider.last_name" required>
                                    <span ng-show="providerForm.last_name.$invalid && !providerForm.last_name.$pristine"
                                          class="text-danger">Los apellidos son requeridos.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Dirección:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address"
                                           data-ng-model="ctrl.provider.address" required>
                                    <span ng-show="providerForm.address.$invalid && !providerForm.address.$pristine"
                                          class="text-danger">La dirección es requerido.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Ciudad:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="ciudad"
                                           data-ng-model="ctrl.provider.ciudad" required>
                                    <span ng-show="providerForm.ciudad.$invalid && !providerForm.ciudad.$pristine"
                                          class="text-danger">La ciudad es requerido.</span>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Teléfono:
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone"
                                           data-ng-model="ctrl.provider.phone">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Celular:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cell_phone"
                                           data-ng-model="ctrl.provider.cell_phone" required>
                                    <span ng-show="providerForm.cell_phone.$invalid && !providerForm.cell_phone.$pristine"
                                          class="text-danger">El celular es requerido.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Correo Eléctronico:
                                </label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email"
                                           data-ng-model="ctrl.provider.email">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">&nbsp;</label>
                                <div class="col-md-6">
                                    <a href="javascript:;" class="btn btn-info btn-fill btn-wd" style="float: right;"
                                       data-ng-click="ctrl.validateProvider(providerForm.$valid);"
                                       data-ng-disabled="providerForm.$invalid">
                                        <i class="fa fa-save"></i> Guardar
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>

            </div>

        </div>



    </div>
</div>