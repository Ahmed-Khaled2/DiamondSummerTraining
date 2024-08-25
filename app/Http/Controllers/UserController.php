<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public function index()
    {
        return User::get();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(StoreUserRequest $request, $user)
    {

        if ($request->hasFile('profile_img')){
        $filename = $request->file('profile_img')->getClientOriginalName();
        $NewFileName = time().'_'.$filename;
        $img_path = $request->file('profile_img')->storeAs('public/user_images', $NewFileName);
        $user->profile_img = $img_path;
        }

        $user->save();
        return $user;
    }

    public function edit(User $post)
    {
        //
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::find(Auth::id());
        $user->update($request->validated());
        $user->save();
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('User deleted!');
    }


}
