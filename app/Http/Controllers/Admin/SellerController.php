<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SellerController extends UserController
{
    public function index()
    {
        // Fetch all users with the role 'stuff'
        $sellers = User::role('Seller')->get();

        // Return the view with the data
        return view('admin.sellers.index', compact('sellers'));
    }
}
