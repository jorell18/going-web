<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\PlaceModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    //
    public function getPlace(Request $request)
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

                $Place = PlaceModel::find($request->id);

                if (!empty($Place)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'Place' => $Place
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'Place does not exist'
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


    public function listPlaces(Request $request)
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
                $Places = PlaceModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $PlaceList = $Places->toArray();
            }else{
                $Places = PlaceModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $PlaceList['data'] = $Places->toArray();    
            }


            if (!empty($PlaceList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'Places' => $PlaceList,
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


    public function addPlace(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'sub_category_id' => 'required',
                    'state_id' => 'required',
                    'address' => 'required',
                    'latitude' => 'nullable',
                    'longitude' => 'nullable',
                    'frequency' => 'nullable',
                    'average_cost' => 'nullable'
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

                $Place_status = PlaceModel::where('country_id', $request->country_id)->first();

                if (!empty($Place_status)) {
                    //Place exists
                    return response()->json(
                        [
                            'status' => 409,
                            'success' => false,
                            'message' => 'Place already exists'
                        ],
                        409
                    );
                } else {
                    $Place = PlaceModel::create(
                        [
                            'name' => $request->name
                        ]
                    );

                    if (!empty($Place)) {

                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Place created successfully',
                                'Place' => $Place,
                            ],
                            200
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Error creating Place',
                                'Place' => $Place,
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

    public function editPlace(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'sub_category_id' => 'required',
                    'state_id' => 'required',
                    'address' => 'required',
                    'latitude' => 'nullable',
                    'longitude' => 'nullable',
                    'frequency' => 'nullable',
                    'average_cost' => 'nullable'
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

                $Place = PlaceModel::find($request->id);

                if (!empty($Place)) {

                    $Place->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Place edited successfully',
                            'Place' => $Place
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Place not found',
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

    public function deletePlace(Request $request)
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

                $Place = PlaceModel::find($request->id);

                if (!empty($Place)) {
                    $Place->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Place deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Place not found',
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
