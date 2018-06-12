(function (){
    var app = angular.module('Client', ['ClientProvider', 'datatables']);

    app.controller('ClientController', function($scope, $http, ClientService, DTOptionsBuilder, DTColumnDefBuilder) {
        var ctrl = this;
        ctrl.clientList = [];
        ctrl.client = {};
        ctrl.showClientList = true;
        ctrl.isCreateProcess = true;

        ctrl.dtInstance = {};
        ctrl.dtOptions = DTOptionsBuilder.newOptions().withDOM('C<"clear">lfrtip').withOption('aaSorting', []);
        ctrl.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0).notSortable(),
            DTColumnDefBuilder.newColumnDef(1).notSortable(),
            DTColumnDefBuilder.newColumnDef(2).notSortable(),
            DTColumnDefBuilder.newColumnDef(3).notSortable(),
            DTColumnDefBuilder.newColumnDef(4).notSortable(),
            DTColumnDefBuilder.newColumnDef(5).notSortable()
        ];

        /**
         * Init de la aplicacion y busca los clientes
         * @param contextPath
         */
        ctrl.init = function (contextPath) {
            startLoading("Cargando Clientes");
            ClientService.contextPath = contextPath;
            // Busca todos los clientes activos
            ctrl.findAllClients();
            stopLoading();
        };

        /**
         * Metodo para encontrar a todos los usuarios activos
         * @returns {*|PromiseLike<T>|Promise<T>}
         */
        ctrl.findAllClients = function () {
            return ClientService.findAllClients().then(function (response) {
                ctrl.clientList = response.data;
            });
        };

        /**
         * Muestra el formulario para crear a un nuevo cliente
         */
        ctrl.showCreateClient = function () {
            ctrl.showClientList = false;
            ctrl.isCreateProcess = true;
            ctrl.client = {name: '', last_name: '', address: '', ciudad: '', phone: '', cell_phone: '', email: ''};
        };

        /**
         * Verifica que tipo de proceso se realiza, creacion o modificacion
         */
        ctrl.validateClient = function () {
            if(ctrl.isCreateProcess) {
                ctrl.createClient();
            } else {
                ctrl.updateClient();
            }
        };

        /**
         * Metodo que crea un nuevo cliente
         * @returns {*|PromiseLike<T>|Promise<T>}
         */
        ctrl.createClient = function () {
            startLoading("Guardando información de cliente");
            return ClientService.createClient(ctrl.client).then(function (response) {
                if(response.data.error) {
                    showNotification('Error', response.data.message, 'error');
                }
                else {
                    ctrl.client.id = response.data.id;
                    ctrl.clientList.push(angular.copy(ctrl.client));
                    ctrl.showClientList = true;
                    showNotification('Info', response.data.message, 'info');
                }
                stopLoading();
            });
        };

        /**
         * Muestra formulario para actualizar un cliente
         * @param client
         * @param index
         */
        ctrl.showUpdateClient = function (client, index) {
            ctrl.client = angular.copy(client);
            ctrl.client.indexElem = index;
            ctrl.showClientList = false;
            ctrl.isCreateProcess = false;
        };

        /**
         * Metodo que actualiza un cliente
         * @returns {*|PromiseLike<T>|Promise<T>}
         */
        ctrl.updateClient = function () {
            startLoading("Guardando información de cliente");
            return ClientService.updateClient(ctrl.client).then(function (response) {
                if(response.data.error) {
                    showNotification('Error', response.data.message, 'error');
                }
                else {
                    ctrl.clientList[ctrl.client.indexElem] = angular.copy(ctrl.client);
                    ctrl.showClientList = true;
                    showNotification('Info', response.data.message, 'info');
                }
                stopLoading();
            });
        };

        /**
         * Metodo para confirmar la eliminacion de un cliente
         * @param clientId El id del cliente a eliminar
         * @param index El index en la lista de clientes
         */
        ctrl.deleteClient = function (clientId, index) {
            swal({
                title: "Confirmación",
                text: "¿Seguro que deseas eliminar al cliente?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, Eliminar!",
                cancelButtonClass: "btn-default",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if(isConfirm) {
                    startLoading("Eliminando cliente");
                    return ClientService.deleteClient(clientId).then(function (response) {
                        if(response.data.error) {
                            showNotification('Error', response.data.message, 'error');
                        }
                        else {
                            ctrl.clientList.splice(index, 1);
                            showNotification('Info', response.data.message, 'info');
                        }
                        stopLoading();
                    });
                }
            });
        };


    });

})();