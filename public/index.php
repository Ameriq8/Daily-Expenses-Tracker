<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expenses Tracker</title>
    <link href="assets/css/output.css" rel="stylesheet">
</head>

<?php

$todayTotal = 125.50;
$thisWeekTotal = 450.75;
$thisMonthTotal = 1245.20;

$cards = [
    ["label" => "Today's Expenses", "amount" => $todayTotal],
    ["label" => "This Week", "amount" => $thisWeekTotal],
    ["label" => "This Month", "amount" => $thisMonthTotal]
];
?>

<body class="bg-gray-900 text-gray-100">
    <main class="mt-[6.5rem] max-w-6xl mx-auto px-6 space-y-12">
        <div class="grid md:grid-cols-3 gap-6 mt-[6.5rem]">
            <?php foreach ($cards as $card): ?>
                <div
                    class="bg-gray-800 p-6 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow duration-300">
                    <div
                        class="mx-auto bg-green-500 rounded-full w-12 h-12 flex items-center justify-center text-white text-xl font-bold shadow-md">
                        $
                    </div>
                    <h2 class="mt-4 text-3xl font-extrabold text-white">$<?php echo number_format($card['amount'], 2) ?>
                    </h2>
                    <p class="mt-2 text-gray-400"><?php echo $card['label']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Add and history buttons -->
        <div class="flex justify-between mx-auto text-center space-x-4">
            <a href="add_expense.php"
                class="bg-blue-600 text-white p-4 w-full rounded hover:bg-blue-700 transition-colors">Add Expense</a>
            <a href="history.php"
                class="bg-gray-700 text-white p-4 w-full rounded hover:bg-gray-800 transition-colors">View History</a>
        </div>

        <?php include '../src/includes/chart.php' ?>
    </main>
</body>

</html>