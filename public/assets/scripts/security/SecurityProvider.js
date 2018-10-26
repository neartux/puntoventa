(function () {
    var app = angular.module('SecurityProvider', []);

    app.factory('SecurityService', function ($http, $q) {
        var service = {};

        service.contextPath = '';

        service.changePassword = function (securityData) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/security/changePassword',
                data: $.param(securityData),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.findUsers = function () {
            return $http.get(service.contextPath + '/admin/security/findUsers');
        };

        service.findRolesNoAdmin = function () {
            return $http.get(service.contextPath + '/admin/security/findRolesNoAdmin');
        };

        service.existUserName = function (id, username) {
            return $http.get(service.contextPath + '/admin/security/existUserName/'+id+'/'+username);
        };

        service.saveUser = function (user) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/user/save',
                data: $.param(user),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.updateUser = function (user) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/user/update',
                data: $.param(user),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.deleteUser = function (id) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/user/delete',
                data: $.param({id: id}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.changePasswordUser = function (securityData) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/security/changePasswordUser',
                data: $.param(securityData),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        service.addRolesToUser = function (user) {
            return $http({
                method: 'POST',
                url: service.contextPath + '/admin/security/addRolesToUser',
                data: $.param(user),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            });
        };

        return service;

    });

})();