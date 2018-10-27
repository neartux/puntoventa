(function () {
    var app = angular.module('ReportSaleProvider', []);

    app.factory('ReportSaleService', function ($http, $q) {
        var service = {};

        service.contextPath = '';

        service.sales = {
            data: [],
            totalAmount: 0
        };
        service.cajas = {
            data: []
        };

        service.setContextPath = function (contextPath) {
            service.contextPath = contextPath;
        };

        service.findSalesCajaOpen = function () {
            return $http.get(service.contextPath+'/admin/reportsales/findSalesCajaOpened').then(function (response) {
                service.sales.data = response.data;
                service.calculateTotalAmountOfListSales();
            });
        };

        service.findDetailsBySale = function (saleId) {
            return $http.get(service.contextPath+'/admin/reportsales/findDetailsBySale/'+saleId);
        };

        service.findCajasByDate = function (startDate, endDate) {

            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/reportsales/findCajasByDate',
                data: $.param({startDate: startDate + " 00:00:59", endDate: endDate + " 23:59:59"}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data) {
                service.cajas.data = data;
            });
        };

        service.cancelSale = function (saleId) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/pointsale/cancelSale',
                data: $.param({saleId: saleId}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.findSalesByCaja = function (cajaId) {
            return $http.get(service.contextPath+'/admin/reportsales/findSalesByCaja/'+cajaId).then(function (response) {
                service.sales.data = response.data;
            });
        };

        service.calculateTotalAmountOfListSales = function () {
            var totalA = 0;
            var total = 0;
            var totalSales = 0;
            var amountSalesCancelled = 0;
            angular.forEach(service.sales.data, function (sale, key) {
                // TODO cambiar a futuro al key estatus activo
                totalA += sale.total;
                if(parseInt(sale.status_id) === 1) {
                    total += sale.total;
                    totalSales ++;
                }
                else {
                    amountSalesCancelled += sale.total;
                }
            });
            service.sales.totalA = parseFloat(totalA).toFixed(2);
            service.sales.totalAmount = parseFloat(total).toFixed(2);
            service.sales.totalAmountCancelled = parseFloat(amountSalesCancelled).toFixed(2);
            service.sales.totalSales = totalSales;
        };

        service.findSalesByDates = function (startDate, endDate) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/reportsales/findSalesByDates',
                data: $.param({startDate: startDate + " 00:00:59", endDate: endDate + " 23:59:59"}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (response) {
                service.sales.data = response;
                service.calculateTotalAmountOfListSales();
            });
        };

        service.findSalesByDatesAndUser = function (startDate, endDate, userId) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/reportsales/findSalesByDatesAndUser',
                data: $.param({startDate: startDate + " 00:00:59", endDate: endDate + " 23:59:59", userId: userId}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (response) {
                service.sales.data = response;
                service.calculateTotalAmountOfListSales();
            });
        };

        service.findAllUsers = function () {
            return $http.get(service.contextPath+'/admin/reportsales/findAllUsers');
        };

        return service;

    });

})();