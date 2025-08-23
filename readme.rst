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
- **AngularJS 1.x** - JavaScript framework for dynamic UI
- **Tailwind CSS 3.x** - Utility-first CSS framework
- **SCSS/Sass** - CSS preprocessor
- **jQuery 3.7.1** - JavaScript library for DOM manipulation
- **DataTables** - Advanced table functionality with export features
- **Bootstrap 5.3.6** - Additional UI components and utilities

Development Tools
~~~~~~~~~~~~~~~~~
- **Node.js & npm** - Package management and build tools
- **Sass** - CSS compilation and watching
- **PostCSS** - CSS post-processing
- **Autoprefixer** - CSS vendor prefixing
- **Concurrently** - Parallel task execution

Key Features
------------

Case Management System
~~~~~~~~~~~~~~~~~~~~~~
- Comprehensive case record creation and management
- Support for multiple case types and crime categories
- Case status tracking (Pending, Active, Resolved, etc.)
- Date tracking for case filing, updates, and crime incidents
- Advanced search and filtering capabilities

Complainant & Complainee Management
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
- Detailed personal information storage
- Contact information management
- Age and birthday tracking
- Image upload and storage capabilities
- Address and demographic data
- Bulk operations support

Crime Details & Documentation
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
- Crime type categorization
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
- User activity tracking

Advanced Data Management
~~~~~~~~~~~~~~~~~~~~~~~~
- Bulk record operations (select all, batch editing)
- Data export functionality (Excel, PDF)
- Responsive data tables with sorting and filtering
- Image preview and management
- Real-time data updates

Project Structure
-----------------

::

    brgycasefile/
    ├── application/           # Application logic
    │   ├── controllers/       # MVC Controllers
    │   │   ├── Ctrl_Api.php  # API endpoints
    │   │   └── Ctrl_Main.php # Main application controller
    │   ├── models/           # Database models
    │   │   ├── Model_Api.php # API data operations
    │   │   └── Model_Main.php # Main business logic
    │   ├── views/            # View templates
    │   │   ├── pages/        # Main page templates
    │   │   ├── sections/     # Reusable view sections
    │   │   └── components/   # UI components and modals
    │   └── config/           # Configuration files
    ├── assets/               # Frontend assets
    │   ├── css/             # Compiled CSS files
    │   ├── js/              # JavaScript modules
    │   │   ├── app.js       # Main application logic
    │   │   ├── ng-*.js      # AngularJS controllers
    │   │   └── custom-script.js # Custom functionality
    │   ├── scss/            # SCSS source files
    │   │   ├── base/        # Base styles and variables
    │   │   ├── components/  # Component-specific styles
    │   │   └── pages/       # Page-specific styles
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

    # Clean build artifacts
    npm run clean

Database Schema
---------------

The system manages several key entities:

- **Cases** - Main case records with status and metadata
- **Complainants** - Case initiators with personal details
- **Complainees** - Case subjects with personal details
- **Crime Types** - Categorization system for cases
- **Users** - System administrators and staff
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

User Interface
--------------

- **Responsive Design** - Mobile-first approach, works on all devices
- **Modern UI/UX** - Clean, intuitive interface using Tailwind CSS
- **Interactive Components** - Modal dialogs, dynamic forms, real-time updates
- **Data Tables** - Advanced table functionality with export options
- **Image Management** - Preview, upload, and management capabilities
- **Toast Notifications** - User feedback and status updates

Performance Features
--------------------

- Optimized database queries with proper indexing
- Efficient image handling and compression
- Minified CSS and JavaScript for production
- Responsive data loading with pagination
- Caching mechanisms for static assets
- Lazy loading for improved page performance

API Endpoints
-------------

The system provides RESTful API endpoints for:

- **Authentication**: ``/ctrl_api/login`` - User login and session management
- **Records**: ``/ctrl_api/get_records``, ``/ctrl_api/save_record`` - Case record operations
- **Crime Types**: ``/ctrl_api/get_crime_types`` - Crime category management
- **Users**: ``/ctrl_api/get_user_masterlist`` - User administration
- **Organization**: ``/ctrl_api/get_org_chart`` - Organizational structure data

Development Guidelines
----------------------

- **MVC Architecture** - Follow CodeIgniter's MVC pattern strictly
- **Data Conversion** - Handle data conversion logic in controllers (not models)
- **Model Responsibilities** - Models should only manage database processes
- **Frontend Separation** - AngularJS controllers handle UI logic and data binding
- **Responsive Design** - Mobile-first approach with Tailwind CSS utilities
- **Code Organization** - Maintain clear separation of concerns
- **Error Handling** - Implement proper error handling and user feedback

System Requirements
-------------------

- **Server**: Apache 2.4+ or Nginx 1.18+ with PHP support
- **PHP**: 7.4+ with extensions (mysqli, gd, session, mbstring, json)
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **Browser**: Modern browsers with JavaScript enabled (Chrome 90+, Firefox 88+, Safari 14+)
- **Storage**: Adequate space for case files and images (minimum 1GB recommended)
- **Memory**: PHP memory limit of 256MB or higher

Use Cases
---------

- **Barangay Officials** - Case management and record keeping
- **Law Enforcement** - Crime incident documentation and tracking
- **Administrative Staff** - User and system management
- **Case Workers** - Complaint processing and status tracking
- **Supervisors** - Report generation and data analysis

Future Enhancements
-------------------

- **Real-time Features**: Live notifications and updates
- **Advanced Analytics**: Comprehensive reporting and data visualization
- **Mobile Application**: Native mobile app for field operations
- **Government Integration**: API integration with other government systems
- **Enhanced Search**: Advanced search with AI-powered suggestions
- **Document Management**: Comprehensive document handling and versioning
- **Audit Trail**: Detailed logging and activity tracking
- **Multi-language Support**: Localization for different regions
- **Cloud Deployment**: Support for cloud hosting platforms

About the Developer
-------------------

**Marvin Verola Bergado** is a Full Stack Web Developer with extensive expertise in modern web technologies and frameworks. This project demonstrates proficiency in:

- **Backend Development**: PHP, CodeIgniter, MySQL, RESTful APIs
- **Frontend Development**: JavaScript, AngularJS, CSS/SCSS, Tailwind CSS
- **Database Design**: Relational database architecture and optimization
- **System Architecture**: MVC pattern implementation and API design
- **User Experience**: Responsive design and modern UI/UX principles
- **DevOps**: Build tools, deployment, and performance optimization

Contact Information
~~~~~~~~~~~~~~~~~~~
- **Role**: Full Stack Web Developer
- **Email**: neomaster667@gmail.com
- **Specialization**: Web Application Development, Database Design, API Development
- **Technologies**: PHP, JavaScript, MySQL, Modern CSS Frameworks, CodeIgniter

Contributing
------------

This project is developed and maintained by Marvin Verola Bergado. For contributions, bug reports, or feature requests, please contact the developer directly.

License
-------

This project is proprietary software developed by Marvin Verola Bergado. All rights reserved.

Summary
--------

This system represents a comprehensive solution for barangay-level case management, combining modern web technologies with robust backend architecture to provide an efficient, user-friendly platform for local government operations. 

**Key Highlights:**
- Modern, responsive web interface built with Tailwind CSS
- Robust backend powered by CodeIgniter 3
- Comprehensive case management and tracking system
- Secure file handling and user management
- RESTful API architecture for extensibility
- Mobile-first responsive design

Developed by Marvin Verola Bergado, a Full Stack Web Developer committed to creating scalable, maintainable, and user-centric web applications that serve the needs of local government operations.
