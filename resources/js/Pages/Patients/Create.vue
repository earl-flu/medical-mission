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

const { showToast } = useToast();
const { calculateAge } = useAgeCalculator();

const props = defineProps({
  cities: {
    type: Array,
    required: true,
  },
  diagnoses: {
    type: Array,
    required: true,
  },
});

const barangays = ref([]);
const maxDate = ref("");
const age = ref(null);

onMounted(() => {
  setMaxDate();
});

const form = useForm({
  first_name: "",
  middle_name: "",
  last_name: "",
  birthdate: "",
  sex: "",
  suffix: null,
  city_id: "",
  barangay_id: "",
});

watch(
  () => form.city_id,
  async (id) => {
    if (id) {
      const response = await axios.get("/api/barangays/" + id);
      barangays.value = response.data;
    } else {
      barangays.value = [];
    }
  }
);

watch(
  () => form.sex,
  (sex) => {
    if (sex == 1) {
      form.is_pregnant = false;
    }
  }
);

watch(
  () => form.birthdate,
  (newBirthdate) => {
    age.value = calculateAge(newBirthdate);
  }
);

function submitPatient() {
  form.post(route("patients.store"), {
    onSuccess: () => {
      showToast(`${form.first_name}, has been registered!`);
      form.reset();
    },
  });
}

function setMaxDate() {
  const currentDate = new Date().toISOString().split("T")[0];
  maxDate.value = currentDate;
}
</script>

<template>
  <Head title="Create Patient" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Create Patient
      </h2>
      <p class="text-xs text-gray-500 mt-2">
        <Link :href="route('patients.index')"
          ><span class="text-indigo-500">Patients</span></Link
        >
        >
        <span>Add Patient</span>
      </p>
    </template>
    <div class="max-w-5xl mx-auto py-12 flex justify-center gap-5">
      <div class="max-w-2xl flex-1">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="font-bold text-xl">Patient Details</p>
            <p class="mb-6 text-xs font-medium text-gray-500">
              Fill out this form to add patient
            </p>

            <form @submit.prevent="submitPatient()">
              <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="first_name" value="First Name*" />
                  <TextInput
                    name="first_name"
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.first_name"
                    autofocus
                    autocomplete="first_name"
                  />

                  <InputError class="mt-2" :message="form.errors.first_name" />
                </div>
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="middle_name" value="Middle Name" />
                  <TextInput
                    name="middle_name"
                    id="middle_name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.middle_name"
                    autofocus
                    autocomplete="middle_name"
                  />

                  <InputError class="mt-2" :message="form.errors.middle_name" />
                </div>
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="last_name" value="Last Name*" />
                  <TextInput
                    name="last_name"
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.last_name"
                    required
                    autofocus
                    autocomplete="last_name"
                  />

                  <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
              </div>
              <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="suffix" value="Suffix" />
                  <select
                    name="suffix"
                    id="suffix"
                    v-model="form.suffix"
                    class="w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  >
                    <option value="" selected></option>
                    <option value="Jr.">Jr.</option>
                    <option value="Sr.">Sr.</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                    <option value="IV">IV</option>
                    <option value="V">V</option>
                  </select>

                  <InputError class="mt-2" :message="form.errors.suffix" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="sex" value="Sex*" />
                  <select
                    name="sex"
                    id="sex"
                    required
                    v-model="form.sex"
                    class="w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  >
                    <option value="0">Female</option>
                    <option value="1">Male</option>
                  </select>

                  <InputError class="mt-2" :message="form.errors.sex" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="birthdate" value="Birthdate*" />
                  <TextInput
                    name="birthdate"
                    id="birthdate"
                    type="date"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.birthdate"
                    required
                    autofocus
                    :max="maxDate"
                    autocomplete="birthdate"
                  />
                  <span class="text-xs font-bold text-blue-500"
                    >{{ age }} yrs old</span
                  >

                  <InputError class="mt-2" :message="form.errors.birthdate" />
                </div>
              </div>
              <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="city" value="Municipality*" />
                  <select
                    name="city"
                    id="city"
                    v-model="form.city_id"
                    required
                    class="w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  >
                    <option value="" selected>Select Here</option>
                    <option
                      v-for="city in props.cities"
                      :key="city.id"
                      :value="city.id"
                    >
                      {{ city.name }}
                    </option>
                  </select>

                  <InputError class="mt-2" :message="form.errors.city" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="barangay" value="Barangay*" />
                  <select
                    name="barangay"
                    id="barangay"
                    required
                    v-model="form.barangay_id"
                    class="w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  >
                    <option
                      v-for="brgy in barangays"
                      :key="brgy.id"
                      :value="brgy.id"
                    >
                      {{ brgy.name }}
                    </option>
                  </select>

                  <InputError class="mt-2" :message="form.errors.barangay" />
                </div>
              </div>

              <button
                type="submit"
                :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                Submit
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>