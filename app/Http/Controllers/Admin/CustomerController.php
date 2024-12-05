<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends UserController
{
    public function index()
    {
        // Fetch all users with the role 'stuff'
        $customers = User::role('Customer')->get();

        // Return the view with the data
        return view('admin.customers.index', compact('customers'));
    }
}
