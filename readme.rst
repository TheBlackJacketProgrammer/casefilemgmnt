Barangay Case File Management System
====================================

Project Overview
----------------

**Barangay Case File Management System** is a comprehensive web application built with CodeIgniter 3 framework designed to manage and track barangay-level case records, complaints, and administrative tasks. The system provides a modern, responsive interface for barangay officials to efficiently handle case management, user administration, and record keeping.

Architecture & Technology Stack
-------------------------------

Backend Framework
~~~~~~~~~~~~~~~~~
- **CodeIgniter 3** - PHP MVC framework
- **PHP 5.3.7+** - Server-side scripting language
- **MySQL/MariaDB** - Database management system

Frontend Technologies
~~~~~~~~~~~~~~~~~~~~~
- **AngularJS 1.x** - JavaScript framework for dynamic UI
- **Tailwind CSS** - Utility-first CSS framework
- **SCSS/Sass** - CSS preprocessor
- **jQuery** - JavaScript library for DOM manipulation
- **DataTables** - Advanced table functionality with export features

Development Tools
~~~~~~~~~~~~~~~~~
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

Complainant & Complainee Management
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
- Detailed personal information storage
- Contact information management
- Age and birthday tracking
- Image upload and storage capabilities
- Address and demographic data

Crime Details & Documentation
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
- Crime type categorization
- Detailed crime scene descriptions
- Witness information recording
- Crime date and time tracking
- Comprehensive case documentation

User Portal & Administration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~
- User masterlist management
- Organizational chart display
- Role-based access control
- Session management and authentication

Advanced Data Management
~~~~~~~~~~~~~~~~~~~~~~~~
- Bulk record operations (select all, batch editing)
- Data export functionality (Excel, PDF)
- Responsive data tables with sorting and filtering
- Image preview and management

Project Structure
-----------------

::

    brgycasefile/
    ├── application/           # Application logic
    │   ├── controllers/       # MVC Controllers
    │   ├── models/           # Database models
    │   ├── views/            # View templates
    │   └── config/           # Configuration files
    ├── assets/               # Frontend assets
    │   ├── css/             # Compiled CSS files
    │   ├── js/              # JavaScript modules
    │   ├── scss/            # SCSS source files
    │   └── img/             # Image assets
    ├── system/               # CodeIgniter core files
    └── index.php            # Application entry point

Installation & Setup
--------------------

Prerequisites
~~~~~~~~~~~~~
- PHP 5.3.7 or higher
- MySQL/MariaDB database
- Web server (Apache/Nginx)
- Composer (for dependency management)
- Node.js & npm (for frontend build tools)

Setup Steps
~~~~~~~~~~~
1. **Clone/Download** the project to your web server directory
2. **Install PHP dependencies**: ``composer install``
3. **Install Node.js dependencies**: ``npm install``
4. **Configure database** connection in ``application/config/database.php``
5. **Build frontend assets**: ``npm run build``
6. **Set up web server** to point to the project directory
7. **Configure URL rewriting** for CodeIgniter

Development Commands
~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

    # Watch SCSS and Tailwind changes
    npm run dev

    # Build production assets
    npm run build

    # Build SCSS only
    npm run build:scss

    # Build Tailwind only
    npm run build:tailwind

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

- Session-based authentication
- CSRF protection
- Input validation and sanitization
- Role-based access control
- Secure file upload handling
- SQL injection prevention

User Interface
--------------

- **Responsive Design** - Works on desktop, tablet, and mobile
- **Modern UI/UX** - Clean, intuitive interface using Tailwind CSS
- **Interactive Components** - Modal dialogs, dynamic forms, real-time updates
- **Data Tables** - Advanced table functionality with export options
- **Image Management** - Preview and upload capabilities

Performance Features
--------------------

- Optimized database queries
- Efficient image handling
- Minified CSS and JavaScript
- Responsive data loading
- Caching mechanisms

API Endpoints
-------------

The system provides RESTful API endpoints for:

- User authentication (``/ctrl_api/login``)
- Record management (``/ctrl_api/get_records``, ``/ctrl_api/save_record``)
- Crime type retrieval (``/ctrl_api/get_crime_types``)
- User management (``/ctrl_api/get_user_masterlist``)
- Organizational data (``/ctrl_api/get_org_chart``)

Development Guidelines
----------------------

- **MVC Architecture** - Follow CodeIgniter's MVC pattern
- **Data Conversion** - Handle data conversion logic in controllers (not models)
- **Model Responsibilities** - Models should only manage database processes
- **Frontend Separation** - AngularJS controllers handle UI logic
- **Responsive Design** - Mobile-first approach with Tailwind CSS

System Requirements
-------------------

- **Server**: Apache/Nginx with PHP support
- **PHP**: 5.3.7+ with extensions (mysqli, gd, session)
- **Database**: MySQL 5.5+ or MariaDB 10.0+
- **Browser**: Modern browsers with JavaScript enabled
- **Storage**: Adequate space for case files and images

Use Cases
---------

- **Barangay Officials** - Case management and record keeping
- **Law Enforcement** - Crime incident documentation
- **Administrative Staff** - User and system management
- **Case Workers** - Complaint processing and tracking

Future Enhancements
-------------------

- Real-time notifications
- Advanced reporting and analytics
- Mobile application
- Integration with government systems
- Enhanced search and filtering
- Document management system
- Audit trail and logging

Summary
--------

This system represents a comprehensive solution for barangay-level case management, combining modern web technologies with robust backend architecture to provide an efficient, user-friendly platform for local government operations.
