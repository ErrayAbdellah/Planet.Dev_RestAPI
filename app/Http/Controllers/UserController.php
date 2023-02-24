<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','forget','reset','test']]);

        $this->middleware([
            'isAdmin',
        ])->only(['updateRole']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data =[];

        if($request->input('password')){
            $data['password']= $request->input('password');
        }
        if($request->input('name')){
            $data['name']= $request->input('name');
        }
        if($request->input('email')){
            $data['email']= $request->input('email');
        }

        $user->id = JWTAuth::user()->id;

         try {
            $user->where('id', $user->id)->update($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        // $user->users()->sync($user);

        return response()->json([
            'success'=>'user has been update',
            'data' => ['user' => $user]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['isAdmin'=>'required|boolean']);

        try {
            $user->update([
                'isAdmin' => $request->isAdmin,
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Error is occurred while updating the role.'
            ], 500);
        }

        return response()->json([
            'message' => 'role has been updated'
        ], 202);
    }
}
