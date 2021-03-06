<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\RouteModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    //
    public function getRoute(Request $request)
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

                $Route = RouteModel::find($request->id);

                if (!empty($Route)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'Route' => $Route
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'Route does not exist'
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


    public function listRoutes(Request $request)
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
                $Routes = RouteModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $RouteList = $Routes->toArray();
            }else{
                $Routes = RouteModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $RouteList['data'] = $Routes->toArray();
            }

            
            if (!empty($RouteList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'Routes' => $RouteList,
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


    public function addRoute(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'origin_id' => 'required',
                    'destination_id' => 'required',
                    'frequency' => 'nullable',
                    'transportation_id' => 'nullable',
                    'subcategory' => 'required'
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

                $Route = RouteModel::create(
                    [
                        'origin_id' => $request->origin_id,
                        'destination_id' => $request->destination_id,
                        'frequency' => $request->frequency,
                        'transportation_id' => $request->transportation_id,
                        'subcategory' => $request->subcategory,
                    ]
                );

                if (!empty($Route)) {

                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Route created successfully',
                            'Route' => $Route,
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Error creating Route',
                            'Route' => $Route,
                        ],
                        200
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

    public function editRoute(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'origin_id' => 'nullable',
                    'destination_id' => 'nullable',
                    'frequency' => 'nullable',
                    'transportation_id' => 'nullable',
                    'subcategory' => 'nullable'
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

                $Route = RouteModel::find($request->id);

                if (!empty($Route)) {

                    $Route->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Route edited successfully',
                            'Route' => $Route
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Route not found',
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

    public function deleteRoute(Request $request)
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

                $Route = RouteModel::find($request->id);

                if (!empty($Route)) {
                    $Route->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Route deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Route not found',
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
