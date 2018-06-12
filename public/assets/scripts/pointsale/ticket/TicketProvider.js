(function () {
    var app = angular.module('TicketProvider', []);

    app.factory('TicketService', function ($http, $q) {
        var service = {};

        service.contextPath = '';

        service.findDataStore = function () {
            return $http.get(service.contextPath+'/admin/configuration/findStore');
        };

        service.findTicketConfiguration = function (configurationId) {
            return $http.get(service.contextPath+'/admin/configuration/findPrintingTicketById/'+configurationId);
        };

        service.saveConfiguration = function (configuration) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/configuration/saveConfiguration',
                data: $.param(configuration),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        return service;

    });

})();