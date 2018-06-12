<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="deparmentForm" novalidate>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title bold">Folio venta #@{{ ctrl.sale.data.id }}</h4>
                </div>
                <div class="modal-body profile-userpic">

                    <div class="portlet light mb-n">

                        <table class="table mb-n">
                            <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr data-ng-repeat="detail in ctrl.sale.details">
                                <td>@{{ detail.id }}</td>
                                <td>@{{ detail.code }}</td>
                                <td>@{{ detail.description }}</td>
                                <td>@{{ detail.quantity }}</td>
                                <td>@{{ detail.product_price | currency }}</td>
                                <td>@{{ detail.quantity * detail.product_price | currency }}</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6" class="bold text-right">
                                    Total @{{ ctrl.sale.data.total | currency }}
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                        <div data-ng-if="ctrl.sale.data.status_id == ctrl.status_cacelled" class="row text-danger bold">
                            <h1 class="bold text-center">Venta Cancelada</h1>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <button type="button" class="btn yellow"
                            data-ng-click="ctrl.printTicketSale(ctrl.sale.data);"><i class="icon-printer"></i> Imprimir</button>
                    <button type="button" data-ng-if="ctrl.sale.data.status_id != ctrl.status_cacelled && ctrl.canCancelSale" class="btn red"
                            data-ng-click="ctrl.cancelSale(ctrl.sale.index, ctrl.sale.data.id, true)"><i class="icon-ban">
                        </i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>