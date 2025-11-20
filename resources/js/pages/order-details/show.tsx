import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type OrderDetail } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard } from '@/routes';
import orderDetails from '@/routes/order-details';
import orders from '@/routes/orders';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Edit, FileText, Package, ShoppingCart } from 'lucide-react';

interface OrderDetailShowProps {
    orderDetail: OrderDetail;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Detalles de Órdenes',
        href: orderDetails.index().url,
    },
    {
        title: 'Ver Detalle',
        href: '#',
    },
];

export default function OrderDetailShow({ orderDetail }: OrderDetailShowProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Detalle #${orderDetail.id}`} />
            
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-2">
                                <FileText className="size-8 text-primary" />
                                <div>
                                    <CardTitle>Detalle de Orden #{orderDetail.id}</CardTitle>
                                    <CardDescription>
                                        Información completa del detalle de orden
                                    </CardDescription>
                                </div>
                            </div>
                            <div className="flex gap-2">
                                <Link href={orderDetails.edit(orderDetail.id).url}>
                                    <Button variant="outline">
                                        <Edit className="mr-2 size-4" />
                                        Editar
                                    </Button>
                                </Link>
                                <Link href={orderDetails.index().url}>
                                    <Button variant="outline">
                                        <ArrowLeft className="mr-2 size-4" />
                                        Volver
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div className="grid gap-6 md:grid-cols-2">
                            {/* Información de la Orden */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center gap-2 text-lg">
                                        <ShoppingCart className="size-5" />
                                        Información de la Orden
                                    </CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-3">
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">Número de Orden</p>
                                        <Link href={orders.show(orderDetail.order_id).url}>
                                            <p className="text-base font-semibold text-primary hover:underline">
                                                #{orderDetail.order_number}
                                            </p>
                                        </Link>
                                    </div>
                                    {orderDetail.order && (
                                        <>
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Cliente</p>
                                                <p className="text-base">{orderDetail.order.user_name}</p>
                                            </div>
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Estado de la Orden</p>
                                                <p className="text-base capitalize">{orderDetail.order.status}</p>
                                            </div>
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Tipo de Servicio</p>
                                                <p className="text-base capitalize">{orderDetail.order.service_type}</p>
                                            </div>
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Fecha de Orden</p>
                                                <p className="text-base">
                                                    {new Date(orderDetail.order.order_date).toLocaleString('es-ES')}
                                                </p>
                                            </div>
                                        </>
                                    )}
                                </CardContent>
                            </Card>

                            {/* Información del Producto */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center gap-2 text-lg">
                                        <Package className="size-5" />
                                        Información del Producto
                                    </CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-3">
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">Nombre del Producto</p>
                                        <p className="text-base font-semibold">{orderDetail.product_name}</p>
                                    </div>
                                    {orderDetail.product && (
                                        <>
                                            {orderDetail.product.description && (
                                                <div>
                                                    <p className="text-sm font-medium text-muted-foreground">Descripción</p>
                                                    <p className="text-base">{orderDetail.product.description}</p>
                                                </div>
                                            )}
                                            {orderDetail.product.category_name && (
                                                <div>
                                                    <p className="text-sm font-medium text-muted-foreground">Categoría</p>
                                                    <p className="text-base">{orderDetail.product.category_name}</p>
                                                </div>
                                            )}
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Precio Base</p>
                                                <p className="text-base">${orderDetail.product.price}</p>
                                            </div>
                                        </>
                                    )}
                                </CardContent>
                            </Card>

                            {/* Detalles del Pedido */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-lg">Detalles del Pedido</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-3">
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">Cantidad</p>
                                        <p className="text-base font-semibold">{orderDetail.quantity} unidades</p>
                                    </div>
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">Precio Unitario</p>
                                        <p className="text-base">${orderDetail.unit_price_formatted}</p>
                                    </div>
                                    <div className="pt-2 border-t">
                                        <p className="text-sm font-medium text-muted-foreground">Subtotal</p>
                                        <p className="text-xl font-bold text-primary">
                                            ${orderDetail.subtotal_formatted}
                                        </p>
                                    </div>
                                    {orderDetail.product_notes && (
                                        <div className="pt-2">
                                            <p className="text-sm font-medium text-muted-foreground">Notas del Producto</p>
                                            <p className="text-base italic">{orderDetail.product_notes}</p>
                                        </div>
                                    )}
                                </CardContent>
                            </Card>

                            {/* Información del Sistema */}
                            <Card>
                                <CardHeader>
                                    <CardTitle className="text-lg">Información del Sistema</CardTitle>
                                </CardHeader>
                                <CardContent className="space-y-3">
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">ID del Detalle</p>
                                        <p className="text-base font-mono">#{orderDetail.id}</p>
                                    </div>
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">Creado</p>
                                        <p className="text-base">
                                            {new Date(orderDetail.created_at).toLocaleString('es-ES')}
                                        </p>
                                    </div>
                                    <div>
                                        <p className="text-sm font-medium text-muted-foreground">Última Actualización</p>
                                        <p className="text-base">
                                            {new Date(orderDetail.updated_at).toLocaleString('es-ES')}
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        {/* Cálculo del Total */}
                        <Card className="mt-6 bg-muted/50">
                            <CardContent className="p-6">
                                <div className="flex justify-between items-center">
                                    <div>
                                        <p className="text-sm text-muted-foreground">Cálculo</p>
                                        <p className="text-base">
                                            {orderDetail.quantity} × ${orderDetail.unit_price_formatted} = ${orderDetail.subtotal_formatted}
                                        </p>
                                    </div>
                                    <div className="text-right">
                                        <p className="text-sm text-muted-foreground">Total del Detalle</p>
                                        <p className="text-2xl font-bold text-primary">
                                            ${orderDetail.subtotal_formatted}
                                        </p>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}

