Barangay Case File Management System
====================================

**Created and Developed by:** Marvin Verola Bergado - Full Stack Web Developer

Project Overview
----------------

**Barangay Case File Management System** is a comprehensive web application built with CodeIgniter 3 framework designed to manage and track barangay-level case records, complaints, and administrative tasks. The system provides a modern, responsive interface for barangay officials to efficiently handle case management, user administration, and record keeping.

**Developer Information**
~~~~~~~~~~~~~~~~~~~~~~~~~
- **Creator & Developer**: Marvin Verola Bergado
- **Role**: Full Stack Web Developer
- **Specialization**: PHP, JavaScript, Modern Web Technologies
- **Architecture**: MVC Pattern, RESTful APIs, Responsive Design

Architecture & Technology Stack
-------------------------------

Backend Framework
~~~~~~~~~~~~~~~~~
- **CodeIgniter 3** - PHP MVC framework
- **PHP 7.4+** - Server-side scripting language (recommended)
- **MySQL 5.7+ / MariaDB 10.2+** - Database management system

Frontend Technologies
~~~~~~~~~~~~~~~~~~~~~
- **AngularJS 1.x** - JavaScript framework for dynamic UI with DataTables integration
- **Tailwind CSS 3.4.1** - Utility-first CSS framework
- **SCSS/Sass 1.69.5** - CSS preprocessor
- **jQuery 3.7.1** - JavaScript library for DOM manipulation
- **DataTables** - Advanced table functionality with export features
- **Bootstrap 5.3.6** - Additional UI components and utilities

Development Tools
~~~~~~~~~~~~~~~~~
- **Node.js & npm** - Package management and build tools
- **Sass 1.69.5** - CSS compilation and watching
- **PostCSS 8.4.35** - CSS post-processing
- **Autoprefixer 10.4.17** - CSS vendor prefixing
- **Concurrently 8.2.2** - Parallel task execution
- **Gulp 5.0.1** - JavaScript build system and task automation
- **Gulp Concat 2.6.1** - JavaScript file concatenation
- **Gulp Uglify 3.0.2** - JavaScript minification
- **Custom Helpers** - File upload and utility functions

Key Features
------------

Case Management System
~~~~~~~~~~~~~~~~~~~~~~
- Comprehensive case record creation and management
- Support for multiple case types and crime categories
- Case status tracking (Pending, Active, Resolved, etc.)
- Date tracking for case filing, updates, and crime incidents
- Advanced search and filtering capabilities
- Real-time case updates and modifications

Complainant & Complainee Management
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
- Detailed personal information storage
- Contact information management
- Age and birthday tracking
- Image upload and storage capabilities
- Address and demographic data
- Bulk operations support
- Individual record editing and updates

Crime Details & Documentation
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
- Crime type categorization with predefined options
- Detailed crime scene descriptions
- Witness information recording
- Crime date and time tracking
- Comprehensive case documentation
- File attachment support

User Portal & Administration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~
- User masterlist management
- Organizational chart display
- Role-based access control
- Session management and authentication
- User activity tracking and event logging
- Secure login/logout functionality

Advanced Data Management
~~~~~~~~~~~~~~~~~~~~~~~~
- Bulk record operations (select all, batch editing)
- Data export functionality (Excel, PDF)
- Responsive data tables with sorting and filtering
- Image preview and management
- Real-time data updates
- Touch-friendly interface for mobile devices
- File upload handling with custom helper functions
- Image compression and optimization

Event Logging System
~~~~~~~~~~~~~~~~~~~~
- Comprehensive user activity tracking
- Login/logout event logging
- Case modification tracking
- User action audit trail
- Timestamp-based event recording

Project Structure
-----------------

::

    brgycasefile/
    ├── application/           # Application logic
    │   ├── controllers/       # MVC Controllers
    │   │   ├── Ctrl_Api.php  # API endpoints and data operations
    │   │   └── Ctrl_Main.php # Main application controller and navigation
    │   ├── models/           # Database models
    │   │   ├── Model_Api.php # API data operations and business logic
    │   │   └── Model_Main.php # Main business logic and database processes
    │   ├── views/            # View templates
    │   │   ├── pages/        # Main page templates (dashboard, login)
    │   │   ├── sections/     # Reusable view sections (records, user portal, event logs, data statistics)
    │   │   └── components/   # UI components and modals
    │   ├── helpers/          # Custom helper functions
    │   │   └── file_upload_helper.php # File upload and image handling
    │   └── config/           # Configuration files
    ├── assets/               # Frontend assets
    │   ├── css/             # Compiled CSS files
    │   ├── js/              # JavaScript modules
    │   ├── scss/            # SCSS source files
    │   │   ├── base/        # Base styles and variables
    │   │   ├── components/  # Component-specific styles
    │   │   └── pages/       # Page-specific styles
    │   ├── dist/            # Compiled and minified JavaScript bundles
    │   └── img/             # Image assets
    ├── system/               # CodeIgniter core files
    └── index.php            # Application entry point

