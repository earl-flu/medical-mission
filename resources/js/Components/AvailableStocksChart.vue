<script setup>
import { ref, onMounted, computed, watch } from "vue";
import VueApexCharts from "vue3-apexcharts";

const availableStocksData = ref(null);

// Function to generate pastel colors
const generatePastelColors = (numColors) => {
  const pastelColors = [];
  for (let i = 0; i < numColors; i++) {
    const hue = (i * 360) / numColors;
    pastelColors.push(`hsl(${hue}, 70%, 80%)`);
  }
  return pastelColors;
};

const series = computed(() => [
  {
    name: "Stocks",
    data: availableStocksData.value?.data || [],
  },
]);

const chartOptions = computed(() => {
  const dataLength = availableStocksData.value?.data.length || 0;
  const pastelColors = generatePastelColors(dataLength);

  return {
    chart: {
      type: "bar",
      height: "100%",
      width: "100%",
      toolbar: {
        show: true,
      },
      fontFamily: "Poppins, sans-serif",
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "65%",
        borderRadius: 8,
        distributed: true,
      },
    },
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val;
      },
      offsetY: -20,
      style: {
        fontSize: "12px",
        colors: ["#304758"],
      },
    },
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
    xaxis: {
      categories: availableStocksData.value?.labels || [],
      labels: {
        style: {
          colors: "#718096",
          fontSize: "12px",
        },
      },
    },
    yaxis: {
      title: {
        text: "Stock Quantity",
        style: {
          color: "#4A5568",
          fontSize: "14px",
          fontWeight: 600,
        },
      },
      labels: {
        style: {
          colors: "#718096",
          fontSize: "12px",
        },
      },
    },
    title: {
      text: "Available Stocks",
      align: "center",
      margin: 20,
      offsetY: 0,
      style: {
        fontSize: "16px",
        fontWeight: "bold",
        color: "#2D3748",
      },
    },
    fill: {
      opacity: 1,
    },
    tooltip: {
      y: {
        formatter: (val) => `${val}`,
      },
    },
    colors: pastelColors,
    grid: {
      borderColor: "#E2E8F0",
    },
    legend: {
      show: false,
    },
  };
});

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
      width="100%"
      height="400"
      type="bar"
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