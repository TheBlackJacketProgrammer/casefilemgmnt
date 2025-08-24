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
});