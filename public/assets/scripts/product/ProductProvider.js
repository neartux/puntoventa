(function () {
    var app = angular.module('ProductProvider', []);

    app.factory('ProductService', function ($http, $q) {
        var service = {};

        service.contextPath = '';

        service.getContextPath = function () {
            return service.contextPath;
        };

        service.findAllProducts = function () {
            return $http.get(service.contextPath + '/admin/product/findAllProducts');
        };

        service.findInversionStock = function () {
            return $http.get(service.contextPath + '/admin/product/findInversionStock');
        };

        service.findAllUnit = function(){
            return $http.get(service.contextPath + '/admin/product/findAllUnit');
        };

        service.findAllDeparments = function(){
            return $http.get(service.contextPath + '/admin/product/findAllDeparment');
        };

        service.findAllAjusmentReasons = function(){
            return $http.get(service.contextPath + '/admin/product/findAllAjusmentReasons');
        };

        service.saveProduct = function (product) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/product/save',
                data: $.param(product),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.updateProduct = function (product) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/product/update',
                data: $.param(product),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.deleteProduct = function (id) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/product/delete',
                data: $.param({id: id}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.updateStock = function (productId, quantity, adjusmentReasonId) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/product/updateStockProduct',
                data: $.param({productId:productId, quantity:quantity, adjusmentReasonId:adjusmentReasonId}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (results) {
                return results.data;
            });
        };

        service.existProductByCode = function (id, code) {
            return $http.get(service.contextPath + '/admin/product/existProductByCode/'+id+'/'+code);
        };

        return service;

    });

})();