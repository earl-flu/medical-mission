<script setup>
import { ref, onMounted, computed, watch } from "vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps({
  eventId: {
    type: Number,
    required: true,
  },
});

const chartData = ref(null);

const generatePastelColors = (numColors) => {
  const pastelColors = [];
  for (let i = 0; i < numColors; i++) {
    const hue = (i * 137.5) % 360; // Using the golden angle (137.5 degrees) for better distribution
    const saturation = 60 + Math.random() * 10; // Randomize saturation slightly
    const lightness = 75 + Math.random() * 10; // Randomize lightness slightly
    pastelColors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
  } 
  return pastelColors;
};

const chartOptions = computed(() => {
  const dataLength = chartData.value?.data.length || 0;
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
      categories: chartData.value ? chartData.value.labels : [],
      labels: {
        style: {
          colors: "#718096",
          fontSize: "12px",
        },
      },
    },
    yaxis: {
      title: {
        text: "Number of Encounters",
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
      text: "Encounters by Program",
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

const series = computed(() => [
  {
    name: "Encounters",
    data: chartData.value ? chartData.value.data : [],
  },
]);

const fetchData = async () => {
  try {
    const response = await fetch(route("event.encountersByProgram", props.eventId));
    const data = await response.json();
    
    // Convert object to array of [key, value] pairs and sort by value
    const sortedData = Object.entries(data).sort((a, b) => b[1] - a[1]);

    chartData.value = {
      labels: sortedData.map(([programCode]) => programCode),
      data: sortedData.map(([, count]) => count),
    };
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(fetchData);

watch(
  () => props.eventId,
  (newEventId) => {
    fetchData(newEventId);
  }
);
</script>

<template>
  <div class="chart-container">
    <apexchart
      v-if="chartData"
      width="100%"
      height="100%"
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