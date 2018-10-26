(function (){
    var app = angular.module('Security', ['SecurityProvider']);

    app.controller('SecurityController', function($scope, $http, SecurityService) {
        var ctrl = this;
        ctrl.formData = {};
        ctrl.userList = { data: [] };
        ctrl.rolesList = { data: [] };
        ctrl.dtInstance = {};
        ctrl.userTO = {};
        ctrl.isCreateUser = true;

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

        /**
         * Initialize app, instance context path of app
         * @param contextPath Application path
         */
        ctrl.initUser = function (contextPath) {
            // Coloca el path del server
            SecurityService.contextPath = contextPath;
            // Find usuarios
            ctrl.findUsers();
            // Busca los roles
            ctrl.findRoles();
        };

        /**
         * Metodo para buscar a todos los usuarios
         *
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.findUsers = function () {
            startLoading("Cargando usuarios");
            return SecurityService.findUsers().then(function (res) {
                ctrl.userList.data = res.data.data;
                stopLoading();
            }, stopLoading());
        };

        /**
         * Metodo para buscar a todos los roles
         *
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.findRoles = function () {
            return SecurityService.findRolesNoAdmin().then(function (res) {
                ctrl.rolesList.data = res.data.data;
            });
        };

        /**
         * Despliega la vista para crear un nuevo usuario
         */
        ctrl.viewCreateUser = function () {
            ctrl.userTO = {};
            ctrl.userTO.id = 0;
            ctrl.isCreateUser = true;
            ctrl.titleFormAction = 'Crear Usuario';
            $scope.userForm.$setPristine();
            $("#userModal").modal();
        };

        /**
         * Valida creacion o modificacion de un usuario
         *
         * @param isValid Verifica si es valido
         */
        ctrl.validateUser = function (isValid) {
            // Si el usuario es valido
            if(isValid) {
                // Valida el nombre usuario si es disponible
                SecurityService.existUserName(ctrl.userTO.id, $.trim(ctrl.userTO.user_name).toUpperCase()).then(function (res) {
                    // Si el usuario es valido
                    if(parseInt(res.data.exist) === 0) {
                        // Si es crear el usuario
                        if(ctrl.isCreateUser) {
                            ctrl.validateCreateUser();
                        }
                        // Si es modificar un usaurio
                        else {
                            ctrl.validateUpdateUser();
                        }
                    }
                    else {
                        showNotification("Info", "El nombre de usuario "+ctrl.userTO.user_name+" no esta disponible", "info");
                    }
                });
            }
        };

        /**
         * Valida los campos para crear un nuevo usuario
         */
        ctrl.validateCreateUser = function () {
            // Crea el usuario
            SecurityService.saveUser(ctrl.userTO).then(function (res) {
                if(!res.data.error) {
                    $("#userModal").modal("hide");
                    ctrl.findUsers();
                    showNotification("Success", res.data.message, "success");
                }
                else {
                    showNotification("Error", res.data.message, "error");
                }
            });
        };

        /**
         * Muestra la informacion para editar un usuario
         *
         * @param user El usuario de la lista de usuarios
         */
        ctrl.editUser = function (user) {
            ctrl.isCreateUser = false;
            ctrl.userTO = angular.copy(user);
            ctrl.titleFormAction = 'Editar usuario ' + user.user_name;
            $scope.userForm.$setPristine();
            $("#userModal").modal();
        };

        /**
         * Metodo para validar campos al actualiza un usuario
         */
        ctrl.validateUpdateUser = function () {
            // Crea el producto
            SecurityService.updateUser(ctrl.userTO).then(function (res) {
                if(!res.data.error) {
                    $("#userModal").modal("hide");
                    ctrl.findUsers();
                    showNotification("Success", res.data.message, "success");
                } else {
                    showNotification("Error", res.data.message, "error");
                }
            });
        };

        /**
         * Metodo para eliminar un usuario por su id
         *
         * @param id El id del usuario
         */
        ctrl.deleteUser = function (id) {
            swal({
                    title: "Confirmación",
                    text: "¿Estas seguro de eliminar el usuario?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Eliminar!",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true
                },
                function(){
                    startLoading("Eliminando usuario");
                    SecurityService.deleteUser(id).success(function (response) {
                        if(!response.error) {
                            ctrl.findUsers();
                            showNotification('Success', response.message, 'success');
                        } else {
                            showNotification('Error', response.message, 'error');
                        }
                        stopLoading();
                    }).error(function () {
                        showNotification('Error', 'Ocurrio un error, favor contacte al administrador', 'error');
                        stopLoading();
                    });
                });
        };

        /**
         * Ver modal para cambiar contraseña
         *
         * @param user El usuario
         */
        ctrl.changePasswordView = function(user) {
            ctrl.userTO = angular.copy(user);
            $scope.securityForm.$setPristine();
            $("#changePassword").modal();
        };

        /**
         * Actualiza la contraseña de algun usuario de la lista de usuarios
         */
        ctrl.changePasswordUser = function () {
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
                if (isConfirm) {
                    startLoading("Actualizando La Contraseña");
                    return SecurityService.changePasswordUser(ctrl.userTO).then(function (response) {
                        if (response.data.error) {
                            showNotification("Error", response.data.message, "error");
                        } else {
                            showNotification("Info", response.data.message, "success");
                            ctrl.formData = {};
                            $("#changePassword").modal("hide");
                        }
                        stopLoading();
                    }, stopLoading());
                }
            });
        };

    });

})();