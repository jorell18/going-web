<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\StateModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    public function getState(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required | numeric',
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

                $State = StateModel::find($request->id);

                $State->load('country');

                if (!empty($State)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'State' => $State
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'State does not exist'
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


    public function listStates(Request $request)
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
                $States = StateModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $StateList = $States->toArray();
            }else{
                $States = StateModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $StateList['data'] = $States->toArray();
            }

            
            if (!empty($StateList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'States' => $StateList,
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 401,
                        'success' => true,
                        'message' => 'Data not found'
                    ],
                    401
                );
            }
        }
    }


    public function addState(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'country_id' => 'required'
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

                $State_status = StateModel::where('country_id', $request->country_id)->first();

                if (!empty($State_status)) {
                    //State exists
                    return response()->json(
                        [
                            'status' => 409,
                            'success' => false,
                            'message' => 'State already exists'
                        ],
                        409
                    );
                } else {
                    $State = StateModel::create(
                        [
                            'name' => $request->name,
                            'country_id' => $request->country_id,
                        ]
                    );

                    if (!empty($State)) {

                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'State created successfully',
                                'State' => $State,
                            ],
                            200
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Error creating State',
                                'State' => $State,
                            ],
                            200
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

    public function editState(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required | numeric',
                    'name' => 'required',
                    'country_id' => 'nullable'
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

                $data = array_filter($request->all());

                $State = StateModel::find($request->id);

                if (!empty($State)) {

                    $State->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'State edited successfully',
                            'State' => $State
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'State not found',
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

    public function deleteState(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required | numeric',
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

                $State = StateModel::find($request->id);

                if (!empty($State)) {
                    $State->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'State deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'State not found',
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
}
