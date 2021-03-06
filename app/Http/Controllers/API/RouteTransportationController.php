<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\RouteTransportationModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RouteTransportationController extends Controller
{
    //
    public function getRouteTransportation(Request $request)
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

                $RouteTransportation = RouteTransportationModel::find($request->id);

                if (!empty($RouteTransportation)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'RouteTransportation' => $RouteTransportation
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'RouteTransportation does not exist'
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


    public function listRouteTransportations(Request $request)
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
                $RouteTransportations = RouteTransportationModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $RouteTransportationList = $RouteTransportations->toArray();
            }else{
                $RouteTransportations = RouteTransportationModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $RouteTransportationList['data'] = $RouteTransportations->toArray();
            }

            if (!empty($RouteTransportationList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'RouteTransportations' => $RouteTransportationList,
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


    public function addRouteTransportation(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'route_id' => 'required',
                    'transportation_id' => 'required'
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

                $RouteTransportation = RouteTransportationModel::create(
                    [
                        'route_id' => $request->route_id,
                        'transportation_id' => $request->transportation_id
                    ]
                );

                if (!empty($RouteTransportation)) {

                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'RouteTransportation created successfully',
                            'RouteTransportation' => $RouteTransportation,
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Error creating RouteTransportation',
                            'RouteTransportation' => $RouteTransportation,
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

    public function editRouteTransportation(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'route_id' => 'nullable',
                    'transportation_id' => 'nullable'
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

                $RouteTransportation = RouteTransportationModel::find($request->id);

                if (!empty($RouteTransportation)) {

                    $RouteTransportation->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'RouteTransportation edited successfully',
                            'RouteTransportation' => $RouteTransportation
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'RouteTransportation not found',
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

    public function deleteRouteTransportation(Request $request)
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

                $RouteTransportation = RouteTransportationModel::find($request->id);

                if (!empty($RouteTransportation)) {
                    $RouteTransportation->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'RouteTransportation deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'RouteTransportation not found',
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
