import { InertiaLinkProps } from '@inertiajs/react';
import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    last_name: string;
    full_name: string;
    email: string;
    email_verified_at: string | null;
    phone_number: string | null;
    address: string | null;
    profile_picture: string | null;
    role: 'admin' | 'employee' | 'client';
    role_label: string;
    status: 'active' | 'inactive';
    status_label: string;
    registration_date: string | null;
    last_connection: string | null;
    avatar?: string;
    two_factor_enabled?: boolean;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface TableColumn {
    key: string;
    label: string;
    sortable: boolean;
    visible: boolean;
}

export interface FilterField {
    name: string;
    label: string;
    type: string;
    placeholder: string;
    options?: { value: string; label: string }[];
}

export interface Pagination {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
}

export interface Category {
    id: number;
    name: string;
    description: string | null;
    image: string | null;
    status: 'active' | 'inactive';
    status_label: string;
    order_show: number;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
}

export interface Product {
    id: number;
    name: string;
    description: string | null;
    price: string;
    category_id: number | null;
    category_name: string | null;
    image: string | null;
    status: 'active' | 'inactive' | 'out of stock';
    status_label: string;
    preparation_time: number;
    ingredients: string | null;
    is_special: boolean;
    creation_date: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
}
