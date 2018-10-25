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
                                     ng-class="{'has-error' : securityForm.current_password.$invalid && !securityForm.current_password.$pristine }">
                                    <label class="control-label">Contrase&ntilde;a Actual</label>
                                    <input type="password" class="form-control" name="current_password"
                                           ng-model="ctrl.formData.current_password" maxlength="15" required> </div>
                                <div class="form-group has-warning"
                                     ng-class="{'has-error' : securityForm.password.$invalid && !securityForm.password.$pristine }">
                                    <label class="control-label">Nueva Contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="password"
                                           ng-model="ctrl.formData.password" maxlength="15" required> </div>
                                <div class="form-group has-warning"
                                     ng-class="{'has-error' : securityForm.password_confirmation.$invalid && !securityForm.password_confirmation.$pristine }">
                                    <label class="control-label">Repetir Contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                           ng-model="ctrl.formData.password_confirmation" maxlength="15" required> </div>
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