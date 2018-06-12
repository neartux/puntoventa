(function (){
    var app = angular.module('ReportSale', ['ReportSaleProvider', 'TicketProvider', 'datatables']);

    app.controller('ReportSaleController', function($scope, $http, ReportSaleService, TicketService, DTOptionsBuilder, DTColumnDefBuilder) {
        var ctrl = this;

        ctrl.sales = ReportSaleService.sales;
        ctrl.sale = { data: {}, datails: [], index: undefined };
        ctrl.status_cacelled = undefined;
        ctrl.dates = { startDate: '', endDate: '', userId: 0 };
        ctrl.cajas = ReportSaleService.cajas;
        ctrl.cajaTO = {};
        ctrl.users = [];
        ctrl.saleTicket = {};
        ctrl.showSales = false;
        ctrl.canCancelSale = false;
        // Configuracion para datatable
        ctrl.dtInstance = {};
        ctrl.dtOptions = DTOptionsBuilder.newOptions().withDOM('C<"clear">lfrtip');
        ctrl.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0).notSortable(),
            DTColumnDefBuilder.newColumnDef(2).notSortable(),
            DTColumnDefBuilder.newColumnDef(3).notSortable(),
            DTColumnDefBuilder.newColumnDef(4).notSortable(),
            DTColumnDefBuilder.newColumnDef(5).notSortable(),
            DTColumnDefBuilder.newColumnDef(6).notSortable()
        ];

        /**
         * Initialize app, instance context path of app
         * @param contextPath Application path
         * @param status_cancelled El estatus cancelado
         */
        ctrl.init = function (contextPath, status_cancelled) {
            startLoading("Cargando Ventas");
            // Coloca el path del server
            ReportSaleService.contextPath = contextPath;

            // Coloca el path al otro service
            TicketService.contextPath = contextPath;

            // Coloca el id del estatus cancelado
            ctrl.status_cacelled = status_cancelled;

            // Busca las ventas
            ctrl.findSalesCajaOpen();

            // Colocal la variable en este reporte la venta si puede ser cancelada
            ctrl.canCancelSale = true;

            // Busca los datos de la tienda y la configuracion del ticket de venta
            ctrl.findTicketConfigurationAndDataStore();
            stopLoading();
        };

        /**
         * Busca las cajas cerradas por fechas
         * @param contextPath El path
         * @param status_cancelled El estatus cancelado
         */
        ctrl.initCajasClosed = function (contextPath, status_cancelled) {
            startLoading("Cargando cajas cerradas");
            // Coloca el path del server
            ReportSaleService.contextPath = contextPath;

            // Coloca el path al otro service
            TicketService.contextPath = contextPath;

            // Coloca el id del estatus cancelado
            ctrl.status_cacelled = status_cancelled;

            // Inicia el date range
            ctrl.initDateRange();
            // Busca las cajas por fecha
            ctrl.findCajasByDate();
            // Busca los datos de la tienda y la configuracion del ticket de venta
            ctrl.findTicketConfigurationAndDataStore();
            stopLoading();
        };

        /**
         * Inicia el daterange
         */
        ctrl.initDateRange = function () {
            var date = new Date();
            ctrl.dates.startDate = moment(new Date(date.getFullYear(), date.getMonth(), 1)).format('YYYY-MM-DD');
            ctrl.dates.endDate = moment(new Date(date.getFullYear(), date.getMonth() + 1, 0)).format('YYYY-MM-DD');
            $('.daterange').daterangepicker(
                {
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    startDate: ctrl.dates.startDate,
                    endDate: ctrl.dates.endDate,
                    autoApply: true
                },
                function(start, end, label) {
                    ctrl.dates.startDate = start.format('YYYY-MM-DD');
                    ctrl.dates.endDate = end.format('YYYY-MM-DD');
                });
        };

        /**
         * Metodo para iniciar los valores del reporte de ventas por fecha
         * @param contextPath El path de la aplicacion
         * @param status_cancelled El estatus cancelado
         */
        ctrl.initSalesByDate = function (contextPath, status_cancelled) {
            startLoading("Cargando ventas");
            // Coloca el path del server
            ReportSaleService.contextPath = contextPath;
            // Coloca el path al otro service
            TicketService.contextPath = contextPath;
            // Coloca el id del estatus cancelado
            ctrl.status_cacelled = status_cancelled;
            // Inicia el date range
            ctrl.initDateRange();
            // Busca las ventas por fechas
            ctrl.findSalesByDates();
            // Busca los datos de la tienda y la configuracion del ticket de venta
            ctrl.findTicketConfigurationAndDataStore();
            stopLoading();
        };

        /**
         * Metodo para iniciar los valores del reporte de ventas por fecha
         * @param contextPath El path de la aplicacion
         * @param status_cancelled El estatus cancelado
         * @param user_Id El id del usuario logueado
         */
        ctrl.initSalesByDateAndUser = function (contextPath, status_cancelled, user_Id) {
            startLoading("Cargando ventas");
            // Coloca el path del server
            ReportSaleService.contextPath = contextPath;
            // Coloca el path al otro service
            TicketService.contextPath = contextPath;
            // Busca los usaurios del sistema
            ctrl.findAllUsers();
            // Coloca el id del estatus cancelado
            ctrl.status_cacelled = status_cancelled;
            // Inicia el date range
            ctrl.initDateRange();
            // Coloca el id del usuario logueado
            ctrl.dates.userId = user_Id+"";
            // Busca las ventas por fechas
            ctrl.findSalesByDatesAndUser();
            // Busca los datos de la tienda y la configuracion del ticket de venta
            ctrl.findTicketConfigurationAndDataStore();
            stopLoading();
        };

        /**
         * Busca la configuracion del ticket de venta, y los datos de la tienda
         */
        ctrl.findTicketConfigurationAndDataStore = function () {
            // Busca los datos de la tienda
            TicketService.findDataStore().then(function (response) {
                ctrl.storeTO = response.data[0];
            });
            // Busca los datos de configuracion de ticket
            TicketService.findTicketConfiguration(1).then(function (response) {
                ctrl.configurationStyle = response.data[0];
                setTimeout(function () {
                    ctrl.loadStyles();
                },500);
            });
        };

        /**
         * Metodo para imprimir un ticket
         * @param sale La venta con la informacion del ticket
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.printTicketSale = function (sale) {
            ctrl.saleTicket = angular.copy(sale);
            return ReportSaleService.findDetailsBySale(sale.id).then(function (response) {
                ctrl.saleTicket.details = response.data;
                ctrl.processSaleTicket();
                setTimeout(function () {
                    $scope.$apply();
                    $(".ticket-area").printArea();
                },100);
            });
        };

        /**
         * Suma el total de productos de una venta
         */
        ctrl.processSaleTicket = function () {
            var totalProducts  = 0;
            angular.forEach(ctrl.saleTicket.details, function (detail, key) {
                totalProducts = totalProducts + parseFloat(detail.quantity);
            });
            ctrl.saleTicket.totalProducts = totalProducts;
        };

        /**
         * Busca las ventas de una caja abieerta
         * @returns {*}
         */
        ctrl.findSalesCajaOpen = function () {
            return ReportSaleService.findSalesCajaOpen();
        };

        /**
         * Busca los detalles de venta por id de venta
         * @param index El index de la venta en la lista de ventas
         * @param sale El id de la venta
         */
        ctrl.findDetailsBySale = function (index, sale) {
            ctrl.sale.data = angular.copy(sale);
            return ReportSaleService.findDetailsBySale(ctrl.sale.data.id).then(function (response) {
                $("#detailsModal").modal();
                ctrl.sale.details= response.data;
                ctrl.sale.index = index;
            });
        };

        /**
         * Cancela una venta por su id
         * @param index El index de la venta en la lista
         * @param saleId  El id de la venta
         * @param control Para ver si abre o cierra modal de detalles
         */
        ctrl.cancelSale = function (index, saleId, control) {
            ctrl.controlModalDetails(control, 0);
            swal({
                    title: "Confirmación",
                    text: "¿Estas seguro de cancelar la venta con folio #"+saleId+"?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Cancelar!",
                    cancelButtonText: "Cerrar",
                    closeOnConfirm: true
                }, function (isConfirm) {
                if(isConfirm) {
                    startLoading("Cancelando venta");
                    ReportSaleService.cancelSale(saleId).success(function (response) {
                        if(!response.error) {
                            showNotification('Info', response.message, 'success');
                            // Modifica estatus de venta a cancelado
                            ctrl.sales.data[index].status_id = ctrl.status_cacelled;
                            ReportSaleService.calculateTotalAmountOfListSales();
                            ctrl.controlModalDetails(control, -1);
                        } else {
                            showNotification('Error', response.message, 'error');
                        }
                        stopLoading();
                    }).error(function () {
                        showNotification('Error', 'Ocurrio un error, por favor contacte al administrador', 'error');
                        stopLoading();
                    });
                } else {
                    ctrl.controlModalDetails(control, 1);
                }
            });
        };

        /**
         * Metodo para controlar el modal de los detalles de venta
         * @param control
         * @param value
         */
        ctrl.controlModalDetails = function (control, value) {
            if(control && value === 0) {
                $("#detailsModal").modal("hide");
            } else if(control && value === 1) {
                $("#detailsModal").modal();
            } else {
                $("#detailsModal").modal("hide");
            }
        };

        /**
         * Busca las cajas cerradas por fecha
         * @returns {*} La lista de cajas cerradas
         */
        ctrl.findCajasByDate = function () {
            return ReportSaleService.findCajasByDate(ctrl.dates.startDate, ctrl.dates.endDate);
        };

        /**
         * Busca las ventas por id de caja
         * @param caja El id de la caja
         * @returns {*} La lista de las ventas
         */
        ctrl.findSalesByCaja = function (caja) {
            ctrl.cajaTO = angular.copy(caja);
            ctrl.showSales = true;
            return ReportSaleService.findSalesByCaja(caja.id);
        };

        /**
         * Busca las ventas por fechas
         * @returns {*} La lista de ventas
         */
        ctrl.findSalesByDates = function () {
            return ReportSaleService.findSalesByDates(ctrl.dates.startDate, ctrl.dates.endDate);
        };

        /**
         * Busca las ventas por fechas y por usuario
         * @returns {*} La lista de ventas
         */
        ctrl.findSalesByDatesAndUser = function () {
            return ReportSaleService.findSalesByDatesAndUser(ctrl.dates.startDate, ctrl.dates.endDate, ctrl.dates.userId);
        };

        /**
         * Busca a todos los usuarios registrados en el sistema
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.findAllUsers = function () {
            return ReportSaleService.findAllUsers().then(function (response) {
                ctrl.users = response.data;
            });
        };

        /**
         * Carga la configuracion de la impresion de ticket
         */
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

    });

})();