<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use Auth;
use Validator;
use Lang;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(10);
        $myprojects = null;
        if (Auth::user() and Auth::user()->projects()->count())
            $myprojects = Auth::user()->projects;
        return view('projects.index', [
            'projects' => $projects,
            'myprojects' => $myprojects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('projects.create', [
            'users' => $users,
        ]);
        //
    }

    public function customValidate(Request $request) {
	    $rules = [
		    'name' => 'required|string|max:191',
		    'privacy' => 'required|integer',
	    ];
	    $validator = Validator::make($request->all(), $rules);
        if (! $request->admins) {
                $validator->after(function ($validator) {
                        $validator->errors()->add('admins', Lang::get('messages.project_admin_required_error'));
                });
        }
        return $validator;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);
	    $validator = $this->customValidate($request);
	    if ($validator->fails()) {
		    return redirect()->back()
			    ->withErrors($validator)
			    ->withInput();
	    }
        $project = new Project($request->only(['name', 'notes', 'privacy']));
        $project->save(); // needed to generate an id?
        $project->setusers($request->admins, Project::ADMIN)
        ->setusers($request->collabs, Project::COLLABORATOR)
        ->setusers($request->viewers, Project::VIEWER);
        return redirect('projects')->withStatus(Lang::get('messages.stored'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $users = User::all();
        return view('projects.create', [
            'project' => $project,
            'users' => $users,
        ]);
        //
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
        $project = Project::findOrFail($id);
        $this->authorize('update', $project);
	    $validator = $this->customValidate($request);
	    if ($validator->fails()) {
		    return redirect()->back()
			    ->withErrors($validator)
			    ->withInput();
	    }
        $project->update($request->only(['name', 'notes', 'privacy']));
        $project->setusers($request->admins, Project::ADMIN)
        ->setusers($request->collabs, Project::COLLABORATOR)
        ->setusers($request->viewers, Project::VIEWER);
        return redirect('projects')->withStatus(Lang::get('messages.saved'));
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
