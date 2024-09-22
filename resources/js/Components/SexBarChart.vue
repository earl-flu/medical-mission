<script setup>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const props = defineProps({
    chartOptions: {
        type: Object,
        required: true
    },
    chartData: {
        type: Object,
        required: true
    },
})
</script>

<template>
    <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>