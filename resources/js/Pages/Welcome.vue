<script setup>
import { Head, Link } from '@inertiajs/vue3';

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
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen  bg-gradient-to-r from-cyan-500 to-blue-900 selection:bg-red-500 selection:text-white">


        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="font-semibold text-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            Dashboard</Link>

            <template v-else>
                <Link :href="route('login')"
                    class="font-semibold text-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Log in</Link>

                <!-- <Link v-if="canRegister" :href="route('register')"
                    class="ms-4 font-semibold text-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Register</Link> -->
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <div class="text-white text-xl flex gap-7 uppercase">
                    <div class="image-logos flex gap-1">
                        <img class="w-28 h-28" src="/images/catanduanes-official-seal.png" alt="PLGU Catanduanes Logo">
                        <img class="w-28 h-28" src="/images/CIA-LOGO.png" alt="CIA Logo">
                    </div>
                    <div>
                        <p class="mb-2">Catanduanes International Association, Inc.</p>
                        <p class="text-6xl font-bold mb-2">11<span>ᵗʰ</span> Medical Mission</p>
                        <p class="">"We Care About Catanduanes"</p>
                        <p class="text-sm opacity-70 mt-10">January 22-26, 2024</p>
                        <p class="text-sm opacity-70 ">PHO Warehouse, EBMC Compound</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute w-full bg-black bottom-0 left-0 text-white px-5 py-2">
            <div class="max-w-7xl text-xs text-gray-200">
                This web application is developed and maintained by PHO Catanduanes, IT Unit.
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
