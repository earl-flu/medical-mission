<template>
  <div class="chart-container">
    <apexchart
      v-if="props.data && props.data.length > 0"
      type="bar"
      height="350"
      :options="chartOptions"
      :series="series"
    />
    <div v-else class="loading-text">Loading data...</div>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
});

const series = computed(() => {
  if (!props.data || props.data.length === 0) return [];

  return [
    {
      name: "Total Examined",
      data: props.data
        .slice() // Create a shallow copy to avoid mutating props
        .sort((a, b) => b.total - a.total) // Sort in descending order (highest total first)
        .map((item) => item.total),
    },
  ];
});

const chartOptions = computed(() => ({
  chart: {
    type: "bar",
    toolbar: {
      show: true,
    },
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: "55%",
      borderRadius: 4,
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    show: true,
    width: 2,
    colors: ["transparent"],
  },
  xaxis: {
    categories: props.data
      .slice() // Create a shallow copy to avoid mutating props
      .sort((a, b) => b.total - a.total) // Sort in descending order (highest total first)
      .map((item) => item.office_name),
    title: {
      text: "Offices",
    },
  },
  yaxis: {
    title: {
      text: "Total Examined",
    },
  },
  fill: {
    opacity: 1,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val;
      },
    },
  },
  colors: ["#4F46E5"],
  title: {
    text: "Total Drug Tests Per Office",
    align: "center",
    style: {
      fontSize: "20px",
      fontWeight: "bold",
    },
  },
}));
</script>

<style scoped>
.chart-container {
  height: 100%;
  width: 100%;
}

.loading-text {
  text-align: center;
  color: #718096;
  font-size: 16px;
  padding: 20px;
}
</style>