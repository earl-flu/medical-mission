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

// Function to generate pastel colors
const generatePastelColors = (numColors) => {
  const pastelColors = [];
  for (let i = 0; i < numColors; i++) {
    const hue = (i * 137.5) % 360; // Using the golden angle for better distribution
    const saturation = 55 + Math.random() * 15; // Randomize saturation
    const lightness = 65 + Math.random() * 15; // Randomize lightness
    pastelColors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
  }
  return pastelColors;
};

const series = computed(() => [{
  name: "Total Patients",
  data: chartData.value?.data || [],
}]);

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
      fontFamily: 'Poppins, sans-serif',
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
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
    xaxis: {
      categories: chartData.value?.labels || [],
      labels: {
        style: {
          colors: '#718096',
          fontSize: '12px',
        },
      },
    },
    yaxis: {
      title: {
        text: 'Number of Patients',
        style: {
          color: '#4A5568',
          fontSize: '14px',
          fontWeight: 600,
        },
      },
      labels: {
        style: {
          colors: '#718096',
          fontSize: '12px',
        },
      },
    },
    title: {
      text: "Services",
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
        formatter: (val) => `${val} Patients`,
      },
    },
    colors: pastelColors,
    grid: {
      borderColor: '#E2E8F0',
    },
    legend: {
      show: false,
    },
  };
});

const fetchData = async () => {
  try {
    const response = await fetch(route("event.encounterServiceData", props.eventId));
    const data = await response.json();
    data.sort((a, b) => Number(b.total) - Number(a.total));

    chartData.value = {
      labels: data.map((item) => item.name),
      data: data.map((item) => item.total),
    };
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

onMounted(fetchData);

watch(() => props.eventId, fetchData);
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
  /* background-color: #FFFFFF;
  border-radius: 12px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  padding: 20px; */
}

.loading-text {
  text-align: center;
  color: #718096;
  font-size: 16px;
  padding: 20px;
}
</style>