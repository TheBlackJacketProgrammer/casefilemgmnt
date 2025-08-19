app.controller('UserPortalController', function($scope, $http, $timeout) {

    // Datatable options
    $scope.dtOptions_users = {
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
            title: 'User Data'
            },
            {
            extend: 'pdfHtml5',
            title: 'User Data'
            }
        ]
    };

    $scope.users = [];
    $scope.orgchart = [];

    // Get users
    $scope.getUsers = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_user_masterlist",
        }).then(function successCallback(response) {
            $scope.users = response.data.users;
            console.log('Users:', $scope.users);
        });
    }

    // Get org chart
    $scope.getOrgChart = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_org_chart",
        }).then(function successCallback(response) {
            $scope.orgchart = response.data.orgchart;
        });
    }

    // Convert MySQL Date to HTML Date - For Global Function later
    $scope.convertMySQLDate = function(dateValue) {
        let date = (dateValue instanceof Date) ? dateValue : new Date(dateValue);
        let options = { 
            weekday: 'long',        // Day name
            year: 'numeric', 
            month: 'short',         // Abbreviated month (e.g., Aug)
            day: '2-digit'
        };
        return date.toLocaleString('en-US',options);
    }

    // Get Position
    $scope.getPosition = function(org_code) {
        const item = $scope.orgchart.find(item => item.org_code == org_code);
        return item ? item.org_position : 'N/A';
    }

    $scope.init = function() {
        $scope.getUsers();
        $scope.getOrgChart();
    }

    // Load initial data
    $scope.init();
});