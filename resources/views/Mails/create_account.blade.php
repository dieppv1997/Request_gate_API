<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
<h1><strong>Gửi bạn thông tin tài khoản</strong></h1>
<table style="width:100%">
    <tr>
        <th>Email</th>
        <th>{{$email}}</th>
    </tr>
    <tr>
        <th>Password</th>
        <th>{{$password}}</th>
    </tr>
</table>
</body>
</html>
