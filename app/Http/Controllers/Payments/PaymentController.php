<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('Payments/Index');
    }

    public function success()
    {
        return Inertia::render('Payments/Success');
    }

    public function fail()
    {
        return Inertia::render('Payments/Fail');
    }
}
