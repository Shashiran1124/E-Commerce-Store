<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PaymentController extends Controller
{
    public function show()
    {
        return Inertia::render('Paymentpage');
    }

}
