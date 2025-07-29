// Main AngularJS application module
var app = angular.module('ng-bcms-app', ['datatables']); 

// Custom directive for touch events
app.directive('ngTouchstart', function() {
    return function(scope, element, attrs) {
        element.bind('touchstart', function(event) {
            scope.$apply(function() {
                scope.$eval(attrs.ngTouchstart, {$event: event});
            });
        });
    };
});

app.directive('ngTouchmove', function() {
    return function(scope, element, attrs) {
        element.bind('touchmove', function(event) {
            scope.$apply(function() {
                scope.$eval(attrs.ngTouchmove, {$event: event});
            });
        });
    };
});

// For Partial View Use
app.directive('compile', ['$compile', function ($compile) 
{
    return function(scope, element, attrs) 
    {
        scope.$watch(function(scope) 
        {
            return scope.$eval(attrs.compile);
        },function(value)
        {
            element.html(value);
            $compile(element.contents())(scope);
        });
    };
}]);