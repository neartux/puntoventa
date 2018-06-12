(function (){
    var app = angular.module('Product', ['ProductProvider', 'datatables']);

    app.controller('ProductController', function($scope, $http, ProductService, DTOptionsBuilder, DTColumnDefBuilder) {
        var ctrl = this;
        ctrl.productList = { data: [] };
        ctrl.unities = [];
        ctrl.deparments = [];
        ctrl.adjusmentReasons = [];
        ctrl.inversionStockTO = {};

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
         */
        ctrl.init = function (contextPath) {
            startLoading("Cargando productos");
            // Coloca el path del server
            ProductService.contextPath = contextPath;

            ProductService.findAllProducts().then(function(res){
                ctrl.productList.data = res.data;
                stopLoading();
            });
            ctrl.findInversionStock();
            ProductService.findAllUnit().then(function(resp){
                ctrl.unities = resp.data;
            });

            ProductService.findAllDeparments().then(function(resp){
                ctrl.deparments = resp.data;
            });
            ProductService.findAllAjusmentReasons().then(function(res){
                ctrl.adjusmentReasons = res.data;
            });
        };

        ctrl.findInversionStock = function () {
            ProductService.findInversionStock().then(function (res) {
                ctrl.inversionStockTO = res.data;
            });
        };

        ctrl.showCreateProduct = function () {
            ctrl.cleanForm();
            ctrl.product.unit = ctrl.unities[0];
            ctrl.product.deparment = ctrl.deparments[0];
            $("#productModal").modal();
            ctrl.titleFormAction = 'Crear Producto';
        };

        /**
         * Valida el form y crea o modifica
         * @param isFormValid La validacion del form
         */
        ctrl.validateProduct = function (isFormValid) {
            console.info("0")
            if(isFormValid) {
                console.info("1")
                startLoading("Guardando informacion");
                console.info("2")
                if(ctrl.product.isNew) {
                    console.info("3")
                    ctrl.saveProduct();
                    console.info("4");
                } else {
                    ctrl.updateProduct();
                }
                stopLoading();
            }
        };

        /**
         *  Metodo que crea un nuevo departamento
         */
        ctrl.saveProduct = function () {
            console.info("se va");
            return ProductService.saveProduct(ctrl.product).success(function(response) {
                console.info("regreso")
                if (!response.error) {
                    ctrl.product.id = response.id;
                    ctrl.productList.data.push(ctrl.product);
                    showNotification('Mensaje', response.message, 'info');
                } else {
                    showNotification('Error', response.message, 'error');
                }
                ctrl.cleanForm();
                $("#productModal").modal("hide");
            }).error(function(response) {
                showNotification('Mensaje', 'Ha ocurrido un error, contacte a su administrador', 'error');
                ctrl.cleanForm();
            });
        };

        /**
         * Muestra el form para actualizar un departamento
         * @param index El indice del elemento
         * @param product El elemento
         */
        ctrl.showEditProduct = function (index, product) {
            ctrl.product = angular.copy(product);
            ctrl.product.index = index;
            ctrl.product.deparment = ctrl.filterSelect(ctrl.product.deparment_id,ctrl.deparments);
            ctrl.product.unit = ctrl.filterSelect(ctrl.product.unit_id,ctrl.unities);
            ctrl.product.isNew = false;
            $("#productModal").modal();
            ctrl.titleFormAction = 'Modificar '+product.description;
        };

        /**
         * Metodo para actualizar un departamento existente
         */
        ctrl.updateProduct = function () {
            return ProductService.updateProduct(ctrl.product).success(function(response) {
                if (!response.error) {
                    ctrl.productList.data[ctrl.product.index] = angular.copy(ctrl.product);
                    showNotification('Mensaje', response.message, 'info');
                } else {
                    showNotification('Error', response.message, 'error');
                }
                ctrl.cleanForm();
                $("#productModal").modal("hide");
                stopLoading();
            }).error(function(response) {
                showNotification('Mensaje', 'Ha ocurrido un error, contacte a su administrador', 'error');
                ctrl.cleanForm();
                stopLoading();
            });
        };

        /**
         * Elimina un producto por su id
         * @param index El indice para remover de la lista
         * @param id El id del elemento para eliminar
         */
        ctrl.deleteProduct = function (index, id) {
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
                stopLoading("Eliminando Producto");
                    ProductService.deleteProduct(id).success(function (response) {
                        if(!response.error) {
                            ctrl.productList.data.splice(index, 1);
                            showNotification('Mensaje', response.message, 'info');
                            setTimeout(function () {
                                $scope.$apply();
                            },400);
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

        ctrl.showEditStock = function(index,product){
            ctrl.product = angular.copy(product);
            ctrl.product.index = index;
            // ctrl.product.adjusmentReason = ctrl.filterSelect(3,ctrl.adjusmentReasons);
            ctrl.titleFormAction = 'Stock';
            $("#stockModal").modal();
        };

        ctrl.validateStock = function (isFormValid) {
            if(isFormValid) {
                ctrl.updateStock();
            }
        };

        ctrl.updateStock = function(){
            startLoading("Actualizando inventario");
            ProductService.updateStock(ctrl.product).then(function(response){
                if (!response.error) {
                    var idx = ctrl.idxCollection(ctrl.productList.data,ctrl.product.id);
                    if(idx!==false){
                        ctrl.productList.data[idx].current_stock = response.stock;
                    }
                    showNotification('Mensaje', response.message, 'info');
                    ctrl.findInversionStock();
                } else {
                    showNotification('Error', response.message, 'error');
                }
                ctrl.cleanForm();
                $("#stockModal").modal("hide");
                stopLoading();
            }).catch(function(response){
                showNotification('Mensaje', 'Ha ocurrido un error, contacte a su administrador', 'error');
                ctrl.cleanForm();
                stopLoading();
            });
        };

        ctrl.idxCollection = function($array,$id){
            var $res = _.filter($array,{'id':$id});

            if($res.length>0){
                var $idx = $array.indexOf($res[0]);
                return $idx;
            }
            return false;
        }
        
        /**
         * Encuentra un item de un select
         * @param id El id del elemento
         * @param array Coleccion a encontrar
         */
        ctrl.filterSelect = function($id,$array){
            var idx = _.filter($array,{'id':$id});
            // console.info("idx",idx);
            return idx[0];
        }

        /**
         * Limpia el form del departamento
         */
        ctrl.cleanForm = function () {
            ctrl.product = {
                id: 0,
                description: '',
                unit_id:0,
                deparment_id:0,
                code:'',
                purchase_price:0,
                sale_price:0,
                wholesale_price:0,
                current_stock:0,
                minimum_stock:0,
                index: undefined,
                isNew: true,
                adjusmentReason: []
            };
            $scope.productForm.$setPristine();
        };

    });

})();