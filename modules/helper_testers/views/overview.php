<!DOCTYPE html>
<html lang="en">

<head>
  <base href="<?= BASE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Helper Testers Overview</title>
  <link rel="stylesheet" href="css/trongate.css">
</head>

<body>
  <div class="container">
    <div class="text-center">
      <h1>Helper Testers Overview</h1>
      <p>Comprehensive testing suite for all Trongate helper functions</p>
    </div>

    <?php foreach ($testers as $tester): ?>
      <div class="card">
        <div class="card-heading">
          <?= $tester['name'] ?>
        </div>
        <div class="card-body">
          <p><?= $tester['description'] ?></p>
          <?= anchor($tester['url'], 'Run Tests', ['class' => 'button']); ?>
          <?= anchor($tester['readme'], 'View README', ['class' => 'button alt']); ?>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="card">
      <div class="card-heading">
        Summary
      </div>
      <div class="card-body">
        <p>This testing suite validates all core helper functions across 5 modules,
          ensuring proper functionality and preventing regressions.
        </p>
        <div>
          <strong>Total Test Modules: <?= count($testers); ?></strong>
        </div>
      </div>
    </div>
</body>

</html>