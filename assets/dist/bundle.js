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

        $scope.reportsByMonth = [];
        $scope.reportsByCrimeType = [];
        $scope.reportsByStatus = [];
        $scope.recordTotals = [];
        $scope.recordStatusTotals = [];
        $scope.recordsPerGender = [];
        $scope.recordsPerAgeGroup = [];
        $scope.recordsPerHour = [];
        $scope.recordsPerDayOfWeek = [];

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

    // Generic nav dropdown (desktop) – only one open at a time
    $scope.activeNavDropdown = null;
    $scope.toggleNavDropdown = function(menuKey, $event) {
        if ($event) $event.stopPropagation();
        var willOpen = $scope.activeNavDropdown !== menuKey;
        $scope.activeNavDropdown = willOpen ? menuKey : null;
        if (willOpen) {
            $timeout(function() {
                angular.element(document).one('click', function() {
                    $scope.$apply(function() {
                        $scope.activeNavDropdown = null;
                    });
                });
            }, 0);
        }
    };
    $scope.isNavDropdownOpen = function(menuKey) {
        return $scope.activeNavDropdown === menuKey;
    };
    $scope.closeNavDropdown = function() {
        $scope.activeNavDropdown = null;
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
        if ($event.key === 'Escape') {
            if ($scope.mobileMenu.isOpen) {
                $scope.closeMobileMenu();
            }
            if ($scope.activeNavDropdown) {
                $scope.activeNavDropdown = null;
            }
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

    // Open Incident Records
    $scope.openIncidentRecords = function() {
        $scope.$parent.section = "";
        $http({
            method: "POST",
            url:  $scope.baseUrl + "open_incident_records"
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

    // Open Citizen Records
    $scope.openCitizenRecords = function() {
        $scope.$parent.section = "";
        $http({
            method: "POST",
            url:  $scope.baseUrl + "open_citizen_records"
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

    // Open Barangay Masterlist
    $scope.openBarangayMasterlist = function() {
        $scope.$parent.section = "";
        $http({
            method: "POST",
            url:  $scope.baseUrl + "open_barangay_masterlist"
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
        dom:    "<'flex flex-wrap'<'flex flex-col w-full sm:w-1/2 text-sm items-start justify-end mb-1'B><'w-full sm:w-1/2 text-sm mb-2'f>>" +
                "<'flex flex-wrap'<'w-full text-sm mb-2'tr>>" +
                "<'flex flex-wrap'<'flex w-full text-sm justify-center items-center mb-2'p>>" +
                // "<'flex flex-wrap'<'w-full text-sm text-center'i>>",
                "<'flex flex-wrap'<'w-full text-sm text-center'>>",
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


        if($scope.credentials.username == '' || $scope.credentials.password == '') {
            toastr.error('Please fill in all fields');
            return;
        }

        console.log('Login');
        console.log($scope.credentials);
        $http({
            method: "POST",
            url: $scope.baseUrl + "login",
            data: $scope.credentials
        }).then(function successCallback(response) {
            // Redirect to dashboard
            if(response.data.status == 'success') {
                toastr.success('Login successful');
                window.location.href = $scope.baseUrl;
            } 
            else {
                toastr.error('Username or password is incorrect');
            }
        }).catch(function errorCallback(response) {
            toastr.error('An error occurred');
        });
    };
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

    $scope.viewReportForm = function() {
        // console.log('Current record:', $scope.currentRecord[$scope.recordIndex]);
        
        $http({
            method: "POST",
            url: $scope.baseUrl + "ctrl_main/view_report_form",
            data: $scope.currentRecord[$scope.recordIndex],
            responseType: 'blob', // Important: tells Angular to expect binary data
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function successCallback(response) {
            // Create blob link to download
            var blob = new Blob([response.data], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'report_form.pdf';
            link.click();
            window.URL.revokeObjectURL(link.href);
        }, function errorCallback(response) {
            console.error('Error generating PDF:', response);
        });
    }

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


    $scope.getReportByMonth = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_report_by_month",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.reports) {
                $scope.reportsByMonth = response.data.reports;
                // console.log('Reports by Month:', $scope.reportsByMonth);
                return response.data.reports;
            } else {
                console.error('Invalid response format for reports by month:', response.data);
                $scope.reportsByMonth = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching reports by month:', error);
            $scope.reportsByMonth = [];
            return [];
        });
    }

    $scope.getReportByCrimeType = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_report_by_crime_type",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.reports) {
                $scope.reportsByCrimeType = response.data.reports;
                // console.log('Reports by Crime Type:', $scope.reportsByCrimeType);
                return response.data.reports;
            } else {
                console.error('Invalid response format for reports by crime type:', response.data);
                $scope.reportsByCrimeType = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching reports by crime type:', error);
            $scope.reportsByCrimeType = [];
            return [];
        });
    }

    $scope.getReportByStatus = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_report_by_status",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.reports) {
                $scope.reportsByStatus = response.data.reports;
                // console.log('Reports by Status:', $scope.reportsByStatus);
                return response.data.reports;
            } else {
                console.error('Invalid response format for reports by status:', response.data);
                $scope.reportsByStatus = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching reports by status:', error);
            $scope.reportsByStatus = [];
            return [];
        });
    }

    $scope.getRecordTotals = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_record_totals",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.counts) {
                $scope.recordTotals = response.data.counts;
                // console.log('Record Totals:', $scope.recordTotals);
                return response.data.counts;
            } else {
                console.error('Invalid response format for record totals:', response.data);
                $scope.recordTotals = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching record totals:', error);
            $scope.recordTotals = [];
            return [];
        });
    }

    $scope.getRecordStatusTotals = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_record_status_totals",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.counts) {
                $scope.recordStatusTotals = response.data.counts;
                // console.log('Record Status Totals:', $scope.recordStatusTotals);
                return response.data.counts;
            } else {
                console.error('Invalid response format for record status totals:', response.data);
                $scope.recordStatusTotals = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching record status totals:', error);
            $scope.recordStatusTotals = [];
            return [];
        });
    }

    $scope.getRecordStatusTotal = function(type) {
        return $http({
            method: "POST",
            url: $scope.baseUrl + "ctrl_api/get_total_status_per_period",
            data: { time_period: type }
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.counts) {
                $scope.recordStatusTotals = response.data.counts;
                // console.log('Record Status Totals:', $scope.recordStatusTotals);
                $(".counts-item").removeClass("active");
                $("." + type).addClass("active");
                return response.data.counts;
            } else {
                console.error('Invalid response format for record status totals:', response.data);
                $scope.recordStatusTotals = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching record status totals:', error);
            $scope.recordStatusTotals = [];
            return [];
        });
    }

    $scope.getRecordsPerGender = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_records_per_gender",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.counts) {
                $scope.recordsPerGender = response.data.counts;
                // console.log('Records per gender:', $scope.recordsPerGender);
                return response.data.counts;
            } else {
                console.error('Invalid response format for records per gender:', response.data);
                $scope.recordsPerGender = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching records per gender:', error);
            $scope.recordsPerGender = [];
            return [];
        });
    }

    $scope.getRecordsPerAgeGroup = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_records_per_age_group",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.counts) {
                $scope.recordsPerAgeGroup = response.data.counts;
                return response.data.counts;
            } else {
                console.error('Invalid response format for records per age group:', response.data);
                $scope.recordsPerAgeGroup = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching records per age group:', error);
            $scope.recordsPerAgeGroup = [];
            return [];
        });
    }

    $scope.getRecordsPerHour = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_records_per_hour",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.counts) {
                $scope.recordsPerHour = response.data.counts;
                return response.data.counts;
            } else {
                console.error('Invalid response format for records per hour:', response.data);
                $scope.recordsPerHour = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching records per hour:', error);
            $scope.recordsPerHour = [];
            return [];
        });
    }

    $scope.getRecordsPerDayOfWeek = function() {
        return $http({
            method: "GET",
            url: $scope.baseUrl + "ctrl_api/get_records_per_day_of_week",
        }).then(function successCallback(response) {
            if (response.data && response.data.status === 'success' && response.data.counts) {
                $scope.recordsPerDayOfWeek = response.data.counts;
                return response.data.counts;
            } else {
                console.error('Invalid response format for records per day of week:', response.data);
                $scope.recordsPerDayOfWeek = [];
                return [];
            }
        }, function errorCallback(error) {
            console.error('Error fetching records per day of week:', error);
            $scope.recordsPerDayOfWeek = [];
            return [];
        });
    }

    $scope.createChart = function(canvasId, labels, data, type) {
        // Validate inputs
        if (!canvasId || !labels || !data || !type) {
            console.error('Invalid parameters for chart creation:', { canvasId, labels, data, type });
            return;
        }

        // Check if canvas element exists
        const canvasElement = document.getElementById(canvasId);
        if (!canvasElement) {
            console.error('Canvas element not found:', canvasId);
            return;
        }

        // Validate data arrays
        if (!Array.isArray(labels) || !Array.isArray(data) || labels.length === 0 || data.length === 0) {
            console.error('Invalid data for chart:', { labels, data });
            return;
        }

        // Check if data contains valid numbers
        const hasValidData = data.some(value => typeof value === 'number' && !isNaN(value) && value > 0);
        if (!hasValidData) {
            console.error('No valid data found for chart:', data);
            return;
        }

        // Check if chart already exists and destroy it
        var chartExist = Chart.getChart(canvasId);
        if (chartExist != undefined) {
            chartExist.destroy();
        }

        const ctx = canvasElement.getContext('2d');
 
        if (type === 'pie') {
            new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Records',
                        data: data,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    devicePixelRatio: 1,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            }); 
        }
        if (type === 'line') {
            new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Records',
                        data: data,
                        borderColor: "blue",
                        backgroundColor: "rgba(0, 0, 255, 0.2)",
                        tension: 0.3,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: "blue"
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: true } },
                    scales: {
                      y: { beginAtZero: true }
                    }
                }
            });
        }
        else {
            new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Records',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    devicePixelRatio: 1,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0,
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                display: true
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                display: true
                            }
                        }
                    }
                }
            });    
        }
        
    }

    // Initialize Graph Reports by Month
    $scope.initGraphReportsByMonth = function() {
        if (!$scope.reportsByMonth || !Array.isArray($scope.reportsByMonth) || $scope.reportsByMonth.length === 0) {
            console.warn('No data available for reports by month chart');
            return;
        }

        let months = [];
        let totals = [];
        for (let i = 0; i < $scope.reportsByMonth.length; i++) {
            if ($scope.reportsByMonth[i].month && $scope.reportsByMonth[i].total !== undefined) {
                months.push($scope.reportsByMonth[i].month);
                totals.push(parseInt($scope.reportsByMonth[i].total) || 0);
            }
        }
        
        if (months.length > 0 && totals.length > 0) {
            $scope.initChartData('barChart', months, totals, 'bar');
        } else {
            console.warn('No valid data found for reports by month chart');
        }
    }

    // Initialize Graph Reports by Gender
    $scope.initGraphReportsByGender = function() {
        if (!$scope.recordsPerGender || !Array.isArray($scope.recordsPerGender) || $scope.recordsPerGender.length === 0) {
            console.warn('No data available for reports by gender chart');
            return;
        }

        let genders = [];
        let totals = [];
        for (let i = 0; i < $scope.recordsPerGender.length; i++) {
            if ($scope.recordsPerGender[i].gender && $scope.recordsPerGender[i].total !== undefined) {
                genders.push($scope.recordsPerGender[i].gender);
                totals.push(parseInt($scope.recordsPerGender[i].total) || 0);
            }
        }
        
        if (genders.length > 0 && totals.length > 0) {
            $scope.initChartData('pcGender', genders, totals, 'pie');
        } else {
            console.warn('No valid data found for reports by gender chart');
        }
    }

    // Initialize Graph Reports by Age Group
    $scope.initGraphReportsByAgeGroup = function() {
        if (!$scope.recordsPerAgeGroup || !Array.isArray($scope.recordsPerAgeGroup) || $scope.recordsPerAgeGroup.length === 0) {
            console.warn('No data available for reports by age group chart');
            return;
        }

        let age_ranges = [];
        let totals = [];
        for (let i = 0; i < $scope.recordsPerAgeGroup.length; i++) {
            if ($scope.recordsPerAgeGroup[i].age_range && $scope.recordsPerAgeGroup[i].total !== undefined) {
                age_ranges.push($scope.recordsPerAgeGroup[i].age_range);
                totals.push(parseInt($scope.recordsPerAgeGroup[i].total) || 0);
            }
        }
        
        if (age_ranges.length > 0 && totals.length > 0) {
            $scope.initChartData('gcReportsByAgeGroup', age_ranges, totals, 'bar');
        } else {
            console.warn('No valid data found for reports by age group chart');
        }
    }

    // Initialize Graph Reports by Hour Range
    $scope.initGraphReportsByHourRange = function() {
        if (!$scope.recordsPerHour || !Array.isArray($scope.recordsPerHour) || $scope.recordsPerHour.length === 0) {
            console.warn('No data available for reports by age group chart');
            return;
        }

        let hour_ranges = [];
        let totals = [];
        for (let i = 0; i < $scope.recordsPerHour.length; i++) {
            if ($scope.recordsPerHour[i].hour_range && $scope.recordsPerHour[i].total !== undefined) {
                hour_ranges.push($scope.recordsPerHour[i].hour_range);
                totals.push(parseInt($scope.recordsPerHour[i].total) || 0);
            }
        }
        
        if (hour_ranges.length > 0 && totals.length > 0) {
            $scope.initChartData('gcReportsByHourRange', hour_ranges, totals, 'line');
        } else {
            console.warn('No valid data found for reports by hour range chart');
        }
    }

    $scope.init = function() {
        // console.log('Initializing data statistics...');
        
        // Load all data in parallel and wait for completion
        Promise.all([
            $scope.getReportByMonth(),
            $scope.getReportByCrimeType(),
            $scope.getReportByStatus(),
            $scope.getRecordTotals(),
            $scope.getRecordStatusTotals(),
            $scope.getRecordsPerGender(),
            $scope.getRecordsPerAgeGroup(),
            $scope.getRecordsPerHour(),
            $scope.getRecordsPerDayOfWeek()
        ]).then(function(results) {
            // console.log('All data loaded successfully');
            
            // Initialize charts after all data is loaded
            $timeout(function() {
                $scope.initGraphReportsByMonth();
                $scope.initGraphReportsByGender();
                $scope.initGraphReportsByAgeGroup();
                $scope.initGraphReportsByHourRange();
            }, 100); // Small delay to ensure DOM is ready
        }).catch(function(error) {
            console.error('Error loading data:', error);
        });
    }

    // Function to clear all charts
    $scope.clearAllCharts = function() {
        const chartIds = ['barChart', 'pcGender', 'gcReportsByAgeGroup'];
        chartIds.forEach(function(chartId) {
            var chartExist = Chart.getChart(chartId);
            if (chartExist != undefined) {
                chartExist.destroy();
            }
        });
    }

    // Function to initialize chart data (similar to your getChartData pattern)
    $scope.initChartData = function(canvasId, labels, data, type) {
        // Check if chart already exists and destroy it
        var chartExist = Chart.getChart(canvasId);
        if (chartExist != undefined) {
            chartExist.destroy();
        }

        // Get canvas element and create chart
        const canvasElement = document.getElementById(canvasId);
        if (canvasElement) {
            return new Chart(canvasElement.getContext('2d'), {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Records',
                        data: data,
                        backgroundColor: type === 'pie' ? [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ] : 'rgba(54, 162, 235, 0.6)',
                        borderColor: type === 'pie' ? [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ] : 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    devicePixelRatio: 1,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                padding: 20,
                                usePointStyle: type === 'pie',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    scales: type !== 'pie' ? {
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0,
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                display: true
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                display: true
                            }
                        }
                    } : {}
                }
            });
        }
    }

    // Function to refresh charts when data changes
    $scope.refreshCharts = function() {
        // console.log('Refreshing charts...');
        // Clear all existing charts first
        $scope.clearAllCharts();
        
        $timeout(function() {
            $scope.initGraphReportsByMonth();
            $scope.initGraphReportsByGender();
            $scope.initGraphReportsByAgeGroup();
            $scope.initGraphReportsByHourRange();
        }, 100);
    }

    // Function to check if all required data is loaded
    $scope.isDataLoaded = function() {
        return $scope.reportsByMonth.length > 0 && 
               $scope.recordsPerGender.length > 0 && 
               $scope.recordTotals.length > 0 &&
               $scope.reportsByAgeGroup.length > 0;
    }

    // Cleanup function for controller destruction
    $scope.$on('$destroy', function() {
        $scope.clearAllCharts();
    });

    // Load initial data
    $scope.init();
}]);
app.controller('CitizenRecordsController', ['$scope', '$http', '$filter', function($scope, $http, $filter) {

    // Variables
    $scope.citizenRecords = [];
    $scope.currentProcess = "Add";
    $scope.citizen_image_preview = $scope.baseUrl + "assets/img/no-image.png";
    $scope.currentCitizenProfile = null;
    $scope.currentImgPath = "";

    // Camera Variables
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let context = canvas.getContext('2d');
    let streamRef = null;
    
    $scope.dtOpt_citizenRecords = {
        responsive: true,
        autoWidth: false,
        scrollX: true,
        scrollCollapse: true,
        width: '100%',
        dom: "<'flex flex-row'<'flex flex-row justify-between items-center w-full'Bf>>" +
             "<'flex flex-col gap-2 my-3'<tr>>" +
             "<'grid grid-cols-3 items-center justify-center gap-2 text-sm'<l><'flex flex-row justify-center items-center'i><p>>",
        order: [[0, 'desc']], 
            buttons: [
            {
                extend: 'excelHtml5',
                title: 'Citizen Records'
            },
            {
                extend: 'pdfHtml5',
                title: 'Citizen Records'
            }
        ]
    };

    $scope.init = function() {
        console.log('Citizen Records Controller Initialized');
        $scope.getCitizenRecords();
    }

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

    $scope.getCitizenRecords = function() {
        $http({
            method: "GET",
            url: $scope.baseUrl + "get_citizen_records",
        }).then(function successCallback(response) {
            $scope.citizenRecords = response.data.citizenRecords;
        });
    }

    $scope.addCitizenProfile = function() {
        $scope.currentProcess = "Add";
        $scope.currentCitizenProfile = {
            citizen_id: null,
            last_name: "",
            first_name: "",
            middle_name: "",
            birthdate: null,
            gender: "",
            address: "",
            contact_number: "",
            email_address: "",
        };

        $('#modalCitizenProfile').removeClass('hidden'); // Remove hidden class to show modal
        $('#modalCitizenProfile').addClass('flex'); 
    }

    $scope.closeModal = function() {
        $scope.currentCitizenProfile = [{
            citizen_id: null,
            lastname: "",
            firstname: "",
            middlename: "",
            birthdate: null,
            gender: "",
            address: "",
            contact_number: "",
            email_address: "",
        }];
        $scope.citizen_image_preview = $scope.baseUrl + "assets/img/no-image.png";
        $scope.currentProcess = "Add";
        $('#modalCitizenProfile').removeClass('flex');
        $('#modalCitizenProfile').addClass('hidden');
        $('#citizen_image_preview').attr('src', $scope.baseUrl + 'assets/img/no-image.png');
    }

    $scope.saveCitizenProfile = function() {
        let formData = new FormData();
        let payload = angular.copy($scope.currentCitizenProfile);
        payload.birthdate = $filter('date')(payload.birthdate, 'yyyy-MM-dd');

        Object.keys(payload).forEach(function(key) {
            formData.append(key, payload[key]);
        });

        formData.append('citizen_img_path', $scope.currentCitizenProfile.citizen_img_path);
        formData.append('current_img_path', $scope.currentImgPath);

        $http({
            method: "POST",
            url: $scope.baseUrl + "save_citizen_profile",
            data: formData,
            headers: {
                'Content-Type': undefined // Let browser set content type for FormData
            }
        }).then(function successCallback(response) {
            if(response.data.success) {
                toastr.success("Citizen profile saved successfully");
                $scope.getCitizenRecords();
                $scope.closeModal();
            } 
            else {
                toastr.error("Failed to save citizen profile");
            }
        });
    };

    $scope.editCitizenProfile = function(citizen) {
        let tempCitizen = angular.copy(citizen);
        $scope.currentProcess = "Edit";
        $scope.currentCitizenProfile = tempCitizen;
        $scope.currentCitizenProfile.birthdate = new Date( tempCitizen.birthdate + 'T00:00:00');
        $scope.citizen_image_preview = (tempCitizen.citizen_img_path != null && tempCitizen.citizen_img_path != "") ? $scope.baseUrl + tempCitizen.citizen_img_path : $scope.baseUrl + 'assets/img/no-image.png';
        $scope.currentImgPath = tempCitizen.citizen_img_path;
        $('#modalCitizenProfile').removeClass('hidden');
        $('#modalCitizenProfile').addClass('flex'); 
    }

    $scope.viewCitizenProfile = function(citizen) {
        let tempCitizen = angular.copy(citizen);
        $scope.currentProcess = "View";
        $scope.currentCitizenProfile = tempCitizen;
        $scope.currentCitizenProfile.birthdate = new Date( tempCitizen.birthdate + 'T00:00:00');
        $scope.citizen_image_preview = (tempCitizen.citizen_img_path != null && tempCitizen.citizen_img_path != "") ? $scope.baseUrl + tempCitizen.citizen_img_path : $scope.baseUrl + 'assets/img/no-image.png';
        $('#modalCitizenProfile').removeClass('hidden');
        $('#modalCitizenProfile').addClass('flex'); 
    }

    $scope.previewImage = function(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $scope.citizen_image_preview = e.target.result;
                $scope.currentCitizenProfile.citizen_img_path = file;
                $scope.$apply();
            };
            reader.readAsDataURL(file);
        }
    };

    $scope.generateBarangayCertificate = function() {
        var citizenProfile = $scope.currentCitizenProfile;

        if (!citizenProfile || (typeof citizenProfile === 'object' && citizenProfile.length !== undefined && citizenProfile.length)) {
            toastr.error('Open a citizen profile first.');
            return;
        }

        var payload = {
            first_name: citizenProfile.first_name || '',
            middle_name: citizenProfile.middle_name || '',
            last_name: citizenProfile.last_name || '',
            nationality: citizenProfile.nationality || '',
            civil_status: citizenProfile.civil_status || '',
            age: citizenProfile.age != null ? String(citizenProfile.age) : ''
        };

        $http({
            method: 'POST',
            url: $scope.baseUrl + 'generate_barangay_certificate',
            data: payload,
            responseType: 'arraybuffer'
        }).then(function(response) {
            var contentType = (response.headers('Content-Type') || '').toLowerCase();
            if (contentType.indexOf('application/json') !== -1) {
                let decoder = new TextDecoder('utf-8');
                try {
                    let err = JSON.parse(decoder.decode(new Uint8Array(response.data)));
                    toastr.error(err.message || 'Could not generate certificate.');
                } 
                catch (e) {
                    toastr.error('Could not generate certificate.');
                }
                return;
            }
            var filename = 'barangay_certificate.docx';
            let contentDisposition = response.headers('Content-Disposition');
            if (contentDisposition) {
                let match = contentDisposition.match(/filename\*?=(?:UTF-8'')?["']?([^"';]+)/i);
                if (match) {
                    filename = match[1].trim();
                }
            }
            let blob = new Blob([response.data], {
                type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            });
            let url = URL.createObjectURL(blob);
            let link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            toastr.success('Certificate downloaded.');
        }, function() {
            toastr.error('Could not generate certificate.');
        });
    };

    $scope.openCamera = function() {
        // Open Cammera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                streamRef = stream;
                video.srcObject = stream;
            })
            .catch(function(err) {
                toastr.error("Camera error: " + err);
            });
        $('#modalCamera').removeClass('hidden');
        $('#modalCamera').addClass('flex');
    }

    $scope.closeCamera = function() {
        // Stop Camera
        if (streamRef) {
            let tracks = streamRef.getTracks();
            tracks.forEach(track => track.stop());
        }

        $('#modalCamera').removeClass('flex');
        $('#modalCamera').addClass('hidden');
    }

    $scope.dataURLtoFile = function(dataURL, filename) {
        let byteString = atob(dataURL.split(',')[1]);
        let mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
        let arrBuffer = new ArrayBuffer(byteString.length);
        let uint8Array = new Uint8Array(arrBuffer);
        for (let i = 0; i < byteString.length; i++) {
            uint8Array[i] = byteString.charCodeAt(i);
        }
        let file = new File([arrBuffer], filename, { type: mimeString });
        return file;
    }

    $scope.takePhoto = function() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        let dataURL = canvas.toDataURL('image/png');
        let file = $scope.dataURLtoFile(dataURL, 'citizen_photo.png');
        context.drawImage(video, 0, 0, 300, 250);
        $scope.citizen_image_preview = canvas.toDataURL('image/png');
        $scope.currentCitizenProfile.citizen_img_path = file;
        $scope.closeCamera();
    }

}]);
app.controller('BarangayMasterlistController', ['$scope', '$http', '$filter', function($scope, $http, $filter) {

    // Variables
    $scope.barangayMasterlist = [];
    $scope.currentProcess = "Add";
    $scope.currentBrgyProfile = null;

    $scope.dtOpt_barangayMasterlist = {
        responsive: true,
        autoWidth: false,
        scrollX: true,
        scrollCollapse: true,
        width: '100%',
        dom: "<'flex flex-row'<'flex flex-row justify-between items-center w-full'Bf>>" +
             "<'flex flex-col gap-2 my-3'<tr>>" +
             "<'grid grid-cols-3 items-center justify-center gap-2 text-sm'<l><'flex flex-row justify-center items-center'i><p>>",
        order: [[0, 'desc']], 
            buttons: [
            {
                extend: 'excelHtml5',
                title: 'Barangay Masterlist'
            },
            {
                extend: 'pdfHtml5',
                title: 'Barangay Masterlist'
            }
        ]
    };

    $scope.init = function() {
        console.log('Barangay Masterlist Controller Initialized');
        $scope.getBarangayMasterlist();
    }

    $scope.getBarangayMasterlist = function() {
        $http({
            method: "POST",
            url: $scope.baseUrl + "get_barangay_masterlist",
        }).then(function successCallback(response) {
            $scope.barangayMasterlist = response.data.barangayMasterlist;
        });
    }
    
    $scope.addBarangayInformation = function() {
        $scope.currentProcess = "Add";
        $scope.currentBrgyProfile = {
            brgy_id: null,
            brgy_name: "",
            brgy_city: "",
            brgy_region: "",
            brgy_status: "Active"
        };
        $('#modalBrgyProfile').removeClass('hidden'); // Remove hidden class to show modal
        $('#modalBrgyProfile').addClass('flex'); 
    }

    $scope.editBarangayInformation = function(brgy) {
        $scope.currentProcess = "Edit";
        $scope.currentBrgyProfile = brgy;
        $('#modalBrgyProfile').removeClass('hidden'); // Remove hidden class to show modal
        $('#modalBrgyProfile').addClass('flex'); 
    }

    $scope.viewBarangayInformation = function(brgy) {
        $scope.currentProcess = "View";
        $scope.currentBrgyProfile = brgy;
        $('#modalBrgyProfile').removeClass('hidden'); // Remove hidden class to show modal
        $('#modalBrgyProfile').addClass('flex'); 
    }

    $scope.saveBrgyProfile = function() {
        let payload = angular.copy($scope.currentBrgyProfile);
        $http({
            method: "POST",
            url: $scope.baseUrl + "save_brgy_profile",
            data: payload
        }).then(function successCallback(response) {
            if(response.data.success) {
                toastr.success("Barangay profile saved successfully");
                $scope.getBarangayMasterlist();
                $scope.closeModal();
            }
            else {
                toastr.error("Failed to save barangay profile");
            }
        });
    }

    $scope.closeModal = function() {
        $scope.currentBrgyProfile = null;
        $scope.currentProcess = "Add";
        $('#modalBrgyProfile').removeClass('flex');
        $('#modalBrgyProfile').addClass('hidden');
    }
}]);