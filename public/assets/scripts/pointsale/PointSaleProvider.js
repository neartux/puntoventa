(function () {
    var app = angular.module('PointSaleProvider', []);

    app.factory('PointSaleService', function ($http, $q) {
        var service = {};

        service.contextPath = '';

        service.setContextPath = function (contextPath) {
            service.contextPath = contextPath;
        };

        service.getContextPath = function () {
            return service.contextPath;
        };

        /**
         * Metodo para encontrar la caja abierta
         */
        service.findCajaOpened = function () {
            return $http.get(service.contextPath+'/admin/pointsale/findCajaOpened');
        };

        /**
         * Abre una nueva caja
         * @param caja El monto de apertura y comentarios
         * @returns {*} El resutado de la transaccion
         */
        service.openingCaja = function (caja) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/pointsale/openingCaja',
                data: $.param(caja),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        /**
         * Encuentra un cliente para la venta por su id
         * @param clientId El id del cliente
         */
        service.findClientById = function (clientId) {
            return $http.get(service.contextPath+'/admin/pointsale/findClientById/'+clientId);
        };

        /**
         * Metodo para buscar un producto por su codigo
         * @param code El codigo del producto
         */
        service.findProductByCode = function (code) {
            return $http.get(service.contextPath+'/admin/pointsale/findProductByCode/'+code);
        };

        /**
         * Metodo que busca el resumen de la caja actual, previo a cerrar
         */
        service.findPreviewCloseCaja = function () {
            return $http.get(service.contextPath+'/admin/pointsale/findPreviewCloseCaja');
        };

        /**
         * Crea una venta
         * @param ventaCompletaTO El objeto con la informacion de la venta
         * @returns {*} Regresa la el response de la peticion
         */
        service.createSale = function (ventaCompletaTO) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/pointsale/createSale',
                data: $.param(ventaCompletaTO),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        /**
         * Llama a metodo para realizar el proceso de cierre de caja
         */
        service.closeCaja = function () {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/pointsale/closeCaja',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        /**
         * Metodo que busca todas las razones de retiro
         */
        service.findReasonWithdrawal = function () {
            return $http.get(service.contextPath+'/admin/pointsale/findReasonWithdrawal');
        };

        /**
         * Metodo que busca el resumen de la caja actual, previo a retiro
         */
        service.findPreviewWithdrawal = function () {
            return $http.get(service.contextPath+'/admin/pointsale/findPreviewWithdrawalCaja');
        };

        /**
         * Llama a metodo para realizar el retiro de caja
         */
        service.applyWithdrawalCaja = function (withdrawal) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/pointsale/applyWithdrawal',
                data: $.param(withdrawal),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        return service;

    });

})();