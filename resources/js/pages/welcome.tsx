import { dashboard, login, register } from '@/routes';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export default function Welcome({
    canRegister = true,
}: {
    canRegister?: boolean;
}) {
    const { auth } = usePage<SharedData>().props;
    
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

    return (
        <>
            <Head title="Welcome">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link
                    href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
                    rel="stylesheet"
                />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                <header className="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
                    <nav className="flex items-center justify-between gap-4">
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

                        {/* Navigation Links */}
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={dashboard()}
                                    className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={login()}
                                        className="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                                    >
                                        Log in
                                    </Link>
                                    {canRegister && (
                                        <Link
                                            href={register()}
                                            className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                                        >
                                            Register
                                        </Link>
                                    )}
                                </>
                            )}
                        </div>
                    </nav>
                </header>
                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <main className="flex w-full max-w-7xl flex-col gap-12 px-6 py-12 lg:py-20">
                        {/* Hero Section */}
                        <div className="text-center">
                            <h1 className="mb-4 text-5xl font-bold text-[#1b1b18] lg:text-7xl dark:text-white">
                                Sabor & Tradición
                            </h1>
                            <p className="mx-auto max-w-2xl text-lg text-[#706f6c] lg:text-xl dark:text-[#A1A09A]">
                                Sistema de gestión administrativa para tu restaurante.
                                Optimiza tus operaciones de entrega y manejo de pedidos.
                            </p>
                        </div>

                        {/* Services Section */}
                        <div className="grid gap-6 md:grid-cols-2 lg:gap-8">
                            {/* Para Llevar Card */}
                            <div className="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-lg transition-all duration-300 hover:shadow-xl lg:p-12 dark:bg-[#0a0a0a]">
                                <div className="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-[#dc2626] opacity-10 transition-transform duration-300 group-hover:scale-150 dark:bg-[#7f1d1d]" />
                                
                                <div className="relative">
                                    <div className="mb-6 inline-flex rounded-xl bg-[#fee2e2] p-4 dark:bg-[#450a0a]">
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
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                            />
                                        </svg>
                                    </div>
                                    
                                    <h2 className="mb-3 text-2xl font-bold text-[#1b1b18] dark:text-white">
                                        Para Llevar
                                    </h2>
                                    
                                    <p className="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
                                        Gestiona los pedidos para recoger en el establecimiento. 
                                        Control completo del inventario, tiempos de preparación y estado de los pedidos.
                                    </p>
                                    
                                    <ul className="space-y-2">
                                        <li className="flex items-start gap-2">
                                            <svg
                                                className="mt-0.5 h-5 w-5 flex-shrink-0 text-[#dc2626] dark:text-[#dc2626]"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fillRule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clipRule="evenodd"
                                                />
                                            </svg>
                                            <span className="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Control de pedidos en tiempo real
                                    </span>
                                </li>
                                        <li className="flex items-start gap-2">
                                            <svg
                                                className="mt-0.5 h-5 w-5 flex-shrink-0 text-[#dc2626] dark:text-[#dc2626]"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fillRule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clipRule="evenodd"
                                                />
                                            </svg>
                                            <span className="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Notificaciones automáticas
                                        </span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <svg
                                                className="mt-0.5 h-5 w-5 flex-shrink-0 text-[#dc2626] dark:text-[#dc2626]"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fillRule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clipRule="evenodd"
                                                />
                                            </svg>
                                            <span className="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Historial de transacciones
                                    </span>
                                </li>
                            </ul>
                                </div>
                        </div>

                            {/* A Domicilio Card */}
                            <div className="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-lg transition-all duration-300 hover:shadow-xl lg:p-12 dark:bg-[#0a0a0a]">
                                <div className="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-[#dc2626] opacity-10 transition-transform duration-300 group-hover:scale-150 dark:bg-[#7f1d1d]" />
                                
                                <div className="relative">
                                    <div className="mb-6 inline-flex rounded-xl bg-[#fee2e2] p-4 dark:bg-[#450a0a]">
                                        <svg
                                            className="h-8 w-8 text-[#dc2626] dark:text-[#dc2626]"
                                fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            strokeWidth={2}
                            >
                                <path
                                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                                <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"
                                            />
                                        </svg>
                                    </div>
                                    
                                    <h2 className="mb-3 text-2xl font-bold text-[#1b1b18] dark:text-white">
                                        A Domicilio
                                    </h2>
                                    
                                    <p className="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
                                        Administra entregas a domicilio de manera eficiente. 
                                        Seguimiento en tiempo real, asignación de repartidores y optimización de rutas.
                                    </p>
                                    
                                    <ul className="space-y-2">
                                        <li className="flex items-start gap-2">
                                            <svg
                                                className="mt-0.5 h-5 w-5 flex-shrink-0 text-[#dc2626] dark:text-[#dc2626]"
                                    fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                <path
                                                    fillRule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clipRule="evenodd"
                                />
                            </svg>
                                            <span className="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Gestión de repartidores
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <svg
                                                className="mt-0.5 h-5 w-5 flex-shrink-0 text-[#dc2626] dark:text-[#dc2626]"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                >
                                    <path
                                                    fillRule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clipRule="evenodd"
                                                />
                                            </svg>
                                            <span className="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Seguimiento GPS en tiempo real
                                            </span>
                                        </li>
                                        <li className="flex items-start gap-2">
                                            <svg
                                                className="mt-0.5 h-5 w-5 flex-shrink-0 text-[#dc2626] dark:text-[#dc2626]"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                >
                                    <path
                                                    fillRule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clipRule="evenodd"
                                                />
                                            </svg>
                                            <span className="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Cálculo automático de tiempos
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {/* Features Section */}
                        <div className="rounded-2xl bg-gradient-to-br from-[#dc2626] to-[#b91c1c] p-8 text-white shadow-xl lg:p-12 dark:from-[#7f1d1d] dark:to-[#450a0a]">
                            <div className="mx-auto max-w-4xl text-center">
                                <h3 className="mb-4 text-3xl font-bold">
                                    Panel Administrativo Completo
                                </h3>
                                <p className="mb-8 text-lg opacity-90">
                                    Todas las herramientas que necesitas para gestionar tu restaurante en un solo lugar
                                </p>
                                
                                <div className="grid gap-6 md:grid-cols-3">
                                    <div className="rounded-xl bg-white/10 p-6 backdrop-blur-sm">
                                        <svg
                                            className="mx-auto mb-3 h-10 w-10"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                >
                                    <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                            />
                            </svg>
                                        <h4 className="mb-2 font-semibold">Reportes y Estadísticas</h4>
                                        <p className="text-sm opacity-90">
                                            Analiza el rendimiento de tu negocio con reportes detallados
                                        </p>
                                    </div>
                                    
                                    <div className="rounded-xl bg-white/10 p-6 backdrop-blur-sm">
                                        <svg
                                            className="mx-auto mb-3 h-10 w-10"
                                fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                >
                                    <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                            />
                                        </svg>
                                        <h4 className="mb-2 font-semibold">Gestión de Personal</h4>
                                        <p className="text-sm opacity-90">
                                            Administra roles, permisos y turnos de tu equipo
                                        </p>
                                    </div>
                                    
                                    <div className="rounded-xl bg-white/10 p-6 backdrop-blur-sm">
                                        <svg
                                            className="mx-auto mb-3 h-10 w-10"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                >
                                    <path
                                                strokeLinecap="round"
                                        strokeLinejoin="round"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <h4 className="mb-2 font-semibold">Control Financiero</h4>
                                        <p className="text-sm opacity-90">
                                            Seguimiento de ventas, gastos e ingresos en tiempo real
                                        </p>
                                    </div>
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
