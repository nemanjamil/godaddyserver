<?php

namespace App\Http\Controllers;
use Validator;
use App\Notes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NotesController extends BaseController
{

    public function index()
    {

        return $this->responseOk("All Ok", Notes::all());
        //return DB::table('notes')->get();
    }

    public function store(Request $request)
    {

      /*  $validatedData = $request->validate([
            'textnote' => 'required|max:255',
            'typenote' => 'required',
            //'title' => 'nullable'
        ]);*/

        $rules = array (
            'textnote' => 'required|max:255',
            'typenote' => 'required',
            'title' => 'nullable'

        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator-> fails()){

            //return $this->respondValidationError('Fields Validation Failed.', $validator->errors());
            return response()->json([
                'success' => false,
                'errors' =>  $validator->errors() ,
                'message' => "One field in not correct"
            ]);

        }

        $request['user_id'] = \Auth::user()->id;
        $request['active'] = 1;
        $request['color'] = 1;

        DB::beginTransaction();
        try {
            $noteId = DB::table('notes')->insertGetId($request->all());
            DB::commit();
            sleep(1);
            return response()->json([
                'success' => true,
                'message' => $noteId,
                'data' => Notes::find($noteId)
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => "Not Added"
                ]);

        }

    }


    public function show(Notes $notes, $id)
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

    public function notes(Notes $notes, $id)
    {
        $user = User::find(\Auth::id());
        $posts = $user->notestype($id)->get();
        return $this->responseOk("All Ok", $posts);
    }



    public function senttotrash(Notes $notes,Request $request)
    {
        $idnote = $request->input('id');
        //$user = User::find(\Auth::id());
        $notes = Notes::find($idnote);
        if (\Auth::user()->id == $notes->user_id)
        {
            // $notes = Notes::with('userget')->get(); kako ide upit za dati userid i dati post id
            $notes->active = 0;
            $notes->save();

            return $this->responseOk("All Ok", $notes);
        } else {
            return $this->responseNotValid("Not Ok, maybe this note not belong to user", $notes);
        }
    }

    public function sentbacktonotes(Notes $notes,Request $request)
    {
        $idnote = $request->input('id');
        //$user = User::find(\Auth::id());
        $notes = Notes::find($idnote);
        if (\Auth::user()->id == $notes->user_id)
        {
            $notes->active = 1;
            $notes->save();

            return $this->responseOk("All Ok", $notes);
        } else {
            return $this->responseNotValid("Not Ok, maybe this note not belong to user", $notes);
        }
    }

    public function updatecolor(Notes $notes,Request $request)
    {
        $idnote = $request->input('id');
        $idcolor = $request->input('color');

        $notes = Notes::find($idnote);
        if (\Auth::user()->id == $notes->user_id)
        {
            $notes->color = $idcolor;
            $notes->save();
            return $this->responseOk("All Ok", $notes);
        } else {
            return $this->responseNotValid("Not Ok, maybe this note not belong to user", $notes);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // 0
        $note = Notes::findOrFail($request->input('id'));
        $note->update($request->all());
        return $this->responseOK("ok",$note);

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


    public function destroy(Notes $notes,Request $request)
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
        $note = Notes::destroy($request->input('id'));
        return response()->json([
            'success' => true,
            'message' => 'Ok',
            'data' => $note ? 1 : 0
        ]);


    }
}
