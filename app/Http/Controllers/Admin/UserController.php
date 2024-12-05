<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreRoleRequest;

use Spatie\Permission\Models\Role;

use App\Models\UserMeta;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::all()->pluck('name', 'id');
        return view('admin.users.create', compact('roles') );
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        $validatedData = $request->validate([
            'name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'required|digits:10|unique:users',
            'password' => 'required|string|min:8', // Adjust the min length as per your requirements
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = $request->password;

        $user->assignRole($request->role);
        

        if ($user->save()) {
            return redirect()->route('admin.users.index')->with('message', 'User created successfully!');
        }
        return redirect()->route('admin.users.index')->with('message', 'User create failed!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $user = User::findOrFail($id);
        // $user_meta = UserMeta::findOrFail($user_id);
        $user = new User();
        $userWithMeta = $user->getUserWithMeta($id)->toArray();

        return view('admin.users.show', compact('userWithMeta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

    public function banUnban($id, $status)
    {
        if (auth()->user()->hasRole('Admin')){
            $user = User::findOrFail($id);
            $user->status = $status;
            if ($user->save()){
                return redirect()->back()->with('message', 'User status updated successfully!');
            }
            return redirect()->back()->with('error', 'User status update fail!');
        }
        return redirect(Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    
}
