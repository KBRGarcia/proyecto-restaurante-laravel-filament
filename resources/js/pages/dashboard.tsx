import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import users from '@/routes/users';
import categories from '@/routes/categories';
import products from '@/routes/products';
import orders from '@/routes/orders';
import orderDetails from '@/routes/order-details';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Users, ArrowRight, Tag, Package, ShoppingCart, FileText } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

function DashboardContent() {
    return (
        <>
            {/* Card de Usuarios */}
            <Card className="hover:shadow-lg transition-shadow">
                <CardHeader>
                    <div className="flex items-center justify-between">
                        <div className="flex size-12 items-center justify-center rounded-lg bg-primary/10">
                            <Users className="size-6 text-primary" />
                        </div>
                    </div>
                    <CardTitle className="mt-4">Gestión de Usuarios</CardTitle>
                    <CardDescription>
                        Administra los usuarios del sistema
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={users.index().url}>
                        <Button className="w-full">
                            Ver Usuarios
                            <ArrowRight className="ml-2 size-4" />
                        </Button>
                    </Link>
                </CardContent>
            </Card>

            {/* Card de Categorías */}
            <Card className="hover:shadow-lg transition-shadow">
                <CardHeader>
                    <div className="flex items-center justify-between">
                        <div className="flex size-12 items-center justify-center rounded-lg bg-orange-500/10">
                            <Tag className="size-6 text-orange-500" />
                        </div>
                    </div>
                    <CardTitle className="mt-4">Gestión de Categorías</CardTitle>
                    <CardDescription>
                        Administra las categorías de productos
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={categories.index().url}>
                        <Button className="w-full">
                            Ver Categorías
                            <ArrowRight className="ml-2 size-4" />
                        </Button>
                    </Link>
                </CardContent>
            </Card>

            {/* Card de Productos */}
            <Card className="hover:shadow-lg transition-shadow">
                <CardHeader>
                    <div className="flex items-center justify-between">
                        <div className="flex size-12 items-center justify-center rounded-lg bg-green-500/10">
                            <Package className="size-6 text-green-500" />
                        </div>
                    </div>
                    <CardTitle className="mt-4">Gestión de Productos</CardTitle>
                    <CardDescription>
                        Administra los productos del restaurante
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={products.index().url}>
                        <Button className="w-full">
                            Ver Productos
                            <ArrowRight className="ml-2 size-4" />
                        </Button>
                    </Link>
                </CardContent>
            </Card>

            {/* Card de Órdenes */}
            <Card className="hover:shadow-lg transition-shadow">
                <CardHeader>
                    <div className="flex items-center justify-between">
                        <div className="flex size-12 items-center justify-center rounded-lg bg-blue-500/10">
                            <ShoppingCart className="size-6 text-blue-500" />
                        </div>
                    </div>
                    <CardTitle className="mt-4">Gestión de Órdenes</CardTitle>
                    <CardDescription>
                        Administra las órdenes del sistema
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={orders.index().url}>
                        <Button className="w-full">
                            Ver Órdenes
                            <ArrowRight className="ml-2 size-4" />
                        </Button>
                    </Link>
                </CardContent>
            </Card>

            {/* Card de Detalles de Órdenes */}
            <Card className="hover:shadow-lg transition-shadow">
                <CardHeader>
                    <div className="flex items-center justify-between">
                        <div className="flex size-12 items-center justify-center rounded-lg bg-purple-500/10">
                            <FileText className="size-6 text-purple-500" />
                        </div>
                    </div>
                    <CardTitle className="mt-4">Detalles de Órdenes</CardTitle>
                    <CardDescription>
                        Gestiona los productos de cada orden
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Link href={orderDetails.index().url}>
                        <Button className="w-full">
                            Ver Detalles
                            <ArrowRight className="ml-2 size-4" />
                        </Button>
                    </Link>
                </CardContent>
            </Card>
        </>
    );
}

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 transition-all duration-300 ease-in-out md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 group-data-[collapsible=icon]:xl:grid-cols-5">
                    <DashboardContent />
                </div>
                <div className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
            </div>
        </AppLayout>
    );
}
