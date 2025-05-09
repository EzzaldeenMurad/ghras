<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display the statistics dashboard.
     */
    public function index()
    {
        // Get count of sellers (users with role_id = 2)
        $sellersCount = User::where('role', "seller")->count();

        // Get count of customers (users with role_id = 3)
        $customersCount = User::where('role', "buyer")->count();

        // Get count of admins (users with role_id = 1)
        $adminsCount = User::where('role', "admin")->count();

        // Get total products count
        $productsCount = Product::count();

        // Get total sales (orders count)
        $orderCount = Order::count();

        // // Get total purchases (sum of order items)
        // $purchasesCount = DB::table('order_items')->count();

        return view('admin.statistics', compact(
            'sellersCount',
            'customersCount',
            'adminsCount',
            'productsCount',
            'orderCount',
            // 'purchasesCount',
        ));
    }
}
