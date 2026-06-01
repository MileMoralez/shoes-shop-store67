<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 

class OrderController extends Controller
{
    public function index()
    {
        // ទាញយក Orders ទាំងអស់ពីថ្មីទៅចាស់
        $orders = Order::orderBy('created_at', 'desc')->get();
       
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}