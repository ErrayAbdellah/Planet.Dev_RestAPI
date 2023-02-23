<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\ExecutionTimeoutException;

class UserController extends Controller
{

    public function __construct()
    {
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
        //
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
