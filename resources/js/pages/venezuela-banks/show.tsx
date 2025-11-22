import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type VenezuelaBank } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard } from '@/routes';
import venezuelaBanks from '@/routes/venezuela-banks';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Edit, Building2, Hash, Calendar, Clock } from 'lucide-react';

interface VenezuelaBankShowProps {
    bank: VenezuelaBank;
}

export default function VenezuelaBankShow({ bank }: VenezuelaBankShowProps) {
    if (!bank) {
        return (
            <AppLayout breadcrumbs={[]}>
                <Head title="Error" />
                <div className="flex h-full flex-1 flex-col items-center justify-center p-4">
                    <p className="text-lg text-muted-foreground">Banco no encontrado</p>
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
            title: 'Bancos de Venezuela',
            href: venezuelaBanks.index().url,
        },
        {
            title: 'Ver Banco',
            href: venezuelaBanks.show(bank.id).url,
        },
    ];

    const getActiveBadgeVariant = (active: boolean): "default" | "secondary" | "destructive" | "outline" => {
        return active ? 'default' : 'outline';
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Banco - ${bank.name}`} />
            
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-4">
                                <div className="size-16 rounded-full bg-primary/10 flex items-center justify-center">
                                    <Building2 className="size-8 text-primary" />
                                </div>
                                <div>
                                    <CardTitle className="flex items-center gap-2">
                                        {bank.name}
                                    </CardTitle>
                                    <CardDescription className="flex items-center gap-2 mt-1">
                                        <Badge variant={getActiveBadgeVariant(bank.active)}>
                                            {bank.active_label}
                                        </Badge>
                                        <span className="text-muted-foreground">Código: {bank.code}</span>
                                    </CardDescription>
                                </div>
                            </div>
                            <div className="flex gap-2">
                                <Link href={venezuelaBanks.edit(bank.id).url}>
                                    <Button variant="default">
                                        <Edit className="mr-2 size-4" />
                                        Editar
                                    </Button>
                                </Link>
                                <Link href={venezuelaBanks.index().url}>
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
                            {/* Información del Banco */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Información del Banco</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <Hash className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Código</p>
                                            <p className="text-base font-mono">{bank.code}</p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Building2 className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Nombre</p>
                                            <p className="text-base">{bank.name}</p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Calendar className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Fecha de Creación</p>
                                            <p className="text-base">
                                                {bank.creation_date_formatted || '-'}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Información del Sistema */}
                            <div className="space-y-4 md:col-span-2">
                                <h3 className="text-lg font-semibold border-b pb-2">Información del Sistema</h3>
                                
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div className="flex items-start gap-3">
                                        <Clock className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Creado</p>
                                            <p className="text-base">
                                                {bank.created_at_formatted || '-'}
                                            </p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Clock className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Última Actualización</p>
                                            <p className="text-base">
                                                {bank.updated_at_formatted || '-'}
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

