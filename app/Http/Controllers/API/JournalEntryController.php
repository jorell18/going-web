<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Data\Models\JournalEntryModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JournalEntryController extends Controller
{
    //
    public function getJournalEntry(Request $request)
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

                $JournalEntry = JournalEntryModel::find($request->id);

                if (!empty($JournalEntry)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'success',
                            'JournalEntry' => $JournalEntry
                        ],
                        200
                    );
                } else {
                    return response()->json([
                        'status' => '401',
                        'message' => 'JournalEntry does not exist'
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


    public function listJournalEntries(Request $request)
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
                $JournalEntries = JournalEntryModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $JournalEntryList = $JournalEntries->toArray();
            }else{
                $JournalEntries = JournalEntryModel::where($filters)
                ->select($fields)
                ->latest()
                ->paginate($limit);
                $JournalEntryList['data'] = $JournalEntries->toArray();
            }

            if (!empty($JournalEntryList)) {
                return response()->json(
                    [
                        'request' => $request->getContent(),
                        'status' => 200,
                        'success' => true,
                        'JournalEntries' => $JournalEntryList,
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


    public function addJournalEntry(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'journal_id' => 'numeric | required',
                    'origin_id' => 'numeric | required',
                    'destination_id' => 'numeric | required',
                    'transportation_id' => 'numeric | nullable',
                    'sub_category_id' => 'numeric | required',
                    'start_time' => 'nullable',
                    'end_time' => 'nullable',
                    'activity_cost' => 'numeric | nullable',
                    'distance' => 'numeric | nullable',
                    'days' => 'numeric | nullable',
                    'nights' => 'numeric | nullable',
                    'is_checked_in' => 'numeric | nullable',
                    'title' => 'numeric | nullable',
                    'tag' => 'numeric | nullable',
                    'notes' => 'numeric | nullable'
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

                $JournalEntry = JournalEntryModel::create(
                    [
                        'journal_id' => $request->journal_id,
                        'origin_id' => $request->origin_id,
                        'destination_id' => $request->destination_id,
                        'transportation_id' => $request->transportation_id,
                        'sub_category_id' => $request->sub_category_id,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'activity_cost' => $request->activity_cost,
                        'transportation_cost' => $request->transportation_cost,
                        'distance' => $request->distance,
                        'days' => $request->days,
                        'nights' => $request->nights,
                        'is_checked_in' => $request->is_checked_in,
                        'title' => $request->title,
                        'tag' => $request->tag,
                        'notes' => $request->notes
                    ]
                );

                if (!empty($JournalEntry)) {

                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'JournalEntry created successfully',
                            'JournalEntry' => $JournalEntry,
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 200,
                            'success' => true,
                            'message' => 'Error creating JournalEntry',
                            'JournalEntry' => $JournalEntry,
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

    public function editJournalEntry(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => 'numeric | required',
                    'journal_id' => 'numeric | required',
                    'origin_id' => 'numeric | nullable',
                    'destination_id' => 'numeric | nullable',
                    'transportation_id' => 'numeric | nullable',
                    'sub_category_id' => 'numeric | nullable',
                    'start_time' => 'nullable',
                    'end_time' => 'nullable',
                    'activity_cost' => 'numeric | nullable',
                    'distance' => 'numeric | nullable',
                    'days' => 'numeric | nullable',
                    'nights' => 'numeric | nullable',
                    'is_checked_in' => 'numeric | nullable',
                    'title' => 'numeric | nullable',
                    'tag' => 'numeric | nullable',
                    'notes' => 'numeric | nullable'
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

                $JournalEntry = JournalEntryModel::find($request->id);

                if (!empty($JournalEntry)) {

                    $JournalEntry->update($data);

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'JournalEntry edited successfully',
                            'JournalEntry' => $JournalEntry
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'JournalEntry not found',
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

    public function deleteJournalEntry(Request $request)
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

                $JournalEntry = JournalEntryModel::find($request->id);

                if (!empty($JournalEntry)) {
                    $JournalEntry->delete();

                    return response()->json(
                        [
                            'status' => 200,
                            'message' => 'JournalEntry deleted successfully',
                            'id' => $request->id
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => 401,
                            'message' => 'JournalEntry not found',
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
