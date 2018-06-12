(function () {
    var app = angular.module('OrderProvider', []);

    app.factory('OrderService', function ($http, $q) {
        var service = {};

        service.contextPath = '';
        service.orderList = {
            data: []
        };

        service.addProductToOrder = function (productId) {
            return $http.get(service.contextPath + '/admin/order/addProductToOrder/'+productId);
        };

        service.findOrdersByDate = function (startDate, endDate) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/order/findOrdersByDate',
                data: $.param({startDate: startDate + " 00:00:59", endDate: endDate + " 23:59:59"}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                service.orderList.data = data;
            });
        };

        service.findOrderDetailsByOrderId = function (orderId) {
            return $http.get(service.contextPath + '/admin/order/findOrderDetailsByOrderId/'+orderId);
        };

        service.updateQuantityProduct = function (orderDetailId, quantity) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/order/updateQuantityProduct',
                data: $.param({orderDetailId: orderDetailId, quantity: quantity}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.closeOrder = function (id) {
            return $http.get(service.contextPath + '/admin/order/closeOrder/'+id);
        };

        return service;

    });

})();