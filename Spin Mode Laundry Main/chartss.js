
const barChartOptions = {
    series: [{
        data: []
    }],
    chart: {
        type: 'bar',
        height: 200,
        foreColor: '#6b7280'
    },
    plotOptions: {
        bar: {
            borderRadius: 4,
            borderRadiusApplication: 'end',
            horizontal: true
        }
    },
    dataLabels: {
        enabled: false
    },
    xaxis: {
        categories: []
    },
    subtitle: {   
        text: '',
        align: 'left',
        offsetY: -5 
    }
};

const barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartOptions);
barChart.render();

function loadChartData(year) {
    fetch('monthlyOrders.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'year=' + year
    })
    .then(response => response.json())
    .then(data => {
        console.log('Received data:', data); 
        barChart.updateOptions({
            series: [{ data: data.series }],
            xaxis: { categories: data.categories },
            subtitle: { 
                text: `Year: ${year}`,
                offsetY: -5
            }
        });
    })
    .catch(error => console.error('Fetch error:', error));
}



document.addEventListener('DOMContentLoaded', () => {
    const currentYear = new Date().getFullYear();
    loadChartData(currentYear);
});

document.getElementById('filterDate').addEventListener('change', function () {
    const year = new Date(this.value).getFullYear();
    loadChartData(year);
});

document.addEventListener("DOMContentLoaded", function () {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const areaChartOptions = {
        series: [{
            name: "Monthly Sales (₱)",
            data: []
        }],
        chart: {
            type: 'area',
            height: 200,
            width: 450,
            foreColor: '#6b7280',
            zoom: { enabled: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        subtitle: { text: '', align: 'left' },
        xaxis: { categories: months },
        yaxis: {
            title: { text: 'Sales (₱)' }
        },
        legend: { horizontalAlign: 'left' }
    };

    const areaChart = new ApexCharts(document.querySelector("#area-chart"), areaChartOptions);
    areaChart.render();

    function updateChartByYear(year) {
        fetch('monthlySales.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `year=${encodeURIComponent(year)}`
        })
        .then(response => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data)) {
                areaChart.updateSeries([{
                    name: "Monthly Sales (₱)",
                    data: data
                }]);
                areaChart.updateOptions({
                    subtitle: {
                        text: `Year: ${year}`,
                        offsetY: -5 
                    }
                });
            } else {
                console.error("Invalid data format:", data);
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
    }

    const dateInput = document.getElementById("filterDate");
    const today = new Date().toISOString().split('T')[0];
    dateInput.value = today;

    const initialYear = new Date(today).getFullYear();
    updateChartByYear(initialYear);

    dateInput.addEventListener("change", function () {
        const selectedDate = new Date(this.value);
        if (!isNaN(selectedDate)) {
            const selectedYear = selectedDate.getFullYear();
            updateChartByYear(selectedYear);
        }
    });
});