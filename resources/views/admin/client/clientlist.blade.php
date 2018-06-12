@extends('admin.layouts.app')

@section('content')

    <div ng-cloak class="page-content" data-ng-app="Client" data-ng-controller="ClientController as ctrl" data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Clientes</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="index.html">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Clientes</span>
                </li>
            </ul>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light " data-ng-show="ctrl.showClientList">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-user font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Lista De Clientes</span>
                        </div>
                        <div class="actions btn-set">

                            <a href="javascript:;" class="btn btn-circle btn-default"
                               data-ng-click="ctrl.showCreateClient();">
                                <i class="fa fa-plus"></i>
                                Nuevo Cliente
                            </a>

                        </div>
                    </div>
                    <div class="portlet-body">


                        <div class="row">

                            <div class="col-sm-12" data-ng-show="!ctrl.clientList.length">
                                <div class="alert alert-success">
                                    <strong>Aviso!</strong> No se han creado clientes. </div>
                            </div>

                            <div class="col-sm-12" data-ng-show="ctrl.clientList.length">

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
                                    <tr data-ng-repeat="client in ctrl.clientList">
                                        <td>@{{ $index + 1 }}</td>
                                        <td>@{{ client.name }} @{{ client.last_name }}</td>
                                        <td>@{{ client.address }}</td>
                                        <td>@{{ client.cell_phone }}</td>
                                        <td>@{{ client.email }}</td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-xs blue"
                                               title="Editar @{{ client.name }} @{{ client.last_name }}"
                                               data-ng-click="ctrl.showUpdateClient(client, $index);">
                                                <i class="icon-note"></i>
                                                Modificar
                                            </a>
                                            <a href="javascript:;" class="btn btn-xs red"
                                               title="Eliminar @{{ client.name }} @{{ client.last_name }}"
                                               data-ng-click="ctrl.deleteClient(client.id, $index);">
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

                @include('admin/client/clientform')

            </div>
        </div>


    </div>

@endsection

@section('script-section')
    <script src="{{ asset('assets/scripts/client/ClientController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/client/ClientProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
        });
    </script>
@endsection