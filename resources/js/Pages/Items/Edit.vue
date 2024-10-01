<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { useToast } from "@/composables/useToast";

const { showToast } = useToast();

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  programs: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  ...props.item,
});

const submit = () => {
  form.put(route("items.update", props.item), {
    onSuccess: () => {
      form.reset();
      showToast(`${props.item.name} updated!`);
    },
  });
};
</script>


<template>
  <Head title="Item Edit" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Edit Item
      </h2>
      <p class="text-xs text-gray-500 mt-2">
        <Link :href="route('items.index')"
          ><span class="text-indigo-500">Items</span></Link
        >
        >
        {{ item.name }}
        >
        <span>Edit Item</span>
      </p>
    </template>
    <div class="py-12">
      <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submit()">
              <div class="">
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="name" value="Item Name*" />
                  <TextInput
                    name="name"
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.name"
                    required
                    autocomplete="name"
                  />

                  <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="name" value="Lot number*" />
                  <TextInput
                    name="lot_no"
                    id="lot_no"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.lot_no"
                    required
                    autocomplete="lot_no"
                  />

                  <InputError class="mt-2" :message="form.errors.lot_no" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="expiration_date" value="Expiration Date" />
                  <TextInput
                    name="expiration_date"
                    id="expiration_date"
                    type="date"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.expiration_date"
                    autocomplete="expiration_date"
                  />

                  <InputError
                    class="mt-2"
                    :message="form.errors.expiration_date"
                  />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="program_id" value="Program*" />
                  <select
                    name="program_id"
                    id="program_id"
                    v-model="form.program_id"
                    required
                    class="w-full border-gray-300 mt-1 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  >
                    <option value="">-</option>
                    <option
                      v-for="program in props.programs"
                      :key="program.id"
                      :value="program.id"
                    >
                      {{ program.code }} {{ program.name }}
                    </option>
                  </select>
                </div>

                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel for="quantity" value="Quantity*" />
                  <TextInput
                    name="quantity"
                    id="quantity"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.quantity"
                    required
                    autocomplete="quantity"
                  />

                  <InputError class="mt-2" :message="form.errors.quantity" />
                </div>
                <div class="relative z-0 w-full mb-6 group">
                  <InputLabel
                    for="restock_threshold"
                    value="Restock Threshold*"
                  />
                  <TextInput
                    name="restock_threshold"
                    id="restock_threshold"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder=" "
                    v-model="form.restock_threshold"
                    required
                    autocomplete="restock_threshold"
                  />

                  <InputError
                    class="mt-2"
                    :message="form.errors.restock_threshold"
                  />
                </div>
              </div>
              <button
                type="submit"
                :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                Update
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>