Installation & Setup
--------------------

Prerequisites
~~~~~~~~~~~~~
- **PHP**: 7.4 or higher (8.0+ recommended)
- **MySQL**: 5.7+ or MariaDB 10.2+
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Composer**: 2.0+ for PHP dependency management
- **Node.js**: 16.0+ and npm 8.0+ for frontend build tools

Setup Steps
~~~~~~~~~~~
1. **Clone/Download** the project to your web server directory
2. **Install PHP dependencies**: ``composer install``
3. **Install Node.js dependencies**: ``npm install``
4. **Configure database** connection in ``application/config/database.php``
5. **Build frontend assets**: ``npm run build``
6. **Set up web server** to point to the project directory
7. **Configure URL rewriting** for CodeIgniter
8. **Set proper permissions** for upload directories

Development Commands
~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

    # Install dependencies
    npm install
    composer install

    # Watch SCSS and Tailwind changes during development
    npm run dev

    # Build production assets
    npm run build

    # Build SCSS only
    npm run build:scss

    # Build Tailwind only
    npm run build:tailwind

    # Watch SCSS changes
    npm run watch:scss

    # Watch Tailwind changes
    npm run watch:tailwind

    # Build JavaScript bundles with Gulp
    gulp build

    # Watch JavaScript files for changes
    gulp watch

Database Schema
---------------

The system manages several key entities:

- **Cases (records)** - Main case records with status and metadata
- **Complainants** - Case initiators with personal details
- **Complainees** - Case subjects with personal details
- **Crime Types** - Categorization system for cases
- **Users** - System administrators and staff
- **Event Logs** - User activity and system event tracking
- **Organizational Chart** - Staff hierarchy and structure

Security Features
-----------------

- Session-based authentication with secure session handling
- CSRF protection and token validation
- Input validation and sanitization
- Role-based access control (RBAC)
- Secure file upload handling with type validation
- SQL injection prevention through prepared statements
- XSS protection through output encoding
- Event logging for security audit trails

User Interface
--------------

- **Responsive Design** - Mobile-first approach, works on all devices
- **Modern UI/UX** - Clean, intuitive interface using Tailwind CSS
- **Interactive Components** - Modal dialogs, dynamic forms, real-time updates
- **Data Tables** - Advanced table functionality with export options
- **Image Management** - Preview, upload, and management capabilities
- **Toast Notifications** - User feedback and status updates
- **Touch Support** - Custom touch directives for mobile devices
- **Dynamic Loading** - Partial view loading for improved performance

Performance Features
--------------------

- Optimized database queries with stored procedures
- Efficient image handling and compression
- Minified CSS and JavaScript for production
- Responsive data loading with pagination
- Caching mechanisms for static assets
- Lazy loading for improved page performance
- Concurrent build processes for faster development

API Endpoints
-------------

The system provides RESTful API endpoints for:

- **Authentication**: ``/ctrl_api/login`` - User login and session management
- **Records**: 
  - ``/ctrl_api/get_records`` - Retrieve case records
  - ``/ctrl_api/save_record`` - Create new case records and update existing ones
- **Crime Types**: 
  - ``/ctrl_api/get_crime_types`` - Crime category management
  - ``/ctrl_api/save_crime_type`` - Create/Update crime types
- **Crime Options**: ``/ctrl_api/get_crime_options`` - Available crime options
- **Users**: 
  - ``/ctrl_api/get_user_masterlist`` - User administration
  - ``/ctrl_api/save_user_details`` - Create/Update user accounts
  - ``/ctrl_api/update_user_status`` - Activate/Deactivate users
- **Organization**: ``/ctrl_api/get_org_chart`` - Organizational structure data
- **Event Logs**: 
  - ``/ctrl_api/get_event_logs`` - Retrieve activity logs


