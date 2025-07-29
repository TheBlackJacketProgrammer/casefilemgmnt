<!-- Navigation Bar (Tailwind) -->
<header class="bg-white shadow-md sticky top-0 z-50" ng-controller="ng-header">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <!-- Logo and Brand -->
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <img class="h-8 w-auto" src="<?php echo base_url('assets/img/brgy_logo.jpg'); ?>" alt="Barangay Logo">
        </div>
        <div class="ml-3">
          <h1 class="text-xl font-bold text-gray-900">Barangay Case File </h1>
          <p class="text-xs bg-blue-1 text-gray-600 text-center">Management System</p>
        </div>
      </div>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:block">
        <div class="ml-10 flex items-center space-x-6">
          <!-- Main Navigation Items -->
          <div class="flex items-center space-x-4">
            <button type="button"
                    ng-click="openRecords()"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 text-sm font-medium transition-all duration-200 group">
              <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <span>Records</span>
            </button>
            
            <button type="button"
                    ng-click="openUserPortal()"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 text-sm font-medium transition-all duration-200 group">
              <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <span>User Portal</span>
            </button>
            
            <button type="button"
                    ng-click="openEventLogs()"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 text-sm font-medium transition-all duration-200 group">
              <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
              </svg>
              <span>Event Logs</span>
            </button>
          </div>

          <!-- Divider -->
          <div class="w-px h-6 bg-gray-300"></div>

          <!-- Search Bar -->
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
            <input type="text" 
                   placeholder="Search records..." 
                   class="block w-40 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
          </div>

          <!-- Divider -->
          <div class="w-px h-6 bg-gray-300"></div>

          <!-- User Actions -->
          <div class="flex items-center space-x-3">
            <button type="button"
                    ng-click="openSettings()"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 text-sm font-medium transition-all duration-200 group">
              <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              <!-- <span>Settings</span> -->
            </button>

            <!-- Simple User Menu -->
            <div class="flex items-center space-x-2">
              <div class="w-8 h-8 bg-text-8-light rounded-full flex items-center justify-center text-white text-sm font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
            </div>

            <button type="button"
                    ng-click="logout()"
                    class="flex items-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition-all duration-200 group">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              <!-- <span>Logout</span> -->
            </button>
          </div>
        </div>
      </nav>

      <!-- Mobile menu button -->
      <div class="lg:hidden">
        <button type="button" 
                class="mobile-menu-button bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200" 
                aria-controls="mobile-menu" 
                ng-attr-aria-expanded="{{mobileMenu.isExpanded}}"
                ng-click="openMobileMenu()">
          <span class="sr-only">Open main menu</span>
          <!-- Icon when menu is closed -->
          <svg class="h-6 w-6" 
               ng-class="{'block': !mobileMenu.isExpanded, 'hidden': mobileMenu.isExpanded}"
               xmlns="http://www.w3.org/2000/svg" 
               fill="none" 
               viewBox="0 0 24 24" 
               stroke="currentColor" 
               aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <!-- Icon when menu is open -->
          <svg class="h-6 w-6" 
               ng-class="{'hidden': !mobileMenu.isExpanded, 'block': mobileMenu.isExpanded}"
               xmlns="http://www.w3.org/2000/svg" 
               fill="none" 
               viewBox="0 0 24 24" 
               stroke="currentColor" 
               aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Navigation Overlay -->
  <div class="mobile-menu lg:hidden fixed inset-0 bg-black bg-opacity-50 z-50 backdrop-blur-sm" 
       ng-class="{'hidden': !mobileMenu.isOpen}"
       ng-click="handleBackdropClick($event)"
       ng-touchstart="handleTouchStart($event)"
       ng-touchmove="handleTouchMove($event)">
    <div class="bg-white h-full w-80 max-w-sm shadow-2xl transform transition-all duration-300 ease-in-out"
         ng-class="{'translate-x-0': mobileMenu.isExpanded, '-translate-x-full': !mobileMenu.isExpanded}">
      <!-- Backdrop overlay for closing -->
      <div class="absolute inset-0 -z-10" id="mobile-backdrop"></div>
      <!-- Mobile Menu Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-lg shadow-sm" src="<?php echo base_url('assets/img/brgy_logo.jpg'); ?>" alt="Barangay Logo">
          </div>
          <div class="ml-3">
            <h2 class="text-lg font-bold text-gray-900">Barangay Case File</h2>
            <p class="text-xs text-gray-600">Management System</p>
          </div>
        </div>
        <button type="button" 
                class="mobile-close-button text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-all duration-200 hover:bg-gray-100 p-2 rounded-full"
                ng-click="closeMobileMenu()">
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Mobile Menu Navigation -->
      <div class="px-6 py-6 space-y-3">
        <div class="mb-4">
          <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Main Navigation</h3>
        </div>
        
        <a href="<?php echo base_url('dashboard'); ?>" 
           class="nav-item flex items-center px-4 py-3 rounded-xl text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group"
           ng-style="{'opacity': mobileMenu.isExpanded ? '1' : '0', 'transform': mobileMenu.isExpanded ? 'translateX(0)' : 'translateX(-20px)'}"
           style="transition: all 0.3s ease;">
          <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <span class="font-medium">Records</span>
        </a>
        
        <a href="<?php echo base_url('dashboard'); ?>" 
           class="nav-item flex items-center px-4 py-3 rounded-xl text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group"
           ng-style="{'opacity': mobileMenu.isExpanded ? '1' : '0', 'transform': mobileMenu.isExpanded ? 'translateX(0)' : 'translateX(-20px)'}"
           style="transition: all 0.3s ease; transition-delay: 0.05s;">
          <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span class="font-medium">User Portal</span>
        </a>
        
        <a href="<?php echo base_url('dashboard'); ?>" 
           class="nav-item flex items-center px-4 py-3 rounded-xl text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group"
           ng-style="{'opacity': mobileMenu.isExpanded ? '1' : '0', 'transform': mobileMenu.isExpanded ? 'translateX(0)' : 'translateX(-20px)'}"
           style="transition: all 0.3s ease; transition-delay: 0.1s;">
          <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
          <span class="font-medium">Event Logs</span>
        </a>
        
        <a href="<?php echo base_url('dashboard'); ?>" 
           class="nav-item flex items-center px-4 py-3 rounded-xl text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group"
           ng-style="{'opacity': mobileMenu.isExpanded ? '1' : '0', 'transform': mobileMenu.isExpanded ? 'translateX(0)' : 'translateX(-20px)'}"
           style="transition: all 0.3s ease; transition-delay: 0.15s;">
          <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <span class="font-medium">Settings</span>
        </a>
        
        <div class="pt-4 border-t border-gray-200">
          <a href="<?php echo base_url('logout'); ?>" 
             class="flex items-center justify-center px-4 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl"
             ng-style="{'opacity': mobileMenu.isExpanded ? '1' : '0', 'transform': mobileMenu.isExpanded ? 'translateX(0)' : 'translateX(-20px)'}"
             style="transition: all 0.3s ease; transition-delay: 0.2s;">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Logout</span>
          </a>
        </div>
      </div>

      <!-- Mobile Menu Footer -->
      <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-center space-x-2 mb-2">
          <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
          <span class="text-xs text-gray-600">System Online</span>
        </div>
        <p class="text-xs text-gray-500 text-center">
          Copyright © Black Jacket Programmer 2025. All rights reserved
        </p>
        <p class="text-xs text-gray-400 text-center mt-1">
          Developed by Black Jacket Programmer
        </p>
      </div>
    </div>
  </div>
</header>

