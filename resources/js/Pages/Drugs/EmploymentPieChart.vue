<template>
  <div class="chart-container">
    <apexchart
      v-if="props.data && props.data.length > 0"
      width="100%"
      height="100%"
      type="pie"
      :options="chartOptions"
      :series="series"
    />
    <p v-else class="loading-text">Loading chart data...</p>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from "vue";

const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
});

const chartData = computed(() => {
  if (!props.data || props.data.length === 0) return [];

  const totalPermanent = props.data.reduce(
    (sum, item) => sum + Number(item.total_permanent),
    0
  );
  const totalJobOrder = props.data.reduce(
    (sum, item) => sum + Number(item.total_job_order),
    0
  );

  return {
    labels: ["Job Order", "Permanent"],
    data: [totalJobOrder, totalPermanent],
  };
});

const series = computed(() => [...chartData.value.data]);

const chartOptions = computed(() => {
  return {
    chart: {
      width: 380,
      type: "pie",
    },
    labels: chartData.value.labels,
    title: {
      text: "Overall Employment",
      align: "center",
      margin: 20,
      offsetY: 0,
      style: {
        fontSize: "16px",
        fontWeight: "bold",
        color: "#2D3748",
      },
    },
    // colors: ["#FF0000", "#008FFB"], // Specific colors for each data
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
  };
});

// const series = computed(() => (chartData.value ? chartData.value.data : []));
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
