<template>
    <BarChart ref="chartRef" :chartData="testData" :options="options" />
</template>

<script>
import { ref, watch } from "vue";
import { BarChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";
import { useI18n } from "vue-i18n";

Chart.register(...registerables);

export default {
    props: ["data"],
    components: {
        BarChart,
    },
    setup(props) {
        const chartRef = ref();
        const { t } = useI18n();

        const options = ref({
            responsive: true,
            plugins: {
                legend: {
                    position: "bottom",
                },
                title: {
                    display: false,
                    text: "Chart.js Doughnut Chart",
                },
            },
        });

        const testData = ref({});

        watch(props, (newVal, oldVal) => {
            testData.value = {
                labels: newVal.data.characterHistory.dates
                    ? newVal.data.characterHistory.dates
                    : [],
                datasets: [
                    {
                        label: t("dashboard.character_generated"),
                        data: newVal.data.characterHistory.characters
                            ? newVal.data.characterHistory.characters
                            : [],
                        backgroundColor: "#20C997",
                    },
                ],
            };
        });

        return {
            chartRef,
            testData,
            options,
        };
    },
};
</script>

<style></style>
