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