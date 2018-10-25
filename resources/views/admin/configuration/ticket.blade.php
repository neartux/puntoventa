@extends('admin.layouts.app')

@section('content')

    <style>
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            border-top: none !important;
        }
        .table > tfoot > tr > td {
            border-top: none !important;
        }
    </style>

    <div ng-cloak class="page-content" data-ng-app="Ticket" data-ng-controller="TicketController as ctrl"
         data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Configuracion Ticket</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="{{ route('point_sale_view') }}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Ticket</span>
                </li>
            </ul>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-printerr font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Ticket</span>
                        </div>
                        <div class="actions btn-set"></div>
                    </div>
                    <div class="portlet-body">


                        <div class="row">

                            <div class="col-sm-12">

                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="bold">Logo (<i class="fa fa-arrows-h"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesLogo();"
                                                   data-ng-model="ctrl.configurationStyle.logo_x">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Logo (<i class="fa fa-arrows-v"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesLogo();"
                                                   data-ng-model="ctrl.configurationStyle.logo_y">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Tamaño</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesLogo();"
                                                   data-ng-model="ctrl.configurationStyle.logo_size">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="bold">Cabecera (<i class="fa fa-arrows-h"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesHeader();"
                                                   data-ng-model="ctrl.configurationStyle.header_x">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Cabecera (<i class="fa fa-arrows-v"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesHeader();"
                                                   data-ng-model="ctrl.configurationStyle.header_y">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Tamaño Fuente (<i class="fa fa-font"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesHeader();"
                                                   data-ng-model="ctrl.configurationStyle.header_size">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="bold">Folio (<i class="fa fa-arrows-h"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesFolio();"
                                                   data-ng-model="ctrl.configurationStyle.folio_x">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Folio (<i class="fa fa-arrows-v"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesFolio();"
                                                   data-ng-model="ctrl.configurationStyle.folio_y">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Tamaño Fuente (<i class="fa fa-font"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesFolio();"
                                                   data-ng-model="ctrl.configurationStyle.folio_size">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="bold">Fecha (<i class="fa fa-arrows-h"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesDate();"
                                                   data-ng-model="ctrl.configurationStyle.date_x">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Fecha (<i class="fa fa-arrows-v"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesDate();"
                                                   data-ng-model="ctrl.configurationStyle.date_y">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Tamaño Fuente (<i class="fa fa-font"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesDate();"
                                                   data-ng-model="ctrl.configurationStyle.date_size">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="bold">Body (<i class="fa fa-arrows-h"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesBody();"
                                                   data-ng-model="ctrl.configurationStyle.body_x">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Body (<i class="fa fa-arrows-v"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesBody();"
                                                   data-ng-model="ctrl.configurationStyle.body_y">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Tamaño Fuente (<i class="fa fa-font"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesBody();"
                                                   data-ng-model="ctrl.configurationStyle.body_size">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="bold">Footer (<i class="fa fa-arrows-h"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesFooter();"
                                                   data-ng-model="ctrl.configurationStyle.footer_x">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Footer (<i class="fa fa-arrows-v"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesFooter();"
                                                   data-ng-model="ctrl.configurationStyle.footer_y">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="bold">Tamaño Fuente (<i class="fa fa-font"></i>)</label>
                                            <input type="number" class="form-control" data-ng-change="ctrl.applyChangesFooter();"
                                                   data-ng-model="ctrl.configurationStyle.footer_size">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="bold">Pie Página</label>
                                            <textarea class="form-control" id="" cols="30" rows="5"
                                                      data-ng-model="ctrl.configurationStyle.comments">

                                        </textarea>
                                        </div>
                                        <div class="col-sm-12 mt-lg">
                                            <button class="btn btn-primary" data-ng-click="ctrl.saveConfiguration()">
                                                <i class="fa fa-save"></i>
                                                Guardar Configuración
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-8">

                                    <div class="row ticket-area" style="border: 1px solid red; height: 500px">

                                        <img src="{{ asset('assets/img/logo-ticket.png') }}"
                                             ng-style="ctrl.logoStyle">

                                        <div ng-style="ctrl.headerStyle"
                                             class="text-center uppercase">
                                            @{{ ctrl.storeTO.company_name }}
                                            <br>
                                            @{{ ctrl.storeTO.address }}
                                            <br>
                                            @{{ ctrl.storeTO.city }}
                                        </div>

                                        <div ng-style="ctrl.folioStyle"
                                             class="uppercase">
                                            Folio: 352
                                        </div>

                                        <div ng-style="ctrl.dateStyle">
                                            11/03/2018 9:55 am
                                        </div>

                                        <div ng-style="ctrl.bodyStyle" class="adf">
                                            <table class="table table-striped table-condensed flip-content">
                                                <thead>
                                                <tr class="uppercase">
                                                    <th ng-style="ctrl.bodyStyle">Cant.</th>
                                                    <th ng-style="ctrl.bodyStyle">Descripción</th>
                                                    <th ng-style="ctrl.bodyStyle">Importe</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td ng-style="ctrl.bodyStyle">1.00</td>
                                                    <td ng-style="ctrl.bodyStyle">Aceite itk 4t</td>
                                                    <td ng-style="ctrl.bodyStyle">57</td>
                                                </tr>
                                                <tr>
                                                    <td ng-style="ctrl.bodyStyle">1.00</td>
                                                    <td ng-style="ctrl.bodyStyle">Aceite itk 4t</td>
                                                    <td ng-style="ctrl.bodyStyle">57</td>
                                                </tr>
                                                </tbody>
                                                <tfoot>
                                                <tr class="text-right">
                                                    <td ng-style="ctrl.bodyStyle" colspan="2" class="text-right">
                                                        No. Articulos:
                                                    </td>
                                                    <td ng-style="ctrl.bodyStyle" class="text-left">1</td>
                                                </tr>
                                                <tr class="text-right">
                                                    <td colspan="2" ng-style="ctrl.bodyStyle" class="text-right">
                                                        Pago con:
                                                    </td>
                                                    <td colspan="2" class="text-left" ng-style="ctrl.bodyStyle">
                                                        60
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td ng-style="ctrl.bodyStyle" colspan="2" class="text-right">Cambio</td>
                                                    <td class="text-left" ng-style="ctrl.bodyStyle">3</td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div ng-style="ctrl.footerStyle" class="text-center uppercase">
                                            @{{ ctrl.configurationStyle.comments }}
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 mt-xl pl-n">
                                            <button class="btn btn-primary" onclick="print()">
                                                <i class="icon-printer"></i>
                                                Probar Impresión
                                            </button>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>



                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('script-section')
    <script src="{{ asset('assets/global/plugins/jQuery.print.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery.printarea.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/ticket/TicketController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/ticket/TicketProvider.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {

        });

        function print() {
            $(".ticket-area").printArea();
        };
    </script>
@endsection