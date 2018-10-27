<div class="modal fade bs-modal-md" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form name="userForm" novalidate>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title bold">@{{ ctrl.titleFormAction }}</h4>
                </div>
                <div class="modal-body profile-userpic">

                    <div class="portlet light mb-n">

                        <div class="row">

                            <div class="col-sm-12">
                                <h5 class="bold font-yellow uppercase mt-n">Datos Generales</h5>
                                <hr class="mt-n mb-n">
                            </div>
                            <br>
                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" ng-class="{ 'has-error' : userForm.name.$invalid && !userForm.name.$pristine }">
                                        <label for="name"
                                               class="col-md-12 control-label bold">Nombres</label>
                                        <br>
                                        <div class="col-md-12">
                                            <input type="text" name="name" data-ng-model="ctrl.userTO.name"
                                                   class="form-control" id="name" required maxlength="50" tabindex="1">
                                            <span ng-show="userForm.name.$invalid && !userForm.name.$pristine"
                                                  class="help-block">El nombre es requerido.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" ng-class="{ 'has-error' : userForm.cell_phone.$invalid && !userForm.cell_phone.$pristine }">
                                        <label for="cell_phone"
                                               class="col-md-12 control-label bold">Celular</label>
                                        <br>
                                        <div class="col-md-12">
                                            <input type="text" name="cell_phone" data-ng-model="ctrl.userTO.cell_phone"
                                                   class="form-control" required id="cell_phone" maxlength="50" tabindex="4">
                                            <span ng-show="userForm.cell_phone.$invalid && !userForm.cell_phone.$pristine"
                                                  class="help-block">El celular es requerido.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" ng-class="{ 'has-error' : userForm.last_name.$invalid && !userForm.last_name.$pristine }">
                                        <label for="last_name"
                                               class="col-md-12 control-label bold">Apellidos</label>
                                        <br>
                                        <div class="col-md-12">
                                            <input type="text" name="last_name" data-ng-model="ctrl.userTO.last_name"
                                                   class="form-control" required id="last_name" maxlength="50" tabindex="2">
                                            <span ng-show="userForm.last_name.$invalid && !userForm.last_name.$pristine"
                                                  class="help-block">Los apellidos son necesarios.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" ng-class="{ 'has-error' : userForm.email.$invalid && !userForm.email.$pristine }">
                                        <label for="email"
                                               class="col-md-12 control-label bold">Email</label>
                                        <br>
                                        <div class="col-md-12">
                                            <input type="text" name="email" data-ng-model="ctrl.userTO.email"
                                                   class="form-control" required id="email" maxlength="50" tabindex="5">
                                            <span ng-show="userForm.email.$invalid && !userForm.email.$pristine"
                                                  class="help-block">El email es requerido.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" ng-class="{ 'has-error' : userForm.address.$invalid && !userForm.address.$pristine }">
                                        <label for="address"
                                               class="col-md-12 control-label bold">Dirección</label>
                                        <br>
                                        <div class="col-md-12">
                                            <input type="text" name="address" data-ng-model="ctrl.userTO.address"
                                                   class="form-control" required id="address" maxlength="50" tabindex="3">
                                            <span ng-show="userForm.address.$invalid && !userForm.address.$pristine"
                                                  class="help-block">La Dirección es requerido.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div ng-show="ctrl.isCreateUser">
                                <br><br>
                                <div class="col-sm-12">
                                    <h5 class="bold font-yellow uppercase mt-n">Datos de Usuario</h5>
                                    <hr class="mt-n mb-n">
                                </div>
                                <br><br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : userForm.user_name.$invalid && !userForm.user_name.$pristine && ctrl.isCreateUser }">
                                            <label for="user_name"
                                                   class="col-md-12 control-label bold">Nombre usuario</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="text" name="user_name" data-ng-model="ctrl.userTO.user_name"
                                                       class="form-control" ng-required="ctrl.isCreateUser" id="user_name" maxlength="30" tabindex="6">
                                                <span ng-show="userForm.user_name.$invalid && !userForm.user_name.$pristine && ctrl.isCreateUser"
                                                      class="help-block">El nombre de usuario es necesario.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : userForm.password.$invalid && !userForm.password.$pristine }">
                                            <label for="password"
                                                   class="col-md-12 control-label bold">Contraseña</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="password" name="password" data-ng-model="ctrl.userTO.password"
                                                       class="form-control" ng-required="ctrl.isCreateUser" id="password" maxlength="50" tabindex="7">
                                                <span ng-show="userForm.password.$invalid && !userForm.password.$pristine"
                                                      class="help-block">La contraseña es requerido.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : userForm.password_confirmation.$invalid && !userForm.password_confirmation.$pristine }">
                                            <label for="password_confirmation"
                                                   class="col-md-12 control-label bold">Repetir Contraseña</label>
                                            <br>
                                            <div class="col-md-12">
                                                <input type="password" name="password_confirmation" data-ng-model="ctrl.userTO.password_confirmation"
                                                       class="form-control" ng-required="ctrl.isCreateUser" id="password_confirmation" maxlength="50" tabindex="8">
                                                <span ng-show="userForm.password_confirmation.$invalid && !userForm.password_confirmation.$pristine"
                                                      class="help-block">Este campo es requerido.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
                    <button type="button" data-ng-disabled="userForm.$invalid" class="btn green"
                            data-ng-click="ctrl.validateUser(userForm.$valid)">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>