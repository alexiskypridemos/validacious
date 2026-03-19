<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Upload Success</title>
    <style>.container { max-width: 600px; margin: 40px auto; font-family: sans-serif; text-align: center; }</style>
</head>
<body>
<div class="container">
    <h1 style="color: green;">Success!</h1>
    <p><?= flashdata() ?></p>
    <p><strong>Filename:</strong> <?= out($filename) ?></p>
    <p>
        <?= anchor('document_tester', 'Upload Another', ['class' => 'button']) ?>
    </p>
</div>
</body>
</html>