<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Head, router, usePage, Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
// import ItemRow from "./Components/ItemRow.vue";
import { ref, watch, onMounted } from "vue";
import throttle from "lodash/throttle";
import { useToast } from "@/composables/useToast";

const { showToast } = useToast();
const page = usePage();

const props = defineProps({
  offices: {
    type: Object,
    required: true,
  },
  filters: Object,
});

onMounted(() => {
  if (page.props.flash.message) {
    showToast(page.props.flash.message);
  }
});

const search = ref(props.filters.search || "");

watch(
  search,
  throttle(function (search) {
    router.get(
      route("offices.index"),
      {
        search,
      },
      { preserveState: true, replace: true }
    );
  }, 300)
);
</script>


<template>
  <Head title="Offices" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        All Offices
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 mb-6 flex space-between">
        <div class="flex-1"></div>
        <Link
          :href="route('offices.create')"
          class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 cursor-pointer"
        >
          Add Office
        </Link>
      </div>
      <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <div class="mb-10">
            <div class="relative z-0 w-full mb-6 group">
              <InputLabel for="search" value="Search" />
              <TextInput
                name="search"
                id="search"
                type="text"
                class="mt-1 block w-full"
                placeholder="Item Name"
                v-model="search"
                required
                autocomplete="off"
              />
            </div>
          </div>

          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
              class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
              <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" class="px-6 py-3">Abbreviation</th>
                  <th scope="col" class="px-6 py-3">Name</th>
                  <th scope="col" class="px-6 py-3">Status</th>
                  <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <!-- <ItemRow
                  v-for="item in items.data"
                  :key="item.id"
                  :item="item"
                /> -->
                <tr
                  v-for="office in offices.data"
                  :key="office.id"
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                >
                  <th
                    scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ office.abbreviation }}
                  </th>
                  <td class="px-6 py-4">
                    {{ office.name }}
                  </td>
                  <td class="px-6 py-4">
                    <span class="text-xs p-1 rounded" :class="office.is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white'">{{ office.is_active ? 'Active' : 'Inactive' }}</span>
                  </td>
                  <td class="px-6 py-4 text-right">
                    <a
                      href="#"
                      class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    >
                      <Link :href="route('offices.edit', office.id)"
                        >Edit</Link
                      >
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
            <p
              v-if="!offices.data.length"
              class="text-red-500 text-xs text-center font-medium uppercase p-5"
            >
              NO OFFICE FOUND
            </p>
          </div>

          <div class="mt-6 flex">
            <div class="flex-1"></div>
            <Pagination :links="offices.links" v-if="offices.total" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>