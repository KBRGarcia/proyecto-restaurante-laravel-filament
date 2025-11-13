# Documentación: UserResource.php

## Tabla de Contenidos
1. [Introducción](#introducción)
2. [Imports y Namespaces](#imports-y-namespaces)
3. [Clase UserResource](#clase-userresource)
4. [Método toArray()](#método-toarray)
5. [Métodos Privados de Transformación](#métodos-privados-de-transformación)
6. [Métodos Estáticos de Configuración](#métodos-estáticos-de-configuración)
7. [Referencias Oficiales](#referencias-oficiales)

---

## Introducción

`UserResource` es una clase que extiende de `JsonResource` de Laravel, utilizada para transformar modelos de usuario en representaciones JSON. Los recursos API en Laravel 12 proporcionan una capa de transformación entre los modelos Eloquent y las respuestas JSON que se devuelven a los clientes.

**Propósito principal:**
- Controlar exactamente qué datos del modelo User se exponen en la API
- Formatear datos (fechas, campos calculados, etc.)
- Proporcionar configuraciones para el frontend (columnas de tabla, campos de formulario, filtros)

**Referencia oficial:** [Laravel 12 - API Resources](https://laravel.com/docs/12.x/eloquent-resources)

---

## Imports y Namespaces

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
```

### Explicación de Imports

#### `namespace App\Http\Resources;`
- **Qué es:** Define el espacio de nombres donde se encuentra esta clase
- **Por qué:** Los namespaces en PHP organizan el código y evitan conflictos de nombres
- **Ubicación:** Sigue la estructura PSR-4, donde `App\Http\Resources` corresponde a `app/Http/Resources/`
- **Referencia:** [PHP Namespaces](https://www.php.net/manual/es/language.namespaces.php)

#### `use Illuminate\Http\Request;`
- **Qué es:** Importa la clase Request del framework Laravel
- **Por qué:** Se utiliza como type hint en el método `toArray()` para indicar que recibe una instancia de Request
- **Función:** Proporciona acceso a toda la información de la petición HTTP actual
- **Referencia:** [Laravel 12 - Requests](https://laravel.com/docs/12.x/requests)

#### `use Illuminate\Http\Resources\Json\JsonResource;`
- **Qué es:** Importa la clase base JsonResource
- **Por qué:** UserResource hereda de esta clase para obtener toda la funcionalidad de transformación
- **Función:** Proporciona métodos para convertir modelos Eloquent en JSON
- **Referencia:** [Laravel 12 - API Resources](https://laravel.com/docs/12.x/eloquent-resources)

---

## Clase UserResource

```php
class UserResource extends JsonResource
{
    // ...
}
```

### Explicación

- **Declaración:** `class UserResource extends JsonResource`
- **Herencia:** La palabra clave `extends` indica que UserResource hereda todas las propiedades y métodos de JsonResource
- **Beneficios de heredar de JsonResource:**
  - Acceso automático al modelo a través de `$this->resource` o simplemente `$this`
  - Métodos como `when()`, `whenLoaded()`, `mergeWhen()` para condicionales
  - Soporte para colecciones y paginación
  - Serialización automática a JSON

---

## Método toArray()

```php
public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'last_name' => $this->last_name,
        'full_name' => $this->name . ' ' . $this->last_name,
        'email' => $this->email,
        'email_verified_at' => $this->email_verified_at?->format('Y-m-d H:i:s'),
        'phone_number' => $this->phone_number,
        'address' => $this->address,
        'profile_picture' => $this->profile_picture,
        'role' => $this->role,
        'role_label' => $this->getRoleLabel(),
        'status' => $this->status,
        'status_label' => $this->getStatusLabel(),
        'registration_date' => $this->registration_date?->format('Y-m-d H:i:s'),
        'last_connection' => $this->last_connection?->format('Y-m-d H:i:s'),
        'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
    ];
}
```

### Explicación Detallada

#### Firma del Método

- **`public`:** Modificador de acceso que permite que el método sea llamado desde cualquier lugar
- **`function toArray`:** Nombre del método que debe implementarse al heredar de JsonResource
- **`Request $request`:** Parámetro type-hinted que recibe la petición HTTP actual
- **`: array`:** Declaración de tipo de retorno, indica que el método DEBE retornar un array
- **Referencia:** [PHP Type Declarations](https://www.php.net/manual/es/language.types.declarations.php)

#### Campos del Array

##### Campos Directos
```php
'id' => $this->id,
'name' => $this->name,
'email' => $this->email,
```
- **`$this`:** Hace referencia al modelo User que está siendo transformado
- **Por qué funciona:** JsonResource automáticamente hace que las propiedades del modelo estén disponibles en `$this`
- **Ventaja:** Acceso directo y limpio a las propiedades del modelo

##### Campo Calculado
```php
'full_name' => $this->name . ' ' . $this->last_name,
```
- **Qué es:** Un campo que no existe en la base de datos, sino que se calcula en tiempo real
- **Por qué:** Evita duplicar lógica en el frontend y centraliza la generación del nombre completo
- **Operador `.`:** Concatenación de strings en PHP

##### Formateo de Fechas con Null Safety
```php
'email_verified_at' => $this->email_verified_at?->format('Y-m-d H:i:s'),
```
- **`?->`:** Operador Nullsafe (PHP 8.0+), solo llama al método si el valor no es null
- **Sin nullsafe:** Si `email_verified_at` es null, PHP lanzaría un error
- **Con nullsafe:** Si es null, toda la expresión retorna null sin error
- **`format('Y-m-d H:i:s')`:** Método de Carbon/DateTime para formatear fechas
  - `Y` = Año con 4 dígitos (2025)
  - `m` = Mes con 2 dígitos (01-12)
  - `d` = Día con 2 dígitos (01-31)
  - `H` = Hora en formato 24h (00-23)
  - `i` = Minutos (00-59)
  - `s` = Segundos (00-59)
- **Referencia:** [PHP Nullsafe Operator](https://www.php.net/manual/es/language.oop5.basic.php#language.oop5.basic.nullsafe)
- **Referencia:** [Laravel 12 - Date Mutators](https://laravel.com/docs/12.x/eloquent-mutators#date-casting)

##### Campos con Métodos Privados
```php
'role_label' => $this->getRoleLabel(),
'status_label' => $this->getStatusLabel(),
```
- **Por qué:** Delega la lógica de transformación a métodos privados para mantener el código limpio y reutilizable
- **Ventaja:** Si necesitas cambiar cómo se obtiene el label, solo modificas un lugar

---

## Métodos Privados de Transformación

### Método getRoleLabel()

```php
private function getRoleLabel(): string
{
    return match ($this->role) {
        'admin' => 'Administrador',
        'employee' => 'Empleado',
        'client' => 'Cliente',
        default => 'Desconocido',
    };
}
```

#### Explicación

##### Modificador de Acceso
- **`private`:** Solo puede ser llamado desde dentro de la misma clase
- **Por qué:** Es un método auxiliar interno que no debe ser accesible desde fuera

##### Expresión Match (PHP 8.0+)
- **`match()`:** Similar a `switch` pero con importantes diferencias:
  1. **Retorna un valor:** Puede asignarse directamente o devolverse con `return`
  2. **Comparación estricta:** Usa `===` en lugar de `==`
  3. **No hay fall-through:** No necesita `break`
  4. **Exhaustivo:** Si no coincide ningún caso y no hay `default`, lanza error
  
- **Sintaxis:**
  ```php
  match (expresión_a_evaluar) {
      valor1 => resultado1,
      valor2 => resultado2,
      default => resultado_por_defecto,
  }
  ```

- **En este caso:**
  - Evalúa `$this->role`
  - Si es 'admin' retorna 'Administrador'
  - Si es 'employee' retorna 'Empleado'
  - Si es 'client' retorna 'Cliente'
  - Si es cualquier otra cosa retorna 'Desconocido'

- **Referencia:** [PHP Match Expression](https://www.php.net/manual/es/control-structures.match.php)

### Método getStatusLabel()

```php
private function getStatusLabel(): string
{
    return match ($this->status) {
        'active' => 'Activo',
        'inactive' => 'Inactivo',
        default => 'Desconocido',
    };
}
```

#### Explicación
- Funciona idénticamente a `getRoleLabel()`
- Traduce valores técnicos ('active', 'inactive') a etiquetas legibles en español
- Proporciona un valor por defecto seguro en caso de datos inesperados

---

## Métodos Estáticos de Configuración

### Método tableColumns()

```php
public static function tableColumns(): array
{
    return [
        [
            'key' => 'id',
            'label' => 'ID',
            'sortable' => true,
            'visible' => true,
        ],
        // ... más columnas
    ];
}
```

#### Explicación

##### Modificador Static
- **`public static`:** Método que puede ser llamado sin instanciar la clase
- **Llamada:** `UserResource::tableColumns()`
- **Por qué static:** No necesita acceso a ninguna instancia específica de usuario, solo devuelve configuración
- **Referencia:** [PHP Static Methods](https://www.php.net/manual/es/language.oop5.static.php)

##### Estructura de Cada Columna

```php
[
    'key' => 'id',              // Nombre del campo en el array de datos
    'label' => 'ID',            // Texto a mostrar en el encabezado de la tabla
    'sortable' => true,         // Si la columna permite ordenamiento
    'visible' => true,          // Si la columna se muestra por defecto
]
```

#### Columnas Definidas

1. **ID**
   - Campo identificador único
   - Sortable para encontrar registros específicos
   - Siempre visible

2. **Nombre Completo (`full_name`)**
   - Muestra nombre y apellido juntos
   - Sortable para ordenar alfabéticamente
   - Campo principal de identificación visual

3. **Correo Electrónico**
   - Información de contacto principal
   - Sortable para búsquedas
   - Siempre visible

4. **Teléfono (`phone_number`)**
   - No sortable (por diseño, ya que puede tener formatos variados)
   - Visible por defecto
   - Información de contacto secundaria

5. **Rol (`role_label`)**
   - Muestra el label traducido, no el valor técnico
   - Sortable para agrupar por tipo de usuario
   - Crítico para identificar permisos

6. **Estado (`status_label`)**
   - Muestra si el usuario está activo o inactivo
   - Sortable para filtrar usuarios activos/inactivos
   - Importante para la gestión

7. **Fecha de Registro**
   - Cuándo se creó la cuenta
   - Sortable para ver usuarios nuevos/antiguos
   - Visible por defecto

8. **Última Conexión**
   - Cuándo el usuario accedió por última vez
   - Sortable para detectar usuarios inactivos
   - **`'visible' => false`:** No se muestra por defecto, pero puede activarse

#### Propósito del Método
- **Frontend agnóstico:** El frontend recibe la configuración desde el backend
- **Centralización:** Cambiar las columnas en un solo lugar afecta toda la aplicación
- **Flexibilidad:** Fácil agregar/quitar columnas modificando el array

---

### Método formFields()

```php
public static function formFields(): array
{
    return [
        [
            'name' => 'name',
            'label' => 'Nombre',
            'type' => 'text',
            'placeholder' => 'Ingrese el nombre',
            'required' => true,
            'validation' => 'required|string|max:255',
            'grid_cols' => 6,
        ],
        // ... más campos
    ];
}
```

#### Explicación

Este método define la configuración de los campos del formulario para crear/editar usuarios.

##### Estructura Común de Cada Campo

```php
[
    'name' => 'campo',           // Nombre del campo en el formulario y base de datos
    'label' => 'Etiqueta',       // Texto del label en español
    'type' => 'text',            // Tipo de input HTML
    'placeholder' => 'Texto',    // Texto de ayuda en el input
    'required' => true,          // Si el campo es obligatorio
    'validation' => 'rules',     // Reglas de validación de Laravel
    'grid_cols' => 6,           // Ancho en sistema de 12 columnas (6 = mitad)
]
```

#### Campos Definidos en Detalle

##### 1. Campo: name
```php
[
    'name' => 'name',
    'label' => 'Nombre',
    'type' => 'text',
    'placeholder' => 'Ingrese el nombre',
    'required' => true,
    'validation' => 'required|string|max:255',
    'grid_cols' => 6,
]
```
- **Validación:** `required|string|max:255`
  - `required`: No puede estar vacío
  - `string`: Debe ser texto
  - `max:255`: Máximo 255 caracteres
- **Grid:** 6 columnas (ocupa la mitad del ancho)
- **Referencia:** [Laravel 12 - Validation Rules](https://laravel.com/docs/12.x/validation#available-validation-rules)

##### 2. Campo: last_name
- Idéntico a `name`, para el apellido
- También ocupa 6 columnas, por lo que `name` y `last_name` aparecen lado a lado

##### 3. Campo: email
```php
[
    'name' => 'email',
    'label' => 'Correo Electrónico',
    'type' => 'email',
    'placeholder' => 'ejemplo@correo.com',
    'required' => true,
    'validation' => 'required|email|max:255',
    'grid_cols' => 6,
]
```
- **Tipo:** `email` - HTML5 input type que valida formato de email en el navegador
- **Validación:** `required|email|max:255`
  - `email`: Valida formato de correo electrónico
- **Referencia:** [Laravel 12 - Email Validation](https://laravel.com/docs/12.x/validation#rule-email)

##### 4. Campo: phone_number
```php
[
    'name' => 'phone_number',
    'label' => 'Número de Teléfono',
    'type' => 'text',
    'placeholder' => '+58 414 1234567',
    'required' => false,
    'validation' => 'nullable|string|max:20',
    'grid_cols' => 6,
]
```
- **Required:** `false` - Campo opcional
- **Validación:** `nullable|string|max:20`
  - `nullable`: Permite valores null/vacíos
  - `max:20`: Suficiente para códigos de país e internacionales

##### 5 y 6. Campos: password y password_confirmation
```php
[
    'name' => 'password',
    'label' => 'Contraseña',
    'type' => 'password',
    'placeholder' => '••••••••',
    'required' => true,
    'validation' => 'required|string|min:8|max:16',
    'help_text' => 'Mínimo 8 caracteres, máximo 16. Debe contener al menos una mayúscula, un número y un carácter especial (@$!%*?&#)',
    'grid_cols' => 6,
    'show_on_edit' => false,
]
```
- **Tipo:** `password` - Oculta el texto ingresado
- **Validación:** `required|string|min:8|max:16`
  - `min:8`: Mínimo 8 caracteres para seguridad
  - `max:16`: Máximo 16 caracteres
- **help_text:** Texto explicativo adicional que aparece bajo el campo
- **show_on_edit:** `false` - No se muestra en el formulario de edición
  - **Por qué:** En edición, no es necesario cambiar la contraseña cada vez
  - El frontend debe manejar este campo como opcional en edición

##### 7. Campo: address
```php
[
    'name' => 'address',
    'label' => 'Dirección',
    'type' => 'textarea',
    'placeholder' => 'Ingrese la dirección completa',
    'required' => false,
    'validation' => 'nullable|string',
    'grid_cols' => 12,
    'rows' => 3,
]
```
- **Tipo:** `textarea` - Permite texto multilínea
- **Grid:** 12 columnas (ancho completo)
- **Rows:** 3 - Altura del textarea
- **Validación:** `nullable|string` - Sin límite de caracteres

##### 8. Campo: role
```php
[
    'name' => 'role',
    'label' => 'Rol',
    'type' => 'select',
    'placeholder' => 'Seleccione un rol',
    'required' => true,
    'validation' => 'required|in:admin,employee,client',
    'options' => [
        ['value' => 'client', 'label' => 'Cliente'],
        ['value' => 'employee', 'label' => 'Empleado'],
        ['value' => 'admin', 'label' => 'Administrador'],
    ],
    'default' => 'client',
    'grid_cols' => 6,
]
```
- **Tipo:** `select` - Dropdown/combobox
- **Validación:** `required|in:admin,employee,client`
  - `in:admin,employee,client`: Solo acepta uno de estos valores
- **Options:** Array de objetos con `value` (valor técnico) y `label` (texto mostrado)
- **Default:** `'client'` - Valor preseleccionado
- **Referencia:** [Laravel 12 - In Validation](https://laravel.com/docs/12.x/validation#rule-in)

##### 9. Campo: status
- Similar a `role`, pero para el estado del usuario
- Opciones: active/inactive
- Default: 'active'

##### 10. Campo: profile_picture
```php
[
    'name' => 'profile_picture',
    'label' => 'Foto de Perfil',
    'type' => 'file',
    'placeholder' => 'Seleccione una imagen',
    'required' => false,
    'validation' => 'nullable|image|max:2048',
    'help_text' => 'Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB',
    'accept' => 'image/*',
    'grid_cols' => 12,
]
```
- **Tipo:** `file` - Input para subir archivos
- **Validación:** `nullable|image|max:2048`
  - `image`: Solo acepta imágenes (jpg, jpeg, png, bmp, gif, svg, webp)
  - `max:2048`: Máximo 2MB (2048 KB)
- **Accept:** `image/*` - Atributo HTML que filtra solo imágenes en el selector de archivos
- **Referencia:** [Laravel 12 - File Validation](https://laravel.com/docs/12.x/validation#rule-image)

---

### Método filterFields()

```php
public static function filterFields(): array
{
    return [
        [
            'name' => 'search',
            'label' => 'Buscar',
            'type' => 'text',
            'placeholder' => 'Buscar por nombre, apellido o email...',
        ],
        // ... más filtros
    ];
}
```

#### Explicación

Define los campos de filtrado para la página de listado de usuarios.

##### Estructura de Cada Filtro

```php
[
    'name' => 'nombre_filtro',     // Nombre del parámetro de query string
    'label' => 'Etiqueta',         // Texto del label
    'type' => 'text',              // Tipo de input
    'placeholder' => 'Texto',      // Placeholder
    'options' => [],               // Opciones para selects
]
```

##### 1. Filtro: search
- **Tipo:** `text` - Búsqueda libre
- **Propósito:** Buscar en múltiples campos (nombre, apellido, email)
- **Backend:** Debe implementar la lógica de búsqueda usando LIKE o similar

##### 2. Filtro: role
```php
[
    'name' => 'role',
    'label' => 'Rol',
    'type' => 'select',
    'placeholder' => 'Todos los roles',
    'options' => [
        ['value' => '', 'label' => 'Todos'],
        ['value' => 'client', 'label' => 'Cliente'],
        ['value' => 'employee', 'label' => 'Empleado'],
        ['value' => 'admin', 'label' => 'Administrador'],
    ],
]
```
- **Opción vacía:** `['value' => '', 'label' => 'Todos']` - Permite no filtrar por rol
- **Diferencia con formFields:** Aquí el vacío es válido

##### 3. Filtro: status
- Similar al filtro de rol
- Permite filtrar por usuarios activos/inactivos

---

## Referencias Oficiales

### Laravel 12

1. **API Resources:**
   - [Eloquent: API Resources](https://laravel.com/docs/12.x/eloquent-resources)
   - [Resource Collections](https://laravel.com/docs/12.x/eloquent-resources#concept-overview)

2. **Validation:**
   - [Validation Rules](https://laravel.com/docs/12.x/validation#available-validation-rules)
   - [Custom Validation Rules](https://laravel.com/docs/12.x/validation#custom-validation-rules)

3. **Eloquent:**
   - [Date Mutators](https://laravel.com/docs/12.x/eloquent-mutators#date-casting)
   - [Accessors & Mutators](https://laravel.com/docs/12.x/eloquent-mutators)

### PHP

1. **Type Declarations:**
   - [Type Declarations](https://www.php.net/manual/es/language.types.declarations.php)
   - [Return Type Declarations](https://www.php.net/manual/es/functions.returning-values.php#functions.returning-values.type-declaration)

2. **Modern PHP Features:**
   - [Nullsafe Operator](https://www.php.net/manual/es/language.oop5.basic.php#language.oop5.basic.nullsafe)
   - [Match Expression](https://www.php.net/manual/es/control-structures.match.php)
   - [Static Methods](https://www.php.net/manual/es/language.oop5.static.php)

---

## Resumen

`UserResource` actúa como:
1. **Transformer:** Convierte modelos User en estructuras JSON consistentes
2. **Data Provider:** Provee configuraciones al frontend (columnas, campos, filtros)
3. **Business Logic Layer:** Centraliza lógica de presentación (labels, formateo)
4. **API Contract:** Define exactamente qué datos se exponen

**Beneficios:**
- ✅ Separación de preocupaciones
- ✅ Reutilización de código
- ✅ Configuración centralizada
- ✅ Frontend agnóstico (puede usarse con React, Vue, Angular, etc.)
- ✅ Type safety con PHP 8+
- ✅ Fácil mantenimiento

---

*Documentación generada siguiendo las mejores prácticas de Laravel 12 y PHP 8.2*

