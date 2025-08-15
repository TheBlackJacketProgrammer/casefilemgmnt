app.controller('RecordsController', function($scope, $http, $timeout) {
    $scope.records = [];
    $scope.dataTable = null;
    $scope.selectAll = false;
    $scope.recordIndex = 0;
    $scope.recordCount = 1;
    $scope.recordTotal = 0;
    $scope.currentRecord = [];
    $scope.status = "Add";


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
            complainee_image: null
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
        $scope.recordTotal = $scope.currentRecord.length;
        $('#modalRecords').removeClass('hidden'); // Remove hidden class to show modal
        $('#modalRecords').addClass('flex'); 
    };

    // Upload Files
    $scope.uploadFiles = function(){
        console.log("uploadFiles - Form Data = ", formData);
    }

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
            // $scope.convertDate(new Date(), 'case_dateFiled');
            // $scope.convertDate($scope.currentRecord[$scope.recordIndex].case_crimeDate, 'case_crimeDate');
            // $scope.convertDate($scope.currentRecord[$scope.recordIndex].complainant_birthday, 'complainant_birthday');
            // $scope.convertDate($scope.currentRecord[$scope.recordIndex].complainee_birthday, 'complainee_birthday');
        }
        else if($scope.status == 'Edit') {
            // $scope.convertDate(new Date(), 'case_dateUpdated');
            // $scope.convertDate($scope.currentRecord[$scope.recordIndex].case_dateFiled, 'case_dateFiled');
            // $scope.convertDate($scope.currentRecord[$scope.recordIndex].case_crimeDate, 'case_crimeDate');
            // $scope.convertDate($scope.currentRecord[$scope.recordIndex].complainant_birthday, 'complainant_birthday');
            // $scope.convertDate($scope.currentRecord[$scope.recordIndex].complainee_birthday, 'complainee_birthday');
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
                console.log('Record saved successfully');
                if($scope.status == 'Add') {
                    $scope.closeModal();
                }
                $scope.getRecords();
            }
        });
    };

    $scope.closeModal = function() {
        $scope.recordIndex = 0;
        $scope.recordCount = 1;
        $scope.recordTotal = 0;
        $scope.currentRecord = [];
        $scope.status = "Add";
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
    };

    $scope.nextRecord = function() {
        $scope.recordIndex++;
        $scope.recordCount++;
        if($scope.recordCount >= $scope.recordTotal) {
            $scope.recordCount = $scope.recordTotal;
            $scope.recordIndex = $scope.recordTotal - 1;
        }
    };

    // Load initial data
    $scope.getRecords();
    $scope.getCrimeTypes();
    
});