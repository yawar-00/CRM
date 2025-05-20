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
<a href="{{route('password.edit')}}">
   Update Password
</a>

    <ul>
        <li>
    <a href="{{url('/users')}}" class="{{ request()->is('users') ? 'active' : '' }}">
    <i class="fa-solid fa-users"></i><span>Users</span>
    </a>
  </li>
  <li>
    <a href="{{url('/role')}}" class="{{ request()->is('role') ? 'active' : '' }}">
    <i class="fa-solid fa-address-book"></i><span>Roles</span>
    </a>
  </li>
  <li>
    <a href="{{url('/permission')}}"class="{{ request()->is('/permission')? 'active' : '' }}">
    <i class="fa-regular fa-folder-open"></i><span>Perission</span>
    </a>
  </li>
    </ul>
    <h1> welcome {{Auth::user()->name}}</h1>
</body>
</html>