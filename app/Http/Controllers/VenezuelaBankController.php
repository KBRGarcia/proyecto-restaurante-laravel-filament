<?php

namespace App\Http\Controllers;

use App\Http\Resources\VenezuelaBankResource;
use App\Models\VenezuelaBank;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VenezuelaBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VenezuelaBank::query();

        // Búsqueda general
        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        // Filtro por estado activo
        if ($request->filled('active')) {
            $active = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);
            if ($active) {
                $query->active();
            } else {
                $query->inactive();
            }
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'code');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $banks = $query->paginate($request->get('per_page', 10))->withQueryString();

        return Inertia::render('venezuela-banks/index', [
            'banks' => VenezuelaBankResource::collection($banks),
            'columns' => VenezuelaBankResource::tableColumns(),
            'filters' => VenezuelaBankResource::filterFields(),
            'queryParams' => $request->only(['search', 'active', 'sort_by', 'sort_order', 'per_page']),
            'pagination' => [
                'current_page' => $banks->currentPage(),
                'last_page' => $banks->lastPage(),
                'per_page' => $banks->perPage(),
                'total' => $banks->total(),
                'from' => $banks->firstItem(),
                'to' => $banks->lastItem(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('venezuela-banks/create', [
            'formFields' => VenezuelaBankResource::formFields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            VenezuelaBank::rules(),
            VenezuelaBank::messages()
        );

        // Convertir active a boolean si viene como string
        if (isset($validated['active'])) {
            $validated['active'] = filter_var($validated['active'], FILTER_VALIDATE_BOOLEAN);
        }

        // Convertir creation_date a timestamp si viene
        if (isset($validated['creation_date'])) {
            $validated['creation_date'] = \Carbon\Carbon::parse($validated['creation_date']);
        }

        $bank = VenezuelaBank::create($validated);

        return redirect()
            ->route('venezuela-banks.show', $bank->id)
            ->with('success', 'Banco creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VenezuelaBank $venezuelaBank)
    {
        return Inertia::render('venezuela-banks/show', [
            'bank' => new VenezuelaBankResource($venezuelaBank),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VenezuelaBank $venezuelaBank)
    {
        return Inertia::render('venezuela-banks/edit', [
            'bank' => new VenezuelaBankResource($venezuelaBank),
            'formFields' => VenezuelaBankResource::formFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VenezuelaBank $venezuelaBank)
    {
        $validated = $request->validate(
            VenezuelaBank::rules($venezuelaBank->id),
            VenezuelaBank::messages()
        );

        // Convertir active a boolean si viene como string
        if (isset($validated['active'])) {
            $validated['active'] = filter_var($validated['active'], FILTER_VALIDATE_BOOLEAN);
        }

        // Convertir creation_date a timestamp si viene
        if (isset($validated['creation_date'])) {
            $validated['creation_date'] = \Carbon\Carbon::parse($validated['creation_date']);
        }

        $venezuelaBank->update($validated);

        return redirect()
            ->route('venezuela-banks.show', $venezuelaBank->id)
            ->with('success', 'Banco actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VenezuelaBank $venezuelaBank)
    {
        $venezuelaBank->delete();

        return redirect()
            ->route('venezuela-banks.index')
            ->with('success', 'Banco eliminado exitosamente.');
    }
}
