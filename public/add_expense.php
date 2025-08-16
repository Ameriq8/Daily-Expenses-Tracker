<?php
$categories = [
  "Food",
  "Transport",
  "Utilities",
  "Entertainment",
  "Health",
  "Other"
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $date = $_POST['date'] ?? '';
  $category = $_POST['category'] ?? '';
  $amount = $_POST['amount'] ?? '';
  $notes = $_POST['notes'] ?? '';

  // Save to CSV
  $line = "$date,$category,$amount," . str_replace(",", ";", $notes) . "\n";
  file_put_contents(__DIR__ . "/../expenses.csv", $line, FILE_APPEND);

  // Redirect after submission
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Expense</title>
  <link href="assets/css/output.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100">
  <main class="flex items-center justify-center min-h-screen max-w-6xl mx-auto px-6">
    <form method="POST" class="w-full max-w-md bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700">

      <h1 class="text-2xl font-bold mb-6 text-white text-center">Add New Expense</h1>

      <!-- Date -->
      <div class="mb-5">
        <label for="date" class="block mb-2 text-sm font-medium text-gray-300">Date</label>
        <input type="datetime-local" id="date" name="date"
          class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          required />
      </div>

      <!-- Category -->
      <div class="mb-5">
        <label for="category" class="block mb-2 text-sm font-medium text-gray-300">Category</label>
        <select id="category" name="category"
          class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          required>
          <option value="" disabled selected>Select a category</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= htmlspecialchars($category) ?>"><?= htmlspecialchars($category) ?></option>
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
            placeholder="0.00" required />
        </div>
      </div>

      <!-- Notes -->
      <div class="mb-5">
        <label for="notes" class="block mb-2 text-sm font-medium text-gray-300">Notes</label>
        <textarea id="notes" name="notes"
          class="bg-gray-700 border border-gray-600 text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          placeholder="Optional notes about the expense"></textarea>
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Add Expense
      </button>
    </form>
  </main>
</body>

</html>