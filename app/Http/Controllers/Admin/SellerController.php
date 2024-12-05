<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::paginate(10);
        return view('admin.sellers.index', compact('sellers'));
    }

    public function show(Seller $seller)
    {
        return view('admin.sellers.show', compact('seller'));
    }

    public function destroy(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('sellers.index')->with('success', 'Seller deleted successfully.');
    }
}
