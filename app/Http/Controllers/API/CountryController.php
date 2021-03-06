<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\CountryModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function getCountry(Request $request)
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

                $Country = CountryModel::find($request->id);

                if (!empty($Country)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'Country' => $Country
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'Country does not exist'
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


    public function listCountries(Request $request)
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
                $Countries = CountryModel::where($filters)
                ->with('states')
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $CountryList = $Countries->toArray();
            }else{
                $Countries = CountryModel::where($filters)
                ->with('states')
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $CountryList['data'] = $Countries->toArray();

            }

           

            if (!empty($CountryList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'Countries' => $CountryList,
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


    public function addCountry(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'country_code' => 'required'
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

                $Country_status = CountryModel::where('country_code', $request->country_code)->first();

                if (!empty($Country_status)) {
                    //Country exists
                    return response()->json(
                        [
                            'status' => 409,
                            'success' => false,
                            'message' => 'Country already exists'
                        ],
                        409
                    );
                } else {
                    $Country = CountryModel::create(
                        [
                            'name' => $request->name,
                            'country_code' => $request->country_code,
                        ]
                    );

                    if (!empty($Country)) {

                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Country created successfully',
                                'Country' => $Country,
                            ],
                            200
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => 200,
                                'success' => true,
                                'message' => 'Error creating country',
                                'Country' => $Country,
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

    public function editCountry(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required | numeric',
                    'name' => 'required',
                    'country_code' => 'required'
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

                $Country = CountryModel::find($request->id);

                if (!empty($Country)) {

                    $Country->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Country edited successfully',
                            'Country' => $Country
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Country not found',
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

    public function deleteCountry(Request $request)
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

                $Country = CountryModel::find($request->id);

                if (!empty($Country)) {
                    $Country->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Country deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Country not found',
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
