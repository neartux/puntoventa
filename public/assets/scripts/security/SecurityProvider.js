(function () {
    var app = angular.module('SecurityProvider', []);

    app.factory('SecurityService', function ($http, $q) {
        var service = {};

        service.contextPath = '';

        service.changePassword = function (securityData) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/configuration/changePassword',
                data: $.param(securityData),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        return service;

    });

})();