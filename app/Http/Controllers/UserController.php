<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class UserController extends Controller
{

    public function index()
    {
        return User::get();
    }

    public function show(User $user)
    {
        return $user();
    }

    public function store(StorePostRequest $request)
    {
        return User::create($request->validated());
    }

    public function edit(User $post)
    {
        //
    }

    public function update(UpdatePostRequest $request, User $user)
    {
        $user->update($request->validated());
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('User deleted!');
    }


}
