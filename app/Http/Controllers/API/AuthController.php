<?php

namespace App\Http\Controllers\API;

use App\Data\Models\TravelerModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Data\Models\UserModel;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'middle_name' => 'nullable',
                'email' => 'required|email',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'validation error :' . $validator->errors(),
                    'errors' => $validator->errors()
                ],
                400
            );
        } else {

            $user_status = UserModel::where('email', $request->email)->first();

            if (!empty($user_status)) {
                //email exists
                return response()->json(
                    [
                        'status' => 409,
                        'success' => false,
                        'message' => 'Whoops! email already registered'
                    ],
                    409
                );
            } else {
                $user = UserModel::create(
                    [
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'key' => Str::uuid()
                    ]
                );

                if (!empty($user)) {


                    //create user as traveller
                    $traveler = TravelerModel::create(
                        [
                            'id' => Str::uuid(),
                            'first_name' => $request->first_name,
                            'middle_name' => $request->middle_name,
                            'last_name' => $request->last_name,
                            'user_id' => $user['key'],
                            'email' => $user['email']
                        ]
                    );

                    if (!empty($traveler)) {
                        //successful add
                        Auth::user($user);
                        $token = $user->createToken('MyApp')->accessToken;

                        $userTraveler = $user['traveler'];
                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Login successful',
                                'user' => $user,
                                'token' => $token
                            ],
                            200
                        );
                    } else {
                        $user->delete();
                    }
                }

                if (empty($user) || empty($traveler)) {
                    return response()->json(
                        [
                            'status' => 406,
                            'success' => false,
                            'message' => 'failed to register'
                        ],
                        406
                    );
                }
            }
        }
    }


    // ------------------ [ User Detail ] ---------------------
    public function userDetail($email)
    {
        $user = array();
        if ($email != '') {
            $user = UserModel::where('email', $email)->first();
            return $user;
        }
    }

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $request)
    {
        // return $request->input('email'). '-' . $request->input('password');

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(
                [
                    'status' => 400,
                    'message' =>$errors->all(),
                    'errors' => $validator->errors()
                ],
                400
            );
        }

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $user = UserModel::where('email', $request->input('email'))
                ->first();

            if (!empty($user)) {
                if (Auth::attempt(['email' => $email, 'password' => $password])) {

                    Auth::user($user);
                    $token = $user->createToken('MyApp')->accessToken;

                    $user->load('traveler');

                    return response()->json([
                        'status' => 200,
                        'success' => true,
                        'message' => 'Login successful',
                        'user' => $user,
                        'token' => $token
                    ], 200);
                } else {
                    return response()->json([
                        'status' => '400',
                        'message' => 'user not found',
                        // 'email' => $email,
                        // 'password' => $password,
                        // 'user' => $user

                    ], 400);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => '401',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }
}
