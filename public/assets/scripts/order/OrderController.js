(function (){
    var app = angular.module('Order', ['OrderProvider', 'datatables']);

    app.controller('OrderController', function($scope, $http, OrderService, DTOptionsBuilder, DTColumnDefBuilder) {
        var ctrl = this;
        ctrl.orderList = OrderService.orderList;
        ctrl.orderTO = {};
        ctrl.dates = { startDate: '', endDate: ''};
        ctrl.showListOrders = true;

        ctrl.init = function (contextPath) {
            startLoading("Buscando Pedidos");
            OrderService.contextPath = contextPath;
            // Inicia el date range
            ctrl.initDateRange();
            // Busca las ordenes por fecha
            ctrl.findOrdersByDate();
            stopLoading();
        };

        /**
         * Busca las ordenes por fecha
         * @returns {*} La lista de ordenes
         */
        ctrl.findOrdersByDate = function () {
            return OrderService.findOrdersByDate(ctrl.dates.startDate, ctrl.dates.endDate);
        };

        /**
         * Metodo para cerrar una orden
         * @param order La orden
         * @param cancelledStatusId El estatus cancellado
         */
        ctrl.closeOrder = function (order, cancelledStatusId) {
            swal({
                title: "Confirmación",
                text: "¿Estas seguro de cerrar el pedido con folio "+order.id+"?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, Cerrar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if(isConfirm) {
                    startLoading("Cerrando Pedido");
                    return OrderService.closeOrder(order.id).then(function (response) {
                        if(response.data.error) {
                            showNotification('Error', response.data.message, 'error');
                        } else {
                            showNotification('Info', response.data.message, 'info');
                            setTimeout(function () {
                                order.status_id = cancelledStatusId+"";
                                $scope.$apply();
                            },500);
                        }
                        stopLoading();
                    });
                }
            });
        };

        /**
         * Busca los productos agregados a una orden
         * @param order El id de la orden
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.findProductByOrderId = function (order) {
            ctrl.orderTO = angular.copy(order);
            return OrderService.findOrderDetailsByOrderId(order.id).then(function (response) {
                ctrl.orderTO.details = response.data;
                $("#detailsModal").modal();
                setTimeout(function () {
                    initNumericFields();
                }, 1000);
            });
        };

        /**
         * Muestra form para poder actualizar cantidades de orden
         * @param detail El detalle de orden
         */
        ctrl.showUpdateQuantity = function (detail) {
            detail.updateQuantity = true;
            detail.quantityU = detail.quantity;
        };

        /**
         * Metodo para actualizar una cantidad de un producto
         * @param order La informacin del detalle
         */
        ctrl.updateQuantityProduct = function (order) {
            startLoading("Actualizando cantidad");
            return OrderService.updateQuantityProduct(order.id, order.quantityU).success(function (response) {
                if(response.error) {
                    showNotification('Error', response.message, 'error');
                } else {
                    showNotification('Info', response.message, 'info');
                    order.quantity = order.quantityU;
                    order.updateQuantity = false;
                }
                stopLoading();
            });
        };

        /**
         * Inicia el daterange
         */
        ctrl.initDateRange = function () {
            var date = new Date();
            ctrl.dates.startDate = moment(new Date(date.getFullYear(), date.getMonth(), 1)).format('YYYY-MM-DD');
            ctrl.dates.endDate = moment(new Date(date.getFullYear(), date.getMonth() + 1, 0)).format('YYYY-MM-DD');
            $('.daterange').daterangepicker(
                {
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    startDate: ctrl.dates.startDate,
                    endDate: ctrl.dates.endDate,
                    autoApply: true
                },
                function(start, end, label) {
                    ctrl.dates.startDate = start.format('YYYY-MM-DD');
                    ctrl.dates.endDate = end.format('YYYY-MM-DD');
                });
        };

    });

})();