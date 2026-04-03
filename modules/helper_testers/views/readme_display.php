<!DOCTYPE html>
<html lang="en">

<head>
  <base href="<?= BASE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>README - <?= $module_name ?> Tester</title>
  <link rel="stylesheet" href="css/trongate.css">
</head>

<body>
  <div class="container">
    <?= anchor('helper_testers', '&larr; Back to Helper Testers Overview', ['class' => 'button alt mb-1']); ?>

    <div class="card">
      <div class="card-heading">
        README - <?= $module_name ?> Tester
      </div>
      <div class="card-body">
        <?= $content ?>
      </div>
    </div>

    <?= anchor('helper_testers', '&larr; Back to Helper Testers Overview', ['class' => 'button alt mt-1']); ?>

  </div>
</body>

</html>