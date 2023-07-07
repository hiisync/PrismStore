<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:see admin dashboard'])->only(['index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'users' => User::all(),
            'orders' => Order::all(),
            'products' => Product::all(),
            'payments' => Payment::all(),
        ]);
    }
}
