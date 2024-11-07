<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $notes = Note::where('user_id',$user_id)->latest()->paginate(5);
        return view('notes.index')->with('notes',$notes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $notebooks = Notebook::where('user_id',Auth::id())->get();
        return view('notes.create')->with('notebooks',$notebooks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|max:120",
            "description" => "required"
        ]);

        $note = new Note ([
            'user_id' => Auth::id(),
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'description' => $request->description,
            'notebook_id' => $request->notebook_id
        ]);

        $note->save();

        return to_route("notes.show", $note);

    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if ($note->user_id !== Auth::id()){
            abort(403);
        };

        return view('notes.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()){
            abort(403);
        };
        
        $notebooks = Notebook::where('user_id',Auth::id())->get();
        return view('notes.edit', ['note' => $note, 'notebooks' => $notebooks]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            "title" => "required|max:120",
            "description" => "required"
        ]);

        if ($note->user_id !== Auth::id()){
            abort(403);
        };

        $note->update([
            'title' => $request->title,
            'description' => $request->description,
            'notebook_id' => $request->notebook_id
        ]);

        return to_route('notes.show', $note)
        ->with('success','Changes Saved successfully...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()){
            abort(403);
        };

        $note->delete();

        return to_route('notes.index')
        ->with('success', 'Note was moved to trash successfylly...');

    }
}
