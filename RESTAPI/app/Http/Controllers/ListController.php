<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\LoginToken;
use App\Models\BoardMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {

        $board = Board::find($id);
        $validate = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'messsage' => 'Invalid field.',
            ], 422);
        }

        $order = BoardList::where('board_id', $board->id)->count() + 1;
        BoardList::create([
            'name' => $request->name,
            'board_id' => $board->id,
            'order' => $order
        ]);

        return response()->json([
            'message' => 'Create list success',
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $list = BoardList::find($id);

        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Invalid field.'
            ], 422);
        }

        BoardList::where('id', $id)->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Update list success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BoardList::where('id', $id)->delete();

        return response()->json([
            'message' => 'Delete list success.'
        ], 200);
    }

    public function moveRight(Request $request, string $id, $id2) {

        $currentList = BoardList::where('id', $id)->where('board_id', $id2)->first();
        $list = BoardList::where('board_id', $id2)->where('order', $currentList->order + 1)->first();

        $sekarangOrder = $currentList->order;
        $currentList->order = $list->order;
        $list->order = $sekarangOrder;

        $currentList->save();
        $list->save();

        return response()->json([
            'message' => 'Move success'
        ], 200);
    }

    public function moveLeft(Request $request, string $id, $id2) {

        $currentList = BoardList::where('id', $id)->where('board_id', $id2)->first();
        $list = BoardList::where('board_id', $id2)->where('order', $currentList->order - 1)->first();

        $sekarangOrder = $currentList->order;
        $currentList->order = $list->order;
        $list->order = $sekarangOrder;

        $currentList->save();
        $list->save();

        return response()->json([
            'message' => 'Move success'
        ], 200);
    }
}
