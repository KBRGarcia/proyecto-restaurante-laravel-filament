import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Order } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard } from '@/routes';
import orders from '@/routes/orders';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Edit, ShoppingCart, User, Calendar, MapPin, Phone, DollarSign, CreditCard, FileText, Truck } from 'lucide-react';

interface OrderShowProps {
    order: Order;
}

export default function OrderShow({ order }: OrderShowProps) {
    // Verificar que order existe
    if (!order) {
        return (
            <AppLayout breadcrumbs={[]}>
                <Head title="Error" />
                <div className="flex h-full flex-1 flex-col items-center justify-center p-4">
                    <p className="text-lg text-muted-foreground">Orden no encontrada</p>
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
            title: 'Órdenes',
            href: orders.index().url,
        },
        {
            title: 'Ver Orden',
            href: orders.show(order.id).url,
        },
    ];

    const getStatusBadgeVariant = (status: string): "default" | "secondary" | "destructive" | "outline" => {
        switch (status) {
            case 'pending': return 'outline';
            case 'preparing': return 'secondary';
            case 'ready': return 'default';
            case 'delivered': return 'default';
            case 'canceled': return 'destructive';
            default: return 'outline';
        }
    };

    const formatCurrency = (amount: string | number, currency: string) => {
        const num = typeof amount === 'string' ? parseFloat(amount) : amount;
        return currency === 'nacional' ? `Bs. ${num.toFixed(2)}` : `$${num.toFixed(2)}`;
    };

    const formatDateTime = (dateString: string | null) => {
        if (!dateString) return '-';
        return new Date(dateString).toLocaleString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Orden #${order.id}`} />
            
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-4">
                                <div className="flex size-16 items-center justify-center rounded-full bg-primary/10">
                                    <ShoppingCart className="size-8 text-primary" />
                                </div>
                                <div>
                                    <CardTitle className="flex items-center gap-2">
                                        Orden #{order.id}
                                    </CardTitle>
                                    <CardDescription className="flex items-center gap-2 mt-1">
                                        <Badge variant={getStatusBadgeVariant(order.status)}>
                                            {order.status_label}
                                        </Badge>
                                        <Badge variant="outline">
                                            {order.service_type_label}
                                        </Badge>
                                        <Badge variant="secondary">
                                            {order.currency_label}
                                        </Badge>
                                    </CardDescription>
                                </div>
                            </div>
                            <div className="flex gap-2">
                                <Link href={orders.edit(order.id).url}>
                                    <Button variant="default">
                                        <Edit className="mr-2 size-4" />
                                        Editar
                                    </Button>
                                </Link>
                                <Link href={orders.index().url}>
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
                            {/* Información del Cliente */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Información del Cliente</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <User className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Cliente</p>
                                            <p className="text-base">{order.user_name || order.user?.full_name || 'No disponible'}</p>
                                            {order.user?.email && (
                                                <p className="text-sm text-muted-foreground">{order.user.email}</p>
                                            )}
                                        </div>
                                    </div>

                                    {order.contact_phone && (
                                        <div className="flex items-start gap-3">
                                            <Phone className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Teléfono de Contacto</p>
                                                <p className="text-base">{order.contact_phone}</p>
                                            </div>
                                        </div>
                                    )}

                                    {order.delivery_address && (
                                        <div className="flex items-start gap-3">
                                            <MapPin className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Dirección de Entrega</p>
                                                <p className="text-base">{order.delivery_address}</p>
                                            </div>
                                        </div>
                                    )}

                                    {order.assigned_employee_name && (
                                        <div className="flex items-start gap-3">
                                            <Truck className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Empleado Asignado</p>
                                                <p className="text-base">{order.assigned_employee_name}</p>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Información de la Orden */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Detalles de la Orden</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <DollarSign className="size-5 text-muted-foreground mt-0.5" />
                                        <div className="flex-1">
                                            <p className="text-sm font-medium text-muted-foreground">Montos</p>
                                            <div className="space-y-1">
                                                <div className="flex justify-between">
                                                    <span className="text-sm">Subtotal:</span>
                                                    <span className="font-medium">{formatCurrency(order.subtotal, order.currency)}</span>
                                                </div>
                                                <div className="flex justify-between">
                                                    <span className="text-sm">Impuestos:</span>
                                                    <span className="font-medium">{formatCurrency(order.taxes, order.currency)}</span>
                                                </div>
                                                <div className="flex justify-between border-t pt-1">
                                                    <span className="text-base font-semibold">Total:</span>
                                                    <span className="text-base font-bold">{formatCurrency(order.total, order.currency)}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {order.payment_method && (
                                        <div className="flex items-start gap-3">
                                            <CreditCard className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Método de Pago</p>
                                                <p className="text-base">{order.payment_method}</p>
                                            </div>
                                        </div>
                                    )}

                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Fecha de Orden</p>
                                            <p className="text-base">{formatDateTime(order.order_date)}</p>
                                        </div>
                                    </div>

                                    {order.estimated_delivery_date && (
                                        <div className="flex items-start gap-3">
                                            <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Fecha de Entrega Estimada</p>
                                                <p className="text-base">{formatDateTime(order.estimated_delivery_date)}</p>
                                            </div>
                                        </div>
                                    )}

                                    {order.special_notes && (
                                        <div className="flex items-start gap-3">
                                            <FileText className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Notas Especiales</p>
                                                <p className="text-base">{order.special_notes}</p>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Historial de Estados */}
                            <div className="space-y-4 md:col-span-2">
                                <h3 className="text-lg font-semibold border-b pb-2">Historial de Estados</h3>
                                
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    {order.pending_date && (
                                        <div className="rounded-lg border p-3">
                                            <p className="text-sm font-medium text-muted-foreground">Pendiente</p>
                                            <p className="text-base">{formatDateTime(order.pending_date)}</p>
                                        </div>
                                    )}

                                    {order.preparing_date && (
                                        <div className="rounded-lg border p-3">
                                            <p className="text-sm font-medium text-muted-foreground">En Preparación</p>
                                            <p className="text-base">{formatDateTime(order.preparing_date)}</p>
                                        </div>
                                    )}

                                    {order.ready_date && (
                                        <div className="rounded-lg border p-3">
                                            <p className="text-sm font-medium text-muted-foreground">Listo</p>
                                            <p className="text-base">{formatDateTime(order.ready_date)}</p>
                                        </div>
                                    )}

                                    {order.on_the_way_date && (
                                        <div className="rounded-lg border p-3">
                                            <p className="text-sm font-medium text-muted-foreground">En Camino</p>
                                            <p className="text-base">{formatDateTime(order.on_the_way_date)}</p>
                                        </div>
                                    )}

                                    {order.delivered_date && (
                                        <div className="rounded-lg border p-3">
                                            <p className="text-sm font-medium text-muted-foreground">Entregado</p>
                                            <p className="text-base">{formatDateTime(order.delivered_date)}</p>
                                        </div>
                                    )}

                                    {order.canceled_date && (
                                        <div className="rounded-lg border p-3 border-destructive">
                                            <p className="text-sm font-medium text-destructive">Cancelado</p>
                                            <p className="text-base">{formatDateTime(order.canceled_date)}</p>
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Información del Sistema */}
                            <div className="space-y-4 md:col-span-2 border-t pt-4">
                                <h3 className="text-lg font-semibold">Información del Sistema</h3>
                                
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Creado</p>
                                            <p className="text-base">{formatDateTime(order.created_at)}</p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Última Actualización</p>
                                            <p className="text-base">{formatDateTime(order.updated_at)}</p>
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

