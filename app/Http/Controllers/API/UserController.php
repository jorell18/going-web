<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Data\Models\UserModel;
use App\Data\Models\TravelerModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function getUser(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'key' => 'required | uuid',
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

                $user = UserModel::where('key', $request->key)->with('traveler')->first();

                if (!empty($user)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'user' => $user
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'user does not exist'
                    ], 401);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => '401',
                'message' => $e->getMessage()
            ], 401);
        }
    }


    public function listUsers(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'filters' => 'nullable | array',
                'limit' => 'nullable | numeric',
                'fields' => 'nullable | array',
                'sort' => 'nullable | array',
                'search' => 'nullable | string',
                'paginate' => 'nullable | string',
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
            $filters = isset($request->filters) ? $request->filters : null;
            $limit = isset($request->limit) ? $request->limit : 15;
            $fields = isset($request->fields) ? $request->fields : ['*'];
            // $sort_by = isset($request->sort_by) ? $request->sort_by : null;
            // $search = isset($request->search) ? $request->search : null;
            $paginate = isset($request->paginate) ? $request->paginate : false;

            if($paginate){
                $users = UserModel::where($filters)
                ->with('traveler')
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $userList = $users->toArray();
            }else{
                $users = UserModel::where($filters)
                ->with('traveler')
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $userList['data'] = $users->toArray();
            }

            
            if (!empty($userList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'users' => $userList,
                    ],
                    200
                );
            }
        }
    }


    public function addUser(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'middle_name' => 'nullable',
                    'email' => 'nullable | email',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                    'role' => 'required'
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
                            'key' => Str::uuid(),
                            'role' => $request->role
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

                            $userTraveler = $user['traveler'];
                            return response()->json(
                                [
                                    'status' => 200,
                                    'success' => true,
                                    'message' => 'User created successfully',
                                    'user' => $user,
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
        } catch (Exception $e) {
            return response()->json([
                'status' => '401',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function editUser(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'email' => 'nullable | string',
                    'first_name' => 'nullable | string',
                    'last_name' => 'nullable | string',
                    'middle_name' => 'nullable | string',
                    'birthdate' => 'nullable | date',
                    'baseCurrency' => 'nullable | string',
                    'picture' => 'nullable | string'
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

                $user = UserModel::find($request->id);

                if (!empty($user)) {

                    $user->email = $request->email;
                    // $traveler->picture = $request->picture;
                    $user->save();

                    $traveler = TravelerModel::where('user_id', $user['key'])->first();

                    if (!empty($traveler)) {
                        $traveler->email = $request->email;
                        $traveler->first_name = $request->first_name;
                        $traveler->last_name = $request->last_name;
                        $traveler->middle_name = $request->middle_name;
                        $traveler->birthdate = $request->birthdate;
                        $traveler->baseCurrency = $request->baseCurrency;

                        $traveler->save();
                    }

                    $user->load('traveler');
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'User edited successfully',
                            'user' => $user
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'User not found',
                        ],
                        401
                    );
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => '401',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function deleteUser(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
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
                $user = UserModel::find($request->id);

                $user->traveler()->delete();

                $user->delete();

                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'User deleted successfully',
                    ],
                    200
                );
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => '401',
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
