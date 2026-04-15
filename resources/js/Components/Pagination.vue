<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  links: {
    type: Array,
    required: true,
  },
});

// Extract only numbered links (ignore prev/next for logic)
const visibleLinks = computed(() => {
  const links = props.links;

  // Find current active index
  const activeIndex = links.findIndex((link) => link.active);

  const range = 2; // how many pages before/after current
  const result = [];

  links.forEach((link, index) => {
    // Always show first & last
    if (
      index === 0 ||
      index === links.length - 1 ||
      (index >= activeIndex - range && index <= activeIndex + range)
    ) {
      result.push(link);
    } else if (
      // Add "..." only once between gaps
      result[result.length - 1]?.label !== "..."
    ) {
      result.push({ label: "...", url: null });
    }
  });

  return result;
});
</script>

<template>
  <div class="flex flex-wrap gap-1">
    <template v-for="(link, index) in visibleLinks" :key="index">
      <Link
        v-if="link.url && link.label !== '...'"
        :href="link.url"
        class="p-2 px-3 text-blue-600 rounded-md"
        :class="{ 'bg-indigo-500 text-gray-100': link.active }"
        v-html="link.label"
        preserve-state
      />

      <div
        v-else
        class="inline-block p-2 px-3 rounded-md opacity-50 text-blue-600"
        v-html="link.label"
      />
    </template>
  </div>
</template>

  <!-- 
  OLD CODE
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
<div class="flex justify-between items-center">
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
  </div> 
  </template>
  <template v-for="link in props.links">
  <Link
    v-if="link.url"
    :href="link.url ? link.url : ''"
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
-->