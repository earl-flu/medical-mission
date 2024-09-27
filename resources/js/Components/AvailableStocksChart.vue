<script setup>
import { ref, onMounted, computed, watch } from "vue";
import VueApexCharts from "vue3-apexcharts";

const availableStocksData = ref(null);

const series = computed(() => [
  {
    name: "Stocks",
    data: availableStocksData.value ? availableStocksData.value.data : [],
  },
]);

const chartOptions = computed(() => ({
  chart: {
    type: "bar",
  },
  plotOptions: {
    bar: {
      borderRadius: 10,
      dataLabels: {
        position: "top", // top, center, bottom
      },
    },
  },
  dataLabels: {
    enabled: true,
    formatter: function (val) {
      return val + "%";
    },
    offsetY: -20,
    style: {
      fontSize: "12px",
      colors: ["#304758"],
    },
  },

  xaxis: {
    categories: availableStocksData.value
      ? availableStocksData.value.labels
      : [],
    position: "top",
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
    crosshairs: {
      fill: {
        type: "gradient",
        gradient: {
          colorFrom: "#D8E3F0",
          colorTo: "#BED1E6",
          stops: [0, 100],
          opacityFrom: 0.4,
          opacityTo: 0.5,
        },
      },
    },
    tooltip: {
      enabled: true,
    },
  },
  yaxis: {
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
    labels: {
      show: false,
      formatter: function (val) {
        return val;
      },
    },
  },
  title: {
    text: "Available Stocks",
    floating: true,
    offsetY: 330,
    align: "center",
    style: {
      color: "#444",
    },
  },
}));

// Fetch data from the API
const loadAvailableStockData = async () => {
  try {
    const response = await fetch(route("availableStocks"));
    const data = await response.json();

    availableStocksData.value = {
      labels: data.map((item) => item.name),
      data: data.map((item) => item.quantity),
    };
    console.log(availableStocksData.value.data);
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(loadAvailableStockData);
</script>

<template>
  <div class="chart-container">
    <apexchart
      v-if="availableStocksData"
      type="bar"
      :options="chartOptions"
      :series="series"
    />
  </div>
</template>

<style scoped>
.chart-container {
  height: 100%;
  width: 100%;
}
</style>