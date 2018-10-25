(function () {
    var app = angular.module('ProviderProvider', []);

    app.factory('ProviderService', function ($http, $q) {
        var service = {};

        service.contextPath = '';

        service.setContextPath = function (contextPath) {
            service.contextPath = contextPath;
        };

        service.findAllProviders = function () {
            return $http.get(service.contextPath+'/admin/provider/findAllProviders');
        };

        service.createProvider = function (provider) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/provider/createProvider',
                data: $.param(provider),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.updateProvider = function (provider) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/provider/updateProvider',
                data: $.param(provider),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.deleteProvider = function (providerId) {
            return $http.get(service.contextPath+'/admin/provider/delete/' + providerId);
        };


        return service;

    });

})();