import { Chart } from "chart.js"

const lineChart = () => {
    return {
        chart: null,

        init() {
            this.drawChart(this.$wire)
        },

        drawChart(component) {
            if (this.chart) {
                this.chart.destroy()
            }

            const title = component.get('title');
            const labels = JSON.parse(JSON.stringify(component.get('labels'))) || {};
            const data = JSON.parse(JSON.stringify(component.get('data')));
            const borderColor = component.get('borderColor');
            const backgroundColor = component.get('backgroundColor');

            const chart_config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        borderWidth: 2,
                        borderColor: borderColor,
                        backgroundColor: backgroundColor,
                        tension: 0.3,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHitRadius: 10,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    style: 'normal',      // normal | italic | oblique
                                },
                            }
                        },
                        x: {
                            grid: {
                                color: 'white',
                            },
                        }
                    },
                }
            };

            this.chart = new Chart(this.$refs.container, chart_config);
        }
    }
}

export default lineChart