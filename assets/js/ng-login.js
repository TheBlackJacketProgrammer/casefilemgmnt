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