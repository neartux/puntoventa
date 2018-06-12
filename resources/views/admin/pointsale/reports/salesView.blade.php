<div class="col-sm-12" data-ng-show="ctrl.sales.data.length">

    <table dt-column-defs="ctrl.dtColumnDefs" datatable="ng" dt-instance="ctrl.dtInstance"
           dt-options="ctrl.dtOptions" class="table table-bordered table-striped table-condensed">
        <thead>
        <tr class="bold">
            <th>Folio</th>
            <th>Fecha</th>
            <th>Vendedor</th>
            <th>Cliente</th>
            <th>Comentarios</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr class="odd gradeX" data-ng-repeat="sale in ctrl.sales.data"
            data-ng-class="sale.status_id == ctrl.status_cacelled ? 'bg-yellow-casablanca bg-font-yellow-casablanca' : ''">
            <td>@{{ sale.id }}</td>
            <td>@{{ sale.created_at | date }}</td>
            <td>@{{ sale.name_user }} @{{ sale.last_name_user }}</td>
            <td>@{{ sale.client_name }} @{{ sale.client_last_name }}</td>
            <td>@{{ sale.comments }}</td>
            <td>@{{ sale.total | currency }}</td>
            <td>
                <a href="javascript:;" class="btn btn-xs blue"
                   data-ng-click="ctrl.findDetailsBySale($index, sale);">
                    <i class="icon-magnifier"></i>
                    Ver
                </a>
                <a href="javascript:;" class="btn btn-xs yellow"
                   data-ng-click="ctrl.printTicketSale(sale);">
                    <i class="icon-printer"></i>
                    Imprimir
                </a>
                <a href="javascript:;" class="btn btn-xs red"
                   data-ng-click="ctrl.cancelSale($index, sale.id, false);"
                   data-ng-if="sale.status_id == '{{ StatusKeys::STATUS_ACTIVE }}' && ctrl.canCancelSale">
                    <i class="icon-ban"></i>
                    Cancelar
                </a>
                <span data-ng-if="sale.status_id == ctrl.status_cacelled"
                      class="bold">
                                                Cancelado
                                            </span>
            </td>
        </tr>
        </tbody>
    </table>

</div>