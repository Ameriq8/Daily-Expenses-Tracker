<?php
// Example: weekly expenses totals
$dataPoints = [
    ["label" => "Mon", "y" => 45.50],
    ["label" => "Tue", "y" => 30.25],
    ["label" => "Wed", "y" => 55.10],
    ["label" => "Thu", "y" => 20.00],
    ["label" => "Fri", "y" => 75.30],
    ["label" => "Sat", "y" => 60.00],
    ["label" => "Sun", "y" => 40.75]
];
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weekly Expenses Chart</title>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                backgroundColor: "#1f2937", // Tailwind gray-800
                title: {
                    text: "Expenses This Week",
                    fontColor: "#f9fafb", // Tailwind gray-50
                    fontSize: 20
                },
                axisX: {
                    labelFontColor: "#f9fafb",
                    lineColor: "#4b5563",
                    tickColor: "#4b5563",
                    labelFontSize: 14
                },
                axisY: {
                    includeZero: true,
                    labelFontColor: "#f9fafb",
                    lineColor: "#4b5563",
                    tickColor: "#4b5563",
                    gridColor: "#374151",
                    labelFontSize: 14
                },
                toolTip: {
                    contentFormatter: function (e) {
                        return "<span style='color:#f9fafb'>" + e.entries[0].dataPoint.label + ": </span><strong>$" + e.entries[0].dataPoint.y + "</strong>";
                    },
                    backgroundColor: "#111827",
                    borderThickness: 0,
                    fontColor: "#f9fafb",
                },
                data: [{
                    type: "column",
                    name: "Expenses",
                    indexLabel: "{y}",
                    indexLabelFontColor: "#f9fafb",
                    yValueFormatString: "$#0.##",
                    showInLegend: false,
                    color: "#10b981", // green for expenses
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>
<body class="bg-gray-900 text-gray-100 flex items-center justify-center min-h-screen">
    <div id="chartContainer" style="height: 400px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>
