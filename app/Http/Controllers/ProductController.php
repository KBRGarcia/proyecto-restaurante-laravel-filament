<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Búsqueda general
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por productos especiales
        if ($request->filled('is_special')) {
            $query->where('is_special', $request->is_special);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $products = $query->paginate($request->get('per_page', 10))->withQueryString();

        // Obtener categorías para los filtros
        $categories = Category::active()->ordered()->get()->map(function ($category) {
            return [
                'value' => $category->id,
                'label' => $category->name,
            ];
        });

        // Agregar opciones de categorías a los filtros
        $filters = ProductResource::filterFields();
        foreach ($filters as &$filter) {
            if ($filter['name'] === 'category_id') {
                $filter['options'] = array_merge(
                    [['value' => '', 'label' => 'Todas las categorías']],
                    $categories->toArray()
                );
            }
        }

        return Inertia::render('products/index', [
            'products' => ProductResource::collection($products),
            'columns' => ProductResource::tableColumns(),
            'filters' => $filters,
            'queryParams' => $request->only(['search', 'category_id', 'status', 'is_special', 'sort_by', 'sort_order', 'per_page']),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener categorías activas para el select
        $categories = Category::active()->ordered()->get()->map(function ($category) {
            return [
                'value' => $category->id,
                'label' => $category->name,
            ];
        });

        // Agregar opciones de categorías a los campos del formulario
        $fields = ProductResource::formFields();
        foreach ($fields as &$field) {
            if ($field['name'] === 'category_id') {
                $field['options'] = $categories->toArray();
            }
        }

        return Inertia::render('products/create', [
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Product::rules(), Product::messages());

        // Manejar la imagen si se proporciona
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
            $validated['image'] = 'data:' . $image->getMimeType() . ';base64,' . $imageData;
        }

        // Establecer fecha de creación del producto
        $validated['creation_date'] = now();

        // Manejar checkbox is_special
        $validated['is_special'] = $request->has('is_special') ? (bool) $request->is_special : false;

        $product = Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');

        return Inertia::render('products/show', [
            'product' => (new ProductResource($product))->resolve(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('category');

        // Obtener categorías activas para el select
        $categories = Category::active()->ordered()->get()->map(function ($category) {
            return [
                'value' => $category->id,
                'label' => $category->name,
            ];
        });

        // Agregar opciones de categorías a los campos del formulario
        $fields = ProductResource::formFields();
        foreach ($fields as &$field) {
            if ($field['name'] === 'category_id') {
                $field['options'] = $categories->toArray();
            }
        }

        return Inertia::render('products/edit', [
            'product' => (new ProductResource($product))->resolve(),
            'fields' => $fields,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = Product::rules(true);

        $validated = $request->validate($rules, Product::messages());

        // Manejar la imagen si se proporciona
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
            $validated['image'] = 'data:' . $image->getMimeType() . ';base64,' . $imageData;
        }

        // Manejar checkbox is_special
        $validated['is_special'] = $request->has('is_special') ? (bool) $request->is_special : false;

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Get form configuration.
     */
    public function getFormConfig()
    {
        // Obtener categorías activas
        $categories = Category::active()->ordered()->get()->map(function ($category) {
            return [
                'value' => $category->id,
                'label' => $category->name,
            ];
        });

        // Agregar opciones de categorías a los campos
        $fields = ProductResource::formFields();
        foreach ($fields as &$field) {
            if ($field['name'] === 'category_id') {
                $field['options'] = $categories->toArray();
            }
        }

        return response()->json([
            'fields' => $fields,
        ]);
    }

    /**
     * Get table configuration.
     */
    public function getTableConfig()
    {
        return response()->json([
            'columns' => ProductResource::tableColumns(),
            'filters' => ProductResource::filterFields(),
        ]);
    }
}
