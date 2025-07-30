app.controller('RecordsController', function($scope, $http, $timeout) {
    $scope.records = [];
    $scope.dataTable = null;
    $scope.selectAll = false;
    $scope.recordIndex = 0;
    $scope.recordCount = 1;
    $scope.recordTotal = 0;

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

    // Edit selected records
    $scope.editSelectedRecords = function() {
        var selectedRecords = $scope.getSelectedRecords();
        console.log('Editing multiple records:', selectedRecords);
        $('#modalRecords').removeClass('hidden');
    };

    $scope.closeModal = function() {
        $('#modalRecords').addClass('hidden');
    };

    $scope.previousRecord = function() {
        $scope.recordIndex--;
        $scope.recordCount--;
        if($scope.recordCount < 1) {
            $scope.recordCount = 1;
        }
    };

    $scope.nextRecord = function() {
        $scope.recordIndex++;
        $scope.recordCount++;
        if($scope.recordCount >= $scope.recordTotal) {
            $scope.recordCount = $scope.recordTotal;
        }
    };


    $scope.getRecords();
    
});