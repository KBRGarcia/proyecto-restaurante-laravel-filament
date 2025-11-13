import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type User } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard } from '@/routes';
import users from '@/routes/users';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowLeft, Edit, Mail, MapPin, Phone, User as UserIcon, Calendar, Clock } from 'lucide-react';

interface UserShowProps {
    user: User;
}

export default function UserShow({ user }: UserShowProps) {
    // Verificar que user existe
    if (!user) {
        return (
            <AppLayout breadcrumbs={[]}>
                <Head title="Error" />
                <div className="flex h-full flex-1 flex-col items-center justify-center p-4">
                    <p className="text-lg text-muted-foreground">Usuario no encontrado</p>
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
            title: 'Usuarios',
            href: users.index().url,
        },
        {
            title: 'Ver Usuario',
            href: users.show(user.id).url,
        },
    ];

    const getRoleBadgeVariant = (role: string): "default" | "secondary" | "destructive" | "outline" => {
        switch (role) {
            case 'admin': return 'destructive';
            case 'employee': return 'secondary';
            case 'client': return 'default';
            default: return 'outline';
        }
    };

    const getStatusBadgeVariant = (status: string): "default" | "secondary" | "destructive" | "outline" => {
        return status === 'active' ? 'default' : 'outline';
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Usuario - ${user.full_name}`} />
            
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-4">
                                {user.profile_picture ? (
                                    <img 
                                        src={user.profile_picture} 
                                        alt={user.full_name}
                                        className="size-16 rounded-full object-cover border-2 border-muted"
                                    />
                                ) : (
                                    <div className="size-16 rounded-full bg-muted flex items-center justify-center">
                                        <UserIcon className="size-8 text-muted-foreground" />
                                    </div>
                                )}
                                <div>
                                    <CardTitle className="flex items-center gap-2">
                                        {user.full_name}
                                    </CardTitle>
                                    <CardDescription className="flex items-center gap-2 mt-1">
                                        <Badge variant={getRoleBadgeVariant(user.role)}>
                                            {user.role_label}
                                        </Badge>
                                        <Badge variant={getStatusBadgeVariant(user.status)}>
                                            {user.status_label}
                                        </Badge>
                                    </CardDescription>
                                </div>
                            </div>
                            <div className="flex gap-2">
                                <Link href={users.edit(user.id).url}>
                                    <Button variant="default">
                                        <Edit className="mr-2 size-4" />
                                        Editar
                                    </Button>
                                </Link>
                                <Link href={users.index().url}>
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
                            {/* Información Personal */}
                            <div className="space-y-4">
                                <h3 className="text-lg font-semibold border-b pb-2">Información Personal</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex items-start gap-3">
                                        <UserIcon className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Nombre</p>
                                            <p className="text-base">{user.name}</p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <UserIcon className="size-5 text-muted-foreground mt-0.5" />
                                        <div>
                                            <p className="text-sm font-medium text-muted-foreground">Apellido</p>
                                            <p className="text-base">{user.last_name}</p>
                                        </div>
                                    </div>

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

                                    {user.phone_number && (
                                        <div className="flex items-start gap-3">
                                            <Phone className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Teléfono</p>
                                                <p className="text-base">{user.phone_number}</p>
                                            </div>
                                        </div>
                                    )}

                                    {user.address && (
                                        <div className="flex items-start gap-3">
                                            <MapPin className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Dirección</p>
                                                <p className="text-base">{user.address}</p>
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
                                            <p className="text-sm font-medium text-muted-foreground">Fecha de Registro</p>
                                            <p className="text-base">
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
                                            </p>
                                        </div>
                                    </div>

                                    {user.last_connection && (
                                        <div className="flex items-start gap-3">
                                            <Clock className="size-5 text-muted-foreground mt-0.5" />
                                            <div>
                                                <p className="text-sm font-medium text-muted-foreground">Última Conexión</p>
                                                <p className="text-base">
                                                    {new Date(user.last_connection).toLocaleString('es-ES', {
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
                                            <p className="text-sm font-medium text-muted-foreground">Creado</p>
                                            <p className="text-base">
                                                {new Date(user.created_at).toLocaleString('es-ES', {
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
                                                {new Date(user.updated_at).toLocaleString('es-ES', {
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

