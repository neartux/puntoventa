(function (){
    var app = angular.module('Product', ['ProductProvider', 'datatables']);

    app.controller('ProductController', function($scope, $http, $compile, ProductService, DTOptionsBuilder, DTColumnBuilder) {
        var ctrl = this;
        ctrl.productList = { data: [] };
        ctrl.unities = { data: [] };
        ctrl.deparments = { data: [] };
        ctrl.adjusmentReasons = { data: [] };
        ctrl.dtInstance = {};
        ctrl.productTO = {};
        ctrl.inversionStockTO = {};
        ctrl.isCreateProduct = true;


        /**
         * Initialize app, instance context path of app
         * @param contextPath Application path
         */
        ctrl.init = function (contextPath) {
            // Coloca el path del server
            ProductService.contextPath = contextPath;
            // busca todas las unidades disponibles
            ProductService.findAllUnit().then(function(resp){
                ctrl.unities.data = resp.data;
            });
            // Busca todos los deparmentos disponibles
            ProductService.findAllDeparments().then(function(resp){
                ctrl.deparments.data = resp.data;
            });
            // Busca las rasones de ajuste
            ProductService.findAllAjusmentReasons().then(function(res){
                ctrl.adjusmentReasons.data = res.data;
            });
            // Busca las inversiones del inventario
            ctrl.findInversionStock();
        };

        /**
         * Busca las inversiones del inventario
         */
        ctrl.findInversionStock = function () {
            ProductService.findInversionStock().then(function (res) {
                ctrl.inversionStockTO = res.data;
            });
        };

        /**
         * Crea los iconos del panel del reporte de stock
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string} El string con el html de las opciones del panel
         */
        function panelActions(data, type, full, meta) {
            return '<a href="javascript:;" class="btn btn-icon-only green-seagreen" ' +
                'data-ng-click="ctrl.previewProduct(' + meta.row + ')">' +
                '<i class="icon-magnifier"></i>' +
                '</a>' +
                '<a href="javascript:;" class="btn btn-icon-only blue" ' +
                'data-ng-click="ctrl.editProduct(' + meta.row + ')">' +
                '<i class="icon-note"></i>' +
                '</a>' +
                '<a href="javascript:;" class="btn btn-icon-only purple"' +
                'data-ng-click="ctrl.updateStockProduct(' + meta.row + ')">' +
                '<i class="icon-share-alt"></i>' +
                '</a>' +
                '<a href="javascript:;" class="btn btn-icon-only red" ' +
                'data-ng-click="ctrl.deleteProduct(' + data.id + ')">' +
                '<i class="icon-trash"></i>' +
                '</a>';
        }

        /**
         * Sobreescribe algunos campos de la tabla de productos
         * @param row La fila
         * @param data El elemento
         * @param dataIndex El index
         */
        function createdRow(row, data, dataIndex) {
            $(row.getElementsByTagName("TD")[2]).html('{{ ' + data.purchase_price + ' | currency }}');
            $(row.getElementsByTagName("TD")[3]).html('{{ ' + data.sale_price + ' | currency }}');
            var clas = data.current_stock <= data.minimum_stock ? 'font-red' : 'font-blue';
            $(row.getElementsByTagName("TD")[4]).html('' +
                '<span class="'+clas+' bold">' +
                '{{'+data.current_stock+'}}' +
                '</span>');
            // Recompiling so we can bind Angular directive to the DT
            $compile(angular.element(row).contents())($scope);
        }

        ctrl.dtOptions = {
            DOM: 'lfrtip',
            displayLength: 10,
            processing: true,
            serverSide: true,
            source: ProductService.getContextPath() + '/admin/stock/findAllProductStock',
            dataProp: 'data',
            paginationType: 'full_numbers',
            fnServerData: function (sSource, aoData, fnCallback, oSettings) {
                $http({
                    method: 'POST',
                    url: ProductService.getContextPath() + '/admin/stock/findAllProductStock',
                    data: {
                        start: aoData[3].value,
                        length: aoData[4].value,
                        draw: aoData[0].value,
                        order: aoData[2].value,
                        search: aoData[5].value,
                        columns: aoData[1].value
                    },
                    headers: {
                        'Content-type': 'application/json'
                    }
                })
                    .then(function (result) {
                        fnCallback(result.data);
                        ctrl.productList.data = result.data.data;
                    }, function () {
                    });
            },
            fnServerParams: function (aoData) {
            },
            createdRow: createdRow,
            paginate: true,
            pagining: true,
            paging: true,
            language: {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ Elementos",
                info: "Mostrando del _START_ al _END_ de _TOTAL_ productos",
                infoEmpty: "No se encontraron productos.",
                infoFiltered: "(filtrado _MAX_ elementos total)",
                infoPostFix: "",
                loadingRecords: "Cargando productos...",
                zeroRecords: "No se encontraron productos",
                emptyTable: "No hay productos disponibles en la tabla",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último"
                }
            }
        };

        ctrl.dtColumns = [
            DTColumnBuilder.newColumn('code').withTitle('Código').withClass('pr-xs pl-xs pb-xs pt-xs').withOption('width', '5%').notSortable(),
            DTColumnBuilder.newColumn('description').withTitle('Producto').withClass('pr-xs pl-xs pb-xs pt-xs').withOption('width', '40%').notSortable(),
            DTColumnBuilder.newColumn('purchase_price').withTitle('Precio Compra').withClass('text-right pr-xs pl-xs pb-xs pt-xs').withOption('width', '10%').notSortable(),
            DTColumnBuilder.newColumn('sale_price').withTitle('Precio Venta').withClass('text-right pr-xs pl-xs pb-xs pt-xs').withOption('width', '10%').notSortable(),
            DTColumnBuilder.newColumn('current_stock').withTitle('Stock').withClass('text-center pr-xs pl-xs pb-xs pt-xs').withOption('width', '10%').notSortable(),
            DTColumnBuilder.newColumn(null).withTitle('Panel').withClass('pr-xs pl-xs pb-xs pt-xs').withOption('width', '25%').renderWith(panelActions).notSortable()
        ];

        /**
         * Despliega la vista para crear un nuevo producto
         */
        ctrl.viewCreateProduct = function () {
            ctrl.productTO = {};
            ctrl.productTO.id = 0;
            ctrl.isCreateProduct = true;
            ctrl.titleFormAction = 'Crear Producto';
            $("#dataProduct").modal();
        };

        /**
         * Visualizacion previa de un producto en especifico
         *
         * @param index El index del producto en la lista
         */
        ctrl.previewProduct = function (index) {
            ctrl.productTO = ctrl.productList.data[index];
            $("#previewProduct").modal();
        };

        /**
         * Valida creacion o modificacion de un producto
         *
         * @param isValid Verifica si es valido
         */
        ctrl.validateProduct = function (isValid) {
            // Si el producto es valido
            if(isValid) {
                // Valida el codigo del producto si es disponible
                ProductService.existProductByCode(ctrl.productTO.id, $.trim(ctrl.productTO.code).toUpperCase()).then(function (res) {
                    // Si el codigo es valido
                    if(parseInt(res.data.exist) === 0) {
                        // Si es crear producto
                        if(ctrl.isCreateProduct) {
                            ctrl.validateCreateProduct();
                        }
                        // Si es modificar un producto
                        else {
                            ctrl.validateUpdateProduct();
                        }
                    }
                    else {
                        showNotification("Info", "El codigo "+ctrl.productTO.code+" no esta disponible", "info");
                    }
                });
            }
        };

        /**
         * Valida los campos para crear un nuevo producto
         */
        ctrl.validateCreateProduct = function () {
            // Valida que tenga stock
            if(!ctrl.productTO.current_stock.length) {
                showNotification("Info", "El inventario actual es requerido", "info");
                return;
            }
            // Crea el producto
            ProductService.saveProduct(ctrl.productTO).then(function (res) {
                if(!res.data.error) {
                    $("#dataProduct").modal("hide");
                    ctrl.dtInstance.rerender();
                    showNotification("Success", res.data.message, "success");
                }
                else {
                    showNotification("Error", res.data.message, "error");
                }
            });
        };

        /**
         * Muestra la informacion para editar un producto
         *
         * @param index El index de la lista del producto
         */
        ctrl.editProduct = function (index) {
            ctrl.isCreateProduct = false;
            var product = ctrl.productList.data[index];
            ctrl.productTO = angular.copy(product);
            ctrl.productTO.deparment_id = ''+product.deparment_id;
            ctrl.productTO.unit_id = ''+product.deparment_id;
            ctrl.titleFormAction = 'Editar producto ' + product.description;
            $("#dataProduct").modal();
        };

        /**
         * Metodo para validar campos al actualiza un producto
         */
        ctrl.validateUpdateProduct = function () {
            // Crea el producto
            ProductService.updateProduct(ctrl.productTO).then(function (res) {
                if(!res.data.error) {
                    $("#dataProduct").modal("hide");
                    ctrl.dtInstance.rerender();
                    showNotification("Success", res.data.message, "success");
                } else {
                    showNotification("Error", res.data.message, "error");
                }
            });
        };

        /**
         * Muestra inofrmacion para actualizar el stock
         *
         * @param index El index del producto a actualizar
         */
        ctrl.updateStockProduct = function (index) {
            var product = ctrl.productList.data[index];
            ctrl.productTO = angular.copy(product);
            ctrl.productTO.quantity_adjust = 0;
            ctrl.productTO.newQuantityStock = product.current_stock;
            $("#previewStockProduct").modal();
        };

        ctrl.applyAdjustProduct = function () {
            if(ctrl.productTO.adjusmentReason === undefined) {
                showNotification("Alerta", "Selecciona una razon de ajuste", "warning");
                return;
            }
            if(parseFloat(ctrl.productTO.quantity_adjust) <= 0) {
                showNotification("Alerta", "La cantidad de ajuste es requerido", "warning");
                return;
            }
            swal({
                    title: "Confirmación",
                    text: "¿Estas seguro de ajustar el inventario?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Ajustar!",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true
                },
                function(apply){
                if(apply) {
                    startLoading("Ajustando stock de producto");
                    // Ajusta el stock
                    ProductService.updateStock(ctrl.productTO.id, parseFloat(ctrl.productTO.quantity_adjust), ctrl.productTO.adjusmentReason.id).then(function (res) {
                        if(!res.error) {
                            $("#previewStockProduct").modal("hide");
                            ctrl.dtInstance.rerender();
                            showNotification("Success", res.message, "success");
                        } else {
                            showNotification("Error", res.message, "error");
                        }
                        stopLoading();
                    });
                }

            });
        };

        /**
         * Calcula la nueva cantidad de stock
         */
        ctrl.calculateNewQuantityStock = function () {
            if(ctrl.productTO.adjusmentReason === undefined) {
                showNotification("Info", "Selecciona una razon de ajuste", "info");
                return;
            }
            var sign = ctrl.getSignReason(ctrl.productTO.adjusmentReason);
            if(sign === 1) {
                ctrl.productTO.newQuantityStock = (parseFloat(ctrl.productTO.current_stock) + parseFloat(ctrl.productTO.quantity_adjust));
            }
            else {
                ctrl.productTO.newQuantityStock = (parseFloat(ctrl.productTO.current_stock) - parseFloat(ctrl.productTO.quantity_adjust));
            }
        };

        /**
         * Valida que opcion de ajuste esta seleccionada
         */
        ctrl.selectReasonAdjustment = function () {
            if(ctrl.productTO.adjusmentReason !== undefined) {
                ctrl.calculateNewQuantityStock();
            }
            else {
                ctrl.productTO.newQuantityStock = ctrl.productTO.current_stock;
                ctrl.productTO.quantity_adjust = 0;
            }
        };

        /**
         * Obtiene el sino que tiene la razon de ajuste
         * @param reason La razon de ajuste
         * @returns {number} El nuemero del resultado
         */
        ctrl.getSignReason = function (reason) {
            if(reason.sign === "+") {
                return 1;
            }
            return 0;
        };

        /**
         * Metodo para eliminar un producto por su id
         *
         * @param id El id del producto
         */
        ctrl.deleteProduct = function (id) {
            swal({
                    title: "Confirmación",
                    text: "¿Estas seguro de eliminar el producto?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Eliminar!",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true
                },
                function(){
                    startLoading("Eliminando producto");
                    ProductService.deleteProduct(id).success(function (response) {
                        if(!response.error) {
                            ctrl.dtInstance.rerender();
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

    });

})();