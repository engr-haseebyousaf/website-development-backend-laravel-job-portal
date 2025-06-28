<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
</head>
<body>
    <h1>Name : {{ $details["employer"]->name }}</h1>
    <h2>Job Title : {{ $details["job"]->title }}</h2>
    <h2>Employee Details:</h2>
    <ul>
        <li>Name : {{ $details["user"]->name }}</li>
        <li>Email : {{ $details["user"]->email }}</li>
        <li>Number : {{ $details["user"]->mobile }}</li>
        <li>Posted At : {{ \Carbon\Carbon::parse($details["job"]->created_at)->format("d M, Y") }}</li>
    </ul>
</body>
</html>
