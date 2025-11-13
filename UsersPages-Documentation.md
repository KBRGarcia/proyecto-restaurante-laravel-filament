# Documentación: Carpeta Users (React 19 + Inertia.js 2.0)

## Tabla de Contenidos
1. [Introducción](#introducción)
2. [Archivo index.tsx](#archivo-indextsx)
3. [Archivo create.tsx](#archivo-createtsx)
4. [Archivo edit.tsx](#archivo-edittsx)
5. [Archivo show.tsx](#archivo-showtsx)
6. [Patrones Comunes](#patrones-comunes)
7. [Referencias Oficiales](#referencias-oficiales)

---

## Introducción

La carpeta `resources/js/pages/users` contiene los componentes de React 19 para la gestión de usuarios en la aplicación. Estos componentes utilizan Inertia.js 2.0 para la comunicación con el backend de Laravel sin necesidad de construir una API REST tradicional.

### Arquitectura General

```
users/
├── index.tsx   → Listado de usuarios con filtros y paginación
├── create.tsx  → Formulario para crear nuevos usuarios
├── edit.tsx    → Formulario para editar usuarios existentes
└── show.tsx    → Vista de detalles de un usuario
```

### Stack Tecnológico
- **React 19:** Framework de componentes
- **TypeScript:** Tipado estático
- **Inertia.js 2.0:** Bridge entre Laravel y React
- **Tailwind CSS:** Estilos utilitarios
- **Lucide React:** Biblioteca de iconos

**Referencias:**
- [React 19 Documentation](https://react.dev/)
- [Inertia.js 2.0 Documentation](https://inertiajs.com/)
- [TypeScript Documentation](https://www.typescriptlang.org/)

---

## Archivo index.tsx

### Propósito
Página de listado de usuarios con funcionalidades de:
- Búsqueda
- Filtrado por rol y estado
- Ordenamiento de columnas
- Paginación
- Acciones (ver, editar, eliminar)

### Imports Detallados

```typescript
import AppLayout from '@/layouts/app-layout';
```
- **Qué es:** Componente de layout que proporciona la estructura común de la aplicación
- **Por qué:** Evita duplicar código de navegación, header, sidebar en cada página
- **Alias `@/`:** Shortcut configurado para `resources/js/`

```typescript
import { type BreadcrumbItem, type User, type TableColumn, type FilterField, type Pagination } from '@/types';
```
- **`type` keyword:** Importación solo de tipos (eliminados en compilación)
- **Tipos importados:**
  - `BreadcrumbItem`: Estructura de las migas de pan
  - `User`: Interfaz del modelo de usuario
  - `TableColumn`: Configuración de columnas de tabla
  - `FilterField`: Configuración de campos de filtro
  - `Pagination`: Información de paginación
- **Por qué TypeScript:** Type safety, autocompletado, detección temprana de errores
- **Referencia:** [TypeScript Type-Only Imports](https://www.typescriptlang.org/docs/handbook/release-notes/typescript-3-8.html#type-only-imports-and-export)

```typescript
import { Head, Link, router } from '@inertiajs/react';
```
- **`Head`:** Componente para modificar el `<head>` del documento (título, meta tags)
- **`Link`:** Componente para navegación SPA (sin recargar la página)
- **`router`:** Objeto global de Inertia para navegación programática
- **Referencia:** [Inertia.js React Helpers](https://inertiajs.com/client-side-setup#react)

```typescript
import { dashboard } from '@/routes';
import users from '@/routes/users';
```
- **Helper de rutas:** Funciones que generan URLs de forma type-safe
- **Ejemplo:** `users.index().url` genera `/users`
- **Ventaja:** Si cambias las rutas en Laravel, solo actualizas el helper

```typescript
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
// ... más componentes UI
```
- **Componentes reutilizables:** Biblioteca de componentes UI personalizada
- **Patrón común:** Similar a shadcn/ui o Radix UI

```typescript
import { Edit, Eye, Plus, Search, Trash2, Users as UsersIcon } from 'lucide-react';
```
- **Lucide React:** Biblioteca de iconos SVG optimizados
- **`as UsersIcon`:** Renombra `Users` para evitar conflicto con tipos/variables
- **Referencia:** [Lucide React](https://lucide.dev/guide/packages/lucide-react)

```typescript
import { useState } from 'react';
```
- **`useState`:** Hook de React para manejar estado local
- **React 19:** Los hooks siguen siendo la forma estándar de manejar estado
- **Referencia:** [React 19 - useState](https://react.dev/reference/react/useState)

### Interfaces TypeScript

```typescript
interface UsersIndexProps {
    users: {
        data: User[];
    };
    columns: TableColumn[];
    filters: FilterField[];
    queryParams: {
        search?: string;
        role?: string;
        status?: string;
        sort_by?: string;
        sort_order?: string;
        per_page?: number;
    };
    pagination: Pagination;
}
```

#### Explicación de la Interfaz

- **`interface`:** Define la estructura de tipos de un objeto
- **`UsersIndexProps`:** Props que recibe el componente desde Laravel vía Inertia
- **Referencia:** [TypeScript Interfaces](https://www.typescriptlang.org/docs/handbook/2/objects.html)

##### Propiedad: users
```typescript
users: {
    data: User[];
};
```
- **Estructura anidada:** El objeto `users` contiene un array `data`
- **`User[]`:** Array de objetos tipo User
- **Por qué esta estructura:** Laravel paginate() retorna `{ data: [], links: [], meta: {} }`

##### Propiedad: columns
```typescript
columns: TableColumn[];
```
- **Origen:** Método `UserResource::tableColumns()`
- **Uso:** Definir qué columnas mostrar y cómo

##### Propiedad: queryParams
```typescript
queryParams: {
    search?: string;
    role?: string;
    // ...
};
```
- **`?` (Optional):** Los campos pueden ser undefined
- **Uso:** Parámetros actuales de la URL (filtros, ordenamiento)
- **Referencia:** [TypeScript Optional Properties](https://www.typescriptlang.org/docs/handbook/2/objects.html#optional-properties)

### Breadcrumbs

```typescript
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Usuarios',
        href: users.index().url,
    },
];
```

- **`const`:** Variable de solo lectura (no puede ser reasignada)
- **Tipo explícito:** `: BreadcrumbItem[]`
- **Propósito:** Navegación jerárquica (Dashboard > Usuarios)
- **Referencia:** [TypeScript const Assertions](https://www.typescriptlang.org/docs/handbook/release-notes/typescript-3-4.html#const-assertions)

### Componente UsersIndex

```typescript
export default function UsersIndex({ 
    users: usersData, 
    columns, 
    filters, 
    queryParams = {}, 
    pagination 
}: UsersIndexProps) {
```

#### Explicación de la Firma

- **`export default`:** Exportación por defecto (un solo export principal por archivo)
- **`function UsersIndex`:** Componente funcional de React
- **Destructuring de props:**
  - `users: usersData` - Renombra `users` a `usersData` para evitar confusión
  - `queryParams = {}` - Valor por defecto si no se proporciona
- **`: UsersIndexProps`:** Type annotation de las props
- **Referencia:** [React 19 - Components](https://react.dev/learn/your-first-component)

### Estado Local con useState

```typescript
const [search, setSearch] = useState(queryParams.search || '');
const [roleFilter, setRoleFilter] = useState(queryParams.role || '');
const [statusFilter, setStatusFilter] = useState(queryParams.status || '');
```

#### Explicación Detallada

- **`useState`:** Hook que retorna `[valor, función_actualizadora]`
- **Destructuring:** Extrae ambos valores del array retornado
- **Convención de nombres:** `[valor, setValue]` o `[nombre, setNombre]`
- **Valor inicial:** `queryParams.search || ''` - USA el parámetro de la URL o string vacío
- **Por qué estado local:** Para que el input sea controlado y se actualice al escribir
- **Referencia:** [React 19 - useState Hook](https://react.dev/reference/react/useState)

### Función handleSearch

```typescript
const handleSearch = () => {
    router.get(users.index().url, {
        search,
        role: roleFilter,
        status: statusFilter,
        per_page: queryParams.per_page || 10,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};
```

#### Explicación

##### router.get()
- **Qué es:** Método de Inertia para hacer peticiones GET
- **Parámetros:**
  1. URL de destino
  2. Objeto con query parameters
  3. Opciones de configuración

##### Opciones de Inertia

```typescript
{
    preserveState: true,
    preserveScroll: true,
}
```

- **`preserveState: true`:**
  - Mantiene el estado del componente después de la petición
  - Evita que se pierdan valores de formularios u otros estados locales
  
- **`preserveScroll: true`:**
  - Mantiene la posición del scroll después de la petición
  - Mejora UX: el usuario no vuelve al inicio de la página

- **Referencia:** [Inertia.js - Manual Visits](https://inertiajs.com/manual-visits)

### Función handleSort

```typescript
const handleSort = (column: string) => {
    const sortOrder = 
        queryParams.sort_by === column && queryParams.sort_order === 'asc' 
            ? 'desc' 
            : 'asc';

    router.get(users.index().url, {
        ...queryParams,
        sort_by: column,
        sort_order: sortOrder,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};
```

#### Explicación

##### Lógica de Toggle
```typescript
const sortOrder = 
    queryParams.sort_by === column && queryParams.sort_order === 'asc' 
        ? 'desc' 
        : 'asc';
```

- **Operador ternario:** `condición ? siVerdadero : siFalso`
- **Lógica:**
  - Si ya estamos ordenando por esta columna (`sort_by === column`)
  - Y el orden es ascendente (`sort_order === 'asc'`)
  - Entonces cambia a descendente (`'desc'`)
  - Sino, usa ascendente (`'asc'`)
- **Resultado:** Cada clic alterna entre asc/desc

##### Spread Operator
```typescript
{
    ...queryParams,
    sort_by: column,
    sort_order: sortOrder,
}
```

- **`...queryParams`:** Copia todas las propiedades de queryParams
- **Sobrescritura:** Los valores después reemplazan los copiados
- **Ventaja:** Mantiene todos los filtros existentes mientras cambia el ordenamiento
- **Referencia:** [JavaScript Spread Syntax](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_syntax)

### Función handleDelete

```typescript
const handleDelete = (userId: number) => {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        router.delete(users.destroy(userId).url, {
            preserveState: true,
            preserveScroll: true,
        });
    }
};
```

#### Explicación

- **`confirm()`:** Función nativa del navegador que muestra un diálogo de confirmación
- **`router.delete()`:** Método de Inertia para peticiones DELETE
- **Flujo:**
  1. Usuario hace clic en el botón de eliminar
  2. Aparece confirmación
  3. Si acepta, se envía petición DELETE al servidor
  4. Laravel procesa y elimina el usuario
  5. Inertia actualiza el componente con los nuevos datos
- **Referencia:** [Window.confirm()](https://developer.mozilla.org/en-US/docs/Web/API/Window/confirm)

### Funciones de Badge Variant

```typescript
const getRoleBadgeVariant = (role: string): "default" | "secondary" | "destructive" | "outline" => {
    switch (role) {
        case 'admin': return 'destructive';
        case 'employee': return 'secondary';
        case 'client': return 'default';
        default: return 'outline';
    }
};
```

#### Explicación

- **Tipo de retorno:** Union type con valores específicos permitidos
- **Propósito:** Determinar el color del badge según el rol
- **Convenciones de color:**
  - `destructive` (rojo) → Admin (alta importancia/peligro)
  - `secondary` (gris) → Employee
  - `default` (azul/primary) → Client
  - `outline` (borde) → Desconocido
- **Referencia:** [TypeScript Union Types](https://www.typescriptlang.org/docs/handbook/2/everyday-types.html#union-types)

### JSX - Estructura del Componente

```typescript
return (
    <AppLayout breadcrumbs={breadcrumbs}>
        <Head title="Usuarios" />
        
        <div className="flex h-full flex-1 flex-col gap-4 p-4">
            {/* Contenido */}
        </div>
    </AppLayout>
);
```

#### Componente Head

```typescript
<Head title="Usuarios" />
```

- **Propósito:** Establece el `<title>` de la página
- **Resultado HTML:** `<title>Usuarios - Nombre de la App</title>`
- **Importante para:** SEO, tabs del navegador, historial
- **Referencia:** [Inertia.js - Title & Meta](https://inertiajs.com/title-and-meta)

#### Clases de Tailwind

```typescript
className="flex h-full flex-1 flex-col gap-4 p-4"
```

- **`flex`:** Display flex
- **`h-full`:** Height 100%
- **`flex-1`:** Flex grow 1 (ocupa espacio disponible)
- **`flex-col`:** Dirección de columna (vertical)
- **`gap-4`:** Espacio entre elementos (1rem = 16px)
- **`p-4`:** Padding de 1rem en todos los lados
- **Referencia:** [Tailwind CSS Documentation](https://tailwindcss.com/docs)

### Sección de Filtros

```typescript
<div className="relative">
    <Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
    <Input
        type="text"
        placeholder="Buscar por nombre, apellido o email..."
        value={search}
        onChange={(e) => setSearch(e.target.value)}
        onKeyDown={(e) => e.key === 'Enter' && handleSearch()}
        className="pl-10"
    />
</div>
```

#### Icono Posicionado Absolutamente

```typescript
<Search className="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
```

- **`absolute`:** Posicionamiento absoluto respecto al padre relativo
- **`left-3`:** 0.75rem desde la izquierda
- **`top-1/2`:** 50% desde arriba
- **`-translate-y-1/2`:** Mueve -50% hacia arriba (centra verticalmente)
- **`size-4`:** Width y height de 1rem
- **Patrón común:** Icono dentro de un input

#### Input Controlado

```typescript
value={search}
onChange={(e) => setSearch(e.target.value)}
```

- **Input controlado:** React controla el valor (no el DOM)
- **`e.target.value`:** Valor actual del input
- **Ventaja:** Validación en tiempo real, formateo, etc.
- **Referencia:** [React 19 - Controlled Components](https://react.dev/reference/react-dom/components/input#controlling-an-input-with-a-state-variable)

#### Evento onKeyDown

```typescript
onKeyDown={(e) => e.key === 'Enter' && handleSearch()}
```

- **Arrow function:** `(parámetro) => expresión`
- **`e.key`:** Tecla presionada
- **`&&` como if:** Si `e.key === 'Enter'` es true, ejecuta `handleSearch()`
- **UX:** Permite buscar presionando Enter sin hacer clic en el botón
- **Referencia:** [React - Responding to Events](https://react.dev/learn/responding-to-events)

### Select Nativo

```typescript
<select
    value={roleFilter}
    onChange={(e) => setRoleFilter(e.target.value)}
    className="flex h-9 w-full rounded-md border border-input..."
>
    <option value="">Todos los roles</option>
    <option value="client">Cliente</option>
    <option value="employee">Empleado</option>
    <option value="admin">Administrador</option>
</select>
```

#### Explicación

- **Select nativo:** HTML `<select>` estilizado con Tailwind
- **Value vacío:** `<option value="">` representa "sin filtro"
- **Controlado:** Como el input, React maneja el valor
- **Por qué nativo:** Más accesible que componentes custom, funciona sin JS

### Tabla de Usuarios

```typescript
<table className="w-full text-sm">
    <thead className="border-b bg-muted/50">
        <tr>
            {columns.filter(col => col.visible).map((column) => (
                <th key={column.key} className="px-4 py-3 text-left font-medium text-muted-foreground">
                    {/* Contenido del header */}
                </th>
            ))}
        </tr>
    </thead>
    <tbody className="divide-y">
        {/* Filas de datos */}
    </tbody>
</table>
```

#### Array.filter() + Array.map()

```typescript
columns.filter(col => col.visible).map((column) => (
    <th key={column.key}>...</th>
))
```

- **`.filter()`:** Crea nuevo array solo con elementos que cumplan la condición
- **`.map()`:** Transforma cada elemento del array en JSX
- **Chain:** Primero filtra columnas visibles, luego las mapea a `<th>`
- **`key={column.key}`:** Requerido por React para optimizar re-renders
- **Referencia:** [React - Rendering Lists](https://react.dev/learn/rendering-lists)

#### Columna Sortable

```typescript
{column.sortable ? (
    <button
        onClick={() => handleSort(column.key)}
        className="flex items-center gap-1 hover:text-foreground"
    >
        {column.label}
        {queryParams.sort_by === column.key && (
            <span className="text-xs">
                {queryParams.sort_order === 'asc' ? '↑' : '↓'}
            </span>
        )}
    </button>
) : (
    column.label
)}
```

##### Conditional Rendering

- **Operador ternario:** Si `column.sortable` es true, renderiza button, sino solo el label
- **Nested conditional:** Dentro del button, otro condicional para el icono
- **`&&` operator:** Solo renderiza el `<span>` si la columna está actualmente ordenada
- **Referencia:** [React - Conditional Rendering](https://react.dev/learn/conditional-rendering)

### Cuerpo de la Tabla

```typescript
<tbody className="divide-y">
    {usersData.data.length === 0 ? (
        <tr>
            <td colSpan={columns.filter(col => col.visible).length + 1}
                className="px-4 py-8 text-center text-muted-foreground">
                No se encontraron usuarios
            </td>
        </tr>
    ) : (
        usersData.data.map((user) => (
            <tr key={user.id} className="hover:bg-muted/50">
                {/* Celdas */}
            </tr>
        ))
    )}
</tbody>
```

#### Estado Vacío

```typescript
usersData.data.length === 0 ? (
    <tr>
        <td colSpan={...}>No se encontraron usuarios</td>
    </tr>
) : (...)
```

- **`colSpan`:** Fusiona celdas horizontalmente
- **Cálculo:** Número de columnas visibles + 1 (columna de acciones)
- **UX:** Mensaje claro cuando no hay datos

#### Renderizado de Filas

```typescript
usersData.data.map((user) => (
    <tr key={user.id} className="hover:bg-muted/50">
        <td className="px-4 py-3">{user.id}</td>
        <td className="px-4 py-3 font-medium">{user.full_name}</td>
        {/* Más celdas */}
    </tr>
))
```

- **`key={user.id}`:** Identificador único para cada fila
- **`hover:bg-muted/50`:** Background al pasar el mouse (UX)
- **Acceso directo:** `user.id`, `user.full_name` - propiedades del objeto User

#### Badge en Celda

```typescript
<td className="px-4 py-3">
    <Badge variant={getRoleBadgeVariant(user.role)}>
        {user.role_label}
    </Badge>
</td>
```

- **Componente Badge:** Etiqueta visual con color
- **`variant`:** Determinado dinámicamente por `getRoleBadgeVariant()`
- **Contenido:** `user.role_label` (traducido desde el backend)

#### Formateo de Fechas

```typescript
<td className="px-4 py-3">
    {user.registration_date 
        ? new Date(user.registration_date).toLocaleDateString('es-ES')
        : '-'
    }
</td>
```

- **`new Date()`:** Constructor de objeto Date de JavaScript
- **`toLocaleDateString('es-ES')`:** Formatea fecha según locale español
- **Conditional:** Si no hay fecha, muestra '-'
- **Referencia:** [Date.prototype.toLocaleDateString()](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date/toLocaleDateString)

### Botones de Acción

```typescript
<div className="flex items-center justify-end gap-2">
    <Link href={users.show(user.id).url}>
        <Button variant="outline" size="sm">
            <Eye className="size-4" />
        </Button>
    </Link>
    <Link href={users.edit(user.id).url}>
        <Button variant="outline" size="sm">
            <Edit className="size-4" />
        </Button>
    </Link>
    <Button
        variant="outline"
        size="sm"
        onClick={() => handleDelete(user.id)}
    >
        <Trash2 className="size-4 text-destructive" />
    </Button>
</div>
```

#### Link de Inertia vs Button con onClick

- **Link:** Para navegación (GET requests)
  - Ver usuario
  - Editar usuario
  
- **Button con onClick:** Para acciones (DELETE, POST, etc.)
  - Eliminar usuario

#### Size Prop

```typescript
size="sm"
```

- **Variante de tamaño:** Botón pequeño
- **Útil en:** Tablas, toolbars, espacios reducidos

### Paginación

```typescript
{pagination.total > 0 && (
    <div className="mt-4 flex items-center justify-between">
        <p className="text-sm text-muted-foreground">
            Mostrando {pagination.from} a {pagination.to} de {pagination.total} usuarios
        </p>
        <div className="flex gap-2">
            {Array.from({ length: pagination.last_page }, (_, i) => i + 1).map((page) => (
                <Button
                    key={page}
                    variant={page === pagination.current_page ? 'default' : 'outline'}
                    size="sm"
                    onClick={() => {
                        router.get(users.index().url, {
                            ...queryParams,
                            page,
                        }, {
                            preserveState: true,
                            preserveScroll: true,
                        });
                    }}
                >
                    {page}
                </Button>
            ))}
        </div>
    </div>
)}
```

#### Array.from()

```typescript
Array.from({ length: pagination.last_page }, (_, i) => i + 1)
```

- **`Array.from()`:** Crea array desde un objeto array-like
- **`{ length: n }`:** Objeto con propiedad length
- **Función mapeadora:** `(_, i) => i + 1`
  - `_` = Valor (undefined, no lo usamos)
  - `i` = Índice (0, 1, 2, ...)
  - Retorna `i + 1` (1, 2, 3, ...)
- **Resultado:** `[1, 2, 3, ..., last_page]`
- **Referencia:** [Array.from()](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/from)

#### Botón de Página Activa

```typescript
variant={page === pagination.current_page ? 'default' : 'outline'}
```

- **Lógica:** Si es la página actual, usa variant 'default' (destacado)
- **Sino:** Usa 'outline' (sin fondo)
- **UX:** Usuario sabe en qué página está

---

## Archivo create.tsx

### Propósito
Formulario para crear nuevos usuarios con:
- Campos dinámicos basados en configuración del backend
- Validación en tiempo real
- Soporte para subida de archivos
- Manejo de errores

### Imports Específicos

```typescript
import { useForm } from '@inertiajs/react';
```

- **`useForm`:** Hook de Inertia para manejo de formularios
- **Funcionalidad:**
  - Estado del formulario
  - Métodos de envío (post, put, patch, delete)
  - Estado de procesamiento
  - Manejo de errores
- **Referencia:** [Inertia.js - Forms](https://inertiajs.com/forms)

### Interface FormField

```typescript
interface FormField {
    name: string;
    label: string;
    type: string;
    placeholder: string;
    required: boolean;
    validation: string;
    grid_cols?: number;
    help_text?: string;
    show_on_edit?: boolean;
    options?: { value: string; label: string }[];
    default?: string;
    rows?: number;
    accept?: string;
}
```

#### Explicación

- **Propósito:** Define la estructura de cada campo del formulario
- **Origen:** Viene desde `UserResource::formFields()`
- **Props opcionales (`?`):** No todos los campos tienen todas las propiedades

### useForm Hook

```typescript
const { data, setData, post, processing, errors } = useForm({
    name: '',
    last_name: '',
    email: '',
    phone_number: '',
    password: '',
    password_confirmation: '',
    address: '',
    role: 'client',
    status: 'active',
    profile_picture: null as File | null,
});
```

#### Desestructuración del Hook

- **`data`:** Objeto con todos los valores del formulario
- **`setData`:** Función para actualizar valores
- **`post`:** Función para enviar formulario con POST
- **`processing`:** Boolean que indica si hay una petición en curso
- **`errors`:** Objeto con errores de validación del servidor

#### Valores Iniciales

```typescript
{
    name: '',              // String vacío
    role: 'client',        // Valor por defecto
    profile_picture: null as File | null,  // Type assertion
}
```

- **Strings vacíos:** Para inputs de texto
- **Valores por defecto:** Para selects (client, active)
- **`as File | null`:** Type assertion de TypeScript
  - Le dice a TS que el valor puede ser File o null
  - Necesario porque TypeScript no puede inferir el tipo automáticamente
- **Referencia:** [TypeScript Type Assertions](https://www.typescriptlang.org/docs/handbook/2/everyday-types.html#type-assertions)

### Función handleSubmit

```typescript
const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (data.profile_picture) {
        router.post(users.store().url, data as any, {
            forceFormData: true,
        });
    } else {
        post(users.store().url);
    }
};
```

#### Prevención del Comportamiento por Defecto

```typescript
e.preventDefault();
```

- **`e`:** Evento del formulario
- **`preventDefault()`:** Evita que el formulario se envíe tradicionalmente
- **Por qué:** Inertia maneja el envío, no queremos recargar la página
- **Referencia:** [Event.preventDefault()](https://developer.mozilla.org/en-US/docs/Web/API/Event/preventDefault)

#### Lógica Condicional para Archivos

```typescript
if (data.profile_picture) {
    router.post(users.store().url, data as any, {
        forceFormData: true,
    });
} else {
    post(users.store().url);
}
```

- **Con archivo:** Usa `router.post()` con `forceFormData: true`
  - **`forceFormData`:** Convierte datos a FormData (necesario para archivos)
  - **`as any`:** Type assertion para evitar error de TypeScript
  
- **Sin archivo:** Usa `post()` directamente
  - Envía JSON normal (más eficiente)

- **Referencia:** [Inertia.js - File Uploads](https://inertiajs.com/file-uploads)

### Función handleFileChange

```typescript
const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files[0]) {
        setData('profile_picture', e.target.files[0]);
    }
};
```

#### Tipo del Evento

```typescript
e: React.ChangeEvent<HTMLInputElement>
```

- **`React.ChangeEvent`:** Tipo de evento de cambio
- **`<HTMLInputElement>`:** Generic que especifica el tipo de elemento
- **Type safety:** TypeScript sabe que `e.target` es un input

#### Verificación de Archivo

```typescript
if (e.target.files && e.target.files[0]) {
    setData('profile_picture', e.target.files[0]);
}
```

- **`e.target.files`:** FileList (puede ser null)
- **`e.target.files[0]`:** Primer archivo (puede no existir)
- **Verificación doble:** Asegura que hay archivos antes de acceder
- **`setData()`:** Actualiza el estado con el archivo seleccionado

### Función renderField

```typescript
const renderField = (field: FormField) => {
    // Lógica de renderizado
    switch (field.type) {
        case 'text':
        case 'email':
            return (/* JSX */);
        case 'password':
            return (/* JSX */);
        case 'textarea':
            return (/* JSX */);
        case 'select':
            return (/* JSX */);
        case 'file':
            return (/* JSX */);
        default:
            return null;
    }
};
```

#### Propósito

- **Función auxiliar:** Genera el JSX para cada tipo de campo
- **DRY:** Evita duplicar código para cada campo
- **Flexible:** Fácil agregar nuevos tipos de campos

#### Grid Mapping

```typescript
const gridColsMap: Record<number, string> = {
    1: 'col-span-1',
    2: 'col-span-2',
    // ...
    12: 'col-span-12',
};
const gridClass = field.grid_cols ? gridColsMap[field.grid_cols] : 'col-span-12';
```

##### Record Type

```typescript
Record<number, string>
```

- **`Record<K, V>`:** Tipo de TypeScript para objetos con claves tipo K y valores tipo V
- **En este caso:** Claves numéricas (1-12), valores string (clases CSS)
- **Referencia:** [TypeScript Record Utility Type](https://www.typescriptlang.org/docs/handbook/utility-types.html#recordkeys-type)

##### Por Qué Este Mapeo

- **Problema:** Tailwind solo genera clases que encuentra explícitamente en el código
- **Solución:** Escribir las clases completas en lugar de concatenar strings
- **Sin mapeo:** `col-span-${field.grid_cols}` → No funciona con Tailwind
- **Con mapeo:** `'col-span-6'` → Tailwind lo reconoce
- **Referencia:** [Tailwind - Dynamic Class Names](https://tailwindcss.com/docs/content-configuration#dynamic-class-names)

#### Campo de Texto

```typescript
case 'text':
case 'email':
    return (
        <div key={field.name} className={gridClass}>
            <Label htmlFor={field.name}>
                {field.label}
                {field.required && <span className="text-destructive ml-1">*</span>}
            </Label>
            <Input
                id={field.name}
                type={field.type}
                placeholder={field.placeholder}
                value={value as string}
                onChange={(e) => setData(field.name as any, e.target.value)}
                className={errors[field.name as keyof typeof errors] ? 'border-destructive' : ''}
                required={field.required}
            />
            {errors[field.name as keyof typeof errors] && (
                <p className="text-sm text-destructive mt-1">
                    {errors[field.name as keyof typeof errors]}
                </p>
            )}
            {field.help_text && !errors[field.name as keyof typeof errors] && (
                <p className="text-sm text-muted-foreground mt-1">{field.help_text}</p>
            )}
        </div>
    );
```

##### Key Prop

```typescript
key={field.name}
```

- **Requerido por React:** Cuando renderizas arrays de elementos
- **Valor único:** `field.name` es único para cada campo
- **Optimización:** React usa keys para determinar qué elementos cambiaronnecesary

##### Asterisco de Obligatorio

```typescript
{field.required && <span className="text-destructive ml-1">*</span>}
```

- **Conditional rendering:** Solo si `field.required` es true
- **UX:** Indica visualmente campos obligatorios
- **Color:** `text-destructive` (rojo)

##### Binding de Valor

```typescript
value={value as string}
onChange={(e) => setData(field.name as any, e.target.value)}
```

- **`value`:** Valor actual del campo desde `data`
- **`as string`:** Type assertion (sabemos que es string)
- **`onChange`:** Actualiza el estado cuando el usuario escribe
- **`field.name as any`:** Type assertion necesaria para TypeScript

##### Mostrar Errores

```typescript
{errors[field.name as keyof typeof errors] && (
    <p className="text-sm text-destructive mt-1">
        {errors[field.name as keyof typeof errors]}
    </p>
)}
```

- **`errors[field.name]`:** Accede al error de este campo
- **`as keyof typeof errors`:** Type assertion para TypeScript
- **Conditional:** Solo renderiza si hay error
- **Origen de errores:** Validación del servidor (Laravel)

#### Campo Select

```typescript
<select
    id={field.name}
    value={value as string}
    onChange={(e) => setData(field.name as any, e.target.value)}
    className={...}
    required={field.required}
>
    {field.placeholder && (
        <option value="">{field.placeholder}</option>
    )}
    {field.options?.map((option) => (
        <option key={option.value} value={option.value}>
            {option.label}
        </option>
    ))}
</select>
```

##### Optional Chaining en Map

```typescript
field.options?.map((option) => (...))
```

- **`?.`:** Optional chaining operator
- **Función:** Si `field.options` es undefined/null, no ejecuta `.map()` y retorna undefined
- **Sin `?.`:** Si `field.options` es undefined, causaría error
- **Referencia:** [JavaScript Optional Chaining](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Optional_chaining)

#### Campo File

```typescript
<Input
    id={field.name}
    type="file"
    accept={field.accept}
    onChange={handleFileChange}
    className={...}
/>
```

- **`type="file"`:** Input de selección de archivos
- **`accept`:** Filtra tipos de archivos (ej: `image/*`)
- **`onChange`:** Usa `handleFileChange` en lugar de `setData` directo
- **No tiene `value`:** Los inputs file no pueden tener valor por seguridad

### Formulario Principal

```typescript
<form onSubmit={handleSubmit}>
    <div className="grid grid-cols-12 gap-4">
        {fields.map(renderField)}
    </div>

    <div className="mt-6 flex items-center justify-end gap-3">
        <Link href={users.index().url}>
            <Button type="button" variant="outline">
                Cancelar
            </Button>
        </Link>
        <Button type="submit" disabled={processing}>
            {processing ? (
                <span className="mr-2">Creando...</span>
            ) : (
                <>
                    <Save className="mr-2 size-4" />
                    Crear Usuario
                </>
            )}
        </Button>
    </div>
</form>
```

#### Grid System

```typescript
<div className="grid grid-cols-12 gap-4">
```

- **`grid`:** Display grid de CSS
- **`grid-cols-12`:** 12 columnas (sistema bootstrap-like)
- **`gap-4`:** Espacio entre elementos
- **Cada campo:** Usa `col-span-{n}` para ocupar n columnas

#### Fragment Corto

```typescript
<>
    <Save className="mr-2 size-4" />
    Crear Usuario
</>
```

- **`<>...</>`:** Sintaxis corta para `<React.Fragment>`
- **Propósito:** Agrupar múltiples elementos sin agregar nodo DOM
- **Referencia:** [React - Fragments](https://react.dev/reference/react/Fragment)

#### Estado de Procesamiento

```typescript
disabled={processing}
```

- **Deshabilita botón:** Mientras hay una petición en curso
- **UX:** Evita múltiples envíos accidentales
- **`processing`:** Automáticamente manejado por Inertia

---

## Archivo edit.tsx

### Propósito
Similar a `create.tsx` pero para editar usuarios existentes.

### Diferencias Clave con create.tsx

#### Props

```typescript
interface UserEditProps {
    user: User;
    fields: FormField[];
}
```

- **Prop adicional:** `user` - Usuario a editar
- **Uso:** Pre-poblar el formulario con datos existentes

#### Inicialización del Formulario

```typescript
const { data, setData, put, processing, errors } = useForm({
    name: user.name || '',
    last_name: user.last_name || '',
    email: user.email || '',
    // ...
});
```

- **Valores iniciales:** Vienen del objeto `user`
- **Fallback:** `|| ''` por si el campo es null/undefined
- **Método:** `put` en lugar de `post`

#### Manejo del Submit

```typescript
const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (data.profile_picture) {
        router.post(users.update(user.id).url, {
            ...data,
            _method: 'PUT',
        } as any, {
            forceFormData: true,
        });
    } else {
        put(users.update(user.id).url);
    }
};
```

##### _method Spoofing

```typescript
_method: 'PUT',
```

- **Qué es:** Method spoofing de Laravel
- **Por qué:** Los formularios HTML solo soportan GET y POST
- **Cómo funciona:**
  1. Se envía como POST
  2. Laravel ve el campo `_method: 'PUT'`
  3. Laravel trata la petición como PUT
- **Referencia:** [Laravel - Form Method Spoofing](https://laravel.com/docs/12.x/routing#form-method-spoofing)

#### Renderizado de Campos de Contraseña

```typescript
if (field.show_on_edit === false && (field.name === 'password' || field.name === 'password_confirmation')) {
    return (
        <div key={field.name} className={passwordGridClass}>
            <Label htmlFor={field.name}>
                {field.label}
                <span className="text-muted-foreground ml-1">(Opcional - dejar en blanco para mantener la actual)</span>
            </Label>
            <Input
                id={field.name}
                type="password"
                placeholder={field.placeholder}
                value={data[field.name as keyof typeof data] as string}
                onChange={(e) => setData(field.name as any, e.target.value)}
                className={errors[field.name as keyof typeof errors] ? 'border-destructive' : ''}
            />
        </div>
    );
}
```

- **Lógica especial:** Campos de contraseña son opcionales en edición
- **UX:** Texto explicativo indica que puede dejarse en blanco
- **Backend:** Debe manejar contraseñas opcionales en updates

#### Preview de Imagen

```typescript
{user.profile_picture && (
    <div className="mb-2">
        <img 
            src={user.profile_picture} 
            alt="Foto actual" 
            className="h-20 w-20 rounded-full object-cover"
        />
        <p className="text-xs text-muted-foreground mt-1">Foto actual</p>
    </div>
)}
```

- **Conditional:** Solo si hay foto actual
- **Clases:**
  - `h-20 w-20`: Tamaño fijo
  - `rounded-full`: Círculo perfecto
  - `object-cover`: Recorta imagen para llenar el círculo
- **UX:** Usuario ve la foto actual antes de cambiarla

---

## Archivo show.tsx

### Propósito
Vista de solo lectura de los detalles de un usuario.

### Características Principales
- No hay formularios ni inputs
- Layout de dos columnas
- Información personal e información del sistema
- Badges para rol y estado
- Botones para editar y volver

### Sin useState ni useForm

```typescript
export default function UserShow({ user }: UserShowProps) {
    // No hay hooks de estado o formulario
    // Todo es estático basado en las props
```

- **Props solamente:** No necesita estado local
- **Componente presentacional:** Solo muestra datos

### Layout de Dos Columnas

```typescript
<div className="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div className="space-y-4">
        <h3>Información Personal</h3>
        {/* Campos personales */}
    </div>
    
    <div className="space-y-4">
        <h3>Información del Sistema</h3>
        {/* Campos del sistema */}
    </div>
</div>
```

#### Responsive Grid

- **`grid-cols-1`:** Una columna en móvil
- **`md:grid-cols-2`:** Dos columnas en tablets y escritorio
- **`md:`:** Prefijo de Tailwind para breakpoint medium (768px+)
- **Referencia:** [Tailwind - Responsive Design](https://tailwindcss.com/docs/responsive-design)

### Patrón de Campo de Información

```typescript
<div className="flex items-start gap-3">
    <Mail className="size-5 text-muted-foreground mt-0.5" />
    <div>
        <p className="text-sm font-medium text-muted-foreground">Correo Electrónico</p>
        <p className="text-base">{user.email}</p>
        {user.email_verified_at && (
            <p className="text-xs text-green-600 dark:text-green-400 mt-1">
                ✓ Verificado
            </p>
        )}
    </div>
</div>
```

#### Estructura

1. **Icono:** Representación visual del tipo de dato
2. **Label:** Descripción del campo
3. **Valor:** Dato del usuario
4. **Indicador condicional:** Información adicional si aplica

#### Dark Mode Variant

```typescript
className="text-green-600 dark:text-green-400"
```

- **`dark:`:** Prefijo para dark mode
- **Color diferente:** Verde más claro en dark mode para contraste
- **Referencia:** [Tailwind - Dark Mode](https://tailwindcss.com/docs/dark-mode)

### Formateo Avanzado de Fechas

```typescript
{user.registration_date 
    ? new Date(user.registration_date).toLocaleString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
    : '-'
}
```

#### toLocaleString Options

```typescript
{
    year: 'numeric',     // 2025
    month: 'long',       // enero, febrero, ...
    day: 'numeric',      // 1, 2, ..., 31
    hour: '2-digit',     // 01, 02, ..., 23
    minute: '2-digit'    // 00, 01, ..., 59
}
```

- **Resultado:** "15 de enero de 2025, 14:30"
- **Locale:** `'es-ES'` para español de España
- **Referencia:** [Intl.DateTimeFormat](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/DateTimeFormat)

### Conditional Field Rendering

```typescript
{user.phone_number && (
    <div className="flex items-start gap-3">
        <Phone className="size-5 text-muted-foreground mt-0.5" />
        <div>
            <p className="text-sm font-medium text-muted-foreground">Teléfono</p>
            <p className="text-base">{user.phone_number}</p>
        </div>
    </div>
)}
```

- **Solo si existe:** Campos opcionales solo se renderizan si tienen valor
- **UX:** No muestra campos vacíos innecesariamente

---

## Patrones Comunes

### 1. Tipado TypeScript

**Props con Interface:**
```typescript
interface ComponentProps {
    user: User;
    columns: TableColumn[];
}

function Component({ user, columns }: ComponentProps) {
    // ...
}
```

**Ventajas:**
- Autocompletado en IDE
- Detección de errores en tiempo de desarrollo
- Documentación implícita del código

### 2. Inertia.js Patterns

**Navigation:**
```typescript
// Con Link (preferido para navegación)
<Link href={users.show(id).url}>
    <Button>Ver</Button>
</Link>

// Con router (para lógica programática)
router.get(url, data, options);
```

**Form Handling:**
```typescript
const { data, setData, post, processing, errors } = useForm({...});

const handleSubmit = (e) => {
    e.preventDefault();
    post(url);
};
```

### 3. Conditional Rendering

**Operador &&:**
```typescript
{condition && <Component />}
```

**Operador Ternario:**
```typescript
{condition ? <ComponentA /> : <ComponentB />}
```

**Optional Rendering:**
```typescript
{value || '-'}  // Muestra '-' si value es falsy
```

### 4. Tailwind CSS Patterns

**Flexbox Centering:**
```typescript
className="flex items-center justify-center"
```

**Grid Layout:**
```typescript
className="grid grid-cols-12 gap-4"
// Hijos: className="col-span-6"
```

**Responsive:**
```typescript
className="flex-col md:flex-row"  // Columna en móvil, fila en desktop
```

**Hover States:**
```typescript
className="hover:bg-muted transition-colors"
```

### 5. Array Operations

**Filter + Map:**
```typescript
items
    .filter(item => item.visible)
    .map(item => <Component key={item.id} {...item} />)
```

**Array.from para Rangos:**
```typescript
Array.from({ length: 10 }, (_, i) => i + 1)
// [1, 2, 3, ..., 10]
```

### 6. Event Handling

**Inline Arrow Functions:**
```typescript
onClick={() => handleClick(id)}
onChange={(e) => setValue(e.target.value)}
onKeyDown={(e) => e.key === 'Enter' && handleSubmit()}
```

### 7. Error Display Pattern

```typescript
{errors.fieldName && (
    <p className="text-sm text-destructive mt-1">
        {errors.fieldName}
    </p>
)}
```

---

## Referencias Oficiales

### React 19

1. **Core Concepts:**
   - [Components](https://react.dev/learn/your-first-component)
   - [Props](https://react.dev/learn/passing-props-to-a-component)
   - [State](https://react.dev/learn/state-a-components-memory)
   - [Hooks](https://react.dev/reference/react)

2. **Hooks:**
   - [useState](https://react.dev/reference/react/useState)
   - [useEffect](https://react.dev/reference/react/useEffect)
   - [Custom Hooks](https://react.dev/learn/reusing-logic-with-custom-hooks)

3. **Advanced:**
   - [Conditional Rendering](https://react.dev/learn/conditional-rendering)
   - [Rendering Lists](https://react.dev/learn/rendering-lists)
   - [Responding to Events](https://react.dev/learn/responding-to-events)

### Inertia.js 2.0

1. **Getting Started:**
   - [Client-Side Setup](https://inertiajs.com/client-side-setup)
   - [Pages](https://inertiajs.com/pages)
   - [Links](https://inertiajs.com/links)

2. **Forms:**
   - [Form Helper](https://inertiajs.com/forms)
   - [File Uploads](https://inertiajs.com/file-uploads)
   - [Validation](https://inertiajs.com/validation)

3. **Advanced:**
   - [Manual Visits](https://inertiajs.com/manual-visits)
   - [Redirects](https://inertiajs.com/redirects)
   - [Progress Indicators](https://inertiajs.com/progress-indicators)

### TypeScript

1. **Basics:**
   - [Basic Types](https://www.typescriptlang.org/docs/handbook/2/everyday-types.html)
   - [Interfaces](https://www.typescriptlang.org/docs/handbook/2/objects.html)
   - [Type Assertions](https://www.typescriptlang.org/docs/handbook/2/everyday-types.html#type-assertions)

2. **Advanced:**
   - [Generics](https://www.typescriptlang.org/docs/handbook/2/generics.html)
   - [Utility Types](https://www.typescriptlang.org/docs/handbook/utility-types.html)
   - [React TypeScript](https://react-typescript-cheatsheet.netlify.app/)

### JavaScript Moderno

1. **ES6+ Features:**
   - [Arrow Functions](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions)
   - [Destructuring](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment)
   - [Spread Operator](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_syntax)
   - [Optional Chaining](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Optional_chaining)

2. **Array Methods:**
   - [map()](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/map)
   - [filter()](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/filter)
   - [Array.from()](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/from)

3. **Date & Time:**
   - [Date](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date)
   - [Intl.DateTimeFormat](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/DateTimeFormat)

### Tailwind CSS

1. **Core:**
   - [Utility-First](https://tailwindcss.com/docs/utility-first)
   - [Responsive Design](https://tailwindcss.com/docs/responsive-design)
   - [Dark Mode](https://tailwindcss.com/docs/dark-mode)

2. **Layout:**
   - [Flexbox](https://tailwindcss.com/docs/flex)
   - [Grid](https://tailwindcss.com/docs/grid-template-columns)
   - [Spacing](https://tailwindcss.com/docs/padding)

---

## Resumen

### Flujo de Datos

1. **Laravel → Inertia → React:**
   ```
   Controller → Resource → Inertia::render() → React Component Props
   ```

2. **React → Inertia → Laravel:**
   ```
   Form Submit → router.post() → Laravel Controller → Validation → Database
   ```

### Ventajas de esta Arquitectura

✅ **No API REST necesaria:** Inertia maneja la comunicación
✅ **Type Safety:** TypeScript en frontend, PHP en backend
✅ **SPA Experience:** Sin recargas de página
✅ **SEO Friendly:** Server-side rendering inicial
✅ **Form Handling:** Manejo automático de errores y validación
✅ **File Uploads:** Soporte nativo con FormData
✅ **Code Sharing:** Configuraciones desde el backend

### Best Practices Implementadas

1. **Componentes pequeños y enfocados**
2. **Tipado estricto con TypeScript**
3. **Manejo de errores comprehensivo**
4. **UX optimizada (loading states, confirmaciones)**
5. **Responsive design con Tailwind**
6. **Accesibilidad (labels, semantic HTML)**
7. **Reutilización de código (renderField, helpers)**

---

*Documentación generada siguiendo las mejores prácticas de React 19, Inertia.js 2.0 y TypeScript*

