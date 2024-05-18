 document.addEventListener("DOMContentLoaded", () => {
      // Initialize empty arrays for all months
      const highestData = Array(12).fill(0);
      const lowestData = Array(12).fill(0);

      // Create the Chart instance
      const barChart = new Chart(document.querySelector('#barChart'), {
        type: 'bar',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          datasets: [
            {
              label: 'Highest',
              data: highestData, // Use the highestData array
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgb(54, 162, 235)',
              borderWidth: 1
            },
            {
              label: 'Lowest',
              data: lowestData, // Use the lowestData array
              backgroundColor: 'rgba(255, 159, 64, 0.2)',
              borderColor: 'rgb(255, 159, 64)',
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // Function to fetch highest and lowest quantities from backend and update chart
      function fetchDataAndUpdateChart() {
        $.ajax({
          url: 'charts/barchart.php', // The path to your PHP script
          method: 'GET',
          dataType: 'json', // Ensure we expect JSON
          success: function (response) {
            if (response.success) {
              const data = response.data;

              for (let i = 0; i < 12; i++) {
                const monthIndex = i + 1;
                if (data[monthIndex]) {
                  highestData[i] = data[monthIndex].max_quantity;
                  lowestData[i] = data[monthIndex].min_quantity;
                } else {
                  highestData[i] = 0;
                  lowestData[i] = 0;
                }
              }

              barChart.update(); // Update the chart with new data
            } else {
              console.error('Error in response:', response.message);


            }
          },
          error: function (error) {
            console.error('Error fetching data:', error);
          }
        });
      }

      // Fetch data and update chart on page load
      fetchDataAndUpdateChart();
    });