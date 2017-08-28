<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Purifier;
use Hash;
use Auth;
use JWTAuth;

use APP\User;

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
      'name' => 'required',
      'password' => 'required'
    ];

    $validator = Vaidator::make(Purifier::clean($rewuest->all()), $rules);

    if($validator->fails())
    {
      return Response:;json(['error' => 'Please fill out all fields.']);
    }

    $email = $request->input('email');
    $name = $request->input('name');
    $password = $request->input('password');

    $password = Hash::make($password);

    $user = new User;
    $user->email = $email;
    $user->name = $name;
    $user->password - $password;
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

      $validator = Validator::male(Purifier::clean($request->all()), $rules);

      if($validator-> fails())
      {
        return Response::json(['error' => 'Please fill out all fields.']);
      }

      $email = $request->input('email');
      $password = $request->input('password')
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
