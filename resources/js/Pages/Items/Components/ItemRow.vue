<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useNumberComma } from '@/composables/useNumberComma';

const { numberComma } = useNumberComma();

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
})

const isLowStock = computed(() => {
    return props.item.quantity <= props.item.restock_threshold
})


</script>


<template>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
     hover:bg-gray-50 dark:hover:bg-gray-600" :class="{ 'text-yellow-600': isLowStock }">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" :class="{ 'text-yellow-600': isLowStock }">
            {{ item.name }}
        </th>
        <td class="px-6 py-4">
            {{ numberComma(item.quantity) }}
        </td>
        <td class="px-6 py-4">
            {{ item.restock_threshold }}
        </td>
        <td class="px-6 py-4 text-right">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                <Link :href="route('items.edit', props.item.id)">Edit</Link>
            </a>
        </td>
    </tr>
</template>