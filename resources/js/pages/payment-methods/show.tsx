import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type PaymentMethod } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard } from '@/routes';
import paymentMethods from '@/routes/payment-methods';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Edit, CreditCard, Code, Globe, Settings, Calendar, CheckCircle, XCircle } from 'lucide-react';

interface PaymentMethodShowProps {
    payment_method: PaymentMethod;
}

export default function PaymentMethodShow({ payment_method }: PaymentMethodShowProps) {
    if (!payment_method) {
        return (
            <AppLayout breadcrumbs={[]}>
                <Head title="Error" />
                <div className="flex h-full flex-1 flex-col items-center justify-center p-4">
                    <p className="text-lg text-muted-foreground">Método de pago no encontrado</p>
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
            title: 'Métodos de Pago',
            href: paymentMethods.index().url,
        },
        {
            title: 'Ver Método de Pago',
            href: paymentMethods.show(payment_method.id).url,
        },
    ];

    const getCurrencyBadgeVariant = (currencyType: string): "default" | "secondary" | "destructive" | "outline" => {
        return currencyType === 'nacional' ? 'default' : 'secondary';
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Método de Pago - ${payment_method.name}`} />
            
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div>
                                <CardTitle className="flex items-center gap-2">
                                    <CreditCard className="size-6" />
                                    {payment_method.name}
                                </CardTitle>
                                <CardDescription className="flex items-center gap-2 mt-2">
                                    <Badge variant={getCurrencyBadgeVariant(payment_method.currency_type)}>
                                        {payment_method.currency_type_label}
                                    </Badge>
                                    <Badge variant={payment_method.active ? 'default' : 'outline'}>
                                        {payment_method.active ? (
                                            <><CheckCircle className="size-3 mr-1" /> {payment_method.active_label}</>
                                        ) : (
                                            <><XCircle className="size-3 mr-1" /> {payment_method.active_label}</>
                                        )}
                                    </Badge>
                                </CardDescription>
                            </div>
                            <div className="flex gap-2">
                                <Link href={paymentMethods.edit(payment_method.id).url}>
                                    <Button variant="default">
                                        <Edit className="mr-2 size-4" />
                                        Editar
                                    </Button>
                                </Link>
                                <Link href={paymentMethods.index().url}>
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
                                        <Code className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Código</p>
                                            <p className="text-base font-mono font-semibold">
                                                {payment_method.code}
                                            </p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <CreditCard className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Nombre</p>
                                            <p className="text-base font-medium">{payment_method.name}</p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Globe className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Tipo de Moneda</p>
                                            <Badge variant={getCurrencyBadgeVariant(payment_method.currency_type)} className="mt-1">
                                                {payment_method.currency_type_label}
                                            </Badge>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Fecha de Creación</p>
                                            <p className="text-base">
                                                {payment_method.creation_date 
                                                    ? new Date(payment_method.creation_date).toLocaleString('es-ES', {
                                                        year: 'numeric',
                                                        month: 'long',
                                                        day: 'numeric',
                                                        hour: '2-digit',
                                                        minute: '2-digit'
                                                    })
                                                    : '-'
                                                }
                                            </p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Última Actualización</p>
                                            <p className="text-base">
                                                {payment_method.update_date 
                                                    ? new Date(payment_method.update_date).toLocaleString('es-ES', {
                                                        year: 'numeric',
                                                        month: 'long',
                                                        day: 'numeric',
                                                        hour: '2-digit',
                                                        minute: '2-digit'
                                                    })
                                                    : '-'
                                                }
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Configuración */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Configuración</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <Settings className="size-5 text-muted-foreground mt-0.5" />
                                        <div className="flex-1">
                                            <p className="text-sm font-medium text-muted-foreground mb-2">
                                                Configuración JSON
                                            </p>
                                            {payment_method.configuration ? (
                                                <div className="p-4 rounded-lg bg-muted/50 border overflow-auto max-h-96">
                                                    <pre className="text-xs whitespace-pre-wrap font-mono">
                                                        {JSON.stringify(payment_method.configuration, null, 2)}
                                                    </pre>
                                                </div>
                                            ) : (
                                                <p className="text-base text-muted-foreground italic">
                                                    Sin configuración
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
                                                <span className="text-muted-foreground">ID:</span>
                                                <span className="font-medium">#{payment_method.id}</span>
                                            </div>
                                            <div className="flex justify-between">
                                                <span className="text-muted-foreground">Creado:</span>
                                                <span className="font-medium">
                                                    {new Date(payment_method.created_at).toLocaleString('es-ES', {
                                                        year: 'numeric',
                                                        month: 'short',
                                                        day: 'numeric',
                                                        hour: '2-digit',
                                                        minute: '2-digit'
                                                    })}
                                                </span>
                                            </div>
                                            <div className="flex justify-between">
                                                <span className="text-muted-foreground">Actualizado:</span>
                                                <span className="font-medium">
                                                    {new Date(payment_method.updated_at).toLocaleString('es-ES', {
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

