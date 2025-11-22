<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VenezuelaBankResource extends JsonResource
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
            'active' => $this->active,
            'active_label' => $this->active ? 'Activo' : 'Inactivo',
            'system_data' => $this->system_data,
            'creation_date' => $this->creation_date,
            'creation_date_formatted' => $this->creation_date ? $this->creation_date->format('d/m/Y H:i') : null,
            'created_at' => $this->created_at,
            'created_at_formatted' => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null,
            'updated_at' => $this->updated_at,
            'updated_at_formatted' => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,
        ];
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
                'key' => 'active_label',
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
                'name' => 'active',
                'label' => 'Estado',
                'type' => 'select',
                'placeholder' => 'Todos los estados',
                'options' => [
                    ['value' => '1', 'label' => 'Activo'],
                    ['value' => '0', 'label' => 'Inactivo'],
                ],
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
                'placeholder' => 'Ej: 0108',
                'required' => true,
                'validation' => 'required|string|max:10|unique:venezuela_banks,code',
                'grid_cols' => 6,
                'help_text' => 'Código único del banco (máximo 10 caracteres)',
            ],
            [
                'name' => 'name',
                'label' => 'Nombre',
                'type' => 'text',
                'placeholder' => 'Ej: BBVA Banco Provincial',
                'required' => true,
                'validation' => 'required|string|max:100',
                'grid_cols' => 6,
                'help_text' => 'Nombre completo del banco (máximo 100 caracteres)',
            ],
            [
                'name' => 'active',
                'label' => 'Estado',
                'type' => 'select',
                'placeholder' => 'Seleccione el estado',
                'required' => true,
                'validation' => 'required|boolean',
                'grid_cols' => 6,
                'options' => [
                    ['value' => '1', 'label' => 'Activo'],
                    ['value' => '0', 'label' => 'Inactivo'],
                ],
                'default' => '1',
            ],
            [
                'name' => 'creation_date',
                'label' => 'Fecha de Creación',
                'type' => 'datetime-local',
                'placeholder' => 'Seleccione la fecha',
                'required' => false,
                'validation' => 'nullable|date',
                'grid_cols' => 6,
            ],
        ];
    }
}
