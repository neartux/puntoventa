<div class="modal fade bs-modal-sm" id="changePassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">
                    <span class="">Usuario @{{ ctrl.userTO.user_name }}</span>
                </h4>
            </div>
            <form name="rolesForm" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="bold font-yellow uppercase mt-n">Agregar Roles</h5>
                            <hr class="mt-n mb-n">
                        </div>
                    </div>
                    <div class="row">
                        <!-- TODO pendiente toeo este proceso, se agregara nota que al crear un usuario se le asignara automaticamente el role de cajero -->


                        <div class="col-sm-12">
                            <div class="form-body">
                                <div class="form-group has-warning"
                                     ng-class="{'has-error' : securityForm.password.$invalid && !securityForm.password.$pristine }">
                                    <label class="control-label">Nueva Contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="password"
                                           ng-model="ctrl.userTO.password" maxlength="15" required></div>
                                <div class="form-group has-warning"
                                     ng-class="{'has-error' : securityForm.password_confirmation.$invalid && !securityForm.password_confirmation.$pristine }">
                                    <label class="control-label">Repetir Contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                           ng-model="ctrl.userTO.password_confirmation" maxlength="15" required></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark" data-dismiss="modal">
                        Cerrar
                    </button>
                    <a href="javascript:;"
                       data-ng-disabled="rolesForm.$invalid"
                       ng-click="ctrl.addRolesUser();"
                       class="btn blue">Aceptar</a>
                </div>
            </form>
        </div>
    </div>
</div>