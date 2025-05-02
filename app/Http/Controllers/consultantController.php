<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class consultantController extends Controller
{
    /**
     * Display a listing of the seller's products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultants =User::where('role', 'consultant')->get();
        return view('consultants.index', compact('consultants'));
    }
    public function show(int $id)
    {
        $consultant = User::findOrFail($id);
        return view('consultants.show', compact('consultant'));

    }
}
