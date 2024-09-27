<script setup>
// import { Link } from '@inertiajs/vue3';
import { useCartStore } from "@/stores/CartStore";
import { computed } from "vue";

const cart = useCartStore();

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
});

const isLowStock = computed(() => {
  return props.item.quantity <= props.item.restock_threshold;
});
</script>


<template>
  <tr
    @click="cart.addOrderItem(props.item)"
    class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
    :class="{ 'text-yellow-600': isLowStock }"
  >
    <th
      scope="row"
      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
      :class="{ 'text-yellow-600': isLowStock }"
    >
      {{ item.name }}
    </th>
    <td class="px-6 py-4">
      {{ item.quantity }}
    </td>
    <td class="px-6 py-4">
      {{ item.lot_no }}
    </td>
  </tr>
</template>