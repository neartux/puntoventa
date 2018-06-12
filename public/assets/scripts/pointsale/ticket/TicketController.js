(function (){
    var app = angular.module('Ticket', ['TicketProvider']);

    app.controller('TicketController', function($scope, $http, TicketService) {
        var ctrl = this;
        ctrl.storeTO = {};
        ctrl.configurationStyle = {};

        /**
         * Initialize app, instance context path of app
         * @param contextPath Application path
         */
        ctrl.init = function (contextPath) {
            // Coloca el path del server
            TicketService.contextPath = contextPath;
            // Busca los datos de la tienda
            TicketService.findDataStore().then(function (response) {
                ctrl.storeTO = response.data[0];
                console.info("ctrl.storeTO = ", ctrl.storeTO);
            });
            // Busca los datos de configuracion de ticket
            TicketService.findTicketConfiguration(1).then(function (response) {
                ctrl.configurationStyle = response.data[0];
                ctrl.loadStyles();
            });
        };

        ctrl.loadStyles = function () {

            ctrl.logoStyle = {
                "margin-left" : ctrl.configurationStyle.logo_x + "px",
                "margin-top" : ctrl.configurationStyle.logo_y + "px",
                "width" : ctrl.configurationStyle.logo_size + "px"
            };

            ctrl.headerStyle = {
                "margin-left" : ctrl.configurationStyle.header_x + "px",
                "margin-top" : ctrl.configurationStyle.header_y + "px",
                "font-size" : ctrl.configurationStyle.header_size + "px"
            };

            ctrl.folioStyle = {
                "margin-left" : ctrl.configurationStyle.folio_x + "px",
                "margin-top" : ctrl.configurationStyle.folio_y + "px",
                "font-size" : ctrl.configurationStyle.folio_size + "px"
            };

            ctrl.dateStyle = {
                "margin-left" : ctrl.configurationStyle.date_x + "px",
                "margin-top" : ctrl.configurationStyle.date_y+ "px",
                "font-size" : ctrl.configurationStyle.date_size + "px"
            };

            ctrl.bodyStyle = {
                "margin-left" : ctrl.configurationStyle.body_x + "px",
                "margin-top" : ctrl.configurationStyle.body_y+ "px",
                "font-size" : ctrl.configurationStyle.body_size + "px"
            };

            ctrl.footerStyle = {
                "margin-left" : ctrl.configurationStyle.footer_x + "px",
                "margin-top" : ctrl.configurationStyle.footer_y+ "px",
                "font-size" : ctrl.configurationStyle.footer_size + "px"
            };
        };

        ctrl.applyChangesHeader = function () {
            setTimeout(function () {
                ctrl.headerStyle = {
                    "margin-left" : ctrl.configurationStyle.header_x + "px",
                    "margin-top" : ctrl.configurationStyle.header_y + "px",
                    "font-size" : ctrl.configurationStyle.header_size + "px"
                };
                $scope.$apply();
            }, 100);
        };

        ctrl.applyChangesFolio = function () {
            setTimeout(function () {
                ctrl.folioStyle = {
                    "margin-left" : ctrl.configurationStyle.folio_x + "px",
                    "margin-top" : ctrl.configurationStyle.folio_y + "px",
                    "font-size" : ctrl.configurationStyle.folio_size + "px"
                };
                $scope.$apply();
            }, 100);
        };

        ctrl.applyChangesDate = function () {
            setTimeout(function () {
                ctrl.dateStyle = {
                    "margin-left" : ctrl.configurationStyle.date_x + "px",
                    "margin-top" : ctrl.configurationStyle.date_y + "px",
                    "font-size" : ctrl.configurationStyle.date_size + "px"
                };
                $scope.$apply();
            }, 100);
        };

        ctrl.applyChangesBody = function () {
            setTimeout(function () {
                ctrl.bodyStyle = {
                    "margin-left" : ctrl.configurationStyle.body_x + "px",
                    "margin-top" : ctrl.configurationStyle.body_y + "px",
                    "font-size" : ctrl.configurationStyle.body_size + "px"
                };
                $scope.$apply();
            }, 100);
        };

        ctrl.applyChangesFooter = function () {
            setTimeout(function () {
                ctrl.footerStyle = {
                    "margin-left" : ctrl.configurationStyle.footer_x + "px",
                    "margin-top" : ctrl.configurationStyle.footer_y + "px",
                    "font-size" : ctrl.configurationStyle.footer_size + "px"
                };
                $scope.$apply();
            }, 100);
        };

        ctrl.applyChangesLogo = function () {
            setTimeout(function () {
                ctrl.logoStyle = {
                    "margin-left" : ctrl.configurationStyle.logo_x + "px",
                    "margin-top" : ctrl.configurationStyle.logo_y + "px",
                    "width" : ctrl.configurationStyle.logo_size + "px"
                };
                $scope.$apply();
            }, 100);
        };

        ctrl.saveConfiguration = function () {
            swal({
                title: "Confirmación",
                text: "¿Estas seguro de guardar la configuración del ticket?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, Guardar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if(isConfirm) {
                    startLoading("Guardando configuracion");
                    TicketService.saveConfiguration(ctrl.configurationStyle).then(function (response) {
                        showNotification("Info", response.data.message, "success");
                        stopLoading();
                    });
                }
            });
        };


    });

})();