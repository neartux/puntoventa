<div class="modal fade" id="withdrawalCajaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title pt-n pb-n">
                    Aplicar Retiro
                </h4>
            </div>
            <form novalidate name="formWithdrawal">
                <div class="modal-body pt-n">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <h5><span class="bold">Efectivo Disponible </span></h5>
                                <span class="font-blue bold">
                                    @{{ (ctrl.previewDataWithdrawal.data.totalCash - ctrl.previewDataWithdrawal.data.totalWithdrawal) | currency }}
                                </span>
                            </div>
                            <div class="col-sm-6">
                                <h5><span class="bold">Total Efectivo</span></h5>
                                <span class="font-yellow-gold bold">@{{ ctrl.previewDataWithdrawal.data.totalCash | currency }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-6">

                                <h5 class="bold">Efectivo Apertura Caja</h5>
                                <span class="font-yellow-gold bold">@{{ ctrl.previewDataWithdrawal.data.caja.opening_amount }}</span>
                            </div>
                            <div class="col-sm-6">

                                <h5 class="bold">Efectivo Retirado</h5>
                                <span class="font-yellow-gold bold">@{{ ctrl.previewDataWithdrawal.data.totalWithdrawal | currency }}</span>

                            </div>
                        </div>
                        <div class="col-sm-12 mt">
                            <div class="col-sm-6" ng-class="{ 'has-error' : formWithdrawal.reasonId.$invalid && !formWithdrawal.reasonId.$pristine }">
                                <label for="reasonId" class="">Razon retiro *</label>
                                <select class="form-control" data-ng-model="ctrl.withDrawalData.reasonId" required
                                        id="reasonId" name="reasonId">
                                    <option value="">Selecciona</option>
                                    <option value="@{{ reason.id }}" data-ng-repeat="reason in ctrl.reasonsWithdrawal.data">
                                        @{{ reason.description }}
                                    </option>
                                </select>
                                <span ng-show="formWithdrawal.reasonId.$invalid && !formWithdrawal.reasonId.$pristine"
                                      class="help-block">Selecciona la razon de retiro</span>
                            </div>
                            <div class="col-sm-6" ng-class="{ 'has-error' : formWithdrawal.amountId.$invalid && !formWithdrawal.amountId.$pristine }">
                                <label for="amountId" class="">Amount *</label>
                                <input type="text" data-ng-model="ctrl.withDrawalData.amount" id="amountId" name="amountId" required
                                       class="form-control numeric-field">
                                <span ng-show="formWithdrawal.amountId.$invalid && !formWithdrawal.amountId.$pristine"
                                      class="help-block">Monto requerido</span>
                            </div>
                        </div>
                        <div class="col-sm-12 mt">
                            <div class="col-sm-6">
                                <label for="commentsId">Comentarios</label>
                                <textarea class="form-control" id="commentsId"
                                          data-ng-model="ctrl.withDrawalData.comments"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    <button type="button" class="btn yellow"
                            data-ng-disabled="formWithdrawal.$invalid"
                            data-ng-click="ctrl.applyWithdrawal(formWithdrawal.$valid);"><i class="icon-check"></i> Aplicar</button>
                </div>
            </form>
        </div>
    </div>
</div>