<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        // Búsqueda general
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $categories = $query->paginate($request->get('per_page', 10))->withQueryString();

        return Inertia::render('categories/index', [
            'categories' => CategoryResource::collection($categories),
            'columns' => CategoryResource::tableColumns(),
            'filters' => CategoryResource::filterFields(),
            'queryParams' => $request->only(['search', 'status', 'sort_by', 'sort_order', 'per_page']),
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('categories/create', [
            'fields' => CategoryResource::formFields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Category::rules(), Category::messages());

        // Manejar la imagen si se proporciona
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
            $validated['image'] = 'data:' . $image->getMimeType() . ';base64,' . $imageData;
        }

        $category = Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return Inertia::render('categories/show', [
            'category' => (new CategoryResource($category))->resolve(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('categories/edit', [
            'category' => (new CategoryResource($category))->resolve(),
            'fields' => CategoryResource::formFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = Category::rules(true);

        $validated = $request->validate($rules, Category::messages());

        // Manejar la imagen si se proporciona
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
            $validated['image'] = 'data:' . $image->getMimeType() . ';base64,' . $imageData;
        }

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }

    /**
     * Get form configuration.
     */
    public function getFormConfig()
    {
        return response()->json([
            'fields' => CategoryResource::formFields(),
        ]);
    }

    /**
     * Get table configuration.
     */
    public function getTableConfig()
    {
        return response()->json([
            'columns' => CategoryResource::tableColumns(),
            'filters' => CategoryResource::filterFields(),
        ]);
    }
}
