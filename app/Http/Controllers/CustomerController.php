<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use PhpParser\ErrorHandler\Collecting;

class CustomerController extends Controller
{
    public function getCustomers(Request $request){
        if($request->searchValue == ''){
        $customers = Customer::orderBy('id', 'desc')->paginate($request->perPage);
        } else {
            $customers = Customer::orderBy('id', 'desc')
                    ->where('id', 'LIKE', '%' . $request->searchValue . '%')
                    ->orWhere('firstname', 'LIKE', '%' . $request->searchValue . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->searchValue . '%')
                    ->paginate($request->perPage);
        }
        return response()->json([
            'status' => 200,
            'customers' => $customers
        ]);
    }
    public function getCustomersAverage(Request $request){
        $date = \Carbon\Carbon::today()->subDays($request->date);
        $customers = Customer::where('created_at' ,'>=',$date)->get();
        $average = collect($customers)->avg('id');
        if($average)
        {
            return response()->json([
                'status' => 200,
                'average' => $average
            ]);
        }
    }
    
    public function customerRegister(RegisterCustomerRequest $request)
    {
        // dd($request->all());
        $customer = Customer::create([
             'firstname' => $request->firstname,
             'lastname' => $request->lastname,
             'email'    => $request->email,
             'phone'    => $request->phone,
             'location' => $request->location,
             'password' => $request->password,
         ]);

        $token = auth('customers')->login($customer);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('customers')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        
        auth('customers')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('customers')->factory()->getTTL() * 60,
            'customer' => auth('customers')->user(),
        ]);
    }

}
