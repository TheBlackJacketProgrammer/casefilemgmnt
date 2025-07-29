<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo isset($title) ? $title : 'Cargomate - Grow your business with us'; ?></title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" href="<?php echo base_url('assets/img/brgy_logo.ico'); ?>" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo base_url('assets/img/brgy_logo.ico'); ?>" type="image/x-icon" /> 

        <!-- Add your CSS files here -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/tailwind.css'); ?>">

        <!-- Datatable CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/devtools/Datatables/jquery.dataTables.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/devtools/Datatables/buttons.dataTables.min.css'); ?>">

    </head>
    <body ng-app="ng-bcms-app" ng-controller="ng-variables">
        <!-- Header -->
        <?php if($user_logged_in): ?>
            <?php $this->load->view('components/header'); ?>
        <?php endif; ?>
        
        <!-- Main Content Area -->
        <?php $this->load->view($content); ?>

        <!-- Footer -->
        <?php if($user_logged_in): ?>
            <?php $this->load->view('components/footer'); ?>
        <?php endif; ?>
        
        <!-- Add your JavaScript files here -->

        <!-- jQuery -->
        <script src="<?php echo base_url('assets/devtools/jquery/jquery-3.7.1.min.js'); ?>"></script>

        <!-- Custom Script -->
        <script src="<?php echo base_url('assets/js/custom-script.js'); ?>"></script>

        <!-- Datatable JS -->
        <script src="<?php echo base_url('assets/devtools/Datatables/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/devtools/Datatables/dataTables.buttons.min.js'); ?>"></script>

        <!-- Excel Export -->
        <script src="<?php echo base_url('assets/devtools/Datatables/jszip.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/devtools/Datatables/buttons.html5.min.js'); ?>"></script>

        <!-- PDF Export -->
        <script src="<?php echo base_url('assets/devtools/Datatables/pdfmake.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/devtools/Datatables/vfs_fonts.js'); ?>"></script>

        <!-- AngularJS -->
        <script src="<?php echo base_url('assets/devtools/angularjs/angular.min.js'); ?>"></script>

        <!-- Angular JS Datatable -->
        <script src="<?php echo base_url('assets/devtools/angularjs/angular-datatables.min.js'); ?>"></script>

        <!-- Angular JS Scripts -->
        <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/ng-variables.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/ng-header.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/ng-login.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/ng-records.js'); ?>"></script>

    </body>
</html> 