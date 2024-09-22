<script setup>
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { router, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import Swal from 'sweetalert2';

const props = defineProps({
    ordered_item: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    ...props.ordered_item
})

const editing = ref(false);

function edit() {
    editing.value = true
}

function remove() {
    Swal.fire({
        title: `Remove ${props.ordered_item.item.name}?`,
        text: "The selected medicine will be removed from the patient",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#8d99ae",
        confirmButtonText: "Yes, remove it!"
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('orderItems.destroy', props.ordered_item.id))
                Swal.fire({
                    title: "Remove!",
                    text: `${props.ordered_item.item.name} has been removed`,
                    icon: "success"
                });
        }
    });
}

function closeModal() {
    editing.value = false
    removing.value = false
}

const submit = () => {
    form.put(route('orderItems.update', props.ordered_item.id), {
        onSuccess: () => {
            editing.value = false;
        }
    })
};
</script>

<template>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ ordered_item.item.name }}
            {{ ordered_item.id }}
        </th>
        <td class="px-6 py-4">
            {{ ordered_item.quantity }}
        </td>
        <td class="px-6 py-4">
            {{ ordered_item.instruction }}
        </td>
        <td class="px-6 py-4 text-right">
            <a href="#" @click="edit()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>  
                <a href="#" @click="remove()"
                    class="font-medium text-red-500 dark:text-red-100 hover:underline ml-3">Remove</a>
        </td>
    </tr>

    <Modal :show="editing" @close="closeModal" maxWidth="sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">
                Edit {{ ordered_item.item.name }}
            </h2>

            <form @submit.prevent="submit()">
                <div class="mt-6">
                    <div>
                        <InputLabel for="quantity" value="Quantity*" />
                        <TextInput name="quantity" id="quantity" type="number" class="mt-1 block w-full" placeholder=" "
                            v-model="form.quantity" required autocomplete="quantity" />
                        <InputError class="mt-2" :message="form.errors.quantity" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="instruction" value="Instruction" />
                        <textarea name="instruction" id="instruction"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            placeholder=" " v-model="form.instruction" autocomplete="instruction"> </textarea>
                        <InputError class="mt-2" :message="form.errors.instruction" />
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton class="ms-3" :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                        :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
