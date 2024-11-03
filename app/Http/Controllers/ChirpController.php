<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Inertia\Inertia;
use Inertia\Response;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        // Eager load chirp's associated user's id and name
        // Latest scope to sort by latest
        $chirps = \App\Models\Chirp::with('user:id,name')->latest()->get();
        return Inertia::render('Chirps/Index', [
            'chirps' => $chirps // must be defined as prop in component, tru defineProps()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        // Create row in db
        // Record belongs to logged in user, through chirps relation ( need to define )
        $request->user()->chirps()->create($validated);
        
        return redirect( route('chirps.index') );
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //
    }
}
