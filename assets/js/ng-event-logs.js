app.controller('EventLogsController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {

    $scope.eventlogs = [];

    $scope.dtOptions_logs = {
        responsive: true,
        autoWidth: false,
        scrollX: true,
        scrollCollapse: true,
        width: '100%',
        // dom: 'Bfrtip', // Buttons, filter, table
        dom:    "<'flex flex-col gap-2 text-sm'<Bf>>" +
                "<'flex flex-col gap-2'<tr>>" +
                "<'grid grid-cols-3 items-center justify-center gap-2 text-sm'<l><i><p>>",
        order: [[0, 'desc']], 
        buttons: [
            {
            extend: 'excelHtml5',
            title: 'Event Logs'
            },
            {
            extend: 'pdfHtml5',
            title: 'Event Logs'
            }
        ]
    };

    $scope.getEventLogs = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_event_logs",
        }).then(function successCallback(response) {
            $scope.eventlogs = response.data.eventlogs;
            console.log('Event Logs:', $scope.eventlogs);
        });
    }

    $scope.init = function() {
        $scope.getEventLogs();
        console.log("Event Logs Controller Initialized");
    }

    // Load initial data
    $scope.init();
}]);