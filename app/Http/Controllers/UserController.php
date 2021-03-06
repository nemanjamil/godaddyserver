<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function userdetails()
    {

        $user = User::get(); // svi useri
        return response()->json(['success' => $user], 200);
    }

    public function userdetail(Request $request) {

        $user = Auth::user();
        if (Auth::user()) {
            return response()->json(['success' => true,'user' => $user->id], 200);
        } else {
            return response()->json(['success' => false], 200);
        }

       /* dd(auth()->user()->id);
        dd($id,$request);*/
    }

    public function userLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        //$credentials = $request->only('email', 'password');
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Token Name')->accessToken;
            return response()->json(['success' => $success], 200);

        } else {
            return response()->json(['success' => "Nema Tog Usera"], 400);
        }

    }

    public function userregister(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $userexist = User::where("email", $request->email)->first();
        if($userexist!= null) {
            return response()->json(['success' => "user Exist"], 200);
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);


        $user = User::create($input);
        $tokenStr = $user->createToken('Token Name')->accessToken;
        $success['token'] = $tokenStr;
        $success['name'] = $user->name;

        return response()->json(['success' => $success], 200);


    }
}
