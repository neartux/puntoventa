@extends('admin.layouts.app')

@section('content')

    <div ng-cloak class="page-content" data-ng-app="Security" data-ng-controller="SecurityController as ctrl"
         data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Cambio de Contrase&ntilde;a</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Configuraci&oacute;n</span>
                </li>
            </ul>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet box blue ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-lock"></i> Cambiar Password </div>
                    </div>
                    <div class="portlet-body form">
                        <form novalidate name="securityForm">
                            <div class="form-body">
                                <div class="form-group has-success"
                                     ng-class="{'has-error' : securityForm.old_password.$invalid && !securityForm.old_password.$pristine }">
                                    <label class="control-label">Contrase&ntilde;a Anterior</label>
                                    <input type="password" class="form-control" name="old_password"
                                           ng-model="ctrl.formData.old_password" maxlength="15" required> </div>
                                <div class="form-group has-warning"
                                     ng-class="{'has-error' : securityForm.new_password.$invalid && !securityForm.new_password.$pristine }">
                                    <label class="control-label">Nueva Contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="new_password"
                                           ng-model="ctrl.formData.new_password" maxlength="15" required> </div>
                                <div class="form-group has-warning"
                                     ng-class="{'has-error' : securityForm.new_password2.$invalid && !securityForm.new_password2.$pristine }">
                                    <label class="control-label">Repetir Contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="new_password2"
                                           ng-model="ctrl.formData.new_password2" maxlength="15" required> </div>
                            </div>
                            <div class="form-actions">
                                <a href="javascript:;"
                                   data-ng-disabled="securityForm.$invalid"
                                   ng-click="ctrl.changePassword();"
                                   class="btn blue">Aceptar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script-section')
    <script src="{{ asset('assets/scripts/security/SecurityController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/security/SecurityProvider.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@endsection