(function (){
    var app = angular.module('PointSale', ['PointSaleProvider', 'TicketProvider', 'OrderProvider', 'CommonDirectives']);

    app.controller('PointSaleController', function($scope, $http, PointSaleService, TicketService, OrderService) {
        var ctrl = this;
        ctrl.clientIdGeneral = undefined;
        ctrl.clientId = undefined;
        ctrl.codeProduct = '';
        ctrl.ventaCompleta = {};
        ctrl.ventaCompletaTO = {};
        ctrl.caja = { isOpen: false };
        ctrl.productSearchMode = false;
        ctrl.clientSearchMode = false;
        ctrl.isProcessSaveActive = false;
        ctrl.productSelected = {};
        ctrl.cajaPreview = {};
        ctrl.discountGeneralSale = PERCENT_DISCOUNT_ZERO;
        ctrl.configurationStyle = {};
        ctrl.storeTO = {};
        ctrl.bulkProductId = ELEMENT_NOT_FOUND;
        ctrl.temporalProductBulk = ELEMENT_NOT_FOUND;
        ctrl.reasonsWithdrawal = { data: [] };
        ctrl.previewDataWithdrawal = { data: [] };
        ctrl.withdrawalList = { data: [] };
        ctrl.withDrawalData = {};
        ctrl.totalAmountWithdrawal = NUMBER_ZERO;


        /**
         * Initialize app, instance context path of app
         * @param contextPath Application path
         * @param clientId Id cliente publico en general
         * @param bulkProduct El id del producto agranel
         */
        ctrl.init = function (contextPath, clientId, bulkProduct) {
            // Coloca el path del server
            PointSaleService.contextPath = contextPath;

            // Coloca el path al otro service
            TicketService.contextPath = contextPath;

            // Colocando el path para ordenes
            OrderService.contextPath = contextPath;

            // Asigna el id del cliente publico general
            ctrl.clientIdGeneral = clientId;

            // Coloca el id del producto agranel
            ctrl.bulkProductId = bulkProduct;

            // Inicia los metodos generales de una venta
            ctrl.initSale();

            // Init autocomplete product
            ctrl.initAutocompleteProduct();

            // Init autocomplete client
            ctrl.initAutocompleteClient();

            // Busca los datos de configuracion de ticket y los datos de la tienda
            ctrl.findTicketConfigurationAndDataStore();

            $("#clientId" ).blur(function() {
                ctrl.enableSearchModeClient(false);
                setTimeout(function () {
                    $scope.$apply();
                },200);
            });

            // Busca todas las razones de retiro
            ctrl.findReasonWithdrawal();
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
                ctrl.loadStyles();
            });
        };

        /**
         * Carga los metodos iniciales para una venta
         */
        ctrl.initSale = function () {
            // Busca los datos de la caja abierta
            ctrl.findCajaOpened();

            // Inicializa los valores de la venta
            ctrl.initValueSale();

            // Coloca a la venta el cliente de publico en general
            ctrl.findClientById(ctrl.clientIdGeneral);

            // Limpia variables generales
            ctrl.cleanAndFocusInputProduct();
        };

        ctrl.findReasonWithdrawal = function () {
            return PointSaleService.findReasonWithdrawal().then(function (res) {
                console.info("REASONS = ", res.data);
                ctrl.reasonsWithdrawal.data = res.data;
            });
        };

        /**
         * Busca una caja abierta
         * @returns {*} Los datos de la caja
         */
        ctrl.findCajaOpened = function () {
            return PointSaleService.findCajaOpened().then(function (response) {
                if(response.data.id !== ELEMENT_NOT_FOUND) {
                    ctrl.caja = {
                        isOpen: true,
                        data: response.data
                    };
                }
                // No hay caja abierta
                else {
                    $("#aperturaCajaField").trigger("focus");
                }
            });
        };

        /**
         * Abre la caja
         * @param isValidForm si los datos del form son validos
         * @returns {*} El resultado de la peticion
         */
        ctrl.openingCaja = function (isValidForm) {
            if(isValidForm) {
                startLoading("Abriendo Caja");
                return PointSaleService.openingCaja(ctrl.caja).then(function (response) {
                    if(!response.data.error) {
                        ctrl.caja = {
                            isOpen: true,
                            data: response.data
                        };
                        ctrl.cleanAndFocusInputProduct();
                    }
                    else {
                        showNotification('Error', response.data.message, 'error');
                    }
                    stopLoading();
                });
            }
        };

        /**
         * Configura el autocomplete para busqueda avanzada del producto
         */
        ctrl.initAutocompleteProduct = function () {
            var options = {
                minCharNumber: 2,
                url: function(phrase) {
                    return PointSaleService.getContextPath() + "/admin/pointsale/findProductsByCodeOrName";
                },
                getValue: function(element) {
                    return element.code + ' - ' + element.description;
                },
                ajaxSettings: { dataType: "json", method: "GET", data: { dataType: "json" } },
                preparePostData: function(data) {
                    data.q = $("#productIdSearch").val();
                    return data;
                },
                list: {
                    onSelectItemEvent: function() {
                        ctrl.codeProduct = $("#productIdSearch").getSelectedItemData().code;
                    },
                    onHideListEvent: function() {
                        $("#productIdSearch").val('');
                    },
                    match: {
                        enabled: true
                    },
                    onClickEvent: function() {
                        ctrl.findProductByCode();
                    }
                },
                theme: "round",
                requestDelay: 300
            };
            $("#productIdSearch").easyAutocomplete(options);
        };

        /**
         * Activa o inactiva busqueda avanzada
         * @param isEnable Boolean
         */
        ctrl.enableSearchModeClient = function (isEnable) {
            ctrl.clientSearchMode = isEnable;
            if(isEnable) {
                setTimeout(function () {
                    $("#clientId").val('').focus();
                    $scope.$apply();
                }, 200);
            }
        };

        /**
         * Configura el autocomplete para cliente
         */
        ctrl.initAutocompleteClient = function () {
            var options = {
                minCharNumber: 2,
                url: function(phrase) {
                    return PointSaleService.getContextPath() + "/admin/pointsale/findClientByNameOrLastName";
                },
                getValue: function(element) {
                    return element.name + ' ' + element.last_name;
                },
                ajaxSettings: { dataType: "json", method: "GET", data: { dataType: "json" } },
                preparePostData: function(data) {
                    data.q = $("#clientId").val();
                    return data;
                },
                list: {
                    onSelectItemEvent: function() {
                        ctrl.clientId = $("#clientId").getSelectedItemData().id;
                    },
                    onHideListEvent: function() {
                        $("#clientId").val('');
                    },
                    match: {
                        enabled: true
                    },
                    onClickEvent: function() {
                        ctrl.findClientById(ctrl.clientId);
                    }
                },
                theme: "round",
                requestDelay: 300
            };
            $("#clientId").easyAutocomplete(options);
        };

        /**
         * Busca un producto por su codigo
         */
        ctrl.findProductByCode = function () {
            if (ctrl.codeProduct !== '') {
                return PointSaleService.findProductByCode(ctrl.codeProduct).then(function (response) {
                    if(response.data.id !== ELEMENT_NOT_FOUND) {
                        ctrl.addProductToSale(response.data);
                    }
                    ctrl.cleanAndFocusInputProduct();
                });
            }
        };

        /**
         * Busca un cliente por su id
         * @param idClient El id del cliente
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.findClientById = function (idClient) {
            return PointSaleService.findClientById(idClient).then(function (response) {
                if (response.data.id !== ELEMENT_NOT_FOUND) {
                    ctrl.ventaCompleta.client = response.data;
                    ctrl.ventaCompleta.client.completeName = response.data.name + ' ' + response.data.last_name;
                }
                ctrl.clientId = undefined;
                ctrl.clientSearchMode = false;
            });
        };

        /**
         * Agrega un producto a la venta
         * @param product El producto
         */
        ctrl.addProductToSale = function (product) {
            var index = ctrl.getIndexProduct(product.id);
            // Valida si el producto es agranel
            if(product.unit_id == ctrl.bulkProductId) {
                ctrl.processBulkProduct(product, index);
            }
            // Si es producto Pieza procesa
            else{
                // Si existe el producto aumenta la cantidad
                if (index !== ELEMENT_NOT_FOUND) {
                    ctrl.ventaCompleta.products[index].quantity = ctrl.ventaCompleta.products[index].quantity + NUMBER_ONE;
                }
                // No existe el producto en la venta lo agrega
                else {
                    ctrl.ventaCompleta.products.push(ctrl.initProduct(product));
                }
                ctrl.calculateTotals();
            }

        };

        /**
         * Metodo para verificar si un producto de tipo agranel es nuevo en la venta, o ya ha sido agregado
         *
         * @param product El producto
         * @param index El indice del producto en la lista de productos venta
         */
        ctrl.processBulkProduct = function (product, index) {
            // Si el producto ya existe en la venta
            if (index !== ELEMENT_NOT_FOUND) {
                ctrl.temporalProductBulk = angular.copy(ctrl.ventaCompleta.products[index]);
                if (ctrl.temporalProductBulk.apply_wholesale) {
                    ctrl.temporalProductBulk.importInBulk = parseFloat(product.price)
                }
            }
            // Si no existe procede a agregar
            else {
                ctrl.temporalProductBulk = product;
                ctrl.temporalProductBulk.isBulkProduct = true;
                ctrl.temporalProductBulk.quantity = parseFloat(NUMBER_ONE).toFixed(NUMBERS_OF_DECIMALS);
                ctrl.temporalProductBulk.importInBulk = parseFloat(product.sale_price).toFixed(NUMBERS_OF_DECIMALS);
                ctrl.temporalProductBulk.price = parseFloat(product.sale_price).toFixed(NUMBERS_OF_DECIMALS);
            }
            $("#bulkModal").modal();
        };

        /**
         * Calcula el importe total de un producto agranel, cambiando la cantidad a llevar
         */
        ctrl.calculateBulkImportToProduct = function () { // TODO hay problemas con redondeo ver, los decimales
            var importe = (ctrl.temporalProductBulk.quantity * ctrl.temporalProductBulk.price);
            ctrl.temporalProductBulk.importInBulk = isNaN(importe) ? NUMBER_ZERO :  parseFloat(importe).toFixed(NUMBERS_OF_DECIMALS_BULK);
        };


        /**
         * Calcula la cantidad de un producto agranel, modificando el monto a llevar
         */
        ctrl.calculateQuantityBulkProduct = function () {
            var quantity = (ctrl.temporalProductBulk.importInBulk/ctrl.temporalProductBulk.price);
            ctrl.temporalProductBulk.quantity = isNaN(quantity) ? NUMBER_ZERO : parseFloat(quantity).toFixed(NUMBERS_OF_DECIMALS_BULK);
        };

        /**
         * Agrega un producto a la venta
         */
        ctrl.addBulkProductToSale = function () {

            if(ctrl.temporalProductBulk !== ELEMENT_NOT_FOUND && ctrl.validateBulkProduct()) {
                var product = angular.copy(ctrl.temporalProductBulk);

                product.apply_wholesale = false;
                product.apply_discount = false;
                product.percent_discount = PERCENT_DISCOUNT_ZERO;
                product.originalPrice = product.sale_price;
                ctrl.temporalProductBulk = ELEMENT_NOT_FOUND;
                var indexProduct = ctrl.getIndexProduct(product.id);
                // Si existe en producto en la venta la sustituye
                if(indexProduct !== ELEMENT_NOT_FOUND) {
                    ctrl.ventaCompleta.products[indexProduct] = product;
                }
                // Si no existe la agrega
                else {
                    ctrl.ventaCompleta.products.push(product);
                }
                ctrl.cleanAndFocusInputProduct();
                $("#bulkModal").modal("hide");
            }
        };

        /**
         * Valida los campos para producto agranel
         *
         * @returns {boolean} Resultado
         */
        ctrl.validateBulkProduct = function () {
            // Valida que la cantidad no este vacio
            if(ctrl.temporalProductBulk.quantity <= NUMBER_ZERO || ctrl.temporalProductBulk.quantity === "" || isNaN(ctrl.temporalProductBulk.quantity)) {
                showNotification("Info", "Cantidad de producto requerido", "info");
                return false;
            }
            // Valida que el importe no sea vacio
            if(ctrl.temporalProductBulk.importInBulk <= NUMBER_ZERO || ctrl.temporalProductBulk.importInBulk === "" || isNaN(ctrl.temporalProductBulk.importInBulk)) {
                showNotification("Info", "Importe de producto requerido", "info");
                return false;
            }
            return true;
        };

        /**
         * Muestra modal para actualizar los montos para un producto agranel
         */
        ctrl.updateBulkProductQuantities = function (indexProduct) {
            var product = angular.copy(ctrl.ventaCompleta.products[indexProduct]);
            ctrl.temporalProductBulk = product;
            ctrl.temporalProductBulk.importInBulk = parseFloat(product.price * product.quantity).toFixed(NUMBERS_OF_DECIMALS);
            $("#bulkModal").modal();
        };

        /**
         * Metodo para activar el modo avanzado de busqueda de producto, tambien desactivar
         * @param isEnable El boolean
         */
        ctrl.activateSearchMode = function (isEnable) {
            ctrl.cleanAndFocusInputProduct();
            ctrl.productSearchMode = isEnable;
            if(isEnable) {
                setTimeout(function () {
                    $("#productIdSearch").focus();
                    $scope.$apply();
                }, 200);
            }
        };

        /**
         * Limpia los valores de busqueda de producto
         */
        ctrl.cleanAndFocusInputProduct = function () {
            ctrl.productSearchMode = false;
            ctrl.codeProduct = '';
            $("#productIdSearch").val('');
            setTimeout(function () {
                $("#productId").focus();
                $scope.$apply();
            }, 500);
        };

        /**
         * Elimina un producto de la lista de productos
         * @param index El index del producto a eliminar
         */
        ctrl.deleteProductToSale = function(index) {
            ctrl.ventaCompleta.products.splice(index, 1);
            ctrl.cleanAndFocusInputProduct();
        };

        /**
         * Inicia valores de un producto antes de agregarlo a la venta
         * @param product El objeto de producto
         * @returns {*} El producto iniciado
         */
        ctrl.initProduct = function (product) {
            product.quantity = NUMBER_ONE;
            product.apply_wholesale = false;
            product.apply_discount = false;
            product.percent_discount = PERCENT_DISCOUNT_ZERO;
            product.price = product.sale_price;
            product.originalPrice = product.sale_price;
            return product;
        };

        /**
         * Obtiene el index de un producto por su id
         * @param idProduct El id del producto
         */
        ctrl.getIndexProduct = function (idProduct) {
            var index = ELEMENT_NOT_FOUND;
            if(ctrl.ventaCompleta.products.length) {
                angular.forEach(ctrl.ventaCompleta.products, function (value, key) {
                    if(idProduct === value.id) {
                        index = key;
                    }
                });
            }

            return index;
        };

        /**
         * Recalcula el total a pagar y el total de productos a comprar
         */
        ctrl.calculateTotals = function () {
            var total = NUMBER_ZERO;
            var totalProducts = NUMBER_ZERO;
            var totalDiscount = NUMBER_ZERO;
            // Valida que existan productos en la venta
            if(ctrl.ventaCompleta.products.length) {
                // Por cada producto
                angular.forEach(ctrl.ventaCompleta.products, function (product, key) {
                    total += product.quantity * product.price;
                    totalProducts += parseFloat(product.quantity);
                    // Verifica si el producto tiene descuento aplicado
                    if(product.apply_discount) {
                        // Verifica si el decuento sobre el precio es de precio mayoreo
                        if(product.apply_wholesale) {
                            totalDiscount += ((product.wholesale_price - product.price) * product.quantity);
                        }
                        // de lo contrario es sobre precio de venta
                        else {
                            totalDiscount += ((product.sale_price - product.price)* product.quantity);
                        }
                    }
                });
            }
            ctrl.ventaCompleta.total = parseFloat(total).toFixed(NUMBERS_OF_DECIMALS);
            ctrl.ventaCompleta.total_discount = parseFloat(totalDiscount).toFixed(NUMBERS_OF_DECIMALS);
            ctrl.ventaCompleta.totalProducts = totalProducts;
        };

        /**
         * Coloca el focus en input de cantidad, y selecciona registro
         * @param index El index del producto
         */
        ctrl.setInputQuantity = function (index) {
            $(".quantity-"+index).focus();
            ctrl.removeClassSelectedAllProducts();
            ctrl.ventaCompleta.products[index].isElementSelected = true;
        };

        /**
         * Quita el foco del campo de cantidad de producto
         */
        ctrl.productOnBlur = function () {
            ctrl.removeClassSelectedAllProducts();
        };

        /**
         * Colocal el foco en el campo de cantidad de un producto
         * @param index El index del elemento seleccionado
         */
        ctrl.focusProductInput = function (index) {
            ctrl.ventaCompleta.products[index].isElementSelected = true;
        };

        /**
         * Remueve var selecte de todos los productos
         */
        ctrl.removeClassSelectedAllProducts = function () {
            angular.forEach(ctrl.ventaCompleta.products, function (product, index) {
                product.isElementSelected = false;
            });
        };

        /**
         * Aplica descuento a un solo producto
         * @param applyWholesalePrice El boolean de verificacion
         * @param index El index del producto
         */
        ctrl.applyWholesalePrice = function (applyWholesalePrice, index) {
            if(applyWholesalePrice) {
                ctrl.ventaCompleta.products[index].apply_wholesale = true;
                ctrl.ventaCompleta.products[index].price = ctrl.ventaCompleta.products[index].wholesale_price;
            }
            else {
                ctrl.ventaCompleta.products[index].apply_wholesale = false;
                ctrl.ventaCompleta.products[index].price = ctrl.ventaCompleta.products[index].sale_price;
            }
            // Si tenia precio de descuento lo remueve
            ctrl.ventaCompleta.products[index].apply_discount = false;
            ctrl.ventaCompleta.products[index].percent_discount = PERCENT_DISCOUNT_ZERO;
            // Recalcula los totales
            ctrl.calculateTotals();
        };

        /**
         * Confirmacion para aplicar precio mayoreo a todos los productos
         */
        ctrl.confirmApplyWholesalePrice = function () {
            swal({
                title: "Confirmación",
                text: "¿Estas seguro de aplicar mayoreo a todos los productos?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, Aplicar!",
                cancelButtonText: "Cerrar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if(isConfirm) {
                    ctrl.applyWholesalePriceAllSale();
                    setTimeout(function () {
                        $scope.$apply();
                    }, 200);
                }
            });
        };

        /**
         * Aplica venta de mayoreo a toda la venta
         */
        ctrl.applyWholesalePriceAllSale = function () {
            angular.forEach(ctrl.ventaCompleta.products, function (product, index) {
                product.apply_wholesale = true;
                product.price = product.wholesale_price;
                product.apply_discount = false;
                product.percent_discount = PERCENT_DISCOUNT_ZERO;
            });
            // Recalcula los totales
            ctrl.calculateTotals();
        };

        /**
         * Muestra el modal para aplicar desceunto a un producto en especifico
         * @param product El producto al que se le aplicara el descuento
         */
        ctrl.showDiscountByProduct = function (product) {
            ctrl.productSelected = angular.copy(product);
            ctrl.productSelected.priceOriginal = product.apply_wholesale ? product.wholesale_price : product.originalPrice;
            $("#productDiscountModal").modal();
        };

        /**
         * Calcula el precio de acuerdo a un porcentaje capturado
         */
        ctrl.calculatePriceByPorcentage = function () {
            // Valida que no aplique mas del 100% de descuento
            if(ctrl.productSelected.percent_discount > PERCENT_DISCOUNT_ONE_HUNDRED) {
                ctrl.productSelected.percent_discount = PERCENT_DISCOUNT_ONE_HUNDRED;
            }
            ctrl.productSelected.percent_discount = parseFloat(ctrl.productSelected.percent_discount);

            var price = (ctrl.productSelected.percent_discount * ctrl.productSelected.priceOriginal) / PERCENT_DISCOUNT_ONE_HUNDRED;
            price = isNaN(price) ? NUMBER_ZERO : price;
            ctrl.productSelected.price = parseFloat(ctrl.productSelected.priceOriginal - price).toFixed(NUMBERS_OF_DECIMALS);
        };

        /**
         * Calcula el porcentaje descontado por el precio capturado
         */
        ctrl.calculatePercentage = function () {
            // Valida que no escriba un precio mayor al que vale el producto
            if(ctrl.productSelected.price > ctrl.productSelected.priceOriginal) {
                ctrl.productSelected.price = ctrl.productSelected.priceOriginal;
            }

            var porcentage = (ctrl.productSelected.price * PERCENT_DISCOUNT_ONE_HUNDRED) / ctrl.productSelected.priceOriginal;
            ctrl.productSelected.percent_discount = (PERCENT_DISCOUNT_ONE_HUNDRED - porcentage).toFixed(NUMBERS_OF_DECIMALS);
        };

        /**
         * Aplica el descuento al producto
         */
        ctrl.applyDiscountToProduct = function () {
            // valida que el porcentaje capturado no sea vacio
            if(ctrl.productSelected.percent_discount === '' || isNaN(ctrl.productSelected.percent_discount)) {
                ctrl.productSelected.percent_discount = 0;
            }
            // Valida que el precio no sea vacio
            if(ctrl.productSelected.price === '') {
                ctrl.productSelected.price = NUMBER_ZERO;
            }
            var index = ctrl.getIndexProduct(ctrl.productSelected.id);
            if(index !== ELEMENT_NOT_FOUND){
                ctrl.productSelected.apply_discount = true;
                ctrl.ventaCompleta.products[index] = angular.copy(ctrl.productSelected);
            }
            // Recalcula los totales
            ctrl.calculateTotals();
            // Cierra el modal
            $("#productDiscountModal").modal("hide");
        };

        /**
         * Muestra modal para aplicar descuento a todos los productos de la venta
         */
        ctrl.showToDiscountToSale = function () {
            ctrl.discountGeneralSale = PERCENT_DISCOUNT_ZERO;
            $("#saleDiscountModal").modal();
        };

        /**
         * Metodo que aplica el descuento a todos los productos
         */
        ctrl.applyDiscountToSale = function () {
            // validar que el descuento no pase de 100%
            if(ctrl.discountGeneralSale > PERCENT_DISCOUNT_ONE_HUNDRED) {
                ctrl.discountGeneralSale = PERCENT_DISCOUNT_ONE_HUNDRED;
            }
            // Valida el valor vacio
            else if(ctrl.discountGeneralSale === '') {
                ctrl.discountGeneralSale = PERCENT_DISCOUNT_ZERO;
            }
            angular.forEach(ctrl.ventaCompleta.products, function (product, index) {
                product.apply_discount = ctrl.discountGeneralSale !== PERCENT_DISCOUNT_ZERO;
                product.percent_discount = ctrl.discountGeneralSale;
                var productPrice = product.apply_wholesale ? product.wholesale_price : product.originalPrice;
                var price = (ctrl.discountGeneralSale * productPrice) / PERCENT_DISCOUNT_ONE_HUNDRED;
                product.price = (productPrice-price).toFixed(NUMBERS_OF_DECIMALS);
            });
            // Recalcula los totales
            ctrl.calculateTotals();
            // Cierra el modal
            $("#saleDiscountModal").modal("hide");
        };

        /**
         * Abre el modal para pagar la venta
         */
        ctrl.paySale = function () {
            ctrl.calculateTotals();
            $("#payModal").modal();
        };

        /**
         * Calcula el cambio para pagar una venta
         */
        ctrl.calculaCambioVenta = function () {
            var cambio = parseFloat(ctrl.ventaCompleta.amount_pay - ctrl.ventaCompleta.total).toFixed(NUMBERS_OF_DECIMALS);
            ctrl.ventaCompleta.cambio = isNaN(cambio) || cambio < 0 ? "" : cambio;
        };

        /**
         * Crea una venta
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.createSale = function () {
            if(parseFloat(ctrl.ventaCompleta.total) <= parseFloat(ctrl.ventaCompleta.amount_pay)) {
                // Para validar doble click venta
                if(!ctrl.isProcessSaveActive) {
                    startLoading("Creando Venta");
                    ctrl.isProcessSaveActive = true;
                    // Agrega la forma de pago estatica, esto en un futuro hay que cambiarlo, para varias formas de pago
                    ctrl.addPaymentMethodCash();
                    return PointSaleService.createSale(ctrl.ventaCompleta).then(function(response) {
                        if (!response.data.error) {
                            showNotification('Info', response.data.message, 'success');
                        } else {
                            showNotification('Error', response.data.message, 'error');
                        }
                        ctrl.ventaCompletaTO = angular.copy(ctrl.ventaCompleta);
                        ctrl.ventaCompletaTO.saleId = response.data.saleId;
                        ctrl.ventaCompletaTO.dateNow = new Date();
                        stopLoading();
                        setTimeout(function () {
                            $scope.$apply();
                            $(".ticket-area").printArea();
                        },100);
                        // Inicializa los valores de la venta
                        ctrl.initSale();
                        $("#payModal").modal('hide');
                    });
                }
            }
        };

        /**
         * Busca los datos previos a un corte de caja
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.findPreviewCloseCaja = function () {
            return PointSaleService.findPreviewCloseCaja().then(function (response) {
                response.data.cajaPreview.caja.opening_date_format = ctrl.formatDateToString(response.data.cajaPreview.caja.opening_date);
                ctrl.cajaPreview = response.data.cajaPreview;
                $("#closeCajaModal").modal();
            });
        };

        /**
         * Metodo para formatear un date a string
         * @param date La fecha
         * @returns {string} El resultado de fecha en string
         */
        ctrl.formatDateToString = function (date) {
            var onlyDate = date.split(" ");
            var partDates = onlyDate[0].split("-");
            return partDates[2] + "/" + partDates[1] + "/" + partDates[0];
        };

        /**
         * Confirmacino de cierre de caja
         */
        ctrl.confirmCloseCaja = function () {
            $("#closeCajaModal").modal('hide');
            swal({
                title: "Confirmación",
                text: "¿Estas seguro de cerrar la caja?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, Cerrar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if(isConfirm) {
                    startLoading("Cerrando caja");
                    ctrl.closeCurrenCaja();
                } else {
                    $("#closeCajaModal").modal();
                }
            });
        };

        /**
         * Realiza un corte de caja
         */
        ctrl.closeCurrenCaja = function () {
            return PointSaleService.closeCaja().then(function (response) {
                if(response.data.error) {
                    showNotification('Error', response.data.message, 'error');
                } else {
                    ctrl.caja.isOpen = false;
                    $("#closeCajaModal").modal('hide');
                    showNotification('Info', response.data.message, 'info');
                    // Reinicia los valores y muestra form para abrir nuevamente la caja
                    ctrl.initSale();
                    setTimeout(function () {
                        $("#aperturaCajaField").trigger("focus");
                    },1000);
                }
                stopLoading();
            });
        };

        /**
         * Metodo para agregar un producto a un pedido abierto
         * @param productId El producto a agregar
         * @returns {PromiseLike<T> | Promise<T> | *}
         */
        ctrl.addProductToOrder = function (productId) {
            return OrderService.addProductToOrder(productId).then(function (response) {
                if(response.data.error) {
                    showNotification('Error', response.data.message, 'error');
                } else {
                    showNotification('Info', response.data.message, 'info');
                }
            });
        };

        /**
         * Escucha cuando se agrega un producto actualiza el total
         */
        $scope.$watchCollection('ctrl.ventaCompleta.products', function (newVal, oldVal) {
            ctrl.calculateTotals();
        });

        /**
         * Inicia las variables para una venta
         */
        ctrl.initValueSale = function () {
            ctrl.ventaCompleta = {
                client: {},
                products: [],
                paymentMethods: [],
                total: NUMBER_ZERO,
                totalProducts: NUMBER_ZERO,
                comments: ''
            };
            ctrl.cajaPreview = {};
            ctrl.isProcessSaveActive = false;
            //ctrl.initAutocompleteProduct();
        };

        /**
         * TODO este metodo es estatico para todas las ventas, cambiar cuando la venta se pague por varias formas de pago
         */
        ctrl.addPaymentMethodCash = function () {
            ctrl.ventaCompleta.paymentMethods = [
                {
                    idPaymentMethod: 1, // TODO pasar esta variable por el key de forma de pago cash
                    amount: ctrl.ventaCompleta.total
                }
            ];
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

        ctrl.findPreviewWithdrawal = function () {
            return PointSaleService.findPreviewWithdrawal().then(function (res) {
                ctrl.previewDataWithdrawal.data = res.data.data;
                $("#withdrawalCajaModal").modal();
            });
        };

        ctrl.applyWithdrawal = function (isValid) { // TODO hay bug, probar y corregir llegado momento
            if(isValid) {
                swal({
                    title: "Confirmación",
                    text: "¿Estas seguro de aplicar el retiro?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Aplicar!",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true
                }, function (isConfirm) {
                    if(isConfirm) {
                        PointSaleService.applyWithdrawalCaja(ctrl.withDrawalData).then(function (res) {
                            if(res.data.error) {
                                showNotification('Error', res.data.message, 'error');
                            } else {
                                showNotification('Info', res.data.message, 'info');
                                $("#withdrawalCajaModal").modal("hide");
                            }
                        });
                    }
                });
            }
        };

        ctrl.viewWithDrawals = function() {
            return PointSaleService.findWithDrawalsByCaja().then(function (res) {
                ctrl.withdrawalList.data = res.data;
                ctrl.sumAmountWithdrawals();
                $("#retirosModal").modal();
            });
        };

        ctrl.sumAmountWithdrawals = function () {
            var totalAmount = NUMBER_ZERO;
            angular.forEach(ctrl.withdrawalList.data, function (retiro, key) {
                totalAmount += parseFloat(retiro.amount);
            });
            ctrl.totalAmountWithdrawal = totalAmount;
        };

    });

})();