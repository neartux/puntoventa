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
            Folio: @{{ ctrl.saleTicket.id }}
        </div>

        <div ng-style="ctrl.dateStyle">
            @{{  ctrl.saleTicket.created_at | date:'dd/MM/yyyy hh:mm a'}}
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
                <tr data-ng-repeat="detail in ctrl.saleTicket.details">
                    <td ng-style="ctrl.bodyStyle">@{{ detail.quantity }}</td>
                    <td ng-style="ctrl.bodyStyle">@{{ detail.description }}</td>
                    <td ng-style="ctrl.bodyStyle">@{{ detail.product_price * detail.quantity | currency }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr class="text-right">
                    <td ng-style="ctrl.bodyStyle" colspan="2" class="text-right">
                        No. Articulos:
                    </td>
                    <td ng-style="ctrl.bodyStyle" class="text-left">
                        @{{ ctrl.saleTicket.totalProducts }}
                    </td>
                </tr>
                <tr class="text-right">
                    <td colspan="2" ng-style="ctrl.bodyStyle" class="text-right">
                        Total:
                    </td>
                    <td colspan="2" class="text-left" ng-style="ctrl.bodyStyle">
                        @{{ ctrl.saleTicket.total | currency }}
                    </td>
                </tr>
                <tr class="text-right">
                    <td colspan="2" ng-style="ctrl.bodyStyle" class="text-right">
                        Pago con:
                    </td>
                    <td colspan="2" class="text-left" ng-style="ctrl.bodyStyle">
                        @{{ ctrl.saleTicket.amount_pay | currency }}
                    </td>
                </tr>
                <tr>
                    <td ng-style="ctrl.bodyStyle" colspan="2" class="text-right">Cambio</td>
                    <td class="text-left" ng-style="ctrl.bodyStyle">
                        @{{ ctrl.saleTicket.amount_pay - ctrl.saleTicket.total | currency }}
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