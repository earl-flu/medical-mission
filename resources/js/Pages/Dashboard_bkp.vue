<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import Datalabels from 'chartjs-plugin-datalabels';
import { Bar, Pie } from 'vue-chartjs';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { Chart as ChartJS, Title, Tooltip, ArcElement, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import { onMounted } from 'vue';

ChartJS.register(Title, Tooltip, ArcElement, Legend, BarElement, CategoryScale, LinearScale);
ChartJS.register(ChartDataLabels);

ChartJS.defaults.set('plugins.datalabels', {
    color: '#fff'
});

const props = defineProps({
    genderCounts: {
        type: Array,
        required: true
    },
    totalPatients: {
        type: [String, Number],
        required: true
    },
    disposedItems: {
        type: Array,
        required: true
    },
    totalDiagnoses: {
        type: Array,
        required: true
    },
    totals: {
        type: Object
    },
    dateFilter: {
        type: String,
    },
    stocks: {
        type: Array,
    },
})

const form = useForm({
    dateFilter: props.dateFilter
})

const submit = () => {
    form.get(route('dashboard', {
        dateFilter
    }), {
        preserveScroll: true,
    });
};

const genderChartData = ref(transformGenderDataForChart(props.genderCounts))
const disposedMedsChartData = ref(transformDisposedDataForChart(props.disposedItems))
const diagnosesChartData = ref(transformDiagnosesDataForChart(props.totalDiagnoses))
const stocksChartData = ref(transformStocksDataForChart(props.stocks));


function chartOptions(titleText) {
    return {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: titleText,
            },
            datalabels: {
                color: '#cdcdcd', 
               // color: '#e8e8e8', // You can customize the color of the labels
                formatter: (value) => value.toLocaleString('en-US'),
            },
        },
    }
}

function transformGenderDataForChart(data) {
    // Define labels for the chart
    const chartLabels = ['Male', 'Female'];

    // Create a dataset array with placeholders for male and female counts
    const chartDataset = data.reduce((genderCounts, personData) => {
        // Map male counts to index 0 and female counts to index 1
        const genderIndex = personData.sex === 1 ? 0 : 1;
        genderCounts[genderIndex] = personData.total;
        return genderCounts;
    }, [0, 0]); // Initialize with placeholder values

    // Return the formatted data for Chart.js
    return {
        labels: chartLabels,
        datasets: [{ data: chartDataset, backgroundColor: ['#1B065E', '#f25cc0'] }],
    };
}

function generateColors(length) {
    const baseColors = ['#2196F3', '#F44336', '#FFC107', '#4CAF50', '#9C27B0']; // Base color palette
    const moreColors = length > baseColors.length ? generateColors(length - baseColors.length) : []; // Generate more colors if needed
    return baseColors.concat(moreColors);
};

function generateUniqueColor(index) {
    const baseHue = 300;
    const hueStep = 50;
    const hue = (baseHue + (index * hueStep)) % 360;
    return `hsl(${hue}, 70%, 50%)`;
}

function transformDisposedDataForChart(data) {
    const sortedData = data.sort((a, b) => a.name.localeCompare(b.name));
    return {
        labels: data.map((item) => item.name), // Dynamically create labels from item names
        datasets: [
            {
                label: 'Disposed Quantity',
                data: sortedData.map((item) => parseInt(item.total_quantity)), // Dynamically extract quantities
                backgroundColor: generateColors(sortedData.length),// Dynamically generate colors
                borderColor: generateColors(sortedData.length), // Use the same colors for borders
                borderWidth: 1,
            },
        ],
    }
}

function transformDiagnosesDataForChart(data) {
    const sortedData = data.sort((a, b) => a.diagnosisName.localeCompare(b.diagnosisName));
    return {
        labels: data.map((item) => item.diagnosisName), // Dynamically create labels from item names
        datasets: [
            {
                label: 'Diagnosis Total',
                data: sortedData.map((item) => parseInt(item.total)), // Dynamically extract quantities
                backgroundColor: generateColors(sortedData.length),// Dynamically generate colors
                borderColor: generateColors(sortedData.length), // Use the same colors for borders
                borderWidth: 1,
            },
        ],
    }
}

function transformStocksDataForChart(data) {
    // const sortedData = data.sort((a, b) => a.name.localeCompare(b.name));
    const sortedData = data.sort((a, b) => b.quantity - a.quantity);

    // Generate a unique color for each item using a color generator function
    const colors = sortedData.map((_, index) => generateUniqueColor(index));

    return {
        labels: data.map((item) => item.name), // Dynamically create labels from item names
        datasets: [
            {
                label: 'Current Stock',
                data: sortedData.map((item) => parseInt(item.quantity)), // Dynamically extract quantities
                backgroundColor: colors,// Dynamically generate colors
                borderColor: colors, // Use the same colors for borders
                borderWidth: 1,
            },
        ],
    }
}


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="w-full mx-auto sm:px-6 lg:px-8 mb-10">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <Bar class="mt-10" :options="chartOptions('Inventory')" :data="stocksChartData" />
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            <form @submit.prevent="submit()">
                                <div class="relative z-0 w-full mb-20 group flex gap-5">
                                    <TextInput name="dateFilter" id="dateFilter" type="date" class="mt-1 block w-54"
                                        placeholder=" " v-model="form.dateFilter" required autocomplete="dateFilter" />
                                    <button type="submit" :class="{ 'opacity-25 cursor-not-allowed': form.processing }"
                                        :disabled="form.processing"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                                     focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto uppercase text-xs
                                     px-4 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Filter</button>
                                </div>
                            </form>
                        </div>
                        <div class="flex justify-around">
                            <div class="min-h-24 min-w-48 shadow-md border border-indigo-50 rounded-lg p-5">
                                <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">Total Patient</p>
                                <p class="text-5xl mt-2">{{ totalPatients }}</p>
                            </div>
                            <div class="min-h-24 min-w-48 shadow-md border border-indigo-50 rounded-lg p-5">
                                <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">Pedia</p>
                                <p class="text-5xl mt-2">{{ totals.totalPedia }}</p>
                            </div>
                            <div class="min-h-24 min-w-48 shadow-md border border-indigo-50 rounded-lg p-5">
                                <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">Senior Citizen</p>
                                <p class="text-5xl mt-2">{{ totals.totalSenior }}</p>
                            </div>
                            <div class="min-h-24 min-w-48 shadow-md border border-indigo-50 rounded-lg p-5">
                                <p class="uppercase text-xs text-gray-600 font-bold text-gray-500">Pregnant</p>
                                <p class="text-5xl mt-2">{{ totals.totalPregnant }}</p>
                            </div>
                        </div>
                        <div class="flex gap-10 mt-20">
                            <div class="flex-1 shadow p-4 flex items-center justify-center flex-col gap-4"
                                style="height:400px;">

                                <Pie :options="chartOptions('Gender')" :data="genderChartData" />
                            </div>
                            <div class="flex-1 shadow p-4 flex items-center justify-center flex-col gap-4"
                                style="height:400px;">
                                <!-- <Bar :options="chartOptions('Diagnoses')" :data="diagnosesChartData" /> -->
                            </div>
                        </div>

                        <div class="shadow-md p-4 mt-10">
                            <Bar :options="chartOptions('Disposed Items')" :data="disposedMedsChartData" />
                        </div>
                        <Bar :options="chartOptions('Diagnoses')" :data="diagnosesChartData" class="mt-10" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
