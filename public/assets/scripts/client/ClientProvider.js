(function () {
    var app = angular.module('ClientProvider', []);

    app.factory('ClientService', function ($http, $q) {
        var service = {};

        service.contextPath = '';

        service.setContextPath = function (contextPath) {
            service.contextPath = contextPath;
        };

        service.findAllClients = function () {
            return $http.get(service.contextPath+'/admin/client/findAllClients');
        };

        service.createClient = function (client) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/client/createClient',
                data: $.param(client),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.updateClient = function (client) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/client/updateClient',
                data: $.param(client),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.deleteClient = function (clientId) {
            return $http.get(service.contextPath+'/admin/client/delete/' + clientId);
        };


        return service;

    });

})();