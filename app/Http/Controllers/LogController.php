<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Purifier;

use App\Log;

class LogController extends Controller
{
    public function index ()
    {
      $logs = Log::all();

      return Response::json(['logs' => $logs]);
    }

    public function store(Request $request)
    {
      $rules = [
        'food'=> 'required',
        'calories' => 'required',
        'fat' => 'required',
        'carbs' => 'required',
        'sugars' => 'required',
        'allergens' => 'required'
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if ($validator->fails())
      {
        return Response::json(['error' => 'Please fill out all fields.']);
      }

      $food = $request->input('food');
      $calories = $request->input('calories');
      $fat = $request->input('fat');
      $carbs = $request->input('carbs');
      $sugars = $request->input('sugars');
      $allergens = $request->input('allergens');

      $logs = new Log;
      $logs->food = $food;
      $logs->calories = $calories;
      $logs->fat = $fat;
      $logs->carbs = $carbs;
      $logs->sugars = $sugars;
      $logs->allergens = $allergens;
      $logs->save();

      return Response::json(['logs' => $logs]);
    }

    public function show($id)
    {
      $logs = Log::find($id);

      return Response::json(['logs' => $logs]);
    }
}
