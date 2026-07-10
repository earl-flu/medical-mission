<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, router, useForm, usePage, Link } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { ref, watch, onMounted } from "vue";
import axios from "axios";
import { useToast } from "@/composables/useToast";
import { useAgeCalculator } from "@/composables/useAgeCalculator";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";

const { showToast } = useToast();
const { calculateAge } = useAgeCalculator();

const props = defineProps({
  encounter: {
    encounter: Object,
    required: true,
  },
  services: {
    type: Array,
    required: true,
  },
});

const maxDate = ref("");
const age = calculateAge();
const showDetails = ref(false);

const form = useForm({
  services: [],
});

function submitEncounterServiceServed() {
  form.services = form.services.map((service) => service.id);
  form.post(route("encounter-service.store", props.encounter), {
    onSuccess: () => {
      showToast(
        `${props.encounter.patient.full_name} services have been set to serve!`
      );
      form.reset();
    },
  });
}
</script>

<template>
  <Head title="Serve Service" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Services
      </h2>
      <p class="text-xs text-gray-500 mt-2">
        <Link :href="route('patients.index')"
          ><span class="text-indigo-500">Patients</span></Link
        >
        >
        <Link :href="route('patients.show', $props.encounter.patient)"
          ><span class="uppercase text-indigo-500">{{
            $props.encounter.patient.full_name
          }}</span></Link
        >
        >
        <span>Services</span>
      </p>
    </template>
    <div class="max-w-5xl mx-auto py-12 flex justify-center gap-5">
      <div class="max-w-2xl flex-1">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-5 border flex gap-5">
            <div class="text-gray-600">
              <p class="uppercase text-cyan-800 font-medium">
                {{ encounter.patient.full_name }}
              </p>
              <div class="text-xs">
                <p>{{ encounter.event.name }}</p>
                <button
                  @click="showDetails = !showDetails"
                  class="text-xs mt-2 text-blue-600 underline focus:outline-none"
                  type="button"
                >
                  {{ showDetails ? "Hide details" : "Show details" }}
                </button>
                <div v-if="showDetails" class="mt-1">
                  <p>{{ encounter.patient.sex_str }}</p>
                  <p>{{ encounter.patient.birthdate_str }}</p>
                  <p>{{ encounter.patient.age_years }}</p>
                  <p>{{ encounter.patient.full_address }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitEncounterServiceServed()">
              <div class="mt-4">
                <p class="font-semibold mb-2 text-green-700">Served Services</p>
                <ul>
                  <li
                    v-for="enc_serv in encounter.encounter_service.filter(
                      (s) => s.is_serve
                    )"
                    :key="enc_serv.id"
                    class="flex items-center mb-1 text-green-700"
                  >
                    <font-awesome-icon
                      icon="check-circle"
                      class="mr-2 text-green-500"
                    />
                    {{ enc_serv.service.name }}
                  </li>
                </ul>
              </div>
              <div class="grid md:gap-6 mt-4">
                <div class="relative w-full mb-6 group">
                  <!-- <InputLabel for="service_id" value="Services" /> -->
                  <multiselect
                    v-model="form.services"
                    :options="services"
                    :multiple="true"
                    :close-on-select="false"
                    placeholder="Select Services"
                    label="name"
                    track-by="id"
                    :preselect-first="false"
                    class="mt-1"
                  />
                  <InputError class="mt-2" :message="form.errors.service_id" />
                </div>
              </div>
              <button
                style="margin-top: 150px"
                type="submit"
                :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                Save
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>