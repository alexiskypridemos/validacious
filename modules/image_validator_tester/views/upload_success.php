<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Results</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>image_validator_tester_module/css/style.css">
</head>
<body>
    <div class="container">
        <h1>📊 Test Results</h1>
        
        <?= flashdata('<div class="alert alert-success">', '</div>') ?>

        <div class="card">
            <h2><?= out($test_name) ?></h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <strong>Error:</strong> <?= out($error) ?>
                </div>
            <?php endif; ?>

            <div class="result-details">
                <h3>Result: <?= isset($file_name) ? '✅ PASSED' : '❌ FAILED' ?></h3>
                
                <?php if (isset($file_name)): ?>
                    <table class="table">
                        <tr>
                            <th>File Name:</th>
                            <td><?= out($file_name) ?></td>
                        </tr>
                        <tr>
                            <th>File Type:</th>
                            <td><?= out($file_type) ?></td>
                        </tr>
                        <tr>
                            <th>File Size:</th>
                            <td><?= round($file_size / 1024, 2) ?> KB</td>
                        </tr>
                        <tr>
                            <th>File Path:</th>
                            <td><code><?= out($file_path) ?></code></td>
                        </tr>
                        <tr>
                            <th>Thumbnail:</th>
                            <td><code><?= out($thumbnail_path) ?></code></td>
                        </tr>
                    </table>

                    <div class="image-previews">
                        <div class="preview">
                            <h4>Uploaded Image:</h4>
                            <img src="<?= BASE_URL ?>image_validator_tester_module/uploads/<?= out($file_name) ?>" 
                                 alt="Uploaded image" class="preview-image">
                        </div>
                        
                        <?php if ($thumbnail_path !== 'Not generated'): ?>
                        <div class="preview">
                            <h4>Thumbnail:</h4>
                            <img src="<?= BASE_URL ?>image_validator_tester_module/uploads/thumbs/<?= out($file_name) ?>" 
                                 alt="Thumbnail" class="preview-image thumb">
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <?= anchor('image_validator_tester', 'Run Another Test', ['class' => 'btn btn-primary']) ?>
                <?= anchor('image_validator_tester/cleanup', 'Cleanup Uploads', ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>

        <div class="card">
            <h3>Test Matrix</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Test File</th>
                        <th>Basic</th>
                        <th>Allowed Types</th>
                        <th>Max Dims</th>
                        <th>Min Dims</th>
                        <th>Exact</th>
                        <th>Square</th>
                        <th>Security</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Valid JPG 800x600</td>
                        <td class="pass">✅</td>
                        <td class="pass">✅</td>
                        <td class="pass">✅</td>
                        <td class="pass">✅</td>
                        <td class="fail">❌</td>
                        <td class="fail">❌</td>
                        <td class="pass">✅</td>
                    </tr>
                    <tr>
                        <td>Text file as .jpg</td>
                        <td class="fail">❌</td>
                        <td class="fail">❌</td>
                        <td class="fail">❌</td>
                        <td class="fail">❌</td>
                        <td class="fail">❌</td>
                        <td class="fail">❌</td>
                        <td class="fail">❌</td>
                    </tr>
                    <tr>
                        <td>Valid GIF</td>
                        <td class="pass">✅</td>
                        <td class="fail">❌</td>
                        <td class="pass">✅</td>
                        <td class="pass">✅</td>
                        <td class="fail">❌</td>
                        <td class="fail">❌</td>
                        <td class="pass">✅</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>