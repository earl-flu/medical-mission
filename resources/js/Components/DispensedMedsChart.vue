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

// Computed properties for chart options and series
const chartOptions = computed(() => ({
  chart: {
    type: "bar",
    height: "100%",
    width: "100%",
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: "55%",
      endingShape: "rounded",
    },
  },
  dataLabels: {
    enabled: true,
  },
  stroke: {
    show: true,
    width: 2,
    colors: ["transparent"],
  },
  xaxis: {
    categories: chartData.value ? chartData.value.labels : [],
  },
  title: {
    text: "Dispensed Items", // Title of the chart
    align: "center", // Can be 'left', 'center', or 'right'
    margin: 10, // Margin between the chart and title
    offsetY: 0, // Adjust vertical position of the title
    style: {
      fontSize: "16px",
      fontWeight: "bold",
      color: "#263238", // Color of the title
    },
  },
  fill: {
    type: "gradient",
    gradient: {
      shade: "dark",
      type: "vertical",
      shadeIntensity: 0.5,
      gradientToColors: undefined, // optional, if not defined - uses the shades of same color in series
      inverseColors: true,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 50, 100],
      colorStops: [],
    },
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val;
      },
    },
  },
}));

const series = computed(() => [
  {
    name: "Total",
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
  </div>
</template>

<style scoped>
.chart-container {
  height: 100%;
  width: 100%;
}
</style>
