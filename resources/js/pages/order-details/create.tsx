import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { dashboard } from '@/routes';
import orderDetails from '@/routes/order-details';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { AlertCircle, ArrowLeft, Save, FileText } from 'lucide-react';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { useEffect } from 'react';

interface FormField {
    name: string;
    label: string;
    type: string;
    placeholder: string;
    required: boolean;
    description?: string;
    options?: { value: string | number; label: string; price?: number }[];
    readonly?: boolean;
    rows?: number;
    min?: number;
    step?: number;
}

interface OrderDetailCreateProps {
    fields: FormField[];
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
        title: 'Crear Detalle',
        href: orderDetails.create().url,
    },
];

export default function OrderDetailCreate({ fields }: OrderDetailCreateProps) {
    const { data, setData, post, processing, errors } = useForm({
        order_id: '',
        product_id: '',
        quantity: '1',
        unit_price: '',
        subtotal: '',
        product_notes: '',
    });

    // Auto-calcular el subtotal cuando cambian cantidad o precio unitario
    useEffect(() => {
        const quantity = parseFloat(data.quantity) || 0;
        const unitPrice = parseFloat(data.unit_price) || 0;
        const subtotal = (quantity * unitPrice).toFixed(2);
        setData('subtotal', subtotal);
    }, [data.quantity, data.unit_price]);

    // Auto-llenar el precio unitario cuando se selecciona un producto
    useEffect(() => {
        if (data.product_id) {
            const productField = fields.find(f => f.name === 'product_id');
            const selectedProduct = productField?.options?.find(
                opt => opt.value.toString() === data.product_id
            );
            if (selectedProduct && 'price' in selectedProduct && selectedProduct.price) {
                setData('unit_price', selectedProduct.price.toString());
            }
        }
    }, [data.product_id]);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(orderDetails.store().url);
    };

    const renderField = (field: FormField) => {
        const value = data[field.name as keyof typeof data] ?? '';

        switch (field.type) {
            case 'select':
                return (
                    <div key={field.name} className="space-y-2">
                        <Label htmlFor={field.name}>
                            {field.label}
                            {field.required && <span className="text-destructive ml-1">*</span>}
                        </Label>
                        <select
                            id={field.name}
                            value={value as string}
                            onChange={(e) => setData(field.name as any, e.target.value)}
                            className={`flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring ${
                                errors[field.name as keyof typeof errors] ? 'border-destructive' : ''
                            }`}
                            required={field.required}
                        >
                            <option value="">{field.placeholder}</option>
                            {field.options?.map((option) => (
                                <option key={option.value} value={option.value}>
                                    {option.label}
                                </option>
                            ))}
                        </select>
                        {errors[field.name as keyof typeof errors] && (
                            <p className="text-sm text-destructive">
                                {errors[field.name as keyof typeof errors]}
                            </p>
                        )}
                        {field.description && !errors[field.name as keyof typeof errors] && (
                            <p className="text-sm text-muted-foreground">{field.description}</p>
                        )}
                    </div>
                );

            case 'number':
                return (
                    <div key={field.name} className="space-y-2">
                        <Label htmlFor={field.name}>
                            {field.label}
                            {field.required && <span className="text-destructive ml-1">*</span>}
                        </Label>
                        <Input
                            id={field.name}
                            type="number"
                            placeholder={field.placeholder}
                            value={value as string | number}
                            onChange={(e) => setData(field.name as any, e.target.value)}
                            className={errors[field.name as keyof typeof errors] ? 'border-destructive' : ''}
                            required={field.required}
                            min={field.min}
                            step={field.step}
                            readOnly={field.readonly}
                        />
                        {errors[field.name as keyof typeof errors] && (
                            <p className="text-sm text-destructive">
                                {errors[field.name as keyof typeof errors]}
                            </p>
                        )}
                        {field.description && !errors[field.name as keyof typeof errors] && (
                            <p className="text-sm text-muted-foreground">{field.description}</p>
                        )}
                    </div>
                );

            case 'textarea':
                return (
                    <div key={field.name} className="space-y-2">
                        <Label htmlFor={field.name}>
                            {field.label}
                            {field.required && <span className="text-destructive ml-1">*</span>}
                        </Label>
                        <Textarea
                            id={field.name}
                            placeholder={field.placeholder}
                            value={value as string}
                            onChange={(e) => setData(field.name as any, e.target.value)}
                            className={errors[field.name as keyof typeof errors] ? 'border-destructive' : ''}
                            required={field.required}
                            rows={field.rows || 3}
                        />
                        {errors[field.name as keyof typeof errors] && (
                            <p className="text-sm text-destructive">
                                {errors[field.name as keyof typeof errors]}
                            </p>
                        )}
                        {field.description && !errors[field.name as keyof typeof errors] && (
                            <p className="text-sm text-muted-foreground">{field.description}</p>
                        )}
                    </div>
                );

            default:
                return null;
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Detalle de Orden" />
            
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Card>
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-2">
                                <FileText className="size-8 text-primary" />
                                <div>
                                    <CardTitle>Crear Detalle de Orden</CardTitle>
                                    <CardDescription>
                                        Agrega un nuevo producto a una orden existente
                                    </CardDescription>
                                </div>
                            </div>
                            <Link href={orderDetails.index().url}>
                                <Button variant="outline">
                                    <ArrowLeft className="mr-2 size-4" />
                                    Volver
                                </Button>
                            </Link>
                        </div>
                    </CardHeader>
                    <CardContent>
                        {Object.keys(errors).length > 0 && (
                            <Alert variant="destructive" className="mb-6">
                                <AlertCircle className="size-4" />
                                <AlertDescription>
                                    Por favor, corrige los errores en el formulario antes de continuar.
                                </AlertDescription>
                            </Alert>
                        )}

                        <form onSubmit={handleSubmit} className="space-y-6">
                            <div className="grid gap-6 md:grid-cols-2">
                                {fields.map(field => renderField(field))}
                            </div>

                            <div className="flex justify-end gap-4 pt-6 border-t">
                                <Link href={orderDetails.index().url}>
                                    <Button type="button" variant="outline">
                                        Cancelar
                                    </Button>
                                </Link>
                                <Button type="submit" disabled={processing}>
                                    <Save className="mr-2 size-4" />
                                    {processing ? 'Guardando...' : 'Guardar Detalle'}
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}

