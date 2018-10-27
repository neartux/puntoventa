@extends('admin.layouts.app')

@section('content')
    <div ng-cloak class="page-content" data-ng-app="Security" data-ng-controller="SecurityController as ctrl" data-ng-init="ctrl.initUser('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Usuarios</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Usuarios</span>
                </li>
            </ul>

        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-users font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Usuarios</span>
                        </div>
                        <div class="actions btn-set">

                            <a href="javascript:;" class="btn btn-circle btn-default"
                               data-ng-click="ctrl.showCreateUser();">
                                <i class="fa fa-plus"></i>
                                Crear Usuario
                            </a>

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12" data-ng-if="!ctrl.userList.data.length">
                            <div class="alert alert-success">
                                <strong>Aviso!</strong> No se han creado usuarios. </div>
                        </div>

                        <div class="col-sm-12" data-ng-if="ctrl.userList.data.length>0">

                            <table dt-column-defs="ctrl.dtColumnDefs" datatable="ng" dt-instance="ctrl.dtInstance"
                                   dt-options="ctrl.dtOptions" class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Direcci&oacute;n</th>
                                    <th>Celular</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="odd gradeX" data-ng-repeat="user in ctrl.userList.data">
                                    <td>
                                        @{{ user.name}} @{{ user.last_name}}
                                    </td>
                                    <td>
                                        @{{ user.user_name}}
                                    </td>
                                    <td>
                                        @{{ user.address }}
                                    </td>
                                    <td>
                                        @{{ user.cell_phone }}
                                    </td>
                                    <td>
                                        @{{ user.email }}
                                    </td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-xs blue"
                                           data-ng-click="ctrl.showEditUser(user)">
                                            <i class="icon-note"></i>
                                            Modificar
                                        </a>
                                        <a href="javascript:;" class="btn btn-xs green"
                                           data-ng-click="ctrl.changePasswordView(user)">
                                            <i class="icon-note"></i>
                                            Cambiar Password
                                        </a>
                                        <a href="javascript:;" class="btn btn-xs red"
                                           data-ng-click="ctrl.deleteUser(user.id)">
                                            <i class="icon-trash"></i>
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('admin.user.modalDataUser')

        @include('admin.user.modalChangePassword')

        @include('admin.user.modalRoles')


    </div>
@endsection

@section('script-section')
    <script src="{{ asset('assets/scripts/security/SecurityController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/security/SecurityProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>
@endsection