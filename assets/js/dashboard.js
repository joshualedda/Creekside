    // Function to hide all cards and tables
    function hideAllElements() {
        document.getElementById('daily').style.display = 'none';
        document.getElementById('weekly').style.display = 'none';
        document.getElementById('monthly').style.display = 'none';
        document.getElementById('yearly').style.display = 'none';
        // Hide tables
        document.getElementById('dailyTable').style.display = 'none';
        document.getElementById('weeklyTable').style.display = 'none';
        document.getElementById('monthlyTable').style.display = 'none';
        document.getElementById('yearlyTable').style.display = 'none';
      }
    
      // Show weekly by default when the page loads
      document.addEventListener('DOMContentLoaded', function() {
        hideAllElements(); // Hide all elements first
        document.getElementById('daily').style.display = 'block'; // Show the daily card by default
        document.getElementById('dailyTable').style.display = 'block'; // Show the daily table by default
    
        // Add event listener for the select change
        document.getElementById('cardSelector').addEventListener('change', function() {
          var selectedCard = this.value;
    
          hideAllElements(); // Hide all elements
    
          // Show the selected card and table
          document.getElementById(selectedCard).style.display = 'block';
          document.getElementById(selectedCard + 'Table').style.display = 'block';
        });
      });