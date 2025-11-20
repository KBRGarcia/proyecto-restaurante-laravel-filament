import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Evaluation } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard } from '@/routes';
import evaluations from '@/routes/evaluations';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Edit, Star, User, Package, ShoppingCart, Calendar, MessageSquare } from 'lucide-react';

interface EvaluationShowProps {
    evaluation: Evaluation;
}

export default function EvaluationShow({ evaluation }: EvaluationShowProps) {
    if (!evaluation) {
        return (
            <AppLayout breadcrumbs={[]}>
                <Head title="Error" />
                <div className="flex h-full flex-1 flex-col items-center justify-center p-4">
                    <p className="text-lg text-muted-foreground">Evaluación no encontrada</p>
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
            title: 'Evaluaciones',
            href: evaluations.index().url,
        },
        {
            title: 'Ver Evaluación',
            href: evaluations.show(evaluation.id).url,
        },
    ];

    const renderRating = (rating: number) => {
        return (
            <div className="flex items-center gap-1">
                {Array.from({ length: 5 }, (_, i) => (
                    <Star
                        key={i}
                        className={`size-6 ${
                            i < rating 
                                ? 'fill-yellow-400 text-yellow-400' 
                                : 'text-gray-300'
                        }`}
                    />
                ))}
                <span className="ml-2 text-lg font-semibold">{rating}/5</span>
            </div>
        );
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Evaluación #${evaluation.id}`} />
            
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div>
                                <CardTitle className="flex items-center gap-2">
                                    <Star className="size-6 fill-yellow-400 text-yellow-400" />
                                    Evaluación #{evaluation.id}
                                </CardTitle>
                                <CardDescription className="flex items-center gap-2 mt-2">
                                    {renderRating(evaluation.rating)}
                                </CardDescription>
                            </div>
                            <div className="flex gap-2">
                                <Link href={evaluations.edit(evaluation.id).url}>
                                    <Button variant="default">
                                        <Edit className="mr-2 size-4" />
                                        Editar
                                    </Button>
                                </Link>
                                <Link href={evaluations.index().url}>
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
                            {/* Información Principal */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Información Principal</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <User className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Usuario</p>
                                            <p className="text-base font-medium">
                                                {evaluation.user_name || '-'}
                                            </p>
                                            {evaluation.user && (
                                                <p className="text-sm text-muted-foreground">
                                                    {evaluation.user.email}
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    {evaluation.product_name && (
                                        <div className="flex items-start gap-3">
                                            <Package className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Producto</p>
                                                <p className="text-base font-medium">{evaluation.product_name}</p>
                                                {evaluation.product && evaluation.product.description && (
                                                    <p className="text-sm text-muted-foreground mt-1">
                                                        {evaluation.product.description}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    )}

                                    {evaluation.order_number && (
                                        <div className="flex items-start gap-3">
                                            <ShoppingCart className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Orden</p>
                                                <p className="text-base font-medium">
                                                    Orden #{evaluation.order_number}
                                                </p>
                                                {evaluation.order && (
                                                    <p className="text-sm text-muted-foreground">
                                                        Total: ${evaluation.order.total}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    )}

                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Fecha de Evaluación</p>
                                            <p className="text-base">
                                                {evaluation.evaluation_date_formatted}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Comentario */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Comentario</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <MessageSquare className="size-5 text-muted-foreground mt-0.5" />
                                        <div className="flex-1">
                                            <p className="text-sm font-medium text-muted-foreground mb-2">
                                                Comentario del Cliente
                                            </p>
                                            {evaluation.comment ? (
                                                <div className="p-4 rounded-lg bg-muted/50 border">
                                                    <p className="text-base whitespace-pre-wrap">
                                                        {evaluation.comment}
                                                    </p>
                                                </div>
                                            ) : (
                                                <p className="text-base text-muted-foreground italic">
                                                    Sin comentario
                                                </p>
                                            )}
                                        </div>
                                    </div>

                                    <div className="pt-4 border-t">
                                        <h4 className="text-sm font-medium text-muted-foreground mb-3">
                                            Información del Sistema
                                        </h4>
                                        <div className="space-y-2 text-sm">
                                            <div className="flex justify-between">
                                                <span className="text-muted-foreground">Creado:</span>
                                                <span className="font-medium">
                                                    {new Date(evaluation.created_at).toLocaleString('es-ES', {
                                                        year: 'numeric',
                                                        month: 'short',
                                                        day: 'numeric',
                                                        hour: '2-digit',
                                                        minute: '2-digit'
                                                    })}
                                                </span>
                                            </div>
                                            <div className="flex justify-between">
                                                <span className="text-muted-foreground">Última actualización:</span>
                                                <span className="font-medium">
                                                    {new Date(evaluation.updated_at).toLocaleString('es-ES', {
                                                        year: 'numeric',
                                                        month: 'short',
                                                        day: 'numeric',
                                                        hour: '2-digit',
                                                        minute: '2-digit'
                                                    })}
                                                </span>
                                            </div>
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

