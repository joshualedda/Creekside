document.addEventListener("DOMContentLoaded", () => {
      fetchDataAndUpdateProductChart();
    });

    async function fetchDataAndUpdateProductChart() {
      try {
        const selectedYear = document.getElementById('yearProduct').value;
        const selectedMonth = document.getElementById('monthlyProduct').value;

        const startYear = parseInt(selectedYear.split('-')[0]);
        const endYear = startYear + 1;

        const response = await fetch(`charts/productPieChart.php?startYear=${startYear}&endYear=${endYear}&month=${selectedMonth}`);
        const data = await response.json();

        updateProductPieChart(data);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }

    function updateProductPieChart(data) {
      const existingChartProduct = Chart.getChart('pieChartProduct');

      if (existingChartProduct) {
        existingChartProduct.destroy();
      }

      if (!data.data || !Array.isArray(data.data)) {
        console.error('Invalid data format:', data);
        return;
      }

      const colors = [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)',
        'rgba(255, 0, 255, 0.6)',
        'rgba(0, 255, 0, 0.6)',
        'rgba(128, 128, 128, 0.6)',
        'rgba(0, 0, 255, 0.6)',
        'rgba(255, 0, 0, 0.6)',
        'rgba(0, 255, 255, 0.6)',
        'rgba(255, 255, 0, 0.6)',
        'rgba(128, 0, 128, 0.6)',
        'rgba(0, 128, 128, 0.6)'
      ];

      const total = data.data.reduce((sum, item) => sum + item.value, 0);

      new Chart(document.querySelector('#pieChartProduct'), {
        type: 'pie',
        data: {
          labels: data.data.map(item => item.label),
          datasets: [{
            label: 'Products',
            data: data.data.map(item => item.value),
            backgroundColor: colors,
            hoverOffset: 4
          }]
        },
        options: {
          plugins: {
            legend: {
              position: 'right',
              align: 'start'
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const label = context.label || '';
                  const value = context.raw || 0;
                  return `Total: ₱${value}`;
                }
              }
            }
          }
        }
      });
    }
