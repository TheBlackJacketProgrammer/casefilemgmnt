<!DOCTYPE html>
<html>
    <head>
        <title>PDF Report Form</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: Arial, sans-serif;
                line-height: 1.4;
                color: #333;
                font-size: 12px;
                padding: 20px;
            }

            /* Modern Table-based Grid Layout (DomPDF Compatible) */
            .form-container {
                width: 100%;
                border-collapse: collapse;
            }

            .header-row {
                display: table-row;
            }

            .body-row {
                display: table-row;
            }

            .body-title-cell {
                display: table-cell;
                text-align: center;
                vertical-align: middle;
                padding: 15px;
                width: 100%;

                h4 {
                    margin: 3px 0;
                    font-size: 16px;
                    font-weight: bold;
                    color: #2c3e50;
                }
            }

            .logo-cell {
                display: table-cell;
                width: 20%;
                text-align: center;
                vertical-align: middle;
                padding: 15px;
            }

            .logo-cell img {
                max-width: 80px;
                max-height: 80px;
                width: auto;
                height: auto;
            }

            .title-cell {
                display: table-cell;
                width: 60%;
                text-align: center;
                vertical-align: middle;
                padding: 15px;

                h4 {
                    margin: 3px 0;
                    font-size: 14px;
                    font-weight: bold;
                    color: #2c3e50;
                }

            }

            .logo-placeholder {
                width: 80px;
                height: 80px;
                background: #f0f0f0;
                border: 2px dashed #ccc;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
                font-weight: bold;
                color: #666;
                text-align: center;
                margin: 0 auto;
            }

            .section {
                margin: 24px 0px;
                width: auto;
                padding: 8px 40px;
                page-break-inside: avoid;
            }

            .section-case-id {
                width: 100% !important;
                margin: 8px 0px;
                width: auto;
                padding: 8px 40px;
                page-break-inside: avoid;
            }

            .section-case-id-title {
                width: auto !important;
                padding: 4px;
                margin: -8px -8px 8px -8px;
            }


            .section-title {
                font-weight: bold;
                background: #eee;
                padding: 4px;
                margin: -8px -8px 8px -8px;
                border-bottom: 1px solid #000;
                border-radius: 4px 4px 0 0;
            }

            .field {
                margin: 8px 0px;
            }

            .label {
                font-weight: bold;
                display: inline-block;
                width: 160px;
            }

            .value {
                display: inline-block;
                border-bottom: 1px solid #000;
                width: 65%;
                padding-left: 4px;
            }

            .event-box {
                border: 1px solid #000;
                min-height: 100px;
                padding: 8px;
                border-radius: 4px;
                white-space: pre-line; /* preserve line breaks */
            }

            .page-break {
                page-break-before: always;
            }

        
        </style>
    </head>
    <body>
        <!-- Modern Header using Table Layout -->
        <table class="form-container">
            <tr class="header-row">
                <td class="logo-cell">
                    <?php 
                    $brgy_logo_path = FCPATH . 'assets/img/brgy-logo.png';
                    if (file_exists($brgy_logo_path)): 
                        $brgy_logo_data = base64_encode(file_get_contents($brgy_logo_path));
                        $brgy_logo_mime = mime_content_type($brgy_logo_path);
                    ?>
                        <img src="data:<?php echo $brgy_logo_mime; ?>;base64,<?php echo $brgy_logo_data; ?>" alt="Barangay Logo">
                    <?php else: ?>
                        <div class="logo-placeholder">BRGY LOGO</div>
                    <?php endif; ?>
                </td>
                <td class="title-cell">
                    <h4>Republic of the Philippines</h4>
                    <h4>Barangay Case File Management System</h4>
                </td>
                <td class="logo-cell">
                    <?php 
                    $pilipinas_logo_path = FCPATH . 'assets/img/bagong-pilipinas-logo.webp';
                    if (file_exists($pilipinas_logo_path)): 
                        $pilipinas_logo_data = base64_encode(file_get_contents($pilipinas_logo_path));
                        $pilipinas_logo_mime = mime_content_type($pilipinas_logo_path);
                    ?>
                        <img src="data:<?php echo $pilipinas_logo_mime; ?>;base64,<?php echo $pilipinas_logo_data; ?>" alt="Bagong Pilipinas Logo">
                    <?php else: ?>
                        <div class="logo-placeholder">PILIPINAS</div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="body-row">
                <td class="body-title-cell" colspan="3">
                    <h4>Report Form</h4>
                </td>
            </tr>
        </table>

        <div class="section-case-id">
            <div class="section-case-id-title" style="margin-bottom: 8px;">
                <span style="width: 50%; float: left;">CASE ID: <b>123456</b></span> 
                <span style="width: 50%; float: right;">STATUS: <b>Pending</b></span> 
            </div>
        </div>

        <!-- <div style="border-bottom: 1px solid #000; border-radius: 4px; margin-bottom: 8px; padding: 0px 40px;"></div> -->

        <!-- COMPLAINANT -->
        <div class="section" style="margin-top: 0px !important;">
            <div class="section-title">Complainant Details</div>
            <div class="field"><span class="label">Full Name:</span> <span class="value">Daniela Dela Rama</span></div>
            <div class="field"><span class="label">Age:</span> <span class="value">25</span></div>
            <div class="field"><span class="label">Birthday:</span> <span class="value">25/01/2000</span></div>
            <div class="field"><span class="label">Gender:</span> <span class="value">Female</span></div>
            <div class="field"><span class="label">Address:</span> <span class="value">Valenzuela, Metro Manila</span></div>
            <div class="field"><span class="label">Contact Number:</span> <span class="value">09186097623</span></div>
        </div>

        <!-- COMPLAINEE -->
        <div class="section">
            <div class="section-title">Complainee Details</div>
            <div class="field"><span class="label">Full Name:</span> <span class="value">Billy Masters</span></div>
            <div class="field"><span class="label">Age:</span> <span class="value">25</span></div>
            <div class="field"><span class="label">Birthday:</span> <span class="value">10/05/2000</span></div>
            <div class="field"><span class="label">Gender:</span> <span class="value">Male</span></div>
            <div class="field"><span class="label">Address:</span> <span class="value">Valenzuela, Metro Manila</span></div>
            <div class="field"><span class="label">Contact Number:</span> <span class="value">09275060519</span></div>
        </div>

        <!-- CRIME INFO -->
        <div class="section">
            <div class="section-title">Crime Information</div>
            <div class="field"><span class="label">Status:</span> <span class="value">Pending</span></div>
            <div class="field"><span class="label">Date Created:</span> <span class="value">03/09/2025</span></div>
            <div class="field"><span class="label">Crime Date:</span> <span class="value">03/09/2025 09:12 pm</span></div>
            <div class="field"><span class="label">Place of Crime:</span> <span class="value">Valenzuela</span></div>
            <div class="field"><span class="label">Witness:</span> <span class="value">None</span></div>
            <div class="field"><span class="label">Crime Type:</span> <span class="value">Domestic Violence</span></div>
            <!-- <div class="field"><span class="label">Last Date Updated:</span> <span class="value">06/09/2025</span></div>
            <div class="field"><span class="label">Last Updated By:</span> <span class="value">Ace Von Bladen</span></div> -->
        </div>
        <!-- PAGE BREAK -->
        <div class="page-break"></div>

        <!-- Modern Header using Table Layout -->
        <table class="form-container">
            <tr class="header-row">
                <td class="logo-cell">
                    <?php 
                    $brgy_logo_path = FCPATH . 'assets/img/brgy-logo.png';
                    if (file_exists($brgy_logo_path)): 
                        $brgy_logo_data = base64_encode(file_get_contents($brgy_logo_path));
                        $brgy_logo_mime = mime_content_type($brgy_logo_path);
                    ?>
                        <img src="data:<?php echo $brgy_logo_mime; ?>;base64,<?php echo $brgy_logo_data; ?>" alt="Barangay Logo">
                    <?php else: ?>
                        <div class="logo-placeholder">BRGY LOGO</div>
                    <?php endif; ?>
                </td>
                <td class="title-cell">
                    <h4>Republic of the Philippines</h4>
                    <h4>Barangay Case File Management System</h4>
                </td>
                <td class="logo-cell">
                    <?php 
                    $pilipinas_logo_path = FCPATH . 'assets/img/bagong-pilipinas-logo.webp';
                    if (file_exists($pilipinas_logo_path)): 
                        $pilipinas_logo_data = base64_encode(file_get_contents($pilipinas_logo_path));
                        $pilipinas_logo_mime = mime_content_type($pilipinas_logo_path);
                    ?>
                        <img src="data:<?php echo $pilipinas_logo_mime; ?>;base64,<?php echo $pilipinas_logo_data; ?>" alt="Bagong Pilipinas Logo">
                    <?php else: ?>
                        <div class="logo-placeholder">PILIPINAS</div>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <!-- EVENT DETAILS -->
        <div class="section">
            <div class="section-title">Details of Event</div>
            <div class="event-box">
            Test only.  
            If this text becomes long, the content will automatically continue and break into the next page when needed.
            </div>
        </div>

        <!-- PREPARED BY -->
        <div class="section">
            <div class="field"><span class="label">Prepared By:</span> <span class="value">Juan Dela Cruz</span></div>
            <div class="field"><span class="label">Position:</span> <span class="value">Barangay Secretary</span></div>
            <div class="field"><span class="label">Date:</span> <span class="value">06/09/2025</span></div>

            <br><br><br>
            <div style="text-align: center; margin-top: 50px;">
                ___________________________<br>
                Signature over Printed Name
            </div>
        </div>

    </body>
</html>