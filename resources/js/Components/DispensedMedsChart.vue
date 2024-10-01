<script setup>
import { ref, onMounted, computed, watch } from "vue";
import VueApexCharts from "vue3-apexcharts";

// Props in script setup
const props = defineProps({
  eventId: {
    type: Number,
    required: true,
  },
});

const chartData = ref(null);

// Add generatePastelColors function
const generatePastelColors = (numColors) => {
  const pastelColors = [];
  for (let i = 0; i < numColors; i++) {
    const hue = (i * 60) % 360; // Using 60 degrees for a different distribution
    const saturation = 50 + Math.random() * 20; // Different saturation range
    const lightness = 70 + Math.random() * 15; // Different lightness range
    pastelColors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
  } 
  return pastelColors;
};

// Computed properties for chart options and series
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
        text: "Quantity Dispensed",
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
      text: "Dispensed Items",
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
    name: "Quantity",
    data: chartData.value ? chartData.value.data : [],
  },
]);

// Fetch data from the API
const fetchData = async () => {
  try {
    const response = await fetch(route("event.dispensedMeds", props.eventId));
    const data = await response.json();
    data.sort((a, b) => Number(b.total_quantity) - Number(a.total_quantity));

    chartData.value = {
      labels: data.map((item) => item.item_name),
      data: data.map((item) => item.total_quantity),
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
