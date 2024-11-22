<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //Method that retrieves all users of db.
    function getUsers(Request $request)
    {

        if (!$request->user()->hasRole('admin')) {
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
                [
                    "user" => $user,
                    "role" => $user->roles[0]
                ],
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
        
        try{


            //return response()->json($request->input('password'));

            $validated = $request->validate([
                "password" => ["max:50", "regex:/^[A-Za-z0-9?¿_-]{5,50}$|^ $"],
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
    
            if ($request->input('name')) {
                $user->name = strtoupper($request->input('name'));
            }
    
            if ($request->input('surname')) {
                $user->surname = strtoupper($request->input('surname'));
            }
    
            if ($request->input('username')) {
                $user->username = strtoupper($request->input('username'));
            }
    
            if ($request->input('email')) {
                $user->email = strtoupper($request->input('email'));
            }
    
    
            //Adding signature image
            if ($request->file('signature')) {
                $signature = $request->file('signature');
                $name = $request->file('signature')->hashName();
                Storage::put('signatures/' . $name, file_get_contents($signature));
                $user->signature = $name;
            }
    
            if ($request->password != " ") {
                $user->password = Hash::make($request['password']);
            }
    
    
    
            if ($request->role != " ") {
                $user->removeRole('writer');
                $user->removeRole('user');
                $user->assignRole($request->role);
            }
    
            $user->save();
    
            return response()->json(
                [
                    "user_id" => $user->id,
                    "message" => "User succesfully edited"
                ],
                200
            );

        }catch(Exception $e){

            return response()->json([
                "error"=> $e
            ],
            400);

        }
    }


    function registerAdmin(Request $request)
    {

        try {

            //If user is not admin, return error
            if (!$request->user()->hasRole('admin')) {
                return response([
                    "error" => "You don't have the permissions to access this resource"
                ], 400);
            }

            $validated = $request->validate([
                "name" => ["required"],
                "surname" => ["required"],
                "username" => ["required"],
                "password" => ["required", "regex:/^[A-Za-z0-9?¿_-]{5,50}|^$/"],
                "email" => ["required"],
                "role" => ["required"]
            ]);

            $user = new User();
            $user->name = strtoupper($request['name']);
            $user->surname = strtoupper($request['surname']);
            $user->username = strtoupper($request['username']);
            $user->email = strtoupper($request['email']);
            $user->password = Hash::make($request['password']);
            $user->assignRole($request->input('role'));

            $user->save();

            

            return response()->json(
                [
                    "user_id" => $user->id,
                    "message" => "User succesfully created"
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json([
                'error' => $e
            ]);
        }
    }


    //Method that creates a new user on db.
    function register(Request $request)
    {
        try {

            $validated = $request->validate([
                "password" => ["required", "regex:/^[A-Za-z0-9?¿_-]{5,50}|^$/"],
                "email" => ["required"],
            ]);


            $user = new User();
            $user->email = strtoupper($request['email']);
            $user->password = Hash::make($request['password']);
            $user->assignRole("user");

            $user->save();

            return response()->json(
                [
                    "user_id" => $user->id,
                    "message" => "User succesfully created"
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json([
                'error' => $e
            ]);
        }
    }


    //Login
    function login(Request $request)
    {
        $user = User::where('email',  strtoupper($request->email))->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'message' => ['Username or password incorrect'],
                    "user" => [$user]
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
