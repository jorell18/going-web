<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Models\SubCategoryModel;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    //
    public function getSubCategory(Request $request)
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

                $SubCategory = SubCategoryModel::find($request->id);
                $category = $SubCategory->category;

                if (!empty($SubCategory)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'SubCategory' => $SubCategory
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'SubCategory does not exist'
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


    public function listSubCategories(Request $request)
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
                $Categories = SubCategoryModel::where($filters)
                ->with('category')
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $SubCategoryList = $Categories->toArray();
            }else{
                $Categories = SubCategoryModel::where($filters)
                ->with('category')
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $SubCategoryList['data'] = $Categories->toArray();
            }

            
            if (!empty($SubCategoryList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'Categories' => $SubCategoryList,
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


    public function addSubCategory(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'category_id' => 'required',
                    'frequency' => 'nullable'
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

                $SubCategory_status = SubCategoryModel::where([
                    ['name','=',strtolower($request->name)],
                    ['category_id','=',$request->category_id]
                ])->first();

                if (!empty($SubCategory_status)) {
                    //SubCategory exists
                    return response()->json(
                        [
                            'status' => 409,
                            'success' => false,
                            'message' => 'SubCategory already exists'
                        ],
                        409
                    );
                } else {
                    $SubCategory = SubCategoryModel::create(
                        [
                            'name' => strtolower($request->name),
                            'category_id' => $request->category_id,
                            'frequency' => $request->frequency
                        ]
                    );

                    $category = $SubCategory->category;

                    if (!empty($SubCategory)) {

                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'SubCategory created successfully',
                                'SubCategory' => $SubCategory,
                            ],
                            200
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Error creating SubCategory',
                                'SubCategory' => $SubCategory,
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

    public function editSubCategory(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'name' => 'nullable',
                    'category_id' => 'nullable',
                    'frequency' => 'nullable'
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
                $SubCategory = SubCategoryModel::find($request->id);
                $existing = false;

                //check duplicate
                $existingRecord = SubCategoryModel::where([
                    ['name','=',$request->name],
                    ['category_id','=',$request->category_id]
                ]);

                if(!empty($existingRecord)){
                    $existing = true;
                } 

                //check if incoming change will create duplicate
                $existingRecord = SubCategoryModel::where([
                    ['name','=',$request->name],
                    ['category_id','=',$SubCategory->category_id]
                ]);


                if (!empty($SubCategory) && !$existing) {

                    $SubCategory->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'SubCategory edited successfully',
                            'SubCategory' => $SubCategory
                        ],
                        200
                    );
                } else if ($existing){
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'SubCategory already exists',
                        ],
                        401
                    );
                }else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'SubCategory not found',
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

    public function deleteSubCategory(Request $request)
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

                $SubCategory = SubCategoryModel::find($request->id);

                if (!empty($SubCategory)) {
                    $SubCategory->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'SubCategory deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'SubCategory not found',
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
