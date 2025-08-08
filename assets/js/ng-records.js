app.controller('RecordsController', function($scope, $http, $timeout) {
    $scope.records = [];
    $scope.dataTable = null;
    $scope.selectAll = false;
    $scope.recordIndex = 0;
    $scope.recordCount = 1;
    $scope.recordTotal = 0;
    $scope.currentRecord = [];

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

    // Date conversion utility function
    $scope.convertDateStringToDateInput = function(dateString) {
        if (!dateString) return null;
        
        try {
            // Handle different date formats
            let date;
            
            // Format: "February 9 2016" or "February 07 1992"
            if (dateString.match(/^[A-Za-z]+ \d{1,2} \d{4}$/)) {
                date = new Date(dateString);
            }
            // Format: "Thursday, July-06-2017, 14:09:43 PM"
            else if (dateString.match(/^[A-Za-z]+, [A-Za-z]+-\d{2}-\d{4}, \d{2}:\d{2}:\d{2} [AP]M$/)) {
                // Extract the date part: "July-06-2017"
                const datePart = dateString.split(', ')[1];
                const [month, day, year] = datePart.split('-');
                date = new Date(year, getMonthIndex(month), parseInt(day));
            }
            // Format: "September 03 1992"
            else if (dateString.match(/^[A-Za-z]+ \d{2} \d{4}$/)) {
                date = new Date(dateString);
            }
            else {
                // Try parsing as is
                date = new Date(dateString);
            }
            
            // Check if date is valid
            if (isNaN(date.getTime())) {
                console.warn('Invalid date string:', dateString);
                return null;
            }
            
            // Return the Date object for AngularJS ng-model
            return date;
        } catch (error) {
            console.error('Error converting date string:', dateString, error);
            return null;
        }
    };
    
    // Helper function to get month index
    function getMonthIndex(monthName) {
        const months = {
            'january': 0, 'february': 1, 'march': 2, 'april': 3, 'may': 4, 'june': 5,
            'july': 6, 'august': 7, 'september': 8, 'october': 9, 'november': 10, 'december': 11
        };
        return months[monthName.toLowerCase()] || 0;
    }
    
    // Get current date in formatted string
    $scope.getCurrentDate = function() {
        const now = new Date();
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        const dayName = days[now.getDay()];
        const monthName = months[now.getMonth()];
        const date = String(now.getDate()).padStart(2, '0');
        const year = now.getFullYear();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = now.getHours() >= 12 ? 'PM' : 'AM';
        
        return `${dayName} - ${monthName}-${date}-${year} - ${hours}:${minutes}:${seconds} ${ampm}`;
    };
    
    // Edit selected records
    $scope.editSelectedRecords = function() {
        $scope.currentRecord = angular.copy($scope.getSelectedRecords());
        
        // Convert date strings to proper format for HTML date inputs
        $scope.currentRecord.forEach(function(record) {
            // Convert case_crimeDate
            if (record.case_crimeDate) {
                record.case_crimeDate = $scope.convertDateStringToDateInput(record.case_crimeDate);
            }
            
            // Convert complainee_birthday
            if (record.complainee_birthday) {
                record.complainee_birthday = $scope.convertDateStringToDateInput(record.complainee_birthday);
            }
            
            // Convert complainant_birthday
            if (record.complainant_birthday) {
                record.complainant_birthday = $scope.convertDateStringToDateInput(record.complainant_birthday);
            }
        });
        
        console.log('Converted records:', $scope.currentRecord);
        $('#modalRecords').removeClass('hidden'); // Remove hidden class to show modal
    };

    $scope.closeModal = function() {
        $('#modalRecords').addClass('hidden'); // Add hidden class to hide modal
    };

    $scope.previousRecord = function() {
        $scope.recordIndex--;
        $scope.recordCount--;
        if($scope.recordCount < 1) {
            $scope.recordCount = 1;
            $scope.recordIndex = 0;
        }
    };

    $scope.nextRecord = function() {
        $scope.recordIndex++;
        $scope.recordCount++;
        if($scope.recordCount >= $scope.recordTotal) {
            $scope.recordCount = $scope.recordTotal;
            $scope.recordIndex = $scope.recordTotal - 1;
        }
    };


    $scope.getRecords();
    
});