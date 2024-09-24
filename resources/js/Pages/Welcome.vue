<script setup>
import { Head, Link } from "@inertiajs/vue3";

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
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen selection:bg-red-500 selection:text-white bg-cover bg-center bg-opacity-5"
    style="background-image: url('/images/phobg2.jpg')"
  >
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
      <Link
        v-if="$page.props.auth.user"
        :href="route('dashboard')"
        class="font-semibold text-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
      >
        Dashboard</Link
      >

      <template v-else>
        <Link
          :href="route('login')"
          class="font-semibold text-gray-100 hover:text-blue-300 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >
          Log in</Link
        >

        <!-- <Link v-if="canRegister" :href="route('register')"
                    class="ms-4 font-semibold text-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Register</Link> -->
      </template>
    </div>

    <div class="max-w-7xl mx-auto p-6 lg:p-8 relative z-10">
      <div class="flex justify-center">
        <div class="text-white text-xl flex gap-7 uppercase items-center">
          <div class="image-logos flex gap-1">
            <img
            style="height:105px; width:105px;"
              src="/images/catanduanes-official-seal.png"
              alt="PLGU Catanduanes Logo"
            />
          </div>
          <div>
            <p class="mb-4 opacity-70" style="letter-spacing: 41px;">Catanduanes</p>
            <p class="font-bold mb-2 uppercase" style="font-size:40px; word-spacing:5px;">Provincial Health Office</p>
            <!-- <p class="">"We Care About Catanduanes"</p> -->
          </div>
        </div>
      </div>
    </div>
    <div class="absolute w-full bg-black bottom-0 left-0 text-white px-5 py-2">
      <div class="text-xs text-gray-200 text-center">
        This web application is developed and maintained by PHO Catanduanes, IT
        Unit.
      </div>
    </div>
  </div>
</template>

<style>
</style>
