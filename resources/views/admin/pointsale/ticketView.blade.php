<div style="display: none;">


    <div class="row ticket-area">

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
            Folio: @{{ ctrl.ventaCompletaTO.saleId }}
        </div>

        <div ng-style="ctrl.dateStyle">
            @{{  ctrl.ventaCompletaTO.dateNow | date:'dd/MM/yyyy hh:mm a'}}
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
                <tr data-ng-repeat="product in ctrl.ventaCompletaTO.products">
                    <td ng-style="ctrl.bodyStyle">@{{ product.quantity | number: 2 }}</td>
                    <td ng-style="ctrl.bodyStyle">@{{ product.description }}</td>
                    <td ng-style="ctrl.bodyStyle">@{{ product.price * product.quantity | currency }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr class="text-right">
                    <td ng-style="ctrl.bodyStyle" colspan="2" class="text-right">
                        No. Articulos:
                    </td>
                    <td ng-style="ctrl.bodyStyle" class="text-left">
                        @{{ ctrl.ventaCompletaTO.totalProducts | number: 2}}
                    </td>
                </tr>
                <tr class="text-right">
                    <td colspan="2" ng-style="ctrl.bodyStyle" class="text-right">
                        Total:
                    </td>
                    <td colspan="2" class="text-left" ng-style="ctrl.bodyStyle">
                        @{{ ctrl.ventaCompletaTO.total | currency }}
                    </td>
                </tr>
                <tr class="text-right">
                    <td colspan="2" ng-style="ctrl.bodyStyle" class="text-right">
                        Pago con:
                    </td>
                    <td colspan="2" class="text-left" ng-style="ctrl.bodyStyle">
                        @{{ ctrl.ventaCompletaTO.amount_pay | currency }}
                    </td>
                </tr>
                <tr>
                    <td ng-style="ctrl.bodyStyle" colspan="2" class="text-right">Cambio</td>
                    <td class="text-left" ng-style="ctrl.bodyStyle">
                        @{{ ctrl.ventaCompletaTO.cambio | currency }}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>

        <div ng-style="ctrl.footerStyle" class="text-center uppercase">
            @{{ ctrl.configurationStyle.comments }}
        </div>


    </div>


</div>