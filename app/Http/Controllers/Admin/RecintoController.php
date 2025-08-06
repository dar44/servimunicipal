<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recinto;
use Illuminate\Http\Request;

class RecintoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recintos = Recinto::orderBy("name", "asc")->paginate(10);
        return view("admin.recintos.index", compact("recintos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.recintos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'ubication' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'state' => 'required|boolean',
        ]);

        Recinto::create($validated);

        return redirect()->route('admin.recintos.index')->with('success', 'Recinto creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Recinto $recinto)
    {
        return view('admin.recintos.show', compact('recinto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recinto $recinto)
    {
        return view('admin.recintos.edit', compact('recinto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recinto $recinto)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'ubication' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'state' => 'required|boolean',
        ]);

        $recinto->update($validated);

        return redirect()->route('admin.recintos.index')->with('success', 'Recinto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recinto $recinto)
    {
        $recinto->delete();
        //$recintos = Recinto::orderBy("name","desc")->paginate(10);
        return redirect()->route("admin.recintos.index")->with('success', 'Recinto eliminado correctamente.');
    }
}
