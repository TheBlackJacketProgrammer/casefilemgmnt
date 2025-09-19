<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .content {
            margin: 20px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo $title; ?></h1>
        <p>Generated on: <?php echo $date; ?></p>
    </div>
    
    <div class="content">
        <p><?php echo $content; ?></p>
        
        <h2>Sample Items</h2>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="footer">
        <p>This document was generated using DomPDF in CodeIgniter</p>
    </div>
</body>
</html>
