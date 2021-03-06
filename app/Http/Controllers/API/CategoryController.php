<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\CategoryModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function getCategory(Request $request)
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

                $Category = CategoryModel::where('id',$request->id)->with('subCategories');

                if (!empty($Category)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'Category' => $Category
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'Category does not exist'
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


    public function listCategories(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'filters' => 'nullable | array',
                'limit' => 'nullable | numeric',
                'fields' => 'nullable | array',
                'sort' => 'nullable | array',
                'search' => 'nullable | string',
                'paginate' => 'nullable | boolean',
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
                $Categories = CategoryModel::where($filters)
                ->with('subCategories')
                ->select($fields)
                ->latest()
                ->paginate($limit);

                $CategoryList = $Categories->toArray();

            }else{
                $Categories = CategoryModel::where($filters)
                ->with('subCategories')
                ->select($fields)
                ->latest()
                ->get();

                $CategoryList['data'] = $Categories->toArray();
            }
            

            if(!empty($request))

            

            if (!empty($CategoryList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'Categories' => $CategoryList,
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


    public function addCategory(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
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

                $Category_status = CategoryModel::where('name', strtolower($request->name))->first();

                if (!empty($Category_status)) {
                    //Category exists
                    return response()->json(
                        [
                            'status' => 409,
                            'success' => false,
                            'message' => 'Category already exists'
                        ],
                        409
                    );
                } else {
                    $Category = CategoryModel::create(
                        [
                            'name' => strtolower($request->name) 
                        ]
                    );

                    if (!empty($Category)) {

                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Category created successfully',
                                'Category' => $Category,
                            ],
                            200
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Error creating Category',
                                'Category' => $Category,
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

    public function editCategory(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required | numeric',
                    'name' => 'required'
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

                $Category = CategoryModel::find($request->id);

                if (!empty($Category)) {

                    $Category->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Category edited successfully',
                            'Category' => $Category
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Category not found',
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

    public function deleteCategory(Request $request)
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

                $Category = CategoryModel::find($request->id);

                if (!empty($Category)) {
                    $Category->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Category deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Category not found',
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
