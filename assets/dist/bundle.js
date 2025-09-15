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

    app.directive('fileModel', ['$parse', function ($parse) 
    {
      return {
        restrict: 'A',
        link: function(scope, element, attrs) 
              {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;
        
                element.bind('change', function() 
                {
                  scope.$apply(function() 
                  {
                    modelSetter(scope, element[0].files[0]);
                  });
                });
              }
        };
    }]);
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
// AngularJS Controller for Header Mobile Menu
app.controller("ng-header", ['$scope', '$window', '$timeout', '$compile', '$http', function($scope, $window, $timeout, $compile, $http  ) {
    
    // Initialize mobile menu state
    $scope.mobileMenu = {
        isOpen: false,
        isExpanded: false
    };

    // Touch state for swipe gestures
    $scope.touchStartX = null;

    // Open mobile menu
    $scope.openMobileMenu = function() {
        $scope.mobileMenu.isOpen = true;
        
        // Use $timeout to ensure DOM is updated before triggering animation
        $timeout(function() {
            $scope.mobileMenu.isExpanded = true;
        }, 10);
        
        // Prevent background scrolling
        document.body.style.overflow = 'hidden';
    };

    // Close mobile menu
    $scope.closeMobileMenu = function() {
        $scope.mobileMenu.isExpanded = false;
        
        // Wait for animation to complete before hiding
        $timeout(function() {
            $scope.mobileMenu.isOpen = false;
        }, 300);
        
        // Restore scrolling
        document.body.style.overflow = '';
    };

    // Handle backdrop click to close menu
    $scope.handleBackdropClick = function($event) {
        if ($event.target.id === 'mobile-backdrop' || $event.target.classList.contains('mobile-menu')) {
            $scope.closeMobileMenu();
        }
    };

    // Handle swipe gestures for closing menu
    $scope.handleTouchStart = function($event) {
        $scope.touchStartX = $event.touches[0].clientX;
    };

    $scope.handleTouchMove = function($event) {
        if (!$scope.touchStartX) return;
        
        var currentX = $event.touches[0].clientX;
        var diffX = $scope.touchStartX - currentX;
        
        if (diffX > 50) { // Swipe left to close
            $scope.closeMobileMenu();
            $scope.touchStartX = null; // Reset touch state
        }
    };

    // Handle window resize
    $scope.handleWindowResize = function() {
        if ($window.innerWidth >= 1024) { // lg breakpoint
            $scope.closeMobileMenu();
        }
    };

    // Handle escape key
    $scope.handleKeydown = function($event) {
        if ($event.key === 'Escape' && $scope.mobileMenu.isOpen) {
            $scope.closeMobileMenu();
        }
    };

    // Initialize controller
    $scope.init = function() {
        console.log('Header Controller Initialized');
        
        // Bind window resize event
        angular.element($window).on('resize', function() {
            $scope.handleWindowResize();
            $scope.$apply();
        });

        // Bind keydown event
        angular.element(document).on('keydown', function($event) {
            $scope.handleKeydown($event);
            $scope.$apply();
        });
    };

    // Cleanup on scope destroy
    $scope.$on('$destroy', function() {
        // Remove event listeners
        angular.element($window).off('resize');
        angular.element(document).off('keydown');
    });

    // Open Records
    $scope.openRecords = function() {
        $scope.$parent.section = "";
        $http({
            method: "POST",
            url:  $scope.baseUrl + "ctrl_main/open_records"
        }).then(function successCallback(response) {
            $scope.$parent.section = response.data["view"];
        });
    };

    // Open User Portal
    $scope.openUserPortal = function() {
        $scope.$parent.section = "";
        $http({
            method: "POST",
            url:  $scope.baseUrl + "ctrl_main/open_user_portal"
        }).then(function successCallback(response) {
            $scope.$parent.section = response.data["view"];
        });
    };

    // Open Event Logs
    $scope.openEventLogs = function() {
        $scope.$parent.section = "";
        $http({
            method: "POST",
            url:  $scope.baseUrl + "ctrl_main/open_event_logs"
        }).then(function successCallback(response) {
            $scope.$parent.section = response.data["view"];
        });
    };

    // Open Data Statistics
    $scope.openDataStatistics = function() {
        $scope.$parent.section = "";
        $http({
            method: "POST",
            url:  $scope.baseUrl + "ctrl_main/open_data_statistics"
        }).then(function successCallback(response) {
            $scope.$parent.section = response.data["view"];
        });
    };

    // Logout
    $scope.logout = function() {
        $http({
            method: "POST",
            url:  $scope.baseUrl + "ctrl_main/logout"
        }).then(function successCallback(response) {
            window.location.href = $scope.baseUrl;
        });
    };

    // Initialize the controller
    $scope.init();
}]); 
app.controller('DatatablesOptionsController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {


    // Datatable options
    $scope.dtOpt_CountsByType = {
        responsive: true,
        autoWidth: false,
        scrollX: true,
        scrollCollapse: true,
        width: '100%',
        dom: 'Bfrtip', // Buttons, filter, table
        order: [[1, 'desc']],
        pageLength: 12,
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

    $scope.dtOpt_CountsByMonths = {
        responsive: true,
        autoWidth: false,
        scrollX: true,
        scrollCollapse: true,
        width: '100%',
        dom: 'Bfrtip', // Buttons, filter, table
        order: [[1, 'desc']],
        pageLength: 12,
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
}]);
app.controller("ng-login", ['$scope', '$http', function ($scope, $http) {


    $scope.login = function() {
        console.log('Login');
        console.log($scope.credentials);
        $http({
            method: "POST",
            url: $scope.baseUrl + "ctrl_api/login",
            data: $scope.credentials
        }).then(function successCallback(response) {
            // Redirect to dashboard
            window.location.href = $scope.baseUrl;
        });
    }
}]);
app.controller('RecordsController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {
    $scope.records = [];
    $scope.dataTable = null;
    $scope.selectAll = false;
    $scope.recordIndex = 0;
    $scope.recordCount = 1;
    $scope.recordTotal = 0;
    $scope.currentRecord = [];
    $scope.status = "None";

    // Datatable options
    $scope.dtOptions = {
        responsive: true,
        autoWidth: false,
        scrollX: true,
        scrollCollapse: true,
        width: '100%',
        dom: 'Bfrtip', // Buttons, filter, table
        order: [[5, 'desc']], // Order by case_dateFiled column (index 5) in descending order
        columnDefs: [
            {
                targets: 6, // case_dateFiled column (adjusted for checkbox column)
                type: 'date',
                render: function(data, type, row) {
                    if (type === 'display') {
                        return data; // Display as is
                    }
                    if (type === 'sort') {
                        // Convert to sortable date format
                        var dateStr = data.substring(0, 25); // Remove "PM" part
                        var date = new Date(dateStr);
                        return date.getTime(); // Return timestamp for sorting
                    }
                    return data;
                }
            }
        ],
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
    
    // Get records
    $scope.getRecords = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_records",
            data: $scope.credentials
        }).then(function successCallback(response) {
            if(response.data.status == 'success')
            {
                $scope.records = response.data.records;
                console.log('Records data:', $scope.records);
                console.log('Records length:', $scope.records.length);
            }
            else
            {
                window.location.href = $scope.baseUrl;
            }
        });
    };

    // Get crime types
    $scope.getCrimeTypes = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_crime_types",
        }).then(function successCallback(response) {
            if(response.data.status == 'success')
            {
                $scope.crimeTypes = response.data.crimeTypes;
            }
        });
    }

    $scope.openCrimeOptions = function() {
        $('#modalCrimeOptions').removeClass('hidden');
        $('#modalCrimeOptions').addClass('flex');
    }

    // Select/Deselect all records
    $scope.toggleSelectAll = function() {
        try {
            var headerCheckbox = $("#selectAll");
            var isChecked = headerCheckbox.prop('checked');
            
            // If header is checked, select all. If unchecked, deselect all
            $scope.selectAll = isChecked;
            
            // Update data model
            $scope.records.forEach(function(record) {
                record.selected = isChecked;
            });
            
            // Update all visible individual checkboxes to match header state
            $('#tbl_records tbody input[type="checkbox"]:visible').prop('checked', isChecked);
            
            // Force Angular digest if needed
            if (!$scope.$$phase) {
                $scope.$apply();
            }
            
            console.log('Select all toggled:', isChecked, 'Records affected:', $scope.records.length);
        } catch (error) {
            console.error('Error in toggleSelectAll:', error);
        }
    };

    // Alternative method for more reliable header checkbox handling
    $scope.handleHeaderCheckbox = function() {
        try {
            var headerCheckbox = $("#selectAll");
            var isChecked = headerCheckbox.prop('checked');
            
            console.log('Header checkbox clicked, state:', isChecked);
            
            // Always set all records to the header checkbox state
            $scope.records.forEach(function(record) {
                record.selected = isChecked;
            });
            
            // Update all individual checkboxes
            $('#tbl_records tbody input[type="checkbox"]').prop('checked', isChecked);
            
            // Update the selectAll variable
            $scope.selectAll = isChecked;
            
            // Force Angular digest
            if (!$scope.$$phase) {
                $scope.$apply();
            }
            
            console.log('Header checkbox handled - All records set to:', isChecked);
        } catch (error) {
            console.error('Error in handleHeaderCheckbox:', error);
        }
    };

    // Update select all checkbox based on individual selections
    $scope.updateSelectAll = function() {
        try {
            var selectedCount = $scope.getSelectedRecords().length;
            var totalRecords = $scope.records.length;
            $scope.recordTotal = selectedCount; // Get the total number of selected records
            $scope.selectAll = (selectedCount === totalRecords && totalRecords > 0);
            
            // Update header checkbox state
            $("#selectAll").prop('checked', $scope.selectAll);
            
            console.log('Selection updated - Selected:', selectedCount, 'Total:', totalRecords, 'SelectAll:', $scope.selectAll);
        } catch (error) {
            console.error('Error in updateSelectAll:', error);
        }
    };

    // Get selected records
    $scope.getSelectedRecords = function() {
        try {
            return $scope.records.filter(function(record) {
                return record.selected === true;
            });
        } catch (error) {
            console.error('Error in getSelectedRecords:', error);
            return [];
        }
    };

    // Pad function
    $scope.pad = function(n) { 
        return (n < 10 ? '0' : '') + n; 
    }

    // Date conversion utility function
    $scope.convertDate = function(dateValue, colName) {

        // Convert ng-model date (string) to Date object
        console.log('dateValue', dateValue);
       let tempDate = new Date(dateValue);
        // let tempDate = dateValue;

        // MySQL format (YYYY-MM-DD HH:MM:SS) → set time to current time
        let mysqlDate = tempDate.getFullYear() + '-' +
                        $scope.pad(tempDate.getMonth() + 1) + '-' +
                        $scope.pad(tempDate.getDate()) + ' ' +
                        $scope.pad(tempDate.getHours()) + ':' +
                        $scope.pad(tempDate.getMinutes()) + ':' +
                        $scope.pad(tempDate.getSeconds());


        if(colName == 'complainant_birthday') {
            $scope.currentRecord[0].complainant_birthday = mysqlDate;
        }
        else if(colName == 'complainee_birthday') {
            $scope.currentRecord[0].complainee_birthday = mysqlDate;
        }
        else if(colName == 'case_crimeDate') {
            $scope.currentRecord[0].case_crimeDate = mysqlDate;
        }
        else if(colName == 'case_dateFiled') {
            $scope.currentRecord[0].case_dateFiled = mysqlDate;
        }
        else if(colName == 'case_dateUpdated') {
            $scope.currentRecord[0].case_dateUpdated = mysqlDate;
        }
        else{
            return mysqlDate;
        }
    };

    $scope.convertMySQLDate = function(dateValue) {
        let date = (dateValue instanceof Date) ? dateValue : new Date(dateValue);
        let options = { 
            weekday: 'long',        // Day name
            year: 'numeric', 
            month: 'short',         // Abbreviated month (e.g., Aug)
            day: '2-digit',
            // hour: '2-digit', 
            // minute: '2-digit', 
            // second: '2-digit',
            // hour12: true 
        };
        return date.toLocaleString('en-US',options);
    }
    
    // Add record
    $scope.addRecord = function() {
        $scope.status = "Add";
        $scope.currentRecord = [{
            case_crimeDate: null,
            case_crimeDetails: "",
            case_crimeScene: "",
            case_crimeType: "",
            case_crimeWitness: "",
            case_dateFiled: null,
            case_id: null,
            case_status: "Pending",
            complainant_address: "",
            complainant_age: "",
            complainant_birthday: null,
            complainant_contactNum: "",
            complainant_image: null,
            complainant_name: "",
            complainee_address: "",
            complainee_age: "",
            complainee_birthday: null,
            complainee_contactNum: "",
            complainee_name: "",
            complainee_image: null,
            complainant_pic: null,
            complainee_pic: null,
            complainant_gender: "",
            complainee_gender: ""
        }];
        $scope.recordTotal = 1;
        $scope.recordIndex = 0;
        $('#modalRecords').removeClass('hidden'); // Remove hidden class to show modal
        $('#modalRecords').addClass('flex'); 
    }
    
    // Edit selected records
    $scope.editSelectedRecords = function(status) {
        $scope.status = status;
        $scope.currentRecord = angular.copy($scope.getSelectedRecords());
        $scope.currentRecord.forEach(function(rec) {
            // DB Date to Input Date HTML Value
            rec.complainant_birthday = new Date(rec.complainant_birthday);
            rec.complainee_birthday = new Date(rec.complainee_birthday);
            rec.case_crimeDate = new Date(rec.case_crimeDate);
            rec.case_dateFiled = new Date(rec.case_dateFiled);
            rec.case_dateUpdated = (rec.case_dateUpdated != null) ? new Date(rec.case_dateUpdated) : null;
        });
        $scope.complainant_image_preview = $scope.baseUrl + $scope.currentRecord[$scope.recordIndex].complainant_pic;
        $scope.complainee_image_preview = $scope.baseUrl + $scope.currentRecord[$scope.recordIndex].complainee_pic;
        $scope.recordTotal = $scope.currentRecord.length;
        $('#modalRecords').removeClass('hidden'); // Remove hidden class to show modal
        $('#modalRecords').addClass('flex'); 
    };

    // Simple image preview
    $scope.previewImage = function(input, type) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (type === 'complainant') {
                    $scope.complainant_image_preview = e.target.result;
                    $scope.currentRecord[$scope.recordIndex].complainant_image = file;
                } else if (type === 'complainee') {
                    $scope.complainee_image_preview = e.target.result;
                    $scope.currentRecord[$scope.recordIndex].complainee_image = file;
                }
                $scope.$apply();
            };
            reader.readAsDataURL(file);
        }
    };

    // Save record
    $scope.saveRecord = function() {
        var formData = new FormData();

        
        if($scope.status == 'Add') {
            $scope.currentRecord[$scope.recordIndex].case_dateFiled = new Date();
        }
        else if($scope.status == 'Edit') {
            $scope.currentRecord[$scope.recordIndex].case_dateUpdated = new Date();
        }

        // Append all record fields to FormData using a loop
        var record = $scope.currentRecord[$scope.recordIndex];
        Object.keys(record).forEach(function(key) {
            formData.append(key, record[key]);
        });

        // Append images separately
        formData.append('complainant_image', $scope.currentRecord[$scope.recordIndex].complainant_image);
        formData.append('complainee_image', $scope.currentRecord[$scope.recordIndex].complainee_image);

        $http({
            method: "POST",
            url: $scope.baseUrl + "ctrl_api/save_record",
            data: formData,
            headers: {
                'Content-Type': undefined // Let browser set content type for FormData
            }
        }).then(function successCallback(response) {
            if(response.data.status == 'success')
            {
                if($scope.status == 'Add') {
                    toastr.success("Record saved successfully");
                    $scope.closeModal();
                }
                else if($scope.status == 'Edit') {
                    toastr.success("Record updated successfully");
                }
                $scope.getRecords();
            }
        });
    };

    $scope.validateAndSave = function() {
        if($scope.isFormInvalid()) {
            return;
        }
        $scope.saveRecord();
    };

    $scope.isFormInvalid = function() {
        if($scope.status == "None") {
            return true;
        }
        // Validate details
        if($scope.currentRecord[$scope.recordIndex].complainant_name == "" ||
            $scope.currentRecord[$scope.recordIndex].complainant_address == "" ||
            $scope.currentRecord[$scope.recordIndex].complainant_contactNum == "" ||
            $scope.currentRecord[$scope.recordIndex].complainant_age == "" ||
            $scope.currentRecord[$scope.recordIndex].complainant_birthday == "" ||
            $scope.currentRecord[$scope.recordIndex].complainee_name == "" ||
            $scope.currentRecord[$scope.recordIndex].complainee_address == "" ||
            $scope.currentRecord[$scope.recordIndex].complainee_contactNum == "" ||
            $scope.currentRecord[$scope.recordIndex].complainee_age == "" ||
            $scope.currentRecord[$scope.recordIndex].complainee_birthday == "" ||
            $scope.currentRecord[$scope.recordIndex].case_crimeDetails == "" ||
            $scope.currentRecord[$scope.recordIndex].case_crimeType == "" ||
            $scope.currentRecord[$scope.recordIndex].case_crimeScene == "" ||
            $scope.currentRecord[$scope.recordIndex].case_status == "" ||
            $scope.currentRecord[$scope.recordIndex].case_crimeDate == "" ||
            $scope.currentRecord[$scope.recordIndex].complainant_gender == "" ||
            $scope.currentRecord[$scope.recordIndex].complainee_gender == "") {
                toastr.error("Please fill in all fields");
                return true; // Form is invalid
        }
        return false; // Form is valid
    };

    $scope.closeModal = function() {
        $scope.recordIndex = 0;
        $scope.recordCount = 1;
        $scope.recordTotal = 0;
        $scope.currentRecord = [];
        $scope.status = "None";
        $scope.complainant_image_preview = $scope.baseUrl + "assets/img/no-image.png";
        $scope.complainee_image_preview = $scope.baseUrl + "assets/img/no-image.png";
        $('#modalRecords').removeClass('flex');
        $('#modalRecords').addClass('hidden'); // Add hidden class to hide modal
    };

    $scope.previousRecord = function() {
        $scope.recordIndex--;
        $scope.recordCount--;
        if($scope.recordCount < 1) {
            $scope.recordCount = 1;
            $scope.recordIndex = 0;
        }
        $scope.complainant_image_preview = $scope.baseUrl + $scope.currentRecord[$scope.recordIndex].complainant_pic;
        $scope.complainee_image_preview = $scope.baseUrl + $scope.currentRecord[$scope.recordIndex].complainee_pic;
    };

    $scope.nextRecord = function() {
        $scope.recordIndex++;
        $scope.recordCount++;
        if($scope.recordCount >= $scope.recordTotal) {
            $scope.recordCount = $scope.recordTotal;
            $scope.recordIndex = $scope.recordTotal - 1;
        }
        $scope.complainant_image_preview = $scope.baseUrl + $scope.currentRecord[$scope.recordIndex].complainant_pic;
        $scope.complainee_image_preview = $scope.baseUrl + $scope.currentRecord[$scope.recordIndex].complainee_pic;
    };

    // Load initial data
    $scope.getRecords();
    $scope.getCrimeTypes();
    
}]);
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
app.controller('UserPortalController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {

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
    $scope.selectedRow = null;
    $scope.crudState = "Add";
    $scope.currentUser = [];
    // $scope.userIndex = 0;
    // $scope.userCount = 1;
    // $scope.userTotal = 0;

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

    $scope.addUser = function(){
        $scope.status = "Add";
        $scope.currentUser = {
            user_id: null,
            user_type: "",
            user_firstname: "",
            user_middlename: "",
            user_lastname: "",
            user_fullname: "",
            user_birthdate: null,
            user_age: "",
            user_gender: "",
            user_address: "",
            user_contact_number: "",
            user_email: "",
            user_image: null,
            user_pic: null,
            user_account: "",
            user_password: "",
            user_secret_question: "",
            user_secret_answer: "",
            user_is_first_login: 1,
            user_status: 1,
            user_datecreated: null
        };
        $('#modalUserDetails').removeClass('hidden');
        $('#modalUserDetails').addClass('flex');
    }

    // Simple image preview
    $scope.previewImage = function(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $scope.user_image_preview = e.target.result;
                $scope.currentUser.user_image = file;
                $scope.$apply();
            };
            reader.readAsDataURL(file);
        }
    }

    $scope.validateAndSave = function() {
        if($scope.isFormInvalid()) {
            return;
        }
        $scope.saveUser();
    }

    $scope.isFormInvalid = function() {
        if($scope.status == "None") {
            return true;
        }
        
        // Validate details
        if($scope.currentUser.user_firstname == "" ||
            $scope.currentUser.user_middlename == "" ||
            $scope.currentUser.user_lastname == "" ||
            $scope.currentUser.user_birthdate == null ||
            $scope.currentUser.user_gender == "" ||
            $scope.currentUser.user_address == "" ||
            $scope.currentUser.user_contact_number == "" ||
            $scope.currentUser.user_email == "" ||
            $scope.currentUser.user_type == "" ||
            $scope.currentUser.user_account == "" ||
            $scope.currentUser.user_password == "" ||
            $scope.currentUser.user_secret_question == "" ||
            $scope.currentUser.user_secret_answer == "") {
                toastr.error("Please fill in all fields");
                return true; // Form is invalid
        }
        return false; // Form is valid
    }

    $scope.saveUser = function() {
        var formData = new FormData();
        $scope.currentUser.user_fullname = $scope.currentUser.user_firstname + " " + $scope.currentUser.user_middlename + " " + $scope.currentUser.user_lastname;
        if($scope.status == 'Add') {
            $scope.currentUser.user_datecreated = new Date();
        }

        console.log($scope.currentUser);

        // Remove AngularJS $$hashKey property before sending data
        if ($scope.currentUser.hasOwnProperty('$$hashKey')) {
            delete $scope.currentUser.$$hashKey;
        }
        

        // Append all record fields to FormData using a loop
        var user = $scope.currentUser;
        Object.keys(user).forEach(function(key) {
            formData.append(key, user[key]);
        });

        // Append images separately
        formData.append('user_image', $scope.currentUser.user_image);

        $http({
            method: "POST",
            url: $scope.baseUrl + "ctrl_api/save_user_details",
            data: formData,
            headers: {
                'Content-Type': undefined // Let browser set content type for FormData
            }
        }).then(function successCallback(response) {
            if(response.data.status == 'success')
            {
                if($scope.status == 'Add') {
                    toastr.success("User saved successfully");
                    $scope.closeModal();
                }
                else if($scope.status == 'Edit') {
                    toastr.success("User updated successfully");
                }
                $scope.getUsers();
            }
        });
    }

    $scope.editUser = function(index) {
        $scope.status = "Edit";
        $scope.currentUser = $scope.users[index];
        $scope.currentUser.user_birthdate = new Date($scope.currentUser.user_birthdate);
        $scope.user_image_preview = $scope.baseUrl + $scope.currentUser.user_pic;
        $('#modalUserDetails').removeClass('hidden');
        $('#modalUserDetails').addClass('flex');
    }

    $scope.updateUserStatus = function(user_id, user_status) {
        $http({
            method: "POST",
            url: $scope.baseUrl + "ctrl_api/update_user_status",
            data: {user_id: user_id, user_status: user_status}
        }).then(function successCallback(response) {
            if(response.data.success == true) {
                toastr.success("User status updated successfully");
                $scope.getUsers();
            }
        });
    }

    $scope.closeModal = function() {
        $scope.selectedRow = null;
        $scope.crudState = "Add";
        $('#modalUserDetails').removeClass('flex');
        $('#modalUserDetails').addClass('hidden');
    }

    $scope.init = function() {
        $scope.getUsers();
        $scope.getOrgChart();
    }

    // Load initial data
    $scope.init();
}]);
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
app.controller('DataStatisticsController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {

    $scope.reportsByMonth = [];
    $scope.reportsByCrimeType = [];
    $scope.reportsByStatus = [];
    $scope.recordTotals = [];
    $scope.recordStatusTotals = [];

    $scope.getReportByMonth = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_report_by_month",
        }).then(function successCallback(response) {
            $scope.reportsByMonth = response.data.reports;
            console.log('Reports:', $scope.reportsByMonth);
        });
    }

    $scope.getReportByCrimeType = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_report_by_crime_type",
        }).then(function successCallback(response) {
            $scope.reportsByCrimeType = response.data.reports;
            console.log('Reports:', $scope.reportsByCrimeType);
        });
    }

    $scope.getReportByStatus = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_report_by_status",
        }).then(function successCallback(response) {
            $scope.reportsByStatus = response.data.reports;
            console.log('Reports:', $scope.reportsByStatus);
        });
    }

    $scope.getRecordTotals = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_record_totals",
        }).then(function successCallback(response) {
            $scope.recordTotals = response.data.counts;
            console.log('Record Totals:', $scope.recordTotals);
        });
    }

    $scope.getRecordStatusTotals = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_record_status_totals",
        }).then(function successCallback(response) {
            $scope.recordStatusTotals = response.data.counts;
            console.log('Record Status Totals:', $scope.recordStatusTotals);
        });
    }

    $scope.getRecordStatusTotal = function(type) {
        $http({
            method: "POST",
            url: $scope.baseUrl + "ctrl_api/get_total_status_per_period",
            data: { time_period: type }
        }).then(function successCallback(response) {
            $scope.recordStatusTotals = response.data.counts;
            console.log('Record Status Totals:', $scope.recordStatusTotals);
            $(".counts-item").removeClass("active");
            $("." + type).addClass("active");
        });
        
    }

    $scope.init = function() {
        $scope.getReportByMonth();
        $scope.getReportByCrimeType();
        $scope.getReportByStatus();
        $scope.getRecordTotals();
        $scope.getRecordStatusTotals(); 
    }

    // Load initial data
    $scope.init();
}]);