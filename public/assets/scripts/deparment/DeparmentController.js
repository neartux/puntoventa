(function (){
    var app = angular.module('Deparment', ['DeparmentProvider', 'datatables']);

    app.controller('DeparmentController', function($scope, $http, DeparmentService, DTOptionsBuilder, DTColumnDefBuilder) {
        var ctrl = this;
        ctrl.deparment = {};
        ctrl.deparmentList = DeparmentService.deparmentList;
        // Configuracion para datatable
        ctrl.dtInstance = {};
        ctrl.dtOptions = DTOptionsBuilder.newOptions().withDOM('C<"clear">lfrtip');
        ctrl.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0).notSortable(),
            DTColumnDefBuilder.newColumnDef(1).notSortable(),
            DTColumnDefBuilder.newColumnDef(2).notSortable()
        ];

        /**
         * Initialize app, instance context path of app
         * @param contextPath Application path
         */
        ctrl.init = function (contextPath) {
            startLoading("Cargando departamentos");
            DeparmentService.contextPath = contextPath;
            DeparmentService.findAllDepartments();
            stopLoading();
        };

        /***
         * Muestra el form para crear un nuevo departamento
         */
        ctrl.showCreateDeparment = function () {
            ctrl.cleanForm();
            $("#deparmentModal").modal();
            ctrl.titleFormAction = 'Crear Departamento';
        };

        /**
         * Muestra el form para actualizar un departamento
         * @param index El indice del elemento
         * @param deparment El elemento
         */
        ctrl.showEditDeparment = function (index, deparment) {
            ctrl.deparment = angular.copy(deparment);
            ctrl.deparment.index = index;
            ctrl.deparment.isNew = false;
            $("#deparmentModal").modal();
            ctrl.titleFormAction = 'Modificar '+deparment.description;
        };

        /**
         * Valida el form y crea o modifica
         * @param isFormValid La validacion del form
         */
        ctrl.validateDeparment = function (isFormValid) {
            if(isFormValid) {
                if(ctrl.deparment.isNew) {
                    ctrl.saveDeparment();
                } else {
                    ctrl.updateDeparment();
                }
            }
        };

        /**
         *  Metodo que crea un nuevo departamento
         */
        ctrl.saveDeparment = function () {
            startLoading("Guardando información de departamento");
            return DeparmentService.saveDeparment(ctrl.deparment).success(function(response) {
                if (!response.error) {
                    ctrl.deparment.id = response.id;
                    ctrl.deparmentList.data.push(ctrl.deparment);
                    showNotification('Mensaje', response.message, 'info');
                } else {
                    showNotification('Error', response.message, 'error');
                }
                ctrl.cleanForm();
                $("#deparmentModal").modal("hide");
                stopLoading();
            }).error(function(response) {
                showNotification('Mensaje', 'Ha ocurrido un error, contacte a su administrador', 'error');
                ctrl.cleanForm();
                stopLoading();
            });
        };

        /**
         * Metodo para actualizar un departamento existente
         */
        ctrl.updateDeparment = function () {
            startLoading("Guardando información de departamento");
            return DeparmentService.updateDeparment(ctrl.deparment).success(function(response) {
                if (!response.error) {
                    ctrl.deparmentList.data[ctrl.deparment.index] = ctrl.deparment;
                    showNotification('Mensaje', response.message, 'info');
                } else {
                    showNotification('Error', response.message, 'error');
                }
                ctrl.cleanForm();
                $("#deparmentModal").modal("hide");
                stopLoading();
            }).error(function(response) {
                showNotification('Mensaje', 'Ha ocurrido un error, contacte a su administrador', 'error');
                ctrl.cleanForm();
                stopLoading();
            });
        };

        /**
         * Elimina un departamento por su id
         * @param index El indice para remover de la lista
         * @param id El id del elemento para eliminar
         */
        ctrl.deleteDeparment = function (index, id) {
            swal({
                    title: "Confirmación",
                    text: "¿Estas seguro de eliminar el departamento?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Eliminar!",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true
                },
                function(){
                    startLoading("Eliminando departamento");
                    DeparmentService.deleteDeparment(id).success(function (response) {
                        if(!response.error) {
                            ctrl.deparmentList.data.splice(index, 1);
                            showNotification('Mensaje', response.message, 'info');
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
         * Limpia el form del departamento
         */
        ctrl.cleanForm = function () {
            ctrl.deparment = {
                id: 0,
                description: '',
                index: undefined,
                isNew: true
            };
            $scope.deparmentForm.$setPristine();
        };

    });

})();