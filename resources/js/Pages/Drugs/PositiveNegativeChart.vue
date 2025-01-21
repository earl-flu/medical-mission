<script setup>
import { ref, onMounted, computed, watch } from "vue";
import VueApexCharts from "vue3-apexcharts";

const chartData = ref(null);

// Computed properties for chart options and series
const chartOptions = computed(() => {
  return {
    chart: {
      width: 380,
      type: "pie",
    },
    labels: chartData.value ? chartData.value.labels : [],
    title: {
      text: "Overall Results",
      align: "center",
      margin: 20,
      offsetY: 0,
      style: {
        fontSize: "16px",
        fontWeight: "bold",
        color: "#2D3748",
      },
    },
    colors: ["#FF0000", "#008FFB"], // Specific colors for each data
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

const series = computed(() => (chartData.value ? chartData.value.data : []));

// Fetch data from the API
const fetchData = async () => {
  try {
    const response = await fetch(route("drugs.getTotalPositiveNegative"));
    const data = await response.json();

    chartData.value = {
      labels: ["Positive", "Negative"],
      data: [data.positive ?? 0, data.negative ?? 0],
    };
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(fetchData);
</script>

<template>
  <div class="chart-container">
    <apexchart
      v-if="chartData"
      width="100%"
      height="100%"
      type="pie"
      :options="chartOptions"
      :series="series"
    />
    <p v-else class="loading-text">Loading chart data...</p>
  </div>
</template>

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
