<script setup>
import { Head, Link } from "@inertiajs/vue3";
import GlobalTicketsLogo from "@/Components/GlobalTicketsLogo.vue";
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-brandDark text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3"
                >
                    <div class="flex lg:justify-center lg:col-start-2">
                        <GlobalTicketsLogo />
                    </div>
                </header>

                <main class="mt-6">
                    <div
                        id="docs-card"
                        class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                    >
                        <div class="relative flex items-center gap-6">
                            <div
                                id="docs-card-content"
                                class="flex flex-col items-start gap-6"
                            >
                                <h1
                                    class="text-4xl font-bold text-gray-800 dark:text-white"
                                >
                                    Welcome to the URL Shortener Project
                                </h1>
                                <h3>by Maksym Kovalenko</h3>
                                <div class="pt-3 sm:pt-5 lg:pt-0">
                                    <h2
                                        class="text-xl font-semibold text-black dark:text-white"
                                    >
                                        Project Overview
                                    </h2>

                                    <div
                                        class="mt-2 text-gray-600 dark:text-gray-400 text-sm"
                                    >
                                        <p>
                                            This project is a URL Shortening
                                            application built with the following
                                            technologies:
                                        </p>
                                        <ul class="list-disc ml-4 mt-2">
                                            <li>Laravel for the backend</li>
                                            <li>
                                                Vue 3 with Composition API for
                                                the frontend
                                            </li>
                                            <li>
                                                Inertia.js for seamless
                                                single-page application
                                                navigation
                                            </li>
                                            <li>
                                                Laravel Sanctum for API
                                                authentication
                                            </li>
                                        </ul>
                                        <p class="mt-4">
                                            It includes user registration and
                                            authentication, URL management, and
                                            redirection functionality.
                                        </p>
                                        <p class="mt-4">
                                            I'm excited for the opportunity to
                                            complete this assessment and
                                            demonstrate my skills in full-stack
                                            development.
                                        </p>

                                        <p>
                                            To start using the application,
                                            please create an account or log in
                                            if you already have one.
                                        </p>

                                        <p class="">
                                            Once logged in, you'll be able to
                                            manage your shortened URLs from the
                                            dashboard.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                id="screenshot-container"
                                class="relative flex w-full flex-1 items-stretch"
                            >
                                <img
                                    src="/images/dashboardScreenshot.png"
                                    alt="Project Dashboard page screenshot"
                                    class="aspect-video h-full w-full flex-1 rounded-[3px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]"
                                />
                                <div
                                    class="absolute -bottom-16 left-0 h-40 w-full bg-gradient-to-b from-transparent via-white to-white dark:via-zinc-900 dark:to-zinc-900"
                                ></div>
                            </div>
                        </div>

                        <nav
                            v-if="canLogin"
                            class="flex justify-start text-base w-full"
                        >
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="rounded-md px-3 py-2 text-brandYellow ring-1 ring-transparent transition hover:text-brandYellow/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                            >
                                Dashboard
                            </Link>

                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="rounded-md px-3 py-2 text-brandYellow ring-1 ring-transparent transition hover:text-brandYellow/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                >
                                    Log in
                                </Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="rounded-md px-3 py-2 text-brandYellow ring-1 ring-transparent transition hover:text-brandYellow/70 focus:outline-none focus-visible:ring-[#FF2D20]"
                                >
                                    Register
                                </Link>
                            </template>
                        </nav>
                    </div>
                </main>

                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                >
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
