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