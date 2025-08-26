app.controller('EventLogsController', function($scope, $http, $timeout) {

    $scope.init = function() {
        // $scope.getEventLogs();
        console.log("Event Logs Controller Initialized");
    }

    // Load initial data
    $scope.init();
});