(function (){
    var app = angular.module('Product', ['ProductProvider', 'datatables']);

    app.controller('ProductController', function($scope, $http, $compile, ProductService, DTOptionsBuilder, DTColumnBuilder) {
        var ctrl = this;
        ctrl.productList = { data: [] };
        ctrl.unities = { data: [] };
        ctrl.deparments = { data: [] };
        ctrl.dtInstance = {};
        ctrl.productTO = {};
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
                'data-ng-click="ctrl.deleteProduct(' + meta.row + ')">' +
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

        ctrl.viewCreateProduct = function () {
            ctrl.productTO = {};
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

        ctrl.validateProduct = function (isValid) {
            if(isValid) {
                if(ctrl.isCreateProduct) {
                    ctrl.validateCreateProduct();
                }
            }
        };

        ctrl.validateCreateProduct = function () {
            console.info("ctrl.productTO = ", ctrl.productTO);
            if(!ctrl.productTO.current_stock.length) {
                showNotification("Info", "El inventario actual es requerido", "info");
                return;
            }
            // TODO hay que validar que no exista el codigo en BD
        };

        ctrl.editProduct = function (index) {
            ctrl.isCreateProduct = false;
            var product = ctrl.productList.data[index];
            ctrl.productTO = angular.copy(product);
            ctrl.productTO.deparment_id = ''+product.deparment_id;
            ctrl.productTO.unit_id = ''+product.deparment_id;
            ctrl.titleFormAction = 'Editar producto ' + product.description;
            $("#dataProduct").modal();
        };

        ctrl.updateStockProduct = function (index) {
            alert(index);
        };

        ctrl.deleteProduct = function (index) {

        };

    });

})();