Core Functionality
------------------

**Case Management**
- Create, read, update, and delete case records
- Associate complainants and complainees with cases
- Track case status and progression
- Manage crime type classifications
- Handle case documentation and attachments

**User Administration**
- User account management
- Role-based permissions
- Session management
- Activity monitoring
- Organizational structure display

**Data Operations**
- Bulk record operations
- Advanced filtering and search
- Data export capabilities
- Real-time updates
- Touch-friendly interface
- JavaScript date parsing and conversion
- Multi-format date handling

**Analytics & Reporting**
- Data statistics module structure (placeholder)
- Event logging and activity tracking
- User activity reports via event logs
- Basic reporting capabilities through data export

Development Guidelines
----------------------

- **MVC Architecture** - Follow CodeIgniter's MVC pattern strictly
- **Data Conversion** - Handle data conversion logic in controllers (not models)
- **Model Responsibilities** - Models should only manage database processes
- **Frontend Separation** - AngularJS controllers handle UI logic and data binding
- **Responsive Design** - Mobile-first approach with Tailwind CSS utilities
- **Code Organization** - Maintain clear separation of concerns
- **Error Handling** - Implement proper error handling and user feedback
- **Event Logging** - Track all user actions for audit purposes
- **Touch Support** - Implement touch-friendly interactions for mobile devices

System Requirements
-------------------

- **Server**: Apache 2.4+ or Nginx 1.18+ with PHP support
- **PHP**: 7.4+ with extensions (mysqli, gd, session, mbstring, json)
- **Database**: MySQL 5.7+ or MariaDB 10.2+ with stored procedure support
- **Browser**: Modern browsers with JavaScript enabled (Chrome 90+, Firefox 88+, Safari 14+)
- **Storage**: Adequate space for case files and images (minimum 1GB recommended)
- **Memory**: PHP memory limit of 256MB or higher
- **Mobile**: Touch-enabled devices with responsive design support

Use Cases
---------

- **Barangay Officials** - Case management and record keeping
- **Law Enforcement** - Crime incident documentation and tracking
- **Administrative Staff** - User and system management
- **Case Workers** - Complaint processing and status tracking
- **Supervisors** - Report generation and data analysis
- **Field Officers** - Mobile access to case information
- **Auditors** - Activity tracking and compliance monitoring

Current Implementation Status
----------------------------

**Completed Features:**
- ✅ User authentication and session management
- ✅ Case record creation and management with CRUD operations
- ✅ Complainant and complainee management
- ✅ Crime type categorization and management system
- ✅ User portal and administration with role-based access
- ✅ Event logging, activity tracking, and audit trail
- ✅ Data statistics module basic structure implemented (functionality in development)
- ✅ Responsive mobile-friendly interface with touch support
- ✅ Data export, bulk operations, and advanced search capabilities
- ✅ Real-time data updates and modifications
- ✅ File upload, image handling, and preview system
- ✅ Date parsing and conversion utilities
- ✅ Custom file upload helper with validation
- ✅ Responsive data tables with pagination and export features
- ✅ Toast notifications for user feedback
- ✅ Organizational chart display
- ✅ Complete user management system with CRUD operations
- ✅ Advanced form validation and error handling
- ✅ Enhanced session management with event tracking

**Technical Implementation:**
- ✅ CodeIgniter 3 MVC architecture
- ✅ AngularJS 1.x frontend framework
- ✅ Tailwind CSS 3.4.1 styling
- ✅ SCSS compilation and build system
- ✅ RESTful API endpoints
- ✅ Stored procedure database optimization
- ✅ Mobile-responsive design
- ✅ Touch event handling
- ✅ Custom helper functions for file operations
- ✅ JavaScript date parsing utilities
- ✅ Event logging and audit trail system
- ✅ Image upload and management system
- ✅ DataTables integration with export features
- ✅ Bootstrap 5.3.6 UI components
- ✅ jQuery 3.7.1 for DOM manipulation
- ✅ Toastr notification system
- ✅ Custom AngularJS directives
- ✅ Modular JavaScript architecture
- ✅ SCSS preprocessing with source maps
- ✅ PostCSS and Autoprefixer integration
- ✅ Gulp build system for JavaScript bundling and minification
- ✅ Modular SCSS component architecture
- ✅ JavaScript bundle optimization and compression
- ✅ Data Statistics Controller and view implemented (basic structure)
- ✅ Enhanced user management API endpoints
- ✅ Advanced event logging system with real-time tracking
- ✅ Form validation and error handling system
- ✅ Organizational chart data management

