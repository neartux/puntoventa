(function () {
    var app = angular.module('CommonDirectives', []);

    app.directive('ngEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if (event.which === 13) {
                    scope.$apply(function () {
                        scope.$eval(attrs.ngEnter, {'event': event});
                    });

                    event.preventDefault();
                }
            });
        };
    });


})();

var NUMBER_ZERO = 0;
var NUMBER_ONE = 1;
var NUMBER_TWO = 1;
var NUMBER_THREE = 3;
var NUMBERS_OF_DECIMALS = 2;
var NUMBERS_OF_DECIMALS_BULK = 2;
var ELEMENT_NOT_FOUND = undefined;
var PERCENT_DISCOUNT_ZERO = 0.0;
var PERCENT_DISCOUNT_ONE_HUNDRED = 100;