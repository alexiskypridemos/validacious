<!DOCTYPE html>
<html lang="en">

<head>
  <base href="<?= BASE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flashdata Helper Tester - Test Results</title>
  <link rel="stylesheet" href="css/trongate.css">
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="card-heading">
        Flashdata Helper Unit Tests
      </div>
      <div class="card-body">
        <p>Testing flashdata_helper functions to ensure they correctly set and retrieve flash messages.</p>

        <?php foreach ($test_results as $test_name => $result): ?>
          <div class="card" style="margin: 10px 0;">
            <div class="card-body">
              <strong><?= out($test_name) ?>:</strong>
              <span style="<?= $result ? 'color: #155724;' : 'color: #721c24;' ?>">
                <?= $result ? '✓ PASS' : '✗ FAIL' ?>
              </span>
            </div>
          </div>
        <?php endforeach; ?>

        <div class="card" style="margin-top: 20px;">
          <div class="card-body">
            <strong>Summary:</strong>
            <?php
            $total_tests = count($test_results);
            $passed_tests = count(array_filter($test_results));
            echo "$passed_tests / $total_tests tests passed.";
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>