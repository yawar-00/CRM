<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'message' => 'Users fetched successfully',
            'data' => $users
        ]);
    }
}
