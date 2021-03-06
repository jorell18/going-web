<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\RouteSubcategoryModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RouteSubcategoryController extends Controller
{
    //
    public function getRouteSubcategory(Request $request)
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

                $RouteSubcategory = RouteSubcategoryModel::find($request->id);

                if (!empty($RouteSubcategory)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'RouteSubcategory' => $RouteSubcategory
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'RouteSubcategory does not exist'
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


    public function listRouteSubcategorys(Request $request)
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
                $RouteSubcategorys = RouteSubcategoryModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $RouteSubcategoryList = $RouteSubcategorys->toArray();
            }else{
                $RouteSubcategorys = RouteSubcategoryModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $RouteSubcategoryList['data'] = $RouteSubcategorys->toArray();
            }

            if (!empty($RouteSubcategoryList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'RouteSubcategorys' => $RouteSubcategoryList,
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


    public function addRouteSubcategory(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'route_id' => 'required',
                    'sub_category_id' => 'required'
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

                $RouteSubcategory = RouteSubcategoryModel::create(
                    [
                        'route_id' => $request->route_id,
                        'sub_category_id' => $request->sub_category_id
                    ]
                );

                if (!empty($RouteSubcategory)) {

                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'RouteSubcategory created successfully',
                            'RouteSubcategory' => $RouteSubcategory,
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Error creating RouteSubcategory',
                            'RouteSubcategory' => $RouteSubcategory,
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

    public function editRouteSubcategory(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'route_id' => 'nullable',
                    'sub_category_id' => 'nullable'
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

                $RouteSubcategory = RouteSubcategoryModel::find($request->id);

                if (!empty($RouteSubcategory)) {

                    $RouteSubcategory->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'RouteSubcategory edited successfully',
                            'RouteSubcategory' => $RouteSubcategory
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'RouteSubcategory not found',
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

    public function deleteRouteSubcategory(Request $request)
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

                $RouteSubcategory = RouteSubcategoryModel::find($request->id);

                if (!empty($RouteSubcategory)) {
                    $RouteSubcategory->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'RouteSubcategory deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'RouteSubcategory not found',
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
