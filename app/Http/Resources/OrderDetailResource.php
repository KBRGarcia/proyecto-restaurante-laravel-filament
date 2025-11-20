<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'order_number' => $this->order?->id ?? null,
            'order' => $this->whenLoaded('order', function () {
                return [
                    'id' => $this->order->id,
                    'user_name' => $this->order->user?->name . ' ' . $this->order->user?->last_name,
                    'status' => $this->order->status,
                    'service_type' => $this->order->service_type,
                    'total' => $this->order->total,
                    'order_date' => $this->order->order_date,
                ];
            }),
            'product_id' => $this->product_id,
            'product_name' => $this->product?->name ?? 'Producto no encontrado',
            'product' => $this->whenLoaded('product', function () {
                return [
                    'id' => $this->product->id,
                    'name' => $this->product->name,
                    'description' => $this->product->description,
                    'price' => $this->product->price,
                    'image' => $this->product->image,
                    'category_name' => $this->product->category?->name,
                ];
            }),
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'unit_price_formatted' => number_format($this->unit_price, 2),
            'subtotal' => $this->subtotal,
            'subtotal_formatted' => number_format($this->subtotal, 2),
            'product_notes' => $this->product_notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get the table columns configuration for the frontend.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function tableColumns(): array
    {
        return [
            [
                'key' => 'id',
                'label' => 'ID',
                'sortable' => true,
            ],
            [
                'key' => 'order_number',
                'label' => 'N° Orden',
                'sortable' => true,
            ],
            [
                'key' => 'product_name',
                'label' => 'Producto',
                'sortable' => true,
            ],
            [
                'key' => 'quantity',
                'label' => 'Cantidad',
                'sortable' => true,
            ],
            [
                'key' => 'unit_price_formatted',
                'label' => 'Precio Unitario',
                'sortable' => true,
            ],
            [
                'key' => 'subtotal_formatted',
                'label' => 'Subtotal',
                'sortable' => true,
            ],
            [
                'key' => 'actions',
                'label' => 'Acciones',
                'sortable' => false,
            ],
        ];
    }

    /**
     * Get the filter fields configuration for the frontend.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function filterFields(): array
    {
        // Obtener órdenes para el filtro
        $orders = Order::with('user')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($order) {
                return [
                    'value' => $order->id,
                    'label' => 'Orden #' . $order->id . ' - ' . ($order->user?->name ?? 'Sin cliente'),
                ];
            });

        // Obtener productos activos para el filtro
        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    'value' => $product->id,
                    'label' => $product->name,
                ];
            });

        return [
            [
                'name' => 'order_id',
                'label' => 'Orden',
                'type' => 'select',
                'options' => $orders,
                'placeholder' => 'Filtrar por orden',
            ],
            [
                'name' => 'product_id',
                'label' => 'Producto',
                'type' => 'select',
                'options' => $products,
                'placeholder' => 'Filtrar por producto',
            ],
        ];
    }

    /**
     * Get the form fields configuration for the frontend.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function formFields(): array
    {
        // Obtener órdenes disponibles
        $orders = Order::with('user')
            ->whereIn('status', ['pending', 'preparing'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'value' => $order->id,
                    'label' => 'Orden #' . $order->id . ' - ' . ($order->user?->name ?? 'Sin cliente') . ' (' . $order->status . ')',
                ];
            });

        // Obtener productos activos
        $products = Product::where('status', 'active')
            ->with('category')
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                return [
                    'value' => $product->id,
                    'label' => $product->name . ' - $' . number_format($product->price, 2) . ' (' . ($product->category?->name ?? 'Sin categoría') . ')',
                    'price' => $product->price,
                ];
            });

        return [
            [
                'name' => 'order_id',
                'label' => 'Orden',
                'type' => 'select',
                'options' => $orders,
                'required' => true,
                'placeholder' => 'Seleccione una orden',
                'description' => 'Orden a la que pertenece este detalle',
            ],
            [
                'name' => 'product_id',
                'label' => 'Producto',
                'type' => 'select',
                'options' => $products,
                'required' => true,
                'placeholder' => 'Seleccione un producto',
                'description' => 'Producto a agregar al pedido',
            ],
            [
                'name' => 'quantity',
                'label' => 'Cantidad',
                'type' => 'number',
                'required' => true,
                'min' => 1,
                'step' => 1,
                'placeholder' => 'Ingrese la cantidad',
                'description' => 'Cantidad de productos',
            ],
            [
                'name' => 'unit_price',
                'label' => 'Precio Unitario',
                'type' => 'number',
                'required' => true,
                'min' => 0,
                'step' => 0.01,
                'placeholder' => '0.00',
                'description' => 'Precio por unidad del producto',
            ],
            [
                'name' => 'subtotal',
                'label' => 'Subtotal',
                'type' => 'number',
                'required' => false,
                'min' => 0,
                'step' => 0.01,
                'placeholder' => '0.00',
                'readonly' => true,
                'description' => 'Subtotal calculado automáticamente (cantidad × precio unitario)',
            ],
            [
                'name' => 'product_notes',
                'label' => 'Notas del Producto',
                'type' => 'textarea',
                'required' => false,
                'placeholder' => 'Ej: Sin cebolla, extra queso, etc.',
                'description' => 'Notas o instrucciones especiales para este producto',
                'rows' => 3,
            ],
        ];
    }
}
