<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'includes/links.php';
    include 'includes/header.php';
    include 'includes/sidebar.php';
    include ('connection.php');
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
</head>

<body>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Reports</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="bi bi-house-door"></i></a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Generate Reports</h5>

                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-auto"><label for="select" class="col-form-label"><b>Fetch:</b></label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="select" onchange="getReport()">
                                        <option value="" selected disabled>Select category</option>
                                        <option value="Sales reports">Sales reports</option>
                                        <option value="Sales per dish">Sales per dish</option>
                                        <option value="Sales by staff">Sales by staff</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-auto"><label for="filter" class="col-form-label"><b>Filter:</b></label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="filter" onchange="getReport()">
                                        <option value="" selected disabled>Select filter</option>
                                        <option value="Today">Today</option>
                                        <option value="This Month">This Month</option>
                                        <option value="This Year">This Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-auto"><label for="limit" class="col-form-label"><b>Show:</b></label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="limit" onchange="getReport()">
                                        <option value=" " selected>All</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-auto"><button class="btn btn2" onclick="generatePDF()"><i
                                    class="bi bi-printer"></i> Print</button></div>
                    </div>
                    <!-- Table with hoverable rows -->
                    <div id="pdfTable">
                        <h4 id="pageTitle" style="text-align: center; margin-bottom: 15px;"></h4>
                        <table class="table table-hover" id="">
                            <thead id="tableHeader">
                                <!-- Table headers will be dynamically added here -->
                            </thead>
                            <tbody id="resultTable">
                                <tr>
                                    <td colspan="3" align="center" style="padding: 100px;">
                                        <font color="#6c757d" size="5px">--No reports to display--</font>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table with hoverable rows -->

                </div>
            </div>

        </section>
    </main><!-- End #main -->

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/jquery.min.js"></script>
    <script>
        function getReport() {
            var reportType = document.getElementById('select').value;
            var filterType = document.getElementById('filter').value;
            var limit = document.getElementById('limit').value;

            $.ajax({
                type: 'POST',
                url: 'get_reports.php',
                data: {
                    reportType: reportType,
                    filterType: filterType,
                    limit: limit
                },
                success: function (data) {
                    var resultTable = document.getElementById('resultTable');
                    resultTable.innerHTML = ''; // Clear existing content

                    var pageTitle = document.getElementById('pageTitle'); // Get the pageTitle element

                    var jsonData = JSON.parse(data);
                    if (!jsonData.error) {
                        if (reportType === 'Sales by staff') {
                            displaySalesByStaff(jsonData, resultTable);
                            pageTitle.innerHTML = 'Sales by Staff'; // Set the title dynamically
                        } else if (reportType === 'Sales per dish') {
                            displaySalesByDish(jsonData, resultTable);
                            pageTitle.innerHTML = 'Sales per Dish'; // Set the title dynamically
                        } else if (reportType === 'Sales reports') {
                            displaySalesReports(jsonData, resultTable);
                            pageTitle.innerHTML = 'Sales Reports'; // Set the title dynamically
                        }
                    } else {
                        console.error(jsonData.error);
                    }
                },
                error: function (error) {
                    console.error("Error fetching data: ", error);
                }
            });
        }

        function getTitle(reportType, jsonData) {
            var title = '';

            // Determine title based on report type and data availability
            if (reportType === 'Sales by staff') {
                title = jsonData.length > 0 ? 'Sales by Staff' : 'No Sales';
            } else if (reportType === 'Sales per dish') {
                title = jsonData.length > 0 ? 'Sales per Dish' : 'No Sales';
            } else if (reportType === 'Sales reports') {
                title = jsonData.length > 0 ? 'Sales Reports' : 'No Sales';
            }

            return title;
        }

        function setTitle(title) {
            // Set the title on the page
            var pageTitle = document.getElementById('pageTitle');
            pageTitle.innerText = title;
        }

        function displaySalesByStaff(data, resultTable) {
            // Clear existing content
            resultTable.innerHTML = '';

            // Create table headers
            var headerRow = resultTable.insertRow(0);
            var headerCell1 = headerRow.insertCell(0);
            var headerCell2 = headerRow.insertCell(1);
            var headerCell3 = headerRow.insertCell(2);

            headerCell1.innerHTML = "<b>#</b>";
            headerCell2.innerHTML = "<b>Staff Name</b>";
            headerCell3.innerHTML = "<b>Sales (₱)</b>";

            var totalSales = 0;

            // Populate table with data
            for (var i = 0; i < data.length; i++) {
                var row = resultTable.insertRow(i + 1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);

                cell1.innerHTML = i + 1;
                cell2.innerHTML = data[i].name;
                cell3.innerHTML = "₱ " + parseFloat(data[i].sales).toFixed(2); // Include peso sign for sales

                totalSales += parseFloat(data[i].sales);
            }

            // Add row for grand total
            var totalRow = resultTable.insertRow(data.length + 1);
            var totalCell1 = totalRow.insertCell(0);
            var totalCell2 = totalRow.insertCell(1);
            var totalCell3 = totalRow.insertCell(2);

            totalCell1.innerHTML = "<b>Grand Total</b>";
            totalCell2.innerHTML = "";
            totalCell3.innerHTML = "<b>₱ " + totalSales.toFixed(2) + "</b>"; // Assuming 2 decimal places for sales
        }


        function displaySalesByDish(data, resultTable) {
            // Clear existing content
            resultTable.innerHTML = '';

            // Create table headers
            var headerRow = resultTable.insertRow(0);
            var headerCell1 = headerRow.insertCell(0);
            var headerCell2 = headerRow.insertCell(1);
            var headerCell3 = headerRow.insertCell(2);

            headerCell1.innerHTML = "<b>#</b>";
            headerCell2.innerHTML = "<b>Dish Name</b>";
            headerCell3.innerHTML = "<b>Sales (₱)</b>";

            var totalSales = 0;

            // Populate table with data
            for (var i = 0; i < data.length; i++) {
                var row = resultTable.insertRow(i + 1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);

                cell1.innerHTML = i + 1;
                cell2.innerHTML = data[i].name;
                cell3.innerHTML = "₱ " + parseFloat(data[i].sales).toFixed(2); // Include peso sign for sales

                totalSales += parseFloat(data[i].sales);
            }

            // Add row for grand total
            var totalRow = resultTable.insertRow(data.length + 1);
            var totalCell1 = totalRow.insertCell(0);
            var totalCell2 = totalRow.insertCell(1);
            var totalCell3 = totalRow.insertCell(2);

            totalCell1.innerHTML = "<b>Grand Total</b>";
            totalCell2.innerHTML = "";
            totalCell3.innerHTML = "<b>₱ " + totalSales.toFixed(2) + "</b>"; // Assuming 2 decimal places for sales
        }




        function displaySalesReports(data, resultTable) {
            // Clear existing content
            resultTable.innerHTML = '';

            // Create table headers
            var headerRow = resultTable.insertRow(0);
            var headerCell1 = headerRow.insertCell(0);
            var headerCell2 = headerRow.insertCell(1);
            var headerCell3 = headerRow.insertCell(2);
            var headerCell4 = headerRow.insertCell(3);
            var headerCell5 = headerRow.insertCell(4);

            headerCell1.innerHTML = "<b>Date</b>";
            headerCell2.innerHTML = "<b>Dish Name</b>";
            headerCell3.innerHTML = "<b>Price</b>";
            headerCell4.innerHTML = "<b>Quantity</b>";
            headerCell5.innerHTML = "<b>Subtotal</b>";

            var totalQuantity = 0;
            var totalSubtotal = 0;

            // Populate table with data
            for (var i = 0; i < data.length; i++) {
                var row = resultTable.insertRow(i + 1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);

                cell1.innerHTML = data[i].date;
                cell2.innerHTML = data[i].dish_name;
                cell3.innerHTML = "₱ " + parseFloat(data[i].price).toFixed(2); // Include peso sign for price
                cell4.innerHTML = data[i].quantity;
                cell5.innerHTML = "₱ " + parseFloat(data[i].subtotal).toFixed(2);

                totalQuantity += parseInt(data[i].quantity);
                totalSubtotal += parseFloat(data[i].subtotal);
            }

            // Add row for grand total
            var totalRow = resultTable.insertRow(data.length + 1);
            var totalCell1 = totalRow.insertCell(0);
            var totalCell2 = totalRow.insertCell(1);
            var totalCell3 = totalRow.insertCell(2);
            var totalCell4 = totalRow.insertCell(3);
            var totalCell5 = totalRow.insertCell(4);

            totalCell1.innerHTML = "<b>Grand Total</b>";
            totalCell2.innerHTML = ""; // Leave blank for the dish name column
            totalCell3.innerHTML = ""; // Leave blank for the quantity column
            totalCell4.innerHTML = ""; // Leave blank for the price column
            totalCell5.innerHTML = "<b>₱ " + totalSubtotal.toFixed(2) + "</b>"; // Assuming 2 decimal places for subtotal
        }


        function generatePDF() {
            var pdfElement = document.getElementById('pdfTable');
            var pdfOptions = {
                margin: 15,
                filename: 'report.pdf', // Default filename
                image: { type: 'jpeg', quality: 1.00 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak: { mode: 'avoid-all' }, // Avoid page breaks within the table
            };

            var title = document.getElementById('pageTitle');

            // Create a new div for the header in the PDF
            var headerInPDF = document.createElement('div');
            headerInPDF.innerHTML = '<div class="row" style="color: #301011; font-size: 12px;">' +
                '<div class="col"></div>' +
                '<div class="col-auto">' +
                '<img src="assets/img/creekside.png" style="width: 60px; height: 60px;">' +
                '</div>' +
                '<div class="col-auto" style="margin-top: auto; margin-bottom: auto; font-size: 14px;">' +
                '<font style="font-family: Nunito; font-weight: bold; font-size: 30px;">The Creekside Café</font>' +
                '</div>' +
                '<div class="col"></div>' +
                '</div>' +
                '<hr>';

            // Adjust the font size for the title in the PDF
            if (title) {

                pdfOptions.filename = title.innerText + '.pdf'; // Set filename based on the title
                title.style.fontSize = '24px';

                // Clone the main PDF element to avoid affecting the original content
                var clonedPdfElement = pdfElement.cloneNode(true);

                // Append the header to the cloned PDF element
                clonedPdfElement.insertBefore(headerInPDF, clonedPdfElement.firstChild);

                // Adjust the font size for the table headers in the PDF
                var tableHeaders = clonedPdfElement.querySelectorAll('#tableHeader b');
                tableHeaders.forEach(function (header) {
                    header.style.fontSize = '12px';
                });

                // Adjust the font size for the table cells in the PDF
                var tableCells = clonedPdfElement.querySelectorAll('#resultTable td, #resultTable th');
                tableCells.forEach(function (cell) {
                    cell.style.fontSize = '12px';
                });

                // Generate the PDF
                html2pdf(clonedPdfElement, pdfOptions);
            }
        }


    </script>

</body>

</html>