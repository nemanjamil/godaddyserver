<?php

namespace App\Http\Controllers;

use App\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Notes::all();
        //return DB::table('notes')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            $noteId = DB::table('notes')->insertGetId($request->all());
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ok',
                'data' => $noteId
            ]);
        } catch (\Exception $e) {
            DB::rollback();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function show(Notes $notes,$id)
    {
        $note = Notes::find($id);
        if ($note) {
            return response()->json([
                'success' => true,
                'message' => 'Ok',
                'data' => $note
            ]);
        } else {
            echo "Nema";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function edit(Notes $notes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 0
        $note = Notes::findOrFail($id);
        $note->update($request->all());
        return $note;

        // 1
        /*$note = Notes::find($id);
        $note->title = $request->title;
        $note->textnote = $request->textnote;
        $note->typenote = $request->typenote;
        $note->active = $request->active;
        $note->color = $request->color;
        $note->save();*/

        // 2
        /*DB::beginTransaction();
        try {
            $noteId = DB::table('notes')->where('id', $id)->update($request->all());
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ok',
                'data' => $noteId
            ]);
        } catch (\Exception $e) {
            DB::rollback();
        }*/


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notes $notes, $id)
    {

        // verzija 1
        /*$nerd = Notes::find($id);
        if ($nerd) {
            $nerd->delete();
            echo 'da';
        } else {
            echo 'ne';
        }*/

        // verzija 2
        $note = Notes::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Ok',
            'data' => $note ? 1 : 0
        ]);


    }
}
