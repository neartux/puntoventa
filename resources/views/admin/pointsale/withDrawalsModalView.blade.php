<div class="modal fade" id="retirosModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="deparmentForm" novalidate>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title bold">Retiros</h4>
                </div>
                <div class="modal-body profile-userpic">

                    <div class="portlet light mb-n">

                        <table class="table mb-n">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Referencia</th>
                                <th>Razon Retiro</th>
                                <th>Monto</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr data-ng-repeat="withdrawal in ctrl.withdrawalList.data">
                                <td>@{{ withdrawal.created_at | date:'dd/MM/yyyy hh:mm a' }}</td>
                                <td>@{{ withdrawal.reference }}</td>
                                <td>@{{ withdrawal.description }}</td>
                                <td>@{{ withdrawal.amount | currency }}</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6" class="bold text-right">
                                    Total @{{ ctrl.totalAmountWithdrawal | currency }}
                                </td>
                            </tr>
                            </tfoot>
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