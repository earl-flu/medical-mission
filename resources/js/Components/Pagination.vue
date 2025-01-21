<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  links: {
    type: Array,
    required: true,
  },
});
</script>
<template>
  <!-- <div class="flex justify-between items-center">
    <Link
      v-if="props.links[0].url"
      :href="props.links[0].url"
      class="p-2 px-3 text-blue-600 rounded-md"
    >
      Previous
    </Link>
    <template v-for="link in props.links" :key="link.label">
      <Link
        v-if="link.url"
        :href="link.url"
        class="p-2 px-3 text-blue-600 rounded-md"
        :class="{ 'bg-indigo-500 text-gray-100': link.active }"
        v-html="link.label"
      />
      <div
        v-else
        v-html="link.label"
        class="inline-block p-2 px-3 rounded-md opacity-50 text-blue-600"
      ></div>
    </template>
    <Link
      v-if="props.links[props.links.length - 1].url"
      :href="props.links[props.links.length - 1].url"
      class="p-2 px-3 text-blue-600 rounded-md"
    >
      Next
    </Link>
  </div> -->
  <template v-for="link in props.links">
        <Link v-if="link.url" :href="link.url ? link.url : ''" class="p-2 px-3 text-blue-600 rounded-md"
            :class="{ 'bg-indigo-500 text-gray-100': link.active }" v-html="link.label" />
        <div v-else v-html="link.label" class="inline-block p-2 px-3 rounded-md opacity-50 text-blue-600"></div>
    </template>
</template>