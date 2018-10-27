<div class="modal fade" id="closeCajaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title pt-n pb-n">
                    Corte del día: <span class="font-yellow bold">@{{ ctrl.cajaPreview.caja.opening_date_format }}</span>
                </h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <h4><span class="bold">Monto Ventas + Caja <br></span>
                                <span class="font-blue bold">
                                    @{{ ctrl.cajaPreview.amountSalesAndCaja | currency }}
                                </span></h4>
                        </div>
                        <div class="col-sm-6">
                            <h4><span class="bold">No. ventas <br></span>
                            <span class="font-yellow-gold bold">@{{ ctrl.cajaPreview.totalSales }}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-6">

                            <h4 class="bold">Resumen caja</h4>

                            <ul class="list-group">
                                <li class="list-group-item p-xs"> Apertura
                                    <span class="badge badge-blue-chambray fnt-sz-14 bold"> @{{ ctrl.cajaPreview.caja.opening_amount | currency }} </span>
                                </li>
                                <li class="list-group-item p-xs"
                                    data-ng-show="ctrl.cajaPreview.totalAmountSales"> Ventas
                                    <span class="badge badge-info fnt-sz-14 bold"> @{{ ctrl.cajaPreview.totalAmountSales | currency }} </span>
                                </li>
                                <li class="list-group-item p-xs"
                                    data-ng-show="ctrl.cajaPreview.amountCancelledSales"> Cancelaciones
                                    <span class="badge badge-danger fnt-sz-14 bold"> @{{ ctrl.cajaPreview.amountCancelledSales | currency }} </span>
                                </li>
                                <li class="list-group-item p-xs"
                                    data-ng-show="ctrl.cajaPreview.caja.total_withdrawals">
                                    <a href="javascript:;" data-ng-click="ctrl.viewWithDrawals();">
                                        Retiros
                                    </a>
                                    <span class="badge badge-danger fnt-sz-14 bold"> @{{ ctrl.cajaPreview.caja.total_withdrawals | currency }} </span>
                                </li>
                                <li class="list-group-item p-xs"
                                    data-ng-show="ctrl.cajaPreview.totalAmountSales"> Total
                                    <span class="badge badge-primary fnt-sz-14 bold"> @{{ ctrl.cajaPreview.finalAmount | currency }} </span>
                                </li>
                            </ul>

                        </div>
                        <div class="col-sm-6" data-ng-show="ctrl.cajaPreview.salesByDeparment.length">

                            <h4 class="bold">Ventas por departamento</h4>

                            <ul class="list-group">
                                <li data-ng-repeat="deparment in ctrl.cajaPreview.salesByDeparment" class="list-group-item p-xs">
                                    @{{ deparment.description }}
                                    <span class="badge badge-success fnt-sz-14 bold"> @{{ deparment.total | currency }} </span>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn yellow"
                        data-ng-click="ctrl.confirmCloseCaja();"><i class="icon-lock"></i> Cerrar Caja</button>
            </div>
        </div>
    </div>
</div>