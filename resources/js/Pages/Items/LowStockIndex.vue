<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import ItemRow from "./Components/ItemRow.vue";
import { ref, watch, onMounted } from "vue";
import throttle from "lodash/throttle";
import { useToast } from "@/composables/useToast";

const { showToast } = useToast();
const page = usePage();

const props = defineProps({
  lowStockItems: {
    type: Object,
    required: true,
  },
  filters: Object,
});

onMounted(() => {
  console.log("mounted");
  if (page.props.flash.message) {
    showToast(page.props.flash.message);
  }
});

const search = ref(props.filters.search || "");

watch(
  search,
  throttle(function (search) {
    router.get(
      route("items.lowstock"),
      {
        search,
      },
      { preserveState: true, replace: true }
    );
  }, 300)
);
</script>


<template>
  <Head title="Low Stock Items" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Low Stock Items
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                  <th scope="col" class="px-6 py-3">Item name</th>
                  <th scope="col" class="px-6 py-3">Quantity</th>
                  <th scope="col" class="px-6 py-3">Lot No.</th>
                  <th scope="col" class="px-6 py-3">Expiry</th>
                  <th scope="col" class="px-6 py-3">Restock Threshold</th>
                  <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <ItemRow
                  v-for="item in lowStockItems.data"
                  :key="item.id"
                  :item="item"
                />
              </tbody>
            </table>
            <p
              v-if="!lowStockItems.data.length"
              class="text-red-500 text-xs text-center font-medium uppercase p-5"
            >
              No Items Found
            </p>
          </div>

          <div class="mt-6 flex">
            <div class="flex-1"></div>
            <Pagination
              :links="lowStockItems.links"
              v-if="lowStockItems.total"
            />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>