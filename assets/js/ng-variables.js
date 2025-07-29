// Controller Script For Global Variables
// This controller manages global variables and state for the application

app.controller("ng-variables", 
    ['$scope', function($scope) {

        // Initialize controller
        $scope.init = function() {
            console.log('Global Variables Controller Initialized');
            // Load initial data if needed
            // $scope.loadInitialData();
        };

        $scope.section = "";

        $scope.baseUrl = window.location.protocol + '//' + window.location.host + '/brgycasefile/';


        // Initialize arrays
        // $scope.credentials = [];

        // Credentials object with proper initialization
        $scope.credentials = {
            username: "",
            password: ""
        };

        // Temporary storage array
        $scope.temp = [];

        // CRUD state management
        $scope.crudState = "Create";

        // Reset employee details to default state
        $scope.resetEmployeeDetails = function() {
            $scope.employeeDetails = {
                id: "",
                ee_id_no: "",
                firstname: "",
                lastname: "",
                middlename: "",
                address: "",
                email: "",
                contact_num: "",
                is_active: 0,
                designation_id: "",
                division_id: "",
                department_id: "",
                employee_type: "",
                date_employed: "",
                date_seperated: "",
                sss: null,
                pagibig: null,
                philhealth: null,
                tin: null
            };
            $scope.crudState = "Create";
        };

        // Set employee details for editing
        $scope.setEmployeeDetails = function(employee) {
            $scope.employeeDetails = angular.copy(employee);
            $scope.crudState = "Update";
        };

        // Clear temporary data
        $scope.clearTemp = function() {
            $scope.temp = [];
        };
        
        // Initialize the controller
        $scope.init();

        

    }]
); 