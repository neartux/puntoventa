@extends('admin.layouts.app')

@section('content')

    <div ng-cloak class="page-content" data-ng-app="Ticket" data-ng-controller="TicketController as ctrl"
         data-ng-init="ctrl.init('{{ URL::to('/') }}')">

        <h1 class="page-title bold"> Cambio de Contrase&ntilde;a</h1>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="index.html">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Configuraci&oacute;n</span>
                </li>
            </ul>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-printerr font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase">Cambiar Contraseña</span>
                        </div>
                        <div class="actions btn-set"></div>
                    </div>
                    <div class="portlet-body">


                        <div class="row">

                            <div class="col-sm-12">

                                <div class="col-sm-4">

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
    <script src="{{ asset('assets/scripts/pointsale/ticket/TicketController.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/pointsale/ticket/TicketProvider.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@endsection