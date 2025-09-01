app.controller('CrimeOptionsController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {

    // Datatable options
    $scope.dtOptions_crime = {
        dom:    "<'flex flex-col gap-2'<f>>" +
                "<'flex flex-col gap-2'<tr>>" +
                "<'flex flex-col items-center justify-center gap-2'<p>>",
        searching: true,
        responsive: true,
        paging: true,
        ordering: false,
        order: [[0, 'desc']]
    };

    $scope.crimeOptions = [];
    $scope.selectedRow = null;
    $scope.crudState = "Add";

    $scope.getCrimeOptions = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_crime_options",
        }).then(function successCallback(response) {
            $scope.crimeOptions = response.data.crimeOptions;
            console.log('Crime Options:', $scope.crimeOptions);
        });
    }

    $scope.selectCrime = function(index) {
        $scope.selectedRow = index;
        console.log('Selected Row:', $scope.crimeOptions[index]);
        $scope.crudState = "Edit";
        $scope.selectedCrime = angular.copy($scope.crimeOptions[index]);
    }

    $scope.init = function() {
        console.log('Crime Options Controller Initialized');
        $scope.getCrimeOptions();
    }

    $scope.closeModal = function() {
        $scope.selectedRow = null;
        $scope.crudState = "Add";
        $('#modalCrimeOptions').removeClass('flex');
        $('#modalCrimeOptions').addClass('hidden');
    }

    $scope.cancel = function() {
        $scope.selectedCrime = null;
        $scope.selectedRow = null;
        $scope.crudState = "Add";
    }

    $scope.save = function() {
        if($scope.selectedCrime == null) {
            toastr.error("Please fill in all fields");
            return;
        }

        if($scope.crudState == 'Add') {
            $scope.selectedCrime.crimeType_id = null;
        }

        $http({
            method: "POST",
            url: $scope.baseUrl + "ctrl_api/save_crime_type",
            data: $scope.selectedCrime
        }).then(function successCallback(response) {
            if(response.data.success == true)
            {
                if($scope.crudState == 'Add') {
                    toastr.success("Crime type saved successfully");
                }
                else if($scope.crudState == 'Edit') {
                    toastr.success("Crime type updated successfully");
                }
                $scope.cancel();
                $scope.crudState = "Add";
                $scope.getCrimeOptions();
            }
        });

    }

    // Load initial data
    $scope.init();
}]);