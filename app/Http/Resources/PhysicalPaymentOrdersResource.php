<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalPaymentOrdersResource extends JsonResource
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
                    'currency' => $this->order->currency,
                    'order_date' => $this->order->order_date,
                ];
            }),
            'limit_date' => $this->limit_date,
            'limit_date_formatted' => $this->limit_date ? $this->limit_date->format('d/m/Y H:i') : null,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'is_expired' => $this->isExpired(),
            'creation_date' => $this->creation_date,
            'creation_date_formatted' => $this->creation_date ? $this->creation_date->format('d/m/Y H:i') : null,
            'update_date' => $this->update_date,
            'update_date_formatted' => $this->update_date ? $this->update_date->format('d/m/Y H:i') : null,
            'created_at' => $this->created_at,
            'created_at_formatted' => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null,
            'updated_at' => $this->updated_at,
            'updated_at_formatted' => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,
        ];
    }

    /**
     * Get the status label.
     */
    private function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmado',
            'canceled' => 'Cancelado',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get table columns configuration for frontend.
     *
     * @return array<string, mixed>
     */
    public static function tableColumns(): array
    {
        return [
            [
                'key' => 'id',
                'label' => 'ID',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'order_number',
                'label' => 'N° Orden',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'limit_date_formatted',
                'label' => 'Fecha Límite',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'status_label',
                'label' => 'Estado',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'creation_date_formatted',
                'label' => 'Fecha de Creación',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'is_expired',
                'label' => 'Vencido',
                'sortable' => false,
                'visible' => false,
            ],
        ];
    }

    /**
     * Get filter fields configuration for frontend.
     *
     * @return array<string, mixed>
     */
    public static function filterFields(): array
    {
        return [
            [
                'name' => 'search',
                'label' => 'Buscar',
                'type' => 'text',
                'placeholder' => 'Buscar por ID o número de orden...',
            ],
            [
                'name' => 'status',
                'label' => 'Estado',
                'type' => 'select',
                'placeholder' => 'Todos los estados',
                'options' => [
                    ['value' => 'pending', 'label' => 'Pendiente'],
                    ['value' => 'confirmed', 'label' => 'Confirmado'],
                    ['value' => 'canceled', 'label' => 'Cancelado'],
                ],
            ],
            [
                'name' => 'order_id',
                'label' => 'Orden',
                'type' => 'select',
                'placeholder' => 'Todas las órdenes',
            ],
        ];
    }

    /**
     * Get form fields configuration for frontend.
     *
     * @return array<string, mixed>
     */
    public static function formFields(): array
    {
        return [
            [
                'name' => 'order_id',
                'label' => 'Orden',
                'type' => 'select',
                'placeholder' => 'Seleccione una orden',
                'required' => true,
                'validation' => 'required|exists:orders,id',
                'grid_cols' => 6,
            ],
            [
                'name' => 'limit_date',
                'label' => 'Fecha Límite',
                'type' => 'datetime-local',
                'placeholder' => 'Seleccione la fecha límite',
                'required' => true,
                'validation' => 'required|date|after:now',
                'grid_cols' => 6,
                'help_text' => 'La fecha límite debe ser posterior a la fecha actual',
            ],
            [
                'name' => 'status',
                'label' => 'Estado',
                'type' => 'select',
                'placeholder' => 'Seleccione el estado',
                'required' => true,
                'validation' => 'required|in:pending,confirmed,canceled',
                'grid_cols' => 6,
                'options' => [
                    ['value' => 'pending', 'label' => 'Pendiente'],
                    ['value' => 'confirmed', 'label' => 'Confirmado'],
                    ['value' => 'canceled', 'label' => 'Cancelado'],
                ],
                'default' => 'pending',
            ],
        ];
    }
}
