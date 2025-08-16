<?php
$categories = [
  "Food",
  "Transport",
  "Utilities",
  "Entertainment",
  "Health",
  "Other"
];

$expensesFile = __DIR__ . '/../expenses.csv';
$expenses = [];

// Load all expenses
if (file_exists($expensesFile)) {
    $lines = file($expensesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        list($date, $category, $amount, $notes) = explode(',', $line);
        $expenses[] = [
            'date' => $date,
            'category' => $category,
            'amount' => $amount,
            'notes' => str_replace(";", ",", $notes) // convert back semicolons to commas
        ];
    }
}

// Get expense ID from URL
$id = $_GET['id'] ?? null;
if ($id === null || !isset($expenses[$id])) {
    die("Invalid expense ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'] ?? '';
    $category = $_POST['category'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $notes = $_POST['notes'] ?? '';

    // Update the selected expense
    $expenses[$id] = [
        'date' => $date,
        'category' => $category,
        'amount' => $amount,
        'notes' => $notes
    ];

    // Save all expenses back to CSV
    $lines = [];
    foreach ($expenses as $expense) {
        $lines[] = "{$expense['date']},{$expense['category']},{$expense['amount']}," . str_replace(",", ";", $expense['notes']);
    }
    file_put_contents($expensesFile, implode("\n", $lines) . "\n");

    // Redirect after update
    header("Location: index.php");
    exit;
}

// Current expense to edit
$current = $expenses[$id];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Expense</title>
  <link href="assets/css/output.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
  <main class="flex items-center justify-center min-h-screen max-w-6xl mx-auto px-6">
    <form method="POST" class="w-full max-w-md bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700">

      <h1 class="text-2xl font-bold mb-6 text-white text-center">Edit Expense</h1>

      <!-- Date -->
      <div class="mb-5">
        <label for="date" class="block mb-2 text-sm font-medium text-gray-300">Date</label>
        <input type="datetime-local" id="date" name="date"
          class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          value="<?= htmlspecialchars($current['date']) ?>" required />
      </div>

      <!-- Category -->
      <div class="mb-5">
        <label for="category" class="block mb-2 text-sm font-medium text-gray-300">Category</label>
        <select id="category" name="category"
          class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          required>
          <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category) ?>" <?= $category === $current['category'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($category) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Amount -->
      <div class="mb-5">
        <label for="amount" class="block mb-2 text-sm font-medium text-gray-300">Amount</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">$</span>
          <input type="number" step="0.01" id="amount" name="amount"
            class="pl-7 bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            value="<?= htmlspecialchars($current['amount']) ?>" required />
        </div>
      </div>

      <!-- Notes -->
      <div class="mb-5">
        <label for="notes" class="block mb-2 text-sm font-medium text-gray-300">Notes</label>
        <textarea id="notes" name="notes"
          class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          placeholder="Optional notes about the expense"><?= htmlspecialchars($current['notes']) ?></textarea>
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Update Expense
      </button>
    </form>
  </main>
</body>

</html>
