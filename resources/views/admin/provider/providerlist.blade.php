@extends('admin.layouts.app')

@section('content')

    <div ng-cloak class="page-content" data-ng-app="Provider" data-ng-controller="ProviderController as ctrl" data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Proveedores</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Proveedores</span>
                </li>
            </ul>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light " data-ng-show="ctrl.showProviderList">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-users font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Lista De Proveedores</span>
                        </div>
                        <div class="actions btn-set">

                            <a href="javascript:;" class="btn btn-circle btn-default"
                               data-ng-click="ctrl.showCreateProvider();">
                                <i class="fa fa-plus"></i>
                                Nuevo Proveedor
                            </a>

                        </div>
                    </div>
                    <div class="portlet-body">


                        <div class="row">

                            <div class="col-sm-12" data-ng-show="!ctrl.providerList.length">
                                <div class="alert alert-success">
                                    <strong>Aviso!</strong> No se han creado proveedores. </div>
                            </div>

                            <div class="col-sm-12" data-ng-show="ctrl.providerList.length">

                                <table dt-column-defs="ctrl.dtColumnDefs" datatable="ng" dt-instance="ctrl.dtInstance"
                                       dt-options="ctrl.dtOptions" class="table table-bordered table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th width="3%" class="bold">#</th>
                                        <th width="20%" class="bold">Nombre</th>
                                        <th class="bold">Dirección</th>
                                        <th width="10%" class="bold">Celular</th>
                                        <th width="10%" class="bold">Correo</th>
                                        <th width="25%" class="bold">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr data-ng-repeat="provider in ctrl.providerList">
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ provider.name }} @{{ provider.last_name }}</td>
                                        <td>@{{ provider.address }}</td>
                                        <td>@{{ provider.cell_phone }}</td>
                                        <td>@{{ provider.email }}</td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-xs blue"
                                               title="Editar @{{ provider.name }} @{{ provider.last_name }}"
                                               data-ng-click="ctrl.showUpdateProvider(provider, $index);">
                                                <i class="icon-note"></i>
                                                Modificar
                                            </a>
                                            <a href="javascript:;" class="btn btn-xs red"
                                               title="Eliminar @{{ provider.name }} @{{ provider.last_name }}"
                                               data-ng-click="ctrl.deleteProvider(provider.id, $index);">
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

                @include('admin/provider/providerform')

            </div>
        </div>


    </div>

@endsection

@section('script-section')
    <script src="{{ asset('assets/scripts/provider/ProviderController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/provider/ProviderProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
        });
    </script>
@endsection