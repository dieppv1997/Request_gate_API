<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gửi mail sau khi create</title>
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
    <h1><strong>Tạo Mới Request</strong></h1>
    <h3><strong>Issue Item</strong></h3>
    <table style="width:100%">
        <tr>
            <th>Type</th>
            <th>Request</th>
        </tr>
        <tr>
            <th>Registered by</th>
            <th><?php echo $data['author'];?></th>
        </tr>
        <tr>
            <th>Title</th>
            <th><?php echo $data['title'];?></th>
        </tr>
        <tr>
            <th>Content</th>
            <th><?php echo $data['content'];?></th>
        </tr>
        <tr>
            <th>Assignee</th>
            <th><?php echo $data['assign'];?></th>
        </tr>
        <tr>
            <th>Start date</th>
            <th><?php echo $data['created'];?></th>
        </tr>
        <tr>
            <th>Due date</th>
            <th><?php echo $data['due_date'];?></th>
        </tr>
        <tr>
            <th>Priority</th>
            <th><?php echo $data['priority'];?></th>
        </tr>
        <tr>
            <th>Status Admin</th>
            <th><?php echo $data['status_admin'];?></th>
        </tr>
        <tr>
            <th>Status Manager</th>
            <th><?php echo $data['status_manager'];?></th>
        </tr>
        <tr>
            <th>Category</th>
            <th><?php echo $data['category'];?></th>
        </tr>
</table>
</body>
</html>