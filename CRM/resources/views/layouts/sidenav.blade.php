<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidenav">
    <a href="{{ url('/home') }}"><img src="/img/home.png" width="35" height="35">Home</a>
    <a href="{{ url('/history') }}"><img src="/img/history.png" width="35" height="35">History</a>
    <a href="{{ route('companies.index') }}"><img src="/img/companies.png" width="35" height="35">Companies</a>
    <a href="{{ route('offices.index') }}"><img src="/img/offices.png" width="35" height="35">Offices</a>
    <a href="{{ route('gates.index') }}"><img src="/img/gates.png" width="35" height="35">Gates</a>
    <a href="{{ route('cars.index') }}"><img src="/img/cars.png" width="35" height="35">Cars</a>
    <!-- <a href="{{ url('/team') }}"><img src="/img/team.png" width="35" height="35">Team</a> -->
</div>
</body>
</html>
