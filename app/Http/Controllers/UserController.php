<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Method that retrieves all users of db.
    function getUsers(Request $request)
    {

        if (!$request->user()->hasRole(['admin'])) {
            return response()->json(
                ["message" => "You are not allowed to see this information"],
                401
            );
        }
        $users = User::all();


        return response()->json(
            $users,
            200
        );
    }

    //Method that retrieves a certain user of db.
    function getUser(Request $request, int $id)
    {

        try {
            $user = User::find($id);

            if ($request->user()->hasRole(['user', 'writer'])) {
                if ($user->id != $request->user()->id) {
                    return response()->json(
                        ["message" => "You are not allowed to see this user's information"],
                        401
                    );
                }
            }

            if ($user == null) {
                return response()->json(
                    ["error" => "The user you are looking for doesn't exist"],
                    404
                );
            }


            return response()->json(
                $user,
                200
            );
        } catch (Exception $e) {
        }
    }


    //Method that deletes an existing user of db.
    function deleteUser(Request $request, int $id)
    {

        $user = User::find($id);

        if ($request->user()->hasRole(['user', 'writer'])) {
            if ($user->id != $request->user()->id) {
                return response()->json(
                    ["message" => "You are not allowed to delete this user"],
                    401
                );
            }
        }


        $user->delete();

        return response()->json(
            [
                "user_id" => $user->id,
                "message" => "User succesfully deleted"
            ],
            200
        );
    }


    //Method that edits an existing user of db.
    function editUser(Request $request, int $id)
    {
        $validated = $request->validate([
            "password" => ["max:50", "regex:/^[A-Za-z0-9?¿_-]{5,50}|^$/"],
        ]);


        $user = User::find($id);

        if ($request->user()->hasRole(['user', 'writer'])) {
            if ($user->id != $request->user()->id) {
                return response()->json(
                    ["message" => "You are not allowed to edit this user"],
                    401
                );
            }
        }

        if ($request->name) {
            $user->name = $request['name'];
        }

        if ($request->surname) {
            $user->surname = $request['surname'];
        }

        if ($request->username) {
            $user->username = $request['username'];
        }

        if ($request->email) {
            $user->email = $request['email'];
        }

        if ($request->password != "") {
            $user->password = Hash::make($request['password']);
        }

        $user->save();

        return response()->json(
            [
                "user_id" => $user->id,
                "message" => "User succesfully edited"
            ],
            200
        );


        return response()->json($request->user(), 200);
    }


    //Method that creates a new user on db.
    function register(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required"],
            "surname" => ["required"],
            "username" => ["required"],
            "password" => ["required", "regex:/^[A-Za-z0-9?¿_-]{5,50}|^$/"],
            "email" => ["required"],
        ]);


        $user = new User();
        $user->name = strtoupper($request['name']);
        $user->surname = strtoupper($request['surname']);
        $user->username = strtoupper($request['username']);
        $user->email = strtoupper($request['email']);
        $user->password = Hash::make($request['password']);
        $user->assignRole("user");
        $user->photo = url("http://localhost:8000/api/profileimage/0");

        $user->save();

        return response()->json(
            [
                "user_id" => $user->id,
                "message" => "User succesfully created"
            ],
            200
        );
    }


    //Login
    function login(Request $request)
    {
        $user = User::where('username',  strtoupper($request->username))->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'message' => ['Username or password incorrect']
                ],
                400
            );
        }

        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'name' => $user->name,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }


    //Profile
    public function profile(Request $request)
    {

        $user = $request->user();

        return response()->json(
            [
                'status' => 'success',
                'user' => $user
            ]
        );
    }


    //Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'User logged out successfully'
            ]
        );
    }



    public function getRole(Request $request)
    {

        if ($request->user()->hasRole("admin")) {
            return response()->json(
                ["role" => "admin"]
            );
        }

        if ($request->user()->hasRole("writer")) {
            return response()->json(
                ["role" => "writer"]
            );
        }

        return response()->json(
            ["role" => "user"]
        );
    }
}
