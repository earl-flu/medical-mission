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

const municipalityData = ref(null);

const municipalitySeries = computed(() => [
  {
    name: "Total Patient",
    data: municipalityData.value ? municipalityData.value.data : [],
  },
]);

// Computed properties for chart options and series
const municipalityChartOption = computed(() => ({
  chart: {
    type: "bar",
    height: "100%",
    width: "100%",
    events: {
      dataPointSelection: function (event, chartContext, config) {
        const municipalityName =
          config.w.config.xaxis.categories[config.dataPointIndex];

        loadBarangayData(municipalityName);
      },
    },
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
    categories: municipalityData.value ? municipalityData.value.labels : [],
  },
  title: {
    text: "Municipality", // Title of the chart
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

// Fetch data from the API
const loadMunicipalityData = async () => {
  try {
    const response = await fetch(
      route("event.municipalityData", props.eventId)
    );
    const data = await response.json();
    data.sort(
      (a, b) => Number(b.total_encounters) - Number(a.total_encounters)
    );

    municipalityData.value = {
      labels: data.map((item) => item.city_name),
      data: data.map((item) => item.total_encounters),
    };
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

// const loadBarangayData = async (municipalityName) => {
//   try {
//     const response = await fetch(
//       `/api/barangayData/${props.eventId}/${municipalityName}`
//     );
//     const data = await response.json();
//     barangayChartSeries.value = [
//       {
//         name: "Total Patients",
//         data: data.map((item) => item.total_patients),
//       },
//     ];
//     barangayChartOptions.value.xaxis = {
//       categories: data.map((item) => item.barangay_name),
//     };
//   } catch (error) {
//     console.error("Error loading barangay data:", error);
//   }
// };

onMounted(loadMunicipalityData);

watch(
  () => props.eventId,
  (newEventId) => {
    loadMunicipalityData(newEventId);
  }
);
</script>

<template>
  <div class="chart-container">
    <apexchart
      v-if="municipalityData"
      width="100%"
      height="100%"
      type="bar"
      :options="municipalityChartOption"
      :series="municipalitySeries"
    />
  </div>
</template>

<style scoped>
.chart-container {
  height: 100%;
  width: 100%;
}
</style>
