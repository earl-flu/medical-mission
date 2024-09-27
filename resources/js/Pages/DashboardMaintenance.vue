<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div
            style="min-height: 500px"
            class="p-6 text-gray-900 dark:text-gray-100 flex items-center justify-center"
          >
            <div class="flex items-center justify-center gap-5">
              <div class="norvs">
                <img
                  style="height: 105px; width: 105px"
                  src="/images/norvin.png"
                  alt="PLGU Catanduanes Logo"
                />
              </div>
              <h2 class="uppercase text-2xl font-bold text-gray-600">
                The dashboard page is under maintenance
              </h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.norvs {
  height: 120px;
  width: 120px;
  background-color: #cdcdcd;
  border-radius: 50%;
}

.norvs img {
  height: 100%!important;
  width: 100%!important;
  object-fit: cover;
}
</style>
