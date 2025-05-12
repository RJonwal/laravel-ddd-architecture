<?php

namespace App\Domains\Admin\Dashboard\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        /* $userCount = User::whereHas('roles',function($query){
            $query->where('id',config('constant.roles.user'));
        })->count();

        $totalPurchasedAmount = UserSubscription::where('payment_status', 'completed')->sum('amount'); */
        
        return view('Dashboard::index'/* ,compact('userCount','totalPurchasedAmount') */);
    }
}
