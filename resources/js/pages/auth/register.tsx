import { home, login } from '@/routes';
import { store } from '@/routes/register';
import { Form, Head, Link } from '@inertiajs/react';
import { useEffect, useState } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';

export default function Register() {
    // Inicializar el tema desde localStorage o preferencia del sistema
    const [theme, setTheme] = useState<'light' | 'dark'>(() => {
        if (typeof window !== 'undefined') {
            const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | null;
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            return savedTheme || (prefersDark ? 'dark' : 'light');
        }
        return 'light';
    });

    useEffect(() => {
        // Aplicar el tema al documento
        document.documentElement.classList.toggle('dark', theme === 'dark');
    }, [theme]);

    const toggleTheme = () => {
        const newTheme = theme === 'light' ? 'dark' : 'light';
        setTheme(newTheme);
        localStorage.setItem('theme', newTheme);
    };

    const goBack = () => {
        window.history.back();
    };

    return (
        <>
            <Head title="Registro" />
            <div className="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                <header className="mb-6 w-full max-w-[500px] text-sm lg:max-w-xl">
                    <nav className="flex items-center justify-between gap-4">
                        {/* Back Button */}
                        <button
                            onClick={goBack}
                            className="group relative inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#19140035] bg-white transition-all duration-300 hover:border-[#dc2626] hover:shadow-md dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:hover:border-[#7f1d1d]"
                            aria-label="Volver"
                            title="Volver a la página anterior"
                        >
                            <svg
                                className="h-5 w-5 text-[#1b1b18] transition-colors duration-300 group-hover:text-[#dc2626] dark:text-[#EDEDEC] dark:group-hover:text-[#7f1d1d]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                strokeWidth={2}
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                />
                            </svg>
                        </button>

                        {/* Navigation Links */}
                        <div className="flex items-center gap-4">
                            {/* Home Link */}
                            <Link
                                href={home()}
                                className="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                            >
                                Inicio
                            </Link>

                            {/* Theme Toggle Button */}
                            <button
                                onClick={toggleTheme}
                                className="group relative inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#19140035] bg-white transition-all duration-300 hover:border-[#dc2626] hover:shadow-md dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:hover:border-[#7f1d1d]"
                                aria-label="Cambiar tema"
                                title={theme === 'light' ? 'Cambiar a modo oscuro' : 'Cambiar a modo claro'}
                            >
                                {/* Sun Icon (visible in dark mode) */}
                                <svg
                                    className="absolute h-5 w-5 rotate-0 scale-100 text-[#dc2626] transition-all duration-300 dark:-rotate-90 dark:scale-0 dark:text-[#7f1d1d]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    strokeWidth={2}
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                                    />
                                </svg>
                                
                                {/* Moon Icon (visible in light mode) */}
                                <svg
                                    className="absolute h-5 w-5 rotate-90 scale-0 text-[#dc2626] transition-all duration-300 dark:rotate-0 dark:scale-100 dark:text-[#7f1d1d]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    strokeWidth={2}
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </nav>
                </header>

                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <main className="w-full max-w-[500px] lg:max-w-xl">
                        {/* Register Card */}
                        <div className="overflow-hidden rounded-2xl bg-white shadow-xl transition-all duration-300 dark:bg-[#0a0a0a]">
                            <div className="relative p-8 lg:p-12">
                                {/* Decorative Element */}
                                <div className="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-[#dc2626] opacity-10 dark:bg-[#7f1d1d]" />
                                
                                <div className="relative">
                                    {/* Title Section */}
                                    <div className="mb-8 text-center">
                                        <div className="mb-4 inline-flex rounded-xl bg-[#fee2e2] p-4 dark:bg-[#450a0a]">
                                            <svg
                                                className="h-8 w-8 text-[#dc2626] dark:text-[#dc2626]"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                strokeWidth={2}
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                                                />
                                            </svg>
                                        </div>
                                        <h1 className="mb-2 text-3xl font-bold text-[#1b1b18] dark:text-white">
                                            Crear una cuenta
                                        </h1>
                                        <p className="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                            Ingresa tus datos para crear tu cuenta
                                        </p>
                                    </div>

                                    {/* Register Form */}
                                    <Form
                                        {...store.form()}
                                        resetOnSuccess={['password', 'password_confirmation']}
                                        disableWhileProcessing
                                        className="flex flex-col gap-6"
                                    >
                                        {({ processing, errors }) => (
                                            <>
                                                <div className="grid gap-6">
                                                    <div className="grid grid-cols-2 gap-4">
                                                        <div className="grid gap-2">
                                                            <Label htmlFor="name" className="text-[#1b1b18] dark:text-[#EDEDEC]">
                                                                Nombre
                                                            </Label>
                                                            <Input
                                                                id="name"
                                                                type="text"
                                                                required
                                                                autoFocus
                                                                tabIndex={1}
                                                                autoComplete="given-name"
                                                                name="name"
                                                                placeholder="Juan"
                                                                className="border-[#19140035] bg-[#FDFDFC] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                                                            />
                                                            <InputError message={errors.name} />
                                                        </div>

                                                        <div className="grid gap-2">
                                                            <Label htmlFor="last_name" className="text-[#1b1b18] dark:text-[#EDEDEC]">
                                                                Apellido
                                                            </Label>
                                                            <Input
                                                                id="last_name"
                                                                type="text"
                                                                required
                                                                tabIndex={2}
                                                                autoComplete="family-name"
                                                                name="last_name"
                                                                placeholder="Pérez"
                                                                className="border-[#19140035] bg-[#FDFDFC] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                                                            />
                                                            <InputError message={errors.last_name} />
                                                        </div>
                                                    </div>

                                                    <div className="grid gap-2">
                                                        <Label htmlFor="email" className="text-[#1b1b18] dark:text-[#EDEDEC]">
                                                            Correo electrónico
                                                        </Label>
                                                        <Input
                                                            id="email"
                                                            type="email"
                                                            required
                                                            tabIndex={3}
                                                            autoComplete="email"
                                                            name="email"
                                                            placeholder="correo@ejemplo.com"
                                                            className="border-[#19140035] bg-[#FDFDFC] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                                                        />
                                                        <InputError message={errors.email} />
                                                    </div>

                                                    <div className="grid gap-2">
                                                        <Label htmlFor="phone_number" className="text-[#1b1b18] dark:text-[#EDEDEC]">
                                                            Teléfono{' '}
                                                            <span className="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                                                (opcional)
                                                            </span>
                                                        </Label>
                                                        <Input
                                                            id="phone_number"
                                                            type="tel"
                                                            tabIndex={4}
                                                            autoComplete="tel"
                                                            name="phone_number"
                                                            placeholder="+52 123 456 7890"
                                                            className="border-[#19140035] bg-[#FDFDFC] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                                                        />
                                                        <InputError message={errors.phone_number} />
                                                    </div>

                                                    <div className="grid gap-2">
                                                        <Label htmlFor="password" className="text-[#1b1b18] dark:text-[#EDEDEC]">
                                                            Contraseña
                                                        </Label>
                                                        <Input
                                                            id="password"
                                                            type="password"
                                                            required
                                                            tabIndex={5}
                                                            autoComplete="new-password"
                                                            name="password"
                                                            placeholder="Contraseña"
                                                            className="border-[#19140035] bg-[#FDFDFC] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                                                        />
                                                        <InputError message={errors.password} />
                                                    </div>

                                                    <div className="grid gap-2">
                                                        <Label htmlFor="password_confirmation" className="text-[#1b1b18] dark:text-[#EDEDEC]">
                                                            Confirmar contraseña
                                                        </Label>
                                                        <Input
                                                            id="password_confirmation"
                                                            type="password"
                                                            required
                                                            tabIndex={6}
                                                            autoComplete="new-password"
                                                            name="password_confirmation"
                                                            placeholder="Confirmar contraseña"
                                                            className="border-[#19140035] bg-[#FDFDFC] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                                                        />
                                                        <InputError
                                                            message={errors.password_confirmation}
                                                        />
                                                    </div>

                                                    <Button
                                                        type="submit"
                                                        className="mt-2 w-full bg-[#dc2626] text-white hover:bg-[#b91c1c] dark:bg-[#7f1d1d] dark:hover:bg-[#991b1b]"
                                                        tabIndex={7}
                                                        data-test="register-user-button"
                                                    >
                                                        {processing && <Spinner />}
                                                        Crear cuenta
                                                    </Button>
                                                </div>

                                                <div className="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                                    ¿Ya tienes una cuenta?{' '}
                                                    <TextLink 
                                                        href={login()} 
                                                        tabIndex={8}
                                                        className="font-semibold text-[#dc2626] hover:text-[#b91c1c] dark:text-[#dc2626] dark:hover:text-[#991b1b]"
                                                    >
                                                        Iniciar sesión
                                                    </TextLink>
                                                </div>
                                            </>
                                        )}
                                    </Form>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div className="hidden h-14.5 lg:block"></div>
            </div>
        </>
    );
}
