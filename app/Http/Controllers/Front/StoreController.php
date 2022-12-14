<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index($subdomain, Store $store)
    {
        $store = $store->whereSubdomain($subdomain)
                        ->with('products')
                        ->firstOrFail();

        return view('front.home', compact('store'));
    }
}
