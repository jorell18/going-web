<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\ItineraryModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ItineraryController extends Controller
{
    //
    public function getItinerary(Request $request)
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

                $Itinerary = ItineraryModel::find($request->id);

                if (!empty($Itinerary)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'Itinerary' => $Itinerary
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'Itinerary does not exist'
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


    public function listItinerarys(Request $request)
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
                $Itineraries = ItineraryModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $ItineraryList = $Itineraries->toArray();
            }else{
                $Itineraries = ItineraryModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $ItineraryList['data'] = $Itineraries->toArray();
            }


            if (!empty($ItineraryList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'Itineraries' => $ItineraryList,
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


    public function addItinerary(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'traveler_id' => 'uuid | required',
                    'sate_origin_id' => 'numeric | required',
                    'state_destination_id' => 'numeric | required',
                    'total_cost' => 'numeric | nullable',
                    'title' => 'string | required',
                    'start_date' => 'nullable',
                    'end_date' => 'nullable',
                    'published' => 'required',
                    'number_of_days' => 'numeric | nullable'
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

                $Itinerary = ItineraryModel::create(
                    [
                        'traveler_id' => $request->traveler_id,
                        'sate_origin_id' => $request->sate_origin_id,
                        'state_destination_id' => $request->state_destination_id,
                        'total_cost' => $request->total_cost,
                        'title' => $request->title,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'published' => $request->published,
                        'number_of_days' => $request->number_of_days
                    ]
                );

                if (!empty($Itinerary)) {

                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Itinerary created successfully',
                            'Itinerary' => $Itinerary,
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Error creating Itinerary',
                            'Itinerary' => $Itinerary,
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

    public function editItinerary(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                    'sate_origin_id' => 'numeric | nullable',
                    'state_destination_id' => 'numeric | nullbable',
                    'total_cost' => 'numeric | nullable',
                    'title' => 'string | nullbable',
                    'start_date' => 'nullable',
                    'end_date' => 'nullable',
                    'published' => 'nullbable',
                    'number_of_days' => 'numeric | nullable'
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

                $Itinerary = ItineraryModel::find($request->id);

                if (!empty($Itinerary)) {

                    $Itinerary->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Itinerary edited successfully',
                            'Itinerary' => $Itinerary
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Itinerary not found',
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

    public function deleteItinerary(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'required | numeric'
                    
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

                $Itinerary = ItineraryModel::find($request->id);

                if (!empty($Itinerary)) {
                    $Itinerary->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Itinerary deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Itinerary not found',
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
