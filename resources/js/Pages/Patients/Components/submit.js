import { props } from './OrderedItemRow.vue';

export const submit = () => {
console.log(props.ordered_item.id);
// form.get('orderItems.create');
// form.put(route('orderItems.update', [props.ordered_item.id]), {
//     // onSuccess: () => { form.reset() }
// });
// form.put(route('orderItems.update', [props.ordered_item.id]))
};
