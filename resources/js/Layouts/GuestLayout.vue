<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <!-- <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link> -->
            <div class="text-gray-600 text-xs flex gap-3">
                <div class="image-logos flex gap-1">
                    <img class="w-14 h-14" src="/images/catanduanes-official-seal.png" alt="PLGU Catanduanes Logo">
                    <img class="w-14 h-14" src="/images/CIA-LOGO.png" alt="CIA Logo">
                </div>
                <div>
                    <p>Catanduanes International Association, Inc.</p>
                    <p class="text-xl text-gray-800">11<span>th</span> Medical Mission</p>
                    <p class="italic">"We Care About Catanduanes"</p>
                    <!-- <p class="text-gray-500 mt-2">January 22-26, 2024</p>
                <p class="text-gray-500 ">PHO Warehouse, EBMC Compound</p> -->
                </div>
            </div>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
