<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Purifier;

use App\Logs;

class LogController extends Controller
{
    public function index ()
    {
      $logs = Log::all();

      return Response::json(['logs' => $logs]);
    }

    public function (Request $request)
    {
      $rules = [
        'logContent'=> 'required'
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if ($validator->fails())
      {
        return Response::json(['error' => 'Please fill out all fields.'])
      }

      $logContent = $request->input('logContent');

      $logs = new Logs;
      $logs->logContent = $logContent;
      $logs->save();

      return Response::json(['logs' => $logs);
    }

    public funciton ($id)
    {
      $logs = Logs::find($id);

      return Response::json(['logs' => $logs]);
    }
}
