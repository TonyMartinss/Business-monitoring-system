<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // crete me the reasonable methods for a customer controller
    public function index()
    {
        // code to list customers
    }

    public function create()
    {
        // code to show form to create a customer
    }

    public function store(Request $request)
    {
        // code to store a new customer
    }

    public function show($id)
    {
        // code to show a specific customer
    }

    public function edit($id)
    {
        // code to show form to edit a customer
    }

    public function update(Request $request, $id)
    {
        // code to update a specific customer
    }

    public function destroy($id)
    {
        // code to delete a specific customer
    }

    public function getCustomer($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json([
            'phone'   => $customer->phone,
            'address' => $customer->address,
        ]);
    }
}
