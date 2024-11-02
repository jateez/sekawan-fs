import { Head, Link } from "@inertiajs/react";

export default function Welcome({ auth }) {
    return (
        <>
            <Head title="Welcome" />
            <div className="bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 min-h-screen flex items-center justify-center">
                <div className="max-w-md w-full text-center p-6">
                    <header className="mb-6">
                        <h1 className="text-4xl font-bold text-gray-800 dark:text-gray-100">
                            Welcome
                        </h1>
                    </header>
                    <nav className="flex justify-center space-x-4">
                        {auth.user ? (
                            <Link
                                href={route("dashboard")}
                                className="btn btn-primary"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={route("login")}
                                    className="btn btn-primary"
                                >
                                    Log in
                                </Link>
                            </>
                        )}
                    </nav>
                </div>
            </div>
        </>
    );
}
