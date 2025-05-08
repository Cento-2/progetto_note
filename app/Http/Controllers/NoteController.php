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
    public function index()
    {
        $notes = Note::with('user')->paginate(10); // Recupera le note con paginazione (10 per pagina)
        return view('notes.index', compact('notes'));
    }
    public function search(Request $request)
    {
        $query = $request->input('search');

        $notes = Note::where('title', 'like', "%$query%")
            ->orWhere('body', 'like', "%$query%")
            ->paginate(10);

        if ($notes->isEmpty()) {
            $request->session()->flash('error', 'Nessuna nota trovata per: "' . $query . '"');
        }

        return view('notes.index', compact('notes', 'query'));
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
        $max_side = (int) ini_get('upload_max_filesize');

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:' . $max_side, // Limite di dimensione in KB
            ]
        ]);
        $file = $request->file('image');
       $file_path = $request->file('image')->store('upload', 'public');

        if (!$request->file('image')->isValid()) {
            return back()->with('error', 'Immagine non trovata') ->with('image', $filePath);
        }
        


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
    public function trashed()
    {
        $note = Note::onlyTrashed()->paginate(10); // Recupera le note eliminate con paginazione
        return view('notes.trash', ['notes' => $note]);
    }
    public function restore($id)
    {
        $note = Note::withTrashed()->findOrFail($id);
        $note->restore(); // Ripristina la nota
        return redirect()->route('notes.index')->with('success', 'Nota ripristinata con successo!');
    }

}
