<?php

namespace App\Http\Controllers;

use App\Http\Resources\EvaluationResource;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the evaluations.
     */
    public function index(Request $request): InertiaResponse
    {
        $query = Evaluation::with(['user', 'order', 'product']);

        // Búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orWhereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        // Filtro por calificación
        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', $request->rating);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'evaluation_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $evaluations = $query->paginate($request->get('per_page', 10))->withQueryString();

        return Inertia::render('evaluations/index', [
            'evaluations' => EvaluationResource::collection($evaluations),
            'columns' => EvaluationResource::tableColumns(),
            'filters' => EvaluationResource::filterFields(),
            'queryParams' => $request->only(['search', 'rating', 'sort_by', 'sort_order', 'per_page']),
            'pagination' => [
                'current_page' => $evaluations->currentPage(),
                'last_page' => $evaluations->lastPage(),
                'per_page' => $evaluations->perPage(),
                'total' => $evaluations->total(),
                'from' => $evaluations->firstItem(),
                'to' => $evaluations->lastItem(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new evaluation.
     */
    public function create(): InertiaResponse
    {
        $fields = EvaluationResource::formFields();

        // Cargar opciones para los selects
        $fields[0]['options'] = User::all()->map(function ($user) {
            return [
                'value' => (string) $user->id,
                'label' => $user->name . ' ' . $user->last_name,
            ];
        })->toArray();

        $fields[1]['options'] = Product::where('status', 'active')->get()->map(function ($product) {
            return [
                'value' => (string) $product->id,
                'label' => $product->name,
            ];
        })->toArray();

        $fields[2]['options'] = Order::orderBy('id', 'desc')->limit(100)->get()->map(function ($order) {
            return [
                'value' => (string) $order->id,
                'label' => 'Orden #' . $order->id . ' - ' . $order->user->full_name ?? '',
            ];
        })->toArray();

        return Inertia::render('evaluations/create', [
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created evaluation in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            Evaluation::rules(),
            Evaluation::messages()
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        $evaluation = Evaluation::create($validator->validated());
        $evaluation->load(['user', 'order', 'product']);

        return response()->json([
            'message' => 'Evaluación creada exitosamente',
            'data' => new EvaluationResource($evaluation),
        ], 201);
    }

    /**
     * Display the specified evaluation.
     */
    public function show(Evaluation $evaluation): InertiaResponse
    {
        $evaluation->load(['user', 'order', 'product']);

        return Inertia::render('evaluations/show', [
            'evaluation' => new EvaluationResource($evaluation),
        ]);
    }

    /**
     * Show the form for editing the specified evaluation.
     */
    public function edit(Evaluation $evaluation): InertiaResponse
    {
        $evaluation->load(['user', 'order', 'product']);

        $fields = EvaluationResource::formFields();

        // Cargar opciones para los selects
        $fields[0]['options'] = User::all()->map(function ($user) {
            return [
                'value' => (string) $user->id,
                'label' => $user->name . ' ' . $user->last_name,
            ];
        })->toArray();

        $fields[1]['options'] = Product::where('status', 'active')->get()->map(function ($product) {
            return [
                'value' => (string) $product->id,
                'label' => $product->name,
            ];
        })->toArray();

        $fields[2]['options'] = Order::orderBy('id', 'desc')->limit(100)->get()->map(function ($order) {
            return [
                'value' => (string) $order->id,
                'label' => 'Orden #' . $order->id . ' - ' . $order->user->full_name ?? '',
            ];
        })->toArray();

        return Inertia::render('evaluations/edit', [
            'evaluation' => new EvaluationResource($evaluation),
            'fields' => $fields,
        ]);
    }

    /**
     * Update the specified evaluation in storage.
     */
    public function update(Request $request, Evaluation $evaluation): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            Evaluation::rules(true),
            Evaluation::messages()
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        $evaluation->update($validator->validated());
        $evaluation->load(['user', 'order', 'product']);

        return response()->json([
            'message' => 'Evaluación actualizada exitosamente',
            'data' => new EvaluationResource($evaluation),
        ], 200);
    }

    /**
     * Remove the specified evaluation from storage.
     */
    public function destroy(Evaluation $evaluation): JsonResponse
    {
        $evaluation->delete();

        return response()->json([
            'message' => 'Evaluación eliminada exitosamente',
        ], 200);
    }

    /**
     * Get evaluations by user.
     */
    public function getByUser(int $userId): AnonymousResourceCollection
    {
        $evaluations = Evaluation::with(['user', 'order', 'product'])
            ->where('user_id', $userId)
            ->orderBy('evaluation_date', 'desc')
            ->get();

        return EvaluationResource::collection($evaluations);
    }

    /**
     * Get evaluations by order.
     */
    public function getByOrder(int $orderId): AnonymousResourceCollection
    {
        $evaluations = Evaluation::with(['user', 'order', 'product'])
            ->where('order_id', $orderId)
            ->orderBy('evaluation_date', 'desc')
            ->get();

        return EvaluationResource::collection($evaluations);
    }

    /**
     * Get evaluations by product.
     */
    public function getByProduct(int $productId): AnonymousResourceCollection
    {
        $evaluations = Evaluation::with(['user', 'order', 'product'])
            ->where('product_id', $productId)
            ->orderBy('evaluation_date', 'desc')
            ->get();

        return EvaluationResource::collection($evaluations);
    }

    /**
     * Get average rating for a product.
     */
    public function getProductAverageRating(int $productId): JsonResponse
    {
        $average = Evaluation::where('product_id', $productId)
            ->avg('rating');

        $count = Evaluation::where('product_id', $productId)
            ->count();

        return response()->json([
            'product_id' => $productId,
            'average_rating' => round($average, 2),
            'total_evaluations' => $count,
        ], 200);
    }
}
