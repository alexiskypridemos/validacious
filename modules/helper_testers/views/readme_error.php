<!DOCTYPE html>
<html lang="en">

<head>
  <base href="<?= BASE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>README Error</title>
  <link rel="stylesheet" href="css/trongate.css">
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="card-body" style="color: #dc3545;">
        <strong>Error:</strong> <?= out($error) ?>
      </div>
    </div>

    <?= anchor('helper_testers', '&larr; Back to Helper Testers Overview', ['class' => 'button']); ?>
  </div>
</body>

</html>