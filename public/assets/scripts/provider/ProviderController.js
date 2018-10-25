(function (){
    var app = angular.module('Provider', ['ProviderProvider', 'datatables']);

    app.controller('ProviderController', function($scope, $http, ProviderService, DTOptionsBuilder, DTColumnDefBuilder) {
        var ctrl = this;
        ctrl.providerList = [];
        ctrl.provider = {};
        ctrl.showProviderList = true;
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
         * Init de la aplicacion y busca los proveedores
         * @param contextPath
         */
        ctrl.init = function (contextPath) {
            startLoading("Cargando Proveedores");
            ProviderService.contextPath = contextPath;
            // Busca todos los proveedores activos
            ctrl.findAllProviders();
            stopLoading();
        };

        /**
         * Metodo para encontrar a todos los usuarios activos
         * @returns {*|PromiseLike<T>|Promise<T>}
         */
        ctrl.findAllProviders = function () {
            return ProviderService.findAllProviders().then(function (response) {
                ctrl.providerList = response.data;
            });
        };

        /**
         * Muestra el formulario para crear a un nuevo provider
         */
        ctrl.showCreateProvider = function () {
            ctrl.showProviderList = false;
            ctrl.isCreateProcess = true;
            ctrl.provider = {name: '', last_name: '', address: '', ciudad: '', phone: '', cell_phone: '', email: ''};
        };

        /**
         * Verifica que tipo de proceso se realiza, creacion o modificacion
         */
        ctrl.validateProvider = function () {
            if(ctrl.isCreateProcess) {
                ctrl.createProvider();
            } else {
                ctrl.updateProvider();
            }
        };

        /**
         * Metodo que crea un nuevo proveedor
         * @returns {*|PromiseLike<T>|Promise<T>}
         */
        ctrl.createProvider = function () {
            startLoading("Guardando información de proveedor");
            return ProviderService.createProvider(ctrl.provider).then(function (response) {
                if(response.data.error) {
                    showNotification('Error', response.data.message, 'error');
                }
                else {
                    ctrl.provider.id = response.data.id;
                    ctrl.providerList.push(angular.copy(ctrl.provider));
                    ctrl.showProviderList = true;
                    showNotification('Info', response.data.message, 'info');
                }
                stopLoading();
            });
        };

        /**
         * Muestra formulario para actualizar un proveedor
         * @param provider
         * @param index
         */
        ctrl.showUpdateProvider = function (provider, index) {
            ctrl.provider = angular.copy(provider);
            ctrl.provider.indexElem = index;
            ctrl.showProviderList = false;
            ctrl.isCreateProcess = false;
        };

        /**
         * Metodo que actualiza un proveedor
         * @returns {*|PromiseLike<T>|Promise<T>}
         */
        ctrl.updateProvider = function () {
            startLoading("Guardando información de proveedor");
            return ProviderService.updateProvider(ctrl.provider).then(function (response) {
                if(response.data.error) {
                    showNotification('Error', response.data.message, 'error');
                }
                else {
                    ctrl.providerList[ctrl.provider.indexElem] = angular.copy(ctrl.provider);
                    ctrl.showProviderList = true;
                    showNotification('Info', response.data.message, 'info');
                }
                stopLoading();
            });
        };

        /**
         * Metodo para confirmar la eliminacion de un proveedor
         * @param providerId El id del proveedor a eliminar
         * @param index El index en la lista de provedores
         */
        ctrl.deleteProvider = function (providerId, index) {
            swal({
                title: "Confirmación",
                text: "¿Seguro que deseas eliminar al proveedor?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, Eliminar!",
                cancelButtonClass: "btn-default",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if(isConfirm) {
                    startLoading("Eliminando proveedor");
                    return ProviderService.deleteProvider(providerId).then(function (response) {
                        if(response.data.error) {
                            showNotification('Error', response.data.message, 'error');
                        }
                        else {
                            ctrl.providerList.splice(index, 1);
                            showNotification('Info', response.data.message, 'info');
                        }
                        stopLoading();
                    });
                }
            });
        };


    });

})();