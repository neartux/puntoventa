(function (){
    var app = angular.module('Security', ['SecurityProvider']);

    app.controller('SecurityController', function($scope, $http, SecurityService) {
        var ctrl = this;
        ctrl.formData = {};

        /**
         * Initialize app, instance context path of app
         * @param contextPath Application path
         */
        ctrl.init = function (contextPath) {
            // Coloca el path del server
            SecurityService.contextPath = contextPath;
        };

        ctrl.changePassword = function () {
            swal({
                title: "Confirmación",
                text: "¿Estas seguro de cambiar la contraseña?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, Cambiar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if(isConfirm) {
                    startLoading("Actualizando La Contraseña");
                    SecurityService.changePassword(ctrl.formData).then(function (response) {
                        if (response.data.error) {
                            showNotification("Error", response.data.message, "error");
                        } else {
                            showNotification("Info", response.data.message, "success");
                            ctrl.formData = {};
                            $scope.securityForm.$setPristine();
                        }
                        stopLoading();
                    }, stopLoading());
                }
            });
        };


    });

})();