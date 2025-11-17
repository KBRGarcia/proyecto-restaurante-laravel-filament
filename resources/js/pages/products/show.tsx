import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Product } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard } from '@/routes';
import products from '@/routes/products';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Edit, Package, Calendar, DollarSign, Clock, Tag, Star, ChefHat } from 'lucide-react';

interface ProductShowProps {
    product: Product;
}

export default function ProductShow({ product }: ProductShowProps) {
    // Verificar que product existe
    if (!product) {
        return (
            <AppLayout breadcrumbs={[]}>
                <Head title="Error" />
                <div className="flex h-full flex-1 flex-col items-center justify-center p-4">
                    <p className="text-lg text-muted-foreground">Producto no encontrado</p>
                </div>
            </AppLayout>
        );
    }

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: dashboard().url,
        },
        {
            title: 'Productos',
            href: products.index().url,
        },
        {
            title: 'Ver Producto',
            href: products.show(product.id).url,
        },
    ];

    const getStatusBadgeVariant = (status: string): "default" | "secondary" | "destructive" | "outline" => {
        switch (status) {
            case 'active': return 'default';
            case 'inactive': return 'outline';
            case 'out of stock': return 'destructive';
            default: return 'outline';
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Producto - ${product.name}`} />
            
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-4">
                                {product.image ? (
                                    <img 
                                        src={product.image} 
                                        alt={product.name}
                                        className="size-16 rounded object-cover border-2 border-muted"
                                    />
                                ) : (
                                    <div className="size-16 rounded bg-muted flex items-center justify-center">
                                        <Package className="size-8 text-muted-foreground" />
                                    </div>
                                )}
                                <div>
                                    <CardTitle className="flex items-center gap-2">
                                        {product.name}
                                        {product.is_special && (
                                            <Badge variant="secondary" className="ml-2">
                                                <Star className="size-3 mr-1" />
                                                Especial
                                            </Badge>
                                        )}
                                    </CardTitle>
                                    <CardDescription className="flex items-center gap-2 mt-1">
                                        <Badge variant={getStatusBadgeVariant(product.status)}>
                                            {product.status_label}
                                        </Badge>
                                        {product.category_name && (
                                            <Badge variant="outline">
                                                <Tag className="size-3 mr-1" />
                                                {product.category_name}
                                            </Badge>
                                        )}
                                    </CardDescription>
                                </div>
                            </div>
                            <div className="flex gap-2">
                                <Link href={products.edit(product.id).url}>
                                    <Button variant="default">
                                        <Edit className="mr-2 size-4" />
                                        Editar
                                    </Button>
                                </Link>
                                <Link href={products.index().url}>
                                    <Button variant="outline">
                                        <ArrowLeft className="mr-2 size-4" />
                                        Volver
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {/* Información del Producto */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Información del Producto</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <Package className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Nombre</p>
                                            <p className="text-base">{product.name}</p>
                                        </div>
                                    </div>

                                    {product.description && (
                                        <div className="flex items-start gap-3">
                                            <Package className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Descripción</p>
                                                <p className="text-base">{product.description}</p>
                                            </div>
                                        </div>
                                    )}

                                    <div className="flex items-start gap-3">
                                        <DollarSign className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Precio</p>
                                            <p className="text-base font-semibold text-green-600 dark:text-green-400">
                                                ${parseFloat(product.price).toFixed(2)}
                                            </p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Clock className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Tiempo de Preparación</p>
                                            <p className="text-base">{product.preparation_time} minutos</p>
                                        </div>
                                    </div>

                                    {product.ingredients && (
                                        <div className="flex items-start gap-3">
                                            <ChefHat className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Ingredientes</p>
                                                <p className="text-base">{product.ingredients}</p>
                                            </div>
                                        </div>
                                    )}

                                    {product.image && (
                                        <div className="flex items-start gap-3">
                                            <Package className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground mb-2">Imagen</p>
                                                <img 
                                                    src={product.image} 
                                                    alt={product.name}
                                                    className="w-full max-w-sm rounded-lg border"
                                                />
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Información del Sistema */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Información del Sistema</h3>
                                
                                <div className="space-y-3">
                                    {product.creation_date && (
                                        <div className="flex items-start gap-3">
                                            <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Fecha de Creación del Producto</p>
                                                <p className="text-base">
                                                    {new Date(product.creation_date).toLocaleString('es-ES', {
                                                        year: 'numeric',
                                                        month: 'long',
                                                        day: 'numeric',
                                                        hour: '2-digit',
                                                        minute: '2-digit'
                                                    })}
                                                </p>
                                            </div>
                                        </div>
                                    )}

                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Creado en el Sistema</p>
                                            <p className="text-base">
                                                {new Date(product.created_at).toLocaleString('es-ES', {
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric',
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                })}
                                            </p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Última Actualización</p>
                                            <p className="text-base">
                                                {new Date(product.updated_at).toLocaleString('es-ES', {
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric',
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                })}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}

