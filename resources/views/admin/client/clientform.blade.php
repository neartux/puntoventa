<div class="portlet light " data-ng-show="!ctrl.showClientList">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-user font-dark"></i>
            <span class="caption-subject font-dark bold uppercase">Datos Cliente</span>
        </div>
        <div class="actions btn-set">

            <a href="javascript:;" class="btn btn-circle btn-default"
               data-ng-click="ctrl.showClientList = true;">
                <i class="icon-action-undo"></i>
                Regresar
            </a>

        </div>
    </div>
    <div class="portlet-body">


        <div class="row">

            <div class="col-sm-12">

                <form class="form-horizontal form-row-seperated" name="clientForm" novalidate>
                    <div class="form-body mt-xl">

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nombres:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control border-input" name="name" data-ng-model="ctrl.client.name"
                                           required>
                                    <span ng-show="clientForm.name.$invalid && !clientForm.name.$pristine"
                                          class="text-danger">Los nombres son requeridos.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Apellidos:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control border-input" name="last_name"
                                           data-ng-model="ctrl.client.last_name" required>
                                    <span ng-show="clientForm.last_name.$invalid && !clientForm.last_name.$pristine"
                                          class="text-danger">Los apellidos son requeridos.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Dirección:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address"
                                           data-ng-model="ctrl.client.address" required>
                                    <span ng-show="clientForm.address.$invalid && !clientForm.address.$pristine"
                                          class="text-danger">La dirección es requerido.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Ciudad:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="ciudad"
                                           data-ng-model="ctrl.client.ciudad" required>
                                    <span ng-show="clientForm.ciudad.$invalid && !clientForm.ciudad.$pristine"
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
                                           data-ng-model="ctrl.client.phone">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Celular:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cell_phone"
                                           data-ng-model="ctrl.client.cell_phone" required>
                                    <span ng-show="clientForm.cell_phone.$invalid && !clientForm.cell_phone.$pristine"
                                          class="text-danger">El celular es requerido.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Correo Eléctronico:
                                </label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email"
                                           data-ng-model="ctrl.client.email">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">&nbsp;</label>
                                <div class="col-md-6">
                                    <a href="javascript:;" class="btn btn-info btn-fill btn-wd" style="float: right;"
                                       data-ng-click="ctrl.validateClient(clientForm.$valid);"
                                       data-ng-disabled="clientForm.$invalid">
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