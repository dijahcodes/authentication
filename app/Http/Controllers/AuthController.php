<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Purifier;
use Hash;
use Auth;
use JWTAuth;
use Carbon\Carbon;

use App\User;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->middleware('jwt.auth', ['only' => ['getUser']]);
  }
    public function signUp (Request $request)
    {
      $rules = [
      'email' => 'required',
      'username' => 'required',
      'password' => 'required',
      'dateOfBirth' => 'required'
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
      return Response::json(['error' => 'Please fill out all fields.']);
    }

    $email = $request->input('email');
    $username = $request->input('username');
    $dateOfBirth= $request->input('dateOfBirth');
    $password = $request->input('password');

    // $then will first be a string-date
    $age = Carbon::parse($dateOfBirth)->age;
    if($age < 13)  {
      return Response::json(['error' => "You're too young, sonny. Go home."]);
    }


    $password = Hash::make($password);

    $user = new User;
    $user->email = $email;
    $user->username = $username;
    $user->password = $password;
    $user->dateOfBirth = $dateOfBirth;
    $user->roleID = 2;
    $user->save();

    return Response::json(['success' => 'Thanks for signing up.']);

    }

    public function signIn(Request $request)
    {
      $rules = [
        'email' => 'required',
        'password' => 'required'

      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if($validator-> fails())
      {
        return Response::json(['error' => 'Please fill out all fields.']);
      }

      $email = $request->input('email');
      $password = $request->input('password');
      $credentials = compact("email", "password");

      $token = JWTAuth::attempt($credentials);

      if($token == false)
      {
        return Response::json(['error' => 'Wrong Email/Password']);
      }
      else
        {
        return Response::json(['token' => $token]);
      }

    }
      public function getUser()
      {
        $id = Auth:: id();
        $user = User::find($id);

        return Response::json(['user' => $user]);
      }
}
