<script setup>
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import { useCartStore } from '@/stores/CartStore';

const props = defineProps({
    orderedItem: {
        type: Object,
        required: true
    },
})

const cart = useCartStore();

const quantity = ref(props.orderedItem.order_quantity)
const instruction = ref(props.orderedItem.instruction)

</script>


<template>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700  hover:bg-gray-100 dark:hover:bg-gray-600">
        <td class="break-all text-wrap pl-3">
            <div @click="cart.removeOrderedItem(props.orderedItem.id)"
                class="close-btn h-7 w-7 rounded-full
                                border text-center flex items-center justify-center
                                cursor-pointer border-red-300 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                X</div>
        </td>
        <td class="break-all text-wrap p-4 dark:text-white product-name">
            {{ props.orderedItem.name }}
        </td>
        <td class="break-all text-wrap p-4">
            <div class="relative z-0 w-full mb-6 group">
                <TextInput @change="cart.adjustOrderQuantity(props.orderedItem.id, quantity)" name="order_quantity"
                    id="order_quantity" type="number" class="mt-1 block w-full" placeholder=" " v-model="quantity" required
                    autofocus autocomplete="order_quantity" />
            </div>
        </td>
        <td class="break-all text-wrap p-4">
            <div class="relative z-0 w-full mb-6 group">
                <textarea name="instruction" @change="cart.updateOrderInstruction(props.orderedItem.id, instruction)" v-model="instruction"></textarea>
            </div>
        </td>
    </tr>
</template>