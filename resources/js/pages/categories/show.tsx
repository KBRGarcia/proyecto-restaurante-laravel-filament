import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Category } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard } from '@/routes';
import categories from '@/routes/categories';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Edit, Tag, Calendar, Image as ImageIcon, ListOrdered } from 'lucide-react';

interface CategoryShowProps {
    category: Category;
}

export default function CategoryShow({ category }: CategoryShowProps) {
    // Verificar que category existe
    if (!category) {
        return (
            <AppLayout breadcrumbs={[]}>
                <Head title="Error" />
                <div className="flex h-full flex-1 flex-col items-center justify-center p-4">
                    <p className="text-lg text-muted-foreground">Categoría no encontrada</p>
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
            title: 'Categorías',
            href: categories.index().url,
        },
        {
            title: 'Ver Categoría',
            href: categories.show(category.id).url,
        },
    ];

    const getStatusBadgeVariant = (status: string): "default" | "secondary" | "destructive" | "outline" => {
        return status === 'active' ? 'default' : 'outline';
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Categoría - ${category.name}`} />
            
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-4">
                                {category.image ? (
                                    <img 
                                        src={category.image} 
                                        alt={category.name}
                                        className="size-16 rounded object-cover border-2 border-muted"
                                    />
                                ) : (
                                    <div className="size-16 rounded bg-muted flex items-center justify-center">
                                        <Tag className="size-8 text-muted-foreground" />
                                    </div>
                                )}
                                <div>
                                    <CardTitle className="flex items-center gap-2">
                                        {category.name}
                                    </CardTitle>
                                    <CardDescription className="flex items-center gap-2 mt-1">
                                        <Badge variant={getStatusBadgeVariant(category.status)}>
                                            {category.status_label}
                                        </Badge>
                                    </CardDescription>
                                </div>
                            </div>
                            <div className="flex gap-2">
                                <Link href={categories.edit(category.id).url}>
                                    <Button variant="default">
                                        <Edit className="mr-2 size-4" />
                                        Editar
                                    </Button>
                                </Link>
                                <Link href={categories.index().url}>
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
                            {/* Información de la Categoría */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Información de la Categoría</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <Tag className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Nombre</p>
                                            <p className="text-base">{category.name}</p>
                                        </div>
                                    </div>

                                    {category.description && (
                                        <div className="flex items-start gap-3">
                                            <Tag className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Descripción</p>
                                                <p className="text-base">{category.description}</p>
                                            </div>
                                        </div>
                                    )}

                                    <div className="flex items-start gap-3">
                                        <ListOrdered className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Orden de Visualización</p>
                                            <p className="text-base">{category.order_show}</p>
                                        </div>
                                    </div>

                                    {category.image && (
                                        <div className="flex items-start gap-3">
                                            <ImageIcon className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground mb-2">Imagen</p>
                                                <img 
                                                    src={category.image} 
                                                    alt={category.name}
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
                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Creado</p>
                                            <p className="text-base">
                                                {new Date(category.created_at).toLocaleString('es-ES', {
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
                                                {new Date(category.updated_at).toLocaleString('es-ES', {
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

