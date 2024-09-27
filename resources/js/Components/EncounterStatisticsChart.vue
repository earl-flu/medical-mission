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
    height: 350,
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
  yaxis: {
    title: {
      text: "Number of Patients",
    },
  },
  fill: {
    opacity: 1,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + " patients";
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
    const response = await fetch(route("event.statistics", props.eventId));
    const data = await response.json();

    chartData.value = {
      labels: [
        "Total Patients",
        "Pediatric Patients",
        "Senior Citizens",
        "Total Pregnant",
      ],
      data: [
        data.total_patients,
        data.total_pedia,
        data.total_senior_citizen,
        data.total_pregnant,
      ],
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
      height="350"
      type="bar"
      :options="chartOptions"
      :series="series"
    />
  </div>
</template>
