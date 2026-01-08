import { Chart } from "chart.js"

const pieChart = () => {
    return {
        chart: null,

        init() {
            this.drawChart(this.$wire)
        },

        drawChart(component) {
            if (this.chart) {
                this.chart.destroy()
            }

            const type = component.get('type');
            const data = JSON.parse(JSON.stringify(component.get('data')));
            const backgroundColors = component.get('backgroundColors');

            const chart_config = {
                type: type,
                data: {
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors,
                        hoverOffset: 4
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            enabled: false
                        }
                    }
                }
            };

            this.chart = new Chart(this.$refs.container, chart_config);
        }
    }
}

export default pieChart