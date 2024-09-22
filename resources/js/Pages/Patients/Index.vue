<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PatientCard from "./Components/PatientCard.vue";
import Pagination from "@/Components/Pagination.vue";
import throttle from "lodash/throttle";

const props = defineProps({
  success: {
    type: String,
    default: null,
  },
  patients: {
    type: Object,
    required: true,
  },
  filters: Object,
});

const search_first_name = ref(props.filters.search_first_name || "");
const search_last_name = ref(props.filters.search_last_name || "");
const search_middle_name = ref(props.filters.search_middle_name || "");

watch(
  [search_first_name, search_middle_name, search_last_name],
  throttle(function ([firstName, middleName, lastName]) {
    router.get(
      "/patients",
      {
        search_first_name: firstName,
        search_middle_name: middleName,
        search_last_name: lastName,
      },
      { preserveState: true, replace: true }
    );
  }, 300)
);
</script>


<template>
  <Head title="Patients" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Patients
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex mb-5">
            <div class="flex-1"></div>
              <p
                class="text-sm text-indigo-500 font-semibold cursor-pointer hover:underline"
              >
                <Link :href="route('patients.create')">Add Patient</Link>
              </p>
            </div>
            <div class="grid md:grid-cols-3 md:gap-6 mb-10">
              <div class="relative z-0 w-full mb-6 group">
                <InputLabel for="search_first_name" value="Search" />
                <TextInput
                  name="search_first_name"
                  id="search_first_name"
                  type="text"
                  class="mt-1 block w-full"
                  placeholder="First Name"
                  v-model="search_first_name"
                  required
                  autocomplete="off"
                />
              </div>

              <div class="relative z-0 w-full mb-6 group">
                <TextInput
                  name="search_middle_name"
                  id="search_middle_name"
                  type="text"
                  class="mt-1 block w-full mt-6"
                  placeholder="Middle Name"
                  v-model="search_middle_name"
                  required
                  autocomplete="off"
                />
              </div>

              <div class="relative z-0 w-full mb-6 group">
                <TextInput
                  name="search_last_name"
                  id="search_last_name"
                  type="text"
                  class="mt-1 block w-full mt-6"
                  placeholder="Last Name"
                  v-model="search_last_name"
                  required
                  autocomplete="off"
                />
              </div>
            </div>

            <PatientCard
              v-for="patient in patients.data"
              :key="patient.id"
              :patient="patient"
            />
            <p
              v-if="!patients.data.length"
              class="text-red-500 text-xs text-center font-medium uppercase p-5"
            >
              NO PATIENTS FOUND
            </p>
            <div class="mt-6 flex">
              <div class="flex-1"></div>
              <Pagination :links="patients.links" v-if="patients.total" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>