New Updates
-----------

**Latest Improvements (August 2025 - Current Version 1.0.0):**
- ✅ **User Management Module** - Complete user administration system with CRUD operations
- ✅ **Event Log Module** - Comprehensive activity tracking and audit trail system
- ✅ **Data Statistics Module** - Basic structure implemented with controller and view (functionality in development)
- ✅ **Enhanced User Portal** - Improved user interface with organizational chart display
- ✅ **Advanced Event Logging** - Real-time activity tracking for all user actions
- ✅ **Toastr Integration** - Enhanced user feedback with toast notifications
- ✅ **Form Validation** - Improved data validation in records modal
- ✅ **Image Upload System** - Enhanced file upload with better error handling
- ✅ **Bulk Operations** - Advanced bulk record operations for better user experience
- ✅ **Mobile Responsiveness** - Optimized touch-friendly interface for mobile devices
- ✅ **Organizational Chart** - Visual representation of barangay staff hierarchy
- ✅ **Session Management** - Improved login/logout functionality with event tracking
- ✅ **Gulp Build System** - JavaScript bundling and minification with Gulp 5.0.1
- ✅ **SCSS Component Architecture** - Modular SCSS components for better maintainability
- ✅ **JavaScript Bundle Optimization** - Minified JavaScript bundles in assets/dist directory

Future Enhancements
-------------------

**High Priority (Planned Features):**
- **Search Filters**: Advanced search and filtering capabilities for case records
- **Complainant/Complainee Filtering**: Easy filtering system for creating reports and records
- **Data Statistics Implementation**: Complete analytics and reporting dashboard functionality
- **Case Status Management**: Enhanced case status tracking (Active, Pending, Closed)
- **Record History Tracking**: Show case update dates and user information for record modifications
- **Image Loading Optimization**: Improved image loading for existing records in edit mode

**Medium Priority:**
- **Real-time Features**: Live notifications and updates via WebSockets
- **Advanced Analytics**: Comprehensive reporting and data visualization
- **Mobile Application**: Native mobile app for field operations
- **Government Integration**: API integration with other government systems
- **Enhanced Search**: Advanced search with AI-powered suggestions
- **Document Management**: Comprehensive document handling and versioning
- **Audit Trail**: Enhanced logging and activity tracking
- **Multi-language Support**: Localization for different regions
- **Cloud Deployment**: Support for cloud hosting platforms
- **Offline Capability**: Offline data synchronization
- **Advanced Security**: Two-factor authentication and encryption
- **Performance Optimization**: Database query optimization and caching
- **API Versioning**: RESTful API versioning for backward compatibility
- **Advanced Reporting**: PDF report generation with charts and graphs
- **Backup System**: Automated database backup and recovery
- **Multi-tenant Support**: Support for multiple barangays in one installation

Development Roadmap
-------------------

**Current Development Status (August 2025):**
- ✅ **Core System**: Fully functional case management system
- ✅ **User Management**: Complete user administration and organizational chart
- ✅ **Event Logging**: Comprehensive activity tracking system
- ✅ **File Management**: Image upload and handling system
- ✅ **Form Validation**: Enhanced data validation and error handling
- ✅ **Data Statistics**: Basic structure implemented with controller and view
- ✅ **Build System**: Gulp-based JavaScript bundling and minification
- ✅ **SCSS Architecture**: Modular component-based styling system
- ⏳ **Search Filters**: Planned for next development phase
- ⏳ **Advanced Reporting**: Analytics dashboard implementation pending

**Next Development Phase:**
1. Complete Data Statistics module implementation
2. Implement advanced search and filtering capabilities
3. Add complainant/complainee filtering system
4. Enhance case status management
5. Implement record history tracking
6. Optimize image loading in edit mode

**Long-term Goals:**
- Real-time notifications and updates
- Mobile application development
- Government system integration
- Advanced analytics and reporting
- Multi-language support
- Cloud deployment capabilities

About the Developer
-------------------

**Marvin Verola Bergado** is a Full Stack Web Developer with extensive expertise in modern web technologies and frameworks. This project demonstrates proficiency in:

