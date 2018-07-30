<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class PostsController extends Controller
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
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $tasks = Task::orderBy('created_at', 'desc')->paginate(10);
       return view('tasks.index')->with('tasks', $tasks);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       return view('tasks.create');
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $this->validate($request, [
           'name' => "required",
           'description' => 'required'
       ]);

           $task = new Task;
           $task->name = $request->input('name');
           $task->description = $request->input('description');
           $task->user_id = auth()->user()->id;
           $task->save();
           return redirect('/tasks')->with('success', 'Post Created');

   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       $task = Task::find($id);
       return view('tasks.show')->with('task', $task);
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $task = Task::find($id);
       // Check for correct user
       if(auth()->user()->id !==$task->user_id) {
           return redirect('/tasks')->with('error', 'Unauthorized Page');
       }
       return view('tasks.edit')->with('task', $task);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
       $this->validate($request, [
           'name' => "required",
           'description' => 'required'
       ]);
           //Create post
           $task = Task::find($id);
           $task->name = $request->input('name');
           $task->description = $request->input('description');
           $task->save();
           return redirect('/tasks')->with('success', 'Post Updated');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $task = Task::find($id);
         // Check for correct user
         if(auth()->user()->id !==$task->user_id) {
           return redirect('/tasks')->with('error', 'Unauthorized Page');
       }
       $task->delete();
       return redirect('/tasks')->with('success', 'Post Removed');;
   }
}


