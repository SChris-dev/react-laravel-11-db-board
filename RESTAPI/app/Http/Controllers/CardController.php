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

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id, string $id2)
    {   
        $list = BoardList::find($id2);
        $validate = Validator::make($request->all(), [
            'task' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Invalid field'
            ], 422);
        }

        $order = Card::where('list_id', $list->id)->count() + 1;

        Card::create([
            'task' => $request->task,
            'list_id' => $list->id,
            'order' => $order,
        ]);

        return response()->json([
            'message' => 'Create card success',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $id2, string $id3) 
    {
        $card = Card::find($id3);

        $validate = Validator::make($request->all(), [
            'task' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Invalid field.'
            ]);
        }

        Card::where('id', $id3)->update([
            'task' => $request->task,
        ], 422);

        return response()->json([
            'message' => 'Update card success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, string $id2, string $id3)
    {
        $card = Card::find($id3);

        Card::where('id', $id3)->delete();

        return response()->json([
            'message' => 'Delete card success'
        ], 200);
    }

    public function moveUp(string $id) {
        $currentCard = Card::find($id);
        $list = $currentCard->list_id;
        $card = Card::where('list_id', $list)->where('order', $currentCard->order - 1)->first();

        $sekarangOrder = $currentCard->order;
        $currentCard->order = $card->order;
        $card->order = $sekarangOrder;

        $currentCard->save();
        $card->save();

        return response()->json([
            'message' => 'Move success'
        ], 200);
    }

    public function moveDown(string $id) {
        $currentCard = Card::find($id);
        $list = $currentCard->list_id;
        $card = Card::where('list_id', $list)->where('order', $currentCard->order + 1)->first();

        $sekarangOrder = $currentCard->order;
        $currentCard->order = $card->order;
        $card->order = $sekarangOrder;

        $currentCard->save();
        $card->save();

        return response()->json([
            'message' => 'Move success'
        ], 200);
    }

    public function moveList(string $id, string $id2) {

        $card = Card::find($id);
        $list = BoardList::find($id2);
        $currentList = BoardList::find($card->list_id);
        if ($currentList->board_id !== $list->board_id) {
            return response()->json([
                'message' => 'Move list invalid'
            ]. 422);
        }

        $order = Card::where('list_Id', $list->id)->max('order') ?? 0;
        $card->list_id = $list->id;
        $card->order = $order + 1;
        $card->save();

        return response()->json([
            'message' => 'Move success.'
        ], 200);

    }
}
