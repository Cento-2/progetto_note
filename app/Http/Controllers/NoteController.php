<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //recuperare elenco note dal database
        //$notes = DB::table('notes')->get();
        $notes = Note::all();

        $notes = Note::With('user')->paginate(10);



        return view('notes.index', ['notes' => $notes]);
        //return view('notes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $note = new Note();
        return view('notes.create', ['note' => $note]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required',
    ]);
    $note = new Note();
    $note->title = $request->input('title');
    $note->body = $request->input('body');
    $note->user_id = auth()->user()->id; // Associa la nota all'utente autenticato
    $note->save(); // Salva la nota nel database

    return redirect()->route('notes.index')->with('success', 'Nota creata con successo!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = Note::with(relations: 'user')->find(id: $id);

        if ($note == null) {
            return "Nota non trovata";
        }

        return view(view: 'notes.show', data: ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $note = Note::findOrFail($id); // Recupera la nota dal database
        return view('notes.edit', ['note' => $note]); // Passa la nota alla vista
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note = Note::findOrFail($id); // Recupera la nota dal database
        $note->title = $request->input('title');
        $note->body = $request->input('body');
        $note->save(); // Salva le modifiche

        return redirect()->route('notes.index')->with('success', 'Nota aggiornata con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::findOrFail($id); // Recupera la nota dal database
        $note->delete(); // Elimina la nota

        return redirect()->route('notes.index')->with('success', 'Nota eliminata con successo!');
    }
    public function __construct()
{
    $this->middleware('auth');
}
}
