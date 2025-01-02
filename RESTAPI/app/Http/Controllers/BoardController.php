<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\LoginToken;
use App\Models\BoardMember;
use App\Models\Card;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Board::get();

        return response()->json([
            'data' => $boards,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $token = Request()->token;
        $user = LoginToken::where('token', $token)->get()->first()->user_id;

        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Invalid field.'
            ], 422);
        }
        
        Board::create([
            'creator_id' => $user,
            'name' => $request->name
        ], 200);


        return response()->json([
            'message' => 'Create board success.'
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $board = Board::find($id);

        // Transform the data into the desired structure
        $response = [
            'id' => $board->id,
            'name' => $board->name,
            'creator_id' => $board->creator_id,
            'members' => $board->board_members->map(function ($member) {
                return [
                    'id' => $member->user->id,
                    'first_name' => $member->user->first_name,
                    'last_name' => $member->user->last_name,
                    'initial' => strtoupper(substr($member->user->first_name, 0, 1) . substr($member->user->last_name, 0, 1)),
                ];
            }),
            'lists' => $board->board_lists->map(function ($list) {
                return [
                    'id' => $list->id,
                    'name' => $list->name,
                    'order' => $list->order,
                    'cards' => $list->cards->map(function ($card) {
                        return [
                            'card_id' => $card->id,
                            'task' => $card->task,
                            'order' => $card->order,
                        ];
                    }),
                ];
            }),
        ];

        return response()->json($response);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $board = Board::find($id);

        $validate = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Invalid field.'
            ], 422);
        }

        Board::where('name', $board->name)->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Update board success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $board = Board::find($id);

        Board::where('id', $id)->delete();

        return response()->json([
            'message' => 'Delete board success.'
        ]);
    }

    public function storeMember(Request $request, string $id) {

        $board = Board::find($id);

        $token = Request()->token;
        $user = LoginToken::where('token', $token)->first()->user_id;
        
        $validate = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
        ]);
        
        if ($validate->fails()) {
            return response()->json([
                'message' => 'User did not exist.'
            ], 422);
        }

        $member = User::where('username', $request->username)->first();

        BoardMember::create([
            'board_id' => $board->id,
            'user_id' => $member->id,
        ]);

        return response()->json([
            'message' => 'Add member success.',
        ], 200);
    }

    public function destroyMember(string $id) {
        $member = BoardMember::find($id);

        BoardMember::where('id', $id)->delete();

        return response()->json([
            'message' => 'Remove member success.',
        ]);
    }
}
