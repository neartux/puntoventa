(function () {
    var app = angular.module('DeparmentProvider', []);

    app.factory('DeparmentService', function ($http, $q) {
        var service = {};

        service.contextPath = '';
        service.deparmentList = {
            data: []
        };

        service.setContextPath = function (contextPath) {
            service.contextPath = contextPath;
        };

        service.findAllDepartments = function () {
            return $http.get(service.contextPath + '/admin/deparment/findAllDepartments').then(function (data) {
                service.deparmentList.data = data.data;
            });
        };

        service.saveDeparment = function (deparment) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/deparment/save',
                data: $.param(deparment),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.updateDeparment = function (deparment) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/deparment/update',
                data: $.param(deparment),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.deleteDeparment = function (id) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/deparment/delete',
                data: $.param({id: id}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        return service;

    });

})();