<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
       $this->middleware('auth', ['except' => ['index', 'show', 'home']]);
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       // $user_id = auth()->user()->id;
       // $user = User::find($user_id);
       return view('home');
   }
  
   public function profile()
   {
       $user_id = auth()->user()->id;
       $user = User::find($user_id);
       return view('tasks.profile')->with('tasks', $user->tasks);
   }
}


