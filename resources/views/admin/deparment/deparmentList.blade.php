@extends('admin.layouts.app')

@section('content')

    <div ng-cloak class="page-content" data-ng-app="Deparment" data-ng-controller="DeparmentController as ctrl" data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Departamentos</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Departamentos</span>
                </li>
            </ul>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-grid font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Departamentos</span>
                        </div>
                        <div class="actions btn-set">

                            <a href="javascript:;" class="btn btn-circle btn-default"
                               data-ng-click="ctrl.showCreateDeparment();">
                                <i class="fa fa-plus"></i>
                                Crear Departamento
                            </a>

                        </div>
                    </div>
                    <div class="portlet-body">


                        <div class="row">

                            <div class="col-sm-12" data-ng-show="!ctrl.deparmentList.data.length">
                                <div class="alert alert-success">
                                    <strong>Aviso!</strong> No se han creado departamentos. </div>
                            </div>

                            <div class="col-sm-12" data-ng-show="ctrl.deparmentList.data.length">

                                <table dt-column-defs="ctrl.dtColumnDefs" datatable="ng" dt-instance="ctrl.dtInstance"
                                       dt-options="ctrl.dtOptions" class="table table-bordered table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripcion</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="odd gradeX" data-ng-repeat="deparment in ctrl.deparmentList.data">
                                        <td>
                                            @{{ $index + 1 }}
                                        </td>
                                        <td>
                                            @{{ deparment.description  }}
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-xs blue"
                                                data-ng-click="ctrl.showEditDeparment($index, deparment)">
                                                <i class="icon-note"></i>
                                                Modificar
                                            </a>
                                            <a href="javascript:;" class="btn btn-xs red"
                                                data-ng-click="ctrl.deleteDeparment($index, deparment.id)">
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
        </div>

        <div class="modal fade bs-modal-sm" id="deparmentModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form name="deparmentForm" novalidate>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title bold">@{{ ctrl.titleFormAction }}</h4>
                        </div>
                        <div class="modal-body profile-userpic">

                            <div class="portlet light mb-n">

                                <div class="row">
                                    <div class="form-group" ng-class="{ 'has-error' : deparmentForm.description.$invalid && !deparmentForm.description.$pristine }">
                                        <label for="adjustQuantity"
                                               class="col-md-12 control-label bold">Descripción</label>
                                        <br>
                                        <div class="col-md-12">
                                            <input type="text" name="description" data-ng-model="ctrl.deparment.description"
                                                   class="form-control" required id="descriptionDeparment" maxlength="50">
                                            <span ng-show="deparmentForm.description.$invalid && !deparmentForm.description.$pristine"
                                                  class="help-block">La descripción es requerido.</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
                            <button type="button" data-ng-disabled="deparmentForm.$invalid" class="btn green"
                                    data-ng-click="ctrl.validateDeparment(deparmentForm.$valid)">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('script-section')
    <script src="{{ asset('assets/scripts/deparment/DeparmentController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/deparment/DeparmentProvider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angular-datatable/angular-datatables.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#deparmentModal').on('shown.bs.modal', function() {
                $("#descriptionDeparment").focus();
            });
        });
    </script>
@endsection