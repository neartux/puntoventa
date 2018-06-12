<div data-ng-show="!ctrl.caja.isOpen" style="display: none;" class="element-hide">

    <div class="row text-center">
        <div class="col-md-3 col-sm-3 col-xs-12"></div>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-drawer font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">&nbsp;Apertura de caja</span>
                    </div>
                    <div class="actions btn-set">
                    </div>
                </div>
                <div class="portlet-body">


                    <form role="form" name="cajaForm">

                        <div class="row form-group">

                            <div class="col-md-12 col-sm-12 col-xs-12 pr-n pl-n">

                                <div class="form-group">
                                    <label class="bold">Monto Apertura</label>
                                    <input type="text" class="form-control input-lg numeric-field" data-ng-model="ctrl.caja.amount"
                                           required name="amount" id="aperturaCajaField">
                                    <span ng-show="cajaForm.amount.$invalid && !cajaForm.amount.$pristine"
                                          class="help-block">El monto es requerido.</span>
                                </div>

                                <div class="form-group">
                                    <label class="bold">Comentarios</label>
                                    <textarea class="form-control input-lg" data-ng-model="ctrl.caja.comments"></textarea>
                                </div>

                                <div class="form-group text-center mt-xl">
                                    <button class="btn blue-hoki btn-lg" data-ng-disabled="cajaForm.$invalid"
                                            data-ng-click="ctrl.openingCaja(cajaForm.$valid)">Abrir Caja</button>
                                </div>

                            </div>

                        </div>

                    </form>


                </div>
            </div>

        </div>
        <div class="col-md-3 col-sm-3 col-xs-12"></div>
    </div>

</div>