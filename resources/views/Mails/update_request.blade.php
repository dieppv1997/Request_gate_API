<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gửi mail sau khi update</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
        padding: 5px;
        text-align: left;
        }
    </style>
</head>
<body>
    <h1><strong>Update Request</strong></h1>
    <h3><strong>Issue Item</strong></h3>
    <table style="width:100%">
        <tr>
            <th>Type</th>
            <th>Request</th>
        </tr>
        <?php
            foreach($data as $key => $item){?>
                <tr>
                    <th><?php echo $key;?></th>
                    <th><?php echo $item['old'].' --> '.$item['new'];?></th>
                </tr>
        <?php    
            }
        ?>
        
</table>
</body>
</html>