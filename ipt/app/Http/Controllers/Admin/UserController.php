<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Imports\AdminImport;
use App\Imports\StudentImport;
use App\Imports\SupervisorImport;
use App\Imports\MarkerImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        /*Get users by their role*/

        $admins     = User::role('admin')->get();
        $supers     = User::role('supervisor')->get();
        $markers    = User::role('marker')->get();
        $students   = User::role('student')->get();
        $roles      = DB::table('roles')->get();

    	return view('admin.user.index', [
        
            'admins'    => $admins,
            'students'  => $students,
            'markers'   => $markers,
            'supers'    => $supers,
            'roles'    => $roles,

        ]);
    }

// adding multiple user

    public function adminImport(Request $request) 
    {
        $this->validate($request, [

            'file' => 'mimes:xlsx',

        ]);

        if($request->hasFile('file')){
        
    	    $file = $request->file;
            Excel::import(new AdminImport, $file);

            toastr()->success('Admins has been added successfully');

        return redirect()->route('user');
        }

            toastr()->error('Please add a file before submitting.');
            return back();
        
    }

    public function studentImport(Request $request) 
    {
        $this->validate($request, [

            'file' => 'mimes:xlsx',

        ]);

        if($request->hasFile('file')){
        
    	    $file = $request->file;
            Excel::import(new StudentImport, $file);

            toastr()->success('Students has been added successfully');

        return redirect()->route('user');
        }

            toastr()->error('Please add a file before submitting.');
            return back();
    }

    public function superImport(Request $request) 
    {
        $this->validate($request, [

            'file' => 'mimes:xlsx',

        ]);

        if($request->hasFile('file')){
        
    	    $file = $request->file;
            Excel::import(new SupervisorImport, $file);

            toastr()->success('Supervisor has been added successfully');

        return back();
        }

            toastr()->error('Please add a file before submitting.');
            return back();
    }

    public function markerImport(Request $request) 
    {
        $this->validate($request, [

            'file' => 'mimes:xlsx',

        ]);

        if($request->hasFile('file')){
        
    	    $file = $request->file;
            Excel::import(new MarkerImport, $file);

            toastr()->success('Marker has been added successfully');

        return redirect()->route('user');
        }

            toastr()->error('Please add a file before submitting.');
            return back();
    }
// End adding


    // downloading sample file

    public function adminSample()
    {   

        $path =  storage_path('app/public/excel/admin.xlsx');
        return response()->download($path);

    }

    public function superSample()
    {   

        $path =  storage_path('app/public/excel/supervisor.xlsx');
        return response()->download($path);

    }

    public function markerSample()
    {   

        $path =  storage_path('app/public/excel/marker.xlsx');
        return response()->download($path);

    }

    public function studentSample()
    {   

        $path =  storage_path('app/public/excel/students.xlsx');
        return response()->download($path);

    }


    // Adding single user
    public function registerUser(Request $request)
    {
        $this->validate($request, [
            'name'       => ['required', 'string', 'max:255'],
            'id'         => ['required', 'string', 'max:20'],
            'department' => ['required', 'string', 'max:20'],
            'role'       => ['required', 'string', 'max:20'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = new User;

        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->userId       = $request->id;
        $user->img          = 'user.png';
        $user->department   = $request->department;
        $user->password     = bcrypt($request->password);

        $user->save();

        $user->assignRole($request->role);


        toastr()->success('User is added successfully,');
        return back();
    }

}

