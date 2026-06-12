<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>

<h2>User Dashboard</h2>

<p>Welcome, {{ auth()->user()->name }}</p>

<hr>
Total Lead: {{ $totalLead }} <br>
Total Contacted Lead: {{ $totalContactedLead }} <br>
Total Converted Lead: {{ $totalConvertedLead }} <br>
Total Lost Lead: {{ $totalLostLead }} <br>

<a href="{{ route('leads-list') }}">View Leads</a>
<hr>
<form method="POST" action="{{ route('frontend-logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>

</body>
</html>