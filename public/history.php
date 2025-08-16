<?php
// Read expenses from CSV
$expensesFile = __DIR__ . '/../expenses.csv';
$expenses = [];
if (file_exists($expensesFile)) {
    $lines = file($expensesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        list($date, $category, $amount, $notes) = explode(',', $line);
        $expenses[] = [
            'date' => $date,
            'category' => $category,
            'amount' => $amount,
            'notes' => $notes
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense History</title>
    <link href="assets/css/output.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
    <main class="mt-[6.5rem] max-w-6xl mx-auto px-6 space-y-8">
        <h1 class="text-3xl font-bold text-white mb-6">Expense History</h1>

        <div class="relative overflow-x-auto shadow-md rounded-lg">
            <table class="w-full text-sm text-left text-gray-300">
                <thead class="text-xs uppercase bg-gray-800 text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Category</th>
                        <th scope="col" class="px-6 py-3">Amount</th>
                        <th scope="col" class="px-6 py-3">Notes</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($expenses)) : ?>
                        <?php foreach ($expenses as $index => $expense) : ?>
                            <tr class="bg-gray-800 hover:bg-gray-700 border-b border-gray-700">
                                <td class="px-6 py-4"><?php echo $index+1; ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars((new DateTime($expense['date']))->format('D, d M Y H:i:s')); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($expense['category']); ?></td>
                                <td class="px-6 py-4">$<?php echo htmlspecialchars($expense['amount']); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($expense['notes']); ?></td>
                                <td class="px-6 py-4">
                                    <a href="edit_expense.php?id=<?php echo $index; ?>"
                                        class="text-blue-500 hover:underline mr-3">Edit</a>
                                    <a href="delete_expense.php?id=<?php echo $index; ?>"
                                        class="text-red-500 hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this expense?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr class="bg-gray-800 border-b border-gray-700">
                            <td class="px-6 py-4 text-center text-gray-400" colspan="5">No expenses found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
