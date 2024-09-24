<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, router, useForm, usePage, Link } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { ref } from "vue";
import { watch } from "vue";
import axios from "axios";
import { onMounted } from "vue";
import { useToast } from "@/composables/useToast";
import { useAgeCalculator } from "@/composables/useAgeCalculator";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";

const { showToast } = useToast();
const { calculateAge } = useAgeCalculator();

const props = defineProps({
  patient: {
    type: Object,
    required: true,
  },
  services: {
    type: Array,
    required: true,
  },
  events: {
    type: Array,
    required: true,
  },
  diagnoses: {
    type: Array,
    required: true,
  },
});

const maxDate = ref("");
const age = calculateAge();
const servicesOptions = ref([]);

onMounted(() => {
  servicesOptions.value = props.services.map((service) => ({
    value: service.id,
    label: service.name,
  }));
});

const dateTimeNow = () => {
  const now = new Date();
  console.log("Current date and time:", now.toISOString());

  // Format the date and time to YYYY-MM-DDTHH:mm
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, "0");
  const day = String(now.getDate()).padStart(2, "0");
  const hours = String(now.getHours()).padStart(2, "0");
  const minutes = String(now.getMinutes()).padStart(2, "0");

  return `${year}-${month}-${day}T${hours}:${minutes}`;
};

const form = useForm({
  is_opto: false,
  is_pregnant: false,
  bp_systolic: "",
  bp_diastolic: "",
  temperature: "",
  respiratory_rate: "",
  oxygen_saturation: "",
  pulse_rate: "",
  remarks: "",
  age: age,
  event_id: props.events.length > 0 ? props.events[0].id : undefined,
  patient_id: props.patient.id,
  patient_birthdate: props.patient.birthdate,
  encounter_date: dateTimeNow(),
  services: [],
});

function submitEncounter() {
  form.services = form.services.map((service) => service.id);
  form.post(route("encounter.store"), {
    onSuccess: () => {
      showToast(`${props.patient.first_name} encounter has been registered!`);
      form.reset();
    },
  });
}
</script>

<template>
  <Head title="Create Patient" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Create Patient Encounter
      </h2>
      <p class="text-xs text-gray-500 mt-2">
        <Link :href="route('patients.index')"
          ><span class="text-indigo-500">Patients</span></Link
        >
        >
        <Link :href="route('patients.show', $props.patient)"
          ><span class="uppercase text-indigo-500">{{
            $props.patient.full_name
          }}</span></Link
        >
        >
        <span>Add Encounter</span>
      </p>
    </template>
    <div class="max-w-5xl mx-auto py-12 flex justify-center gap-5">
      <div class="max-w-2xl flex-1">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-5 border flex gap-5">
            <div class="h-28 w-28 bg-gray-300"></div>
            <div class="text-gray-600">
              <p class="uppercase text-cyan-800 font-medium">
                {{ patient.full_name }}
              </p>
              <p>{{ patient.sex_str }}</p>
              <p>{{ patient.birthdate_str }}</p>
              <p>{{ patient.age_years }}</p>
              <p>{{ patient.full_address }}</p>
            </div>
          </div>
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitEncounter()">
              <p class="font-bold text-xl mt-5">Event</p>
              <div class="grid md:gap-6 mt-4">
                <div class="relative z-0 w-full group">
                  <InputLabel for="event_id" value="Event Name*" />
                  <select
                    name="event"
                    id="event"
                    v-model="form.event_id"
                    required
                    class="w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  >
                    <option
                      v-for="event in props.events"
                      :key="event.id"
                      :value="event.id"
                    >
                      {{ event.name }}
                    </option>
                  </select>

                  <InputError class="mt-2" :message="form.errors.event_id" />
                </div>
              </div>
              <div class="md:gap-6 mt-4">
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="encounter_date" value="Encounter Date*" />
                  <TextInput
                    name="encounter_date"
                    id="encounter_date"
                    step="0.1"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.encounter_date"
                    autofocus
                    autocomplete="encounter_date"
                    type="datetime-local"
                  />

                  <InputError
                    class="mt-2"
                    :message="form.errors.encounter_date"
                  />
                </div>
              </div>
              <p class="font-bold text-xl mt-10">Vital Signs</p>

              <div class="grid md:grid-cols-3 md:gap-6 mt-4">
                <div
                  class="relative z-0 w-full mb-6 group"
                  v-if="form.sex == '0'"
                >
                  <label class="flex items-center">
                    <Checkbox
                      name="remember"
                      v-model:checked="form.is_pregnant"
                    />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400"
                      >Pregnant</span
                    >
                  </label>
                </div>
              </div>
              <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="temperature" value="Temperature (deg)" />
                  <TextInput
                    name="temperature"
                    id="temperature"
                    type="number"
                    step="0.1"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.temperature"
                    autofocus
                    autocomplete="temperature"
                  />

                  <InputError class="mt-2" :message="form.errors.temperature" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="bp_systolic" value="BP Systolic" />
                  <TextInput
                    name="bp_systolic"
                    id="bp_systolic"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder="120"
                    v-model="form.bp_systolic"
                    autofocus
                    autocomplete="bp_systolic"
                  />

                  <InputError class="mt-2" :message="form.errors.temperature" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="bp_diastolic" value="BP Diastolic" />
                  <TextInput
                    name="bp_diastolic"
                    id="bp_diastolic"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder="80"
                    v-model="form.bp_diastolic"
                    autofocus
                    autocomplete="bp_diastolic"
                  />

                  <InputError
                    class="mt-2"
                    :message="form.errors.bp_diastolic"
                  />
                </div>
              </div>
              <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="respiratory_rate" value="Respiratory Rate" />
                  <TextInput
                    name="respiratory_rate"
                    id="respiratory_rate"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.respiratory_rate"
                    autofocus
                    autocomplete="respiratory_rate"
                  />

                  <InputError
                    class="mt-2"
                    :message="form.errors.respiratory_rate"
                  />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel
                    for="oxygen_saturation"
                    value="Oxygen Saturation (%)"
                  />
                  <TextInput
                    name="oxygen_saturation"
                    id="oxygen_saturation"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.oxygen_saturation"
                    autofocus
                    autocomplete="oxygen_saturation"
                  />

                  <InputError
                    class="mt-2"
                    :message="form.errors.oxygen_saturation"
                  />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="pulse_rate" value="Pulse Rate" />
                  <TextInput
                    name="pulse_rate"
                    id="pulse_rate"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.pulse_rate"
                    autofocus
                    autocomplete="pulse_rate"
                  />

                  <InputError class="mt-2" :message="form.errors.pulse_rate" />
                </div>
              </div>
              <p class="font-bold text-xl mt-2">Service</p>

              <div class="grid md:gap-6 mt-4">
                <div class="relative w-full mb-6 group">
                  <InputLabel for="service_id" value="Services" />
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

              <div class="grid md:gap-6">
                <div class="relative w-full mb-6 group">
                  <InputLabel for="remarks" value="Remarks" />
                  <textarea
                    name="remarks"
                    v-model="form.remarks"
                    id="remarks"
                    rows="4"
                    class="block mt-1 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  ></textarea>

                  <InputError class="mt-2" :message="form.errors.remarks" />
                </div>
              </div>

              <button
                type="submit"
                :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                Save Encounter
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>