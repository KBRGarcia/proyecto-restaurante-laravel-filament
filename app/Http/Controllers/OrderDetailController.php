<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderDetailResource;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OrderDetail::with(['order.user', 'product.category']);

        // Búsqueda general
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('product_notes', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('order', function ($orderQuery) use ($search) {
                        $orderQuery->where('id', 'like', "%{$search}%");
                    });
            });
        }

        // Filtro por orden
        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        // Filtro por producto
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $orderDetails = $query->paginate($request->get('per_page', 10))->withQueryString();

        return Inertia::render('order-details/index', [
            'orderDetails' => OrderDetailResource::collection($orderDetails),
            'columns' => OrderDetailResource::tableColumns(),
            'filters' => OrderDetailResource::filterFields(),
            'queryParams' => $request->only(['search', 'order_id', 'product_id', 'sort_by', 'sort_order', 'per_page']),
            'pagination' => [
                'current_page' => $orderDetails->currentPage(),
                'last_page' => $orderDetails->lastPage(),
                'per_page' => $orderDetails->perPage(),
                'total' => $orderDetails->total(),
                'from' => $orderDetails->firstItem(),
                'to' => $orderDetails->lastItem(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('order-details/create', [
            'fields' => OrderDetailResource::formFields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate(
            OrderDetail::rules(),
            OrderDetail::messages()
        );

        // El subtotal se calcula automáticamente en el modelo
        // pero si viene en la petición, lo respetamos
        if (!isset($validated['subtotal']) && isset($validated['quantity']) && isset($validated['unit_price'])) {
            $validated['subtotal'] = $validated['quantity'] * $validated['unit_price'];
        }

        // Crear el detalle de orden
        $orderDetail = OrderDetail::create($validated);

        // Actualizar los totales de la orden
        $this->updateOrderTotals($orderDetail->order_id);

        return redirect()
            ->route('order-details.index')
            ->with('success', 'Detalle de orden creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderDetail $orderDetail)
    {
        $orderDetail->load(['order.user', 'product.category']);

        return Inertia::render('order-details/show', [
            'orderDetail' => new OrderDetailResource($orderDetail),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderDetail $orderDetail)
    {
        $orderDetail->load(['order', 'product']);

        return Inertia::render('order-details/edit', [
            'orderDetail' => new OrderDetailResource($orderDetail),
            'fields' => OrderDetailResource::formFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        // Validación
        $validated = $request->validate(
            OrderDetail::rules(true),
            OrderDetail::messages()
        );

        // El subtotal se calcula automáticamente en el modelo
        // pero si viene en la petición, lo respetamos
        if (!isset($validated['subtotal']) && isset($validated['quantity']) && isset($validated['unit_price'])) {
            $validated['subtotal'] = $validated['quantity'] * $validated['unit_price'];
        }

        // Guardar el order_id anterior por si cambia
        $previousOrderId = $orderDetail->order_id;

        // Actualizar el detalle de orden
        $orderDetail->update($validated);

        // Actualizar los totales de la orden actual
        $this->updateOrderTotals($orderDetail->order_id);

        // Si cambió la orden, actualizar también la anterior
        if ($previousOrderId !== $orderDetail->order_id) {
            $this->updateOrderTotals($previousOrderId);
        }

        return redirect()
            ->route('order-details.index')
            ->with('success', 'Detalle de orden actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDetail $orderDetail)
    {
        $orderId = $orderDetail->order_id;

        // Eliminar el detalle
        $orderDetail->delete();

        // Actualizar los totales de la orden
        $this->updateOrderTotals($orderId);

        return redirect()
            ->route('order-details.index')
            ->with('success', 'Detalle de orden eliminado exitosamente.');
    }

    /**
     * Update the totals of an order based on its details.
     *
     * @param int $orderId
     * @return void
     */
    private function updateOrderTotals(int $orderId): void
    {
        $order = Order::find($orderId);

        if (!$order) {
            return;
        }

        // Calcular el subtotal sumando todos los detalles
        $subtotal = OrderDetail::where('order_id', $orderId)->sum('subtotal');

        // Calcular el total (subtotal + impuestos)
        $total = $subtotal + ($order->taxes ?? 0);

        // Actualizar la orden
        $order->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }
}
