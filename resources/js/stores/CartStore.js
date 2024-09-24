import { defineStore } from "pinia";
import { ref, reactive, watch } from "vue";

export const useCartStore = defineStore("cart", () => {
    let orderItems = reactive([]);

    function addOrderItem(item) {
        const { id, name, lot_no } = item;
        const exists = orderItems.some((orderItem) => orderItem.id === item.id);
        if (exists) return;
        return orderItems.push({
            id,
            name,
            lot_no,
            instruction: '',
            order_quantity: 1,
        });
    }

    function removeOrderedItem(id) {
        const index = orderItems.findIndex((orderItem) => orderItem.id === id);
        if (index !== -1) {
            orderItems.splice(index, 1);
        }
    }

    function adjustOrderQuantity(id, qty) {
        const item = orderItems.find((orderItem) => orderItem.id === id);
        return (item.order_quantity = qty);
    }

    function updateOrderInstruction(id, instruction) {
        const item = orderItems.find((orderItem) => orderItem.id === id);
        return (item.instruction = instruction);
    }

    function orderedItemsReset() {
        orderItems.splice(0, orderItems.length);
    }

    return {
        orderItems,
        addOrderItem,
        removeOrderedItem,
        orderedItemsReset,
        adjustOrderQuantity,
        updateOrderInstruction
    };
});
