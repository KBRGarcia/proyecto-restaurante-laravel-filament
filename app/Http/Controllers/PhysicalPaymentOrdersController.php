<?php

namespace App\Http\Controllers;

use App\Http\Resources\PhysicalPaymentOrdersResource;
use App\Models\Order;
use App\Models\PhysicalPaymentOrders;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PhysicalPaymentOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PhysicalPaymentOrders::with(['order.user']);

        // Búsqueda general
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($orderQuery) use ($search) {
                        $orderQuery->where('id', 'like', "%{$search}%");
                    });
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por orden
        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'limit_date');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $physicalPaymentOrders = $query->paginate($request->get('per_page', 10))->withQueryString();

        return Inertia::render('physical-payment-orders/index', [
            'physicalPaymentOrders' => PhysicalPaymentOrdersResource::collection($physicalPaymentOrders),
            'columns' => PhysicalPaymentOrdersResource::tableColumns(),
            'filters' => PhysicalPaymentOrdersResource::filterFields(),
            'queryParams' => $request->only(['search', 'status', 'order_id', 'sort_by', 'sort_order', 'per_page']),
            'pagination' => [
                'current_page' => $physicalPaymentOrders->currentPage(),
                'last_page' => $physicalPaymentOrders->lastPage(),
                'per_page' => $physicalPaymentOrders->perPage(),
                'total' => $physicalPaymentOrders->total(),
                'from' => $physicalPaymentOrders->firstItem(),
                'to' => $physicalPaymentOrders->lastItem(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener órdenes pendientes o en preparación que no tengan ya una orden de pago físico
        $orders = Order::whereIn('status', ['pending', 'preparing'])
            ->whereDoesntHave('physicalPaymentOrders', function ($query) {
                $query->where('status', 'pending');
            })
            ->with('user')
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'value' => $order->id,
                    'label' => "Orden #{$order->id} - {$order->user->name} {$order->user->last_name} - Total: " . number_format($order->total, 2) . " " . ($order->currency === 'nacional' ? 'Bs.' : '$'),
                ];
            });

        return Inertia::render('physical-payment-orders/create', [
            'formFields' => PhysicalPaymentOrdersResource::formFields(),
            'orders' => $orders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(PhysicalPaymentOrders::rules(), PhysicalPaymentOrders::messages());

        // Establecer creation_date si no se proporciona
        if (!isset($validated['creation_date'])) {
            $validated['creation_date'] = now();
        }

        // Establecer update_date si no se proporciona
        if (!isset($validated['update_date'])) {
            $validated['update_date'] = now();
        }

        $physicalPaymentOrder = PhysicalPaymentOrders::create($validated);

        return redirect()
            ->route('physical-payment-orders.index')
            ->with('success', 'Orden de pago físico creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhysicalPaymentOrders $physicalPaymentOrder)
    {
        $physicalPaymentOrder->load(['order.user']);

        return Inertia::render('physical-payment-orders/show', [
            'physicalPaymentOrder' => new PhysicalPaymentOrdersResource($physicalPaymentOrder),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhysicalPaymentOrders $physicalPaymentOrder)
    {
        $physicalPaymentOrder->load(['order.user']);

        // Obtener órdenes pendientes o en preparación
        $orders = Order::whereIn('status', ['pending', 'preparing'])
            ->with('user')
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'value' => $order->id,
                    'label' => "Orden #{$order->id} - {$order->user->name} {$order->user->last_name} - Total: " . number_format($order->total, 2) . " " . ($order->currency === 'nacional' ? 'Bs.' : '$'),
                ];
            });

        return Inertia::render('physical-payment-orders/edit', [
            'physicalPaymentOrder' => new PhysicalPaymentOrdersResource($physicalPaymentOrder),
            'formFields' => PhysicalPaymentOrdersResource::formFields(),
            'orders' => $orders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhysicalPaymentOrders $physicalPaymentOrder)
    {
        $validated = $request->validate(PhysicalPaymentOrders::rules(true), PhysicalPaymentOrders::messages());

        // Actualizar update_date automáticamente
        $validated['update_date'] = now();

        $physicalPaymentOrder->update($validated);

        return redirect()
            ->route('physical-payment-orders.index')
            ->with('success', 'Orden de pago físico actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhysicalPaymentOrders $physicalPaymentOrder)
    {
        $physicalPaymentOrder->delete();

        return redirect()
            ->route('physical-payment-orders.index')
            ->with('success', 'Orden de pago físico eliminada exitosamente.');
    }
}
