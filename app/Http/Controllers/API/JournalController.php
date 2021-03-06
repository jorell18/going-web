<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\JournalModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
{
    //
    public function getJournal(Request $request)
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

                $Journal = JournalModel::find($request->id);

                if (!empty($Journal)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'Journal' => $Journal
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'Journal does not exist'
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


    public function listJournals(Request $request)
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
                $Journals = JournalModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $JournalList = $Journals->toArray();
            }else{
                $Journals = JournalModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $JournalList['data'] = $Journals->toArray();
            }

            if (!empty($JournalList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'Journals' => $JournalList,
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


    public function addJournal(Request $request)
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

                $Journal = JournalModel::create(
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

                if (!empty($Journal)) {

                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Journal created successfully',
                            'Journal' => $Journal,
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Error creating Journal',
                            'Journal' => $Journal,
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

    public function editJournal(Request $request)
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

                $Journal = JournalModel::find($request->id);

                if (!empty($Journal)) {

                    $Journal->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Journal edited successfully',
                            'Journal' => $Journal
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Journal not found',
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

    public function deleteJournal(Request $request)
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

                $Journal = JournalModel::find($request->id);

                if (!empty($Journal)) {
                    $Journal->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'Journal deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'Journal not found',
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
