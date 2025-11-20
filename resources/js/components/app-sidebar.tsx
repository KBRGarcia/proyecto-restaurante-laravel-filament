import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookOpen, Folder, LayoutGrid, Users, Tag, Package, ShoppingCart, Settings, Store, Receipt } from 'lucide-react';
import AppLogo from './app-logo';
import users from '@/routes/users';
import categories from '@/routes/categories';
import products from '@/routes/products';
import orders from '@/routes/orders';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Administración',
        href: users.index(), // Href por defecto (no se usa cuando hay subitems)
        icon: Settings,
        items: [
            {
                title: 'Usuarios',
                href: users.index(),
                icon: Users,
            },
        ],
    },
    {
        title: 'Catálogo',
        href: categories.index(), // Href por defecto (no se usa cuando hay subitems)
        icon: Store,
        items: [
            {
                title: 'Categorías',
                href: categories.index(),
                icon: Tag,
            },
            {
                title: 'Productos',
                href: products.index(),
                icon: Package,
            },
        ],
    },
    {
        title: 'Ventas',
        href: orders.index(), // Href por defecto (no se usa cuando hay subitems)
        icon: Receipt,
        items: [
            {
                title: 'Órdenes',
                href: orders.index(),
                icon: ShoppingCart,
            },
        ],
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
