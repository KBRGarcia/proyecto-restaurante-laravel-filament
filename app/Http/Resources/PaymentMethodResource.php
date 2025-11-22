<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'currency_type' => $this->currency_type,
            'currency_type_label' => $this->getCurrencyTypeLabel(),
            'active' => $this->active,
            'active_label' => $this->active ? 'Activo' : 'Inactivo',
            'configuration' => $this->configuration,
            'creation_date' => $this->creation_date?->format('Y-m-d H:i:s'),
            'update_date' => $this->update_date?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get the currency type label in Spanish.
     *
     * @return string
     */
    private function getCurrencyTypeLabel(): string
    {
        return match ($this->currency_type) {
            'nacional' => 'Nacional',
            'internacional' => 'Internacional',
            default => 'Desconocido',
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
                'key' => 'code',
                'label' => 'Código',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'name',
                'label' => 'Nombre',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'currency_type_label',
                'label' => 'Tipo de Moneda',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'active_label',
                'label' => 'Estado',
                'sortable' => true,
                'visible' => true,
            ],
            [
                'key' => 'creation_date',
                'label' => 'Fecha de Creación',
                'sortable' => true,
                'visible' => true,
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
                'name' => 'code',
                'label' => 'Código',
                'type' => 'text',
                'placeholder' => 'Ingrese el código (ej: PM, ZELLE, BINANCE)',
                'required' => true,
                'validation' => 'required|string|max:50',
                'grid_cols' => 6,
                'help_text' => 'Código único del método de pago',
            ],
            [
                'name' => 'name',
                'label' => 'Nombre',
                'type' => 'text',
                'placeholder' => 'Ingrese el nombre del método de pago',
                'required' => true,
                'validation' => 'required|string|max:100',
                'grid_cols' => 6,
            ],
            [
                'name' => 'currency_type',
                'label' => 'Tipo de Moneda',
                'type' => 'select',
                'placeholder' => 'Seleccione el tipo de moneda',
                'required' => true,
                'validation' => 'required|in:nacional,internacional',
                'options' => [
                    ['value' => 'nacional', 'label' => 'Nacional'],
                    ['value' => 'internacional', 'label' => 'Internacional'],
                ],
                'default' => 'nacional',
                'grid_cols' => 6,
            ],
            [
                'name' => 'active',
                'label' => 'Estado',
                'type' => 'select',
                'placeholder' => 'Seleccione el estado',
                'required' => true,
                'validation' => 'required|boolean',
                'options' => [
                    ['value' => '1', 'label' => 'Activo'],
                    ['value' => '0', 'label' => 'Inactivo'],
                ],
                'default' => '1',
                'grid_cols' => 6,
            ],
            [
                'name' => 'configuration',
                'label' => 'Configuración (JSON)',
                'type' => 'textarea',
                'placeholder' => 'Ingrese la configuración en formato JSON (opcional)',
                'required' => false,
                'validation' => 'nullable|json',
                'grid_cols' => 12,
                'rows' => 4,
                'help_text' => 'Configuración adicional del método de pago en formato JSON',
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
                'placeholder' => 'Buscar por código o nombre...',
            ],
            [
                'name' => 'currency_type',
                'label' => 'Tipo de Moneda',
                'type' => 'select',
                'placeholder' => 'Todos los tipos',
                'options' => [
                    ['value' => '', 'label' => 'Todos'],
                    ['value' => 'nacional', 'label' => 'Nacional'],
                    ['value' => 'internacional', 'label' => 'Internacional'],
                ],
            ],
            [
                'name' => 'active',
                'label' => 'Estado',
                'type' => 'select',
                'placeholder' => 'Todos los estados',
                'options' => [
                    ['value' => '', 'label' => 'Todos'],
                    ['value' => '1', 'label' => 'Activo'],
                    ['value' => '0', 'label' => 'Inactivo'],
                ],
            ],
        ];
    }
}
