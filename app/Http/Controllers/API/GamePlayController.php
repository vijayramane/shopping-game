<?php

namespace App\Http\Controllers\API;

use App\Models\GamePlay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GamePlayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gamePlay = GamePlay::paginate();

        if ($gamePlay) {
            return response()->json($gamePlay, 200);
        } else {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $validatedData = $request->validate([
            'location' => 'required|string|max:64',
            'scene' => 'required|string|max:64',
            'right_attempt' => 'nullable|integer',
            'wrong_attempt' => 'nullable|integer',
            // 'total_attempt' => 'nullable|integer',
            'total_time' => 'nullable|integer',
        ]);

        $gamePlay = new GamePlay();
        $gamePlay->location = $request->location;
        $gamePlay->scene = $request->scene;
        $gamePlay->right_attempt = $request->right_attempt;
        $gamePlay->wrong_attempt = $request->wrong_attempt;
        $gamePlay->total_attempt = $request->right_attempt + $request->wrong_attempt;
        $gamePlay->total_time = $request->total_time;
        $gamePlay->save();

        if ($gamePlay) {
            return response()->json($gamePlay, 201);
        } else {
            return response()->json(['error' => 'Game Play not created'], 400);
        }

        return response()->json(['error' => 'Game Play not created'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get game play by id
        $gamePlay = GamePlay::find($id);

        if ($gamePlay) {
            return response()->json($gamePlay, 200);
        } else {
            return response()->json(['error' => 'Game Play not found'], 404);
        }

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate request
        $validatedData = $request->validate([
            'location' => 'nullable|string|max:64',
            'scene' => 'nullable|string|max:64',
            'right_attempt' => 'nullable|integer',
            'wrong_attempt' => 'nullable|integer',
            // 'total_attempt' => 'nullable|integer',
            'total_time' => 'nullable|integer',
        ]);

        // get game play by id
        $gamePlay = GamePlay::find($id);

        if ($gamePlay) {
            // update game play
            $gamePlay->location = $request->location;
            $gamePlay->scene = $request->scene;
            $gamePlay->right_attempt = $request->right_attempt;
            $gamePlay->wrong_attempt = $request->wrong_attempt;
            $gamePlay->total_attempt = $request->right_attempt + $request->wrong_attempt;
            $gamePlay->total_time = $request->total_time;
            $gamePlay->save();

            return response()->json($gamePlay, 200);
        } else {
            return response()->json(['error' => 'Game Play not found'], 404);
        }

        return response()->json(['error' => 'Something went wrong'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get game play by id
        $gamePlay = GamePlay::find($id);

        if ($gamePlay) {
            $gamePlay->delete();

            return response()->json(['success' => 'Game Play deleted'], 204);
        } else {
            return response()->json(['error' => 'Game Play not found'], 404);
        }

        return response()->json(['error' => 'Something went wrong'], 500);
    }
}