- **Backend Development**: PHP, CodeIgniter, MySQL, RESTful APIs, Stored Procedures
- **Frontend Development**: JavaScript, AngularJS, CSS/SCSS, Tailwind CSS, Touch Events
- **Database Design**: Relational database architecture, optimization, and stored procedures
- **System Architecture**: MVC pattern implementation and API design
- **User Experience**: Responsive design and modern UI/UX principles
- **DevOps**: Build tools, deployment, and performance optimization
- **Mobile Development**: Touch-friendly interfaces and responsive design

Contact Information
~~~~~~~~~~~~~~~~~~~
- **Role**: Full Stack Web Developer
- **Email**: neomaster667@gmail.com
- **Specialization**: Web Application Development, Database Design, API Development
- **Technologies**: PHP, JavaScript, MySQL, Modern CSS Frameworks, CodeIgniter

Known Issues
------------

**Current Known Issues:**
- **PHP8 Session Wrapper Error**: Occasional error in `system/libraries/Session/PHP8SessionWrapper` (investigation ongoing)
- **Image Loading in Edit Mode**: Existing images may not load properly when editing records (pending fix)
- **Search Functionality**: Advanced search filters are not yet implemented (planned feature)

**Development Notes:**
- Case status system uses temporary values (Active, Pending, Closed) - will be enhanced
- Record modification tracking needs implementation for showing update dates and users
- Image upload system needs optimization for better error handling

Troubleshooting
---------------

Common Issues and Solutions
~~~~~~~~~~~~~~~~~~~~~~~~~~~

**File Upload Issues:**
- Ensure upload directory has proper write permissions (755 or 777)
- Check PHP upload_max_filesize and post_max_size settings
- Verify file types are allowed in the upload helper configuration

**Database Connection Issues:**
- Verify database credentials in application/config/database.php
- Ensure MySQL/MariaDB service is running
- Check database user permissions

**Frontend Build Issues:**
- Run ``npm install`` to ensure all dependencies are installed
- Use ``npm run build`` for production builds
- Check Node.js version compatibility (16.0+)

**Mobile Responsiveness Issues:**
- Clear browser cache and reload
- Ensure Tailwind CSS is properly compiled
- Check viewport meta tag in HTML head

**Performance Issues:**
- Enable PHP OPcache for better performance
- Optimize database queries and add indexes
- Use CDN for static assets in production

Contributing
------------

This project is developed and maintained by Marvin Verola Bergado. For contributions, bug reports, or feature requests, please contact the developer directly.

**How to Contribute:**
1. Fork the repository
2. Create a feature branch
3. Make your changes following the coding standards
4. Test thoroughly on different devices and browsers
5. Submit a pull request with detailed description

**Bug Reports:**
When reporting bugs, please include:
- PHP version and server environment
- Browser and version
- Steps to reproduce the issue
- Expected vs actual behavior
- Screenshots if applicable

License
-------

This project is proprietary software developed by Marvin Verola Bergado. All rights reserved.

**Usage Rights:**
- This software is intended for barangay case management purposes
- Commercial use requires explicit permission from the developer
- Modification and distribution rights are reserved
- Support and updates are provided by the original developer

Summary
--------

This system represents a comprehensive solution for barangay-level case management, combining modern web technologies with robust backend architecture to provide an efficient, user-friendly platform for local government operations. 

**Key Highlights:**
- Modern, responsive web interface built with Tailwind CSS 3.4.1
- Robust backend powered by CodeIgniter 3 with stored procedures
- Comprehensive case management and tracking system
- Secure file handling and user management
- RESTful API architecture for extensibility
- Mobile-first responsive design with touch support
- Advanced event logging and audit trail system
- Real-time data updates and bulk operations

**Current Version Features:**
- Complete case management system with CRUD operations
- User authentication and role-based access control
- Event logging and activity tracking
- Data statistics module basic structure (functionality in development)
- Mobile-responsive design with touch support
- Advanced data tables with export functionality
- Crime type categorization and management
- Comprehensive user administration portal
- File upload and image management system
- JavaScript date parsing and conversion utilities
- Custom helper functions for enhanced functionality
- Real-time data updates and bulk operations
- Enhanced form validation and error handling
- Organizational chart display and management
- Advanced session management with event tracking

Developed by Marvin Verola Bergado, a Full Stack Web Developer committed to creating scalable, maintainable, and user-centric web applications that serve the needs of local government operations.
