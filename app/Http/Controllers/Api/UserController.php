<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all(); // Fetch all users

        //echo "<pre>"; print_r($users);exit;

        return response()->json($users); // Return data as JSON
    }
}
