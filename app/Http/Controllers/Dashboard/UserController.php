<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->when($request->search, function ($query) use ($request) {
            return $query->where('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));

    }


    public function create()
    {
        return view('dashboard.users.create');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1',
        ]);
        $data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $data['password'] = bcrypt($request->password);

        // Image
        if ($request->image) {
            Image::make($request->image)
                ->resize('300', null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/users_images/' . $request->image->hashName()));

            $data['image'] = $request->image->hashname();
        }


        $user = User::create($data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions); // Sync Permissions for user

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('users.index');
    }


    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id),],
            'image' => 'image',
        ]);
        $data = $request->except(['permissions', 'image']);

        if ($request->image) {
            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
            }
            Image::make($request->image)
                ->resize('300', null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/users_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashname();
        }


        $user->update($data);
        if ($request->permissions) {
            $user->syncPermissions($request->permissions);
        }

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('users.index');


    }


    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
        }

        $user->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('users.index');
    }
}
