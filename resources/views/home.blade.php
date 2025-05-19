<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">
        Log Out
    </button>
</form>
<a href="{{route('profile.edit')}}">
    Edit Profile
</a>
    <h1> welcome {{Auth::user()->name}}</h1>
</body>
</html>