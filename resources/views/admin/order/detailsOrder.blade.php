<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 80%">
        <div class="modal-content">
            <form name="deparmentForm" novalidate>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title bold">Folio Pedido #@{{ ctrl.orderTO.id }}</h4>
                </div>
                <div class="modal-body profile-userpic">

                    <div class="portlet light mb-n">

                        <table class="table mb-n">
                            <thead>
                            <tr>
                                <th width="5%">Folio</th>
                                <th width="15%">Código</th>
                                <th>Producto</th>
                                <th width="15%">Cantidad</th>
                                <th width="10%">Stock</th>
                                <th width="10%">Último precio compra</th>
                                <th width="20%">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr data-ng-repeat="detail in ctrl.orderTO.details">
                                <td>@{{ detail.id }}</td>
                                <td>@{{ detail.code }}</td>
                                <td>@{{ detail.description }}</td>
                                <td>
                                    <span data-ng-show="!detail.updateQuantity">@{{ detail.quantity }}</span>
                                    <span data-ng-show="detail.updateQuantity">
                                        <input type="text" class="form-control numeric-field"
                                               data-ng-model="ctrl.orderTO.details[$index].quantityU">
                                    </span>
                                </td>
                                <td>@{{ detail.current_stock }}</td>
                                <td>@{{ detail.purchase_price | currency }}</td>
                                <td>
                                    <a href="javascript:;" class="btn btn-xs blue"
                                       data-ng-show="!detail.updateQuantity && ctrl.orderTO.status_id == '{{ StatusKeys::STATUS_OPEN }}'"
                                       data-ng-click="ctrl.showUpdateQuantity(detail);">
                                        <i class="icon-pencil"></i>
                                        Actualizar
                                    </a>
                                    <a href="javascript:;" class="btn btn-xs green-jungle"
                                       data-ng-show="detail.updateQuantity"
                                       data-ng-click="ctrl.updateQuantityProduct(detail);">
                                        <i class="fa fa-save"></i>
                                        Guardar
                                    </a>
                                    <a href="javascript:;" class="btn btn-xs yellow"
                                       data-ng-show="detail.updateQuantity"
                                       data-ng-click="detail.updateQuantity = false;">
                                        <i class="icon-ban"></i>
                                        Cancelar
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>