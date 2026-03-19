<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Validator Tester</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>image_validator_tester_module/css/style.css">
</head>
<body>
    <div class="container">
        <h1>🖼️ Image Validator Tester</h1>
        
        <?= flashdata('<div class="alert alert-success">', '</div>') ?>
        <?= validation_errors() ?>

        <div class="card">
            <h2>Select Test Type</h2>
            
            <?= form_open_upload('image_validator_tester/submit') ?>
                
                <div class="form-group">
                    <label for="test_type">Validation Test:</label>
                    <select name="test_type" id="test_type" class="form-control">
                        <option value="basic">Basic Image Upload (is_image)</option>
                        <option value="allowed_types">Allowed Types (JPG, PNG only)</option>
                        <option value="is_image">Is Image Test</option>
                        <option value="max_dimensions">Max Dimensions (800x600)</option>
                        <option value="min_dimensions">Min Dimensions (300x200)</option>
                        <option value="exact_dimensions">Exact Dimensions (500x500)</option>
                        <option value="square">Square Image Test</option>
                        <option value="security">Security Threat Detection</option>
                        <option value="combined">Combined Strict Rules</option>
                    </select>
                </div>

                <div class="form-group">
                    <?= form_label('Select Image:', ['for' => 'userfile']) ?>
                    <?php
                    $file_attr = [
                        'id' => 'userfile',
                        'accept' => 'image/jpeg,image/png,image/gif,image/webp'
                    ];
                    echo form_file_select('userfile', $file_attr);
                    ?>
                    <small class="text-muted">Max size: 5MB | Formats: JPG, PNG, GIF, WEBP</small>
                </div>

                <div class="test-info" id="test-info">
                    <h3>Current Test Details:</h3>
                    <div id="test-desc">
                        <p><strong>Basic Image Upload:</strong> Validates that file is a valid image.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <?= form_submit('submit', 'Run Test', ['class' => 'btn btn-primary']) ?>
                    <?= anchor('image_validator_tester/cleanup', 'Cleanup Uploads', ['class' => 'btn btn-secondary']) ?>
                </div>

            <?= form_close() ?>
        </div>

        <div class="card">
            <h3>Test Files Preparation</h3>
            <p>Create these test files to verify all validation rules:</p>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Test</th>
                        <th>File to Upload</th>
                        <th>Expected Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>✅ Valid Image</td>
                        <td>real_photo.jpg (800x600)</td>
                        <td>Success</td>
                    </tr>
                    <tr>
                        <td>❌ Fake Image</td>
                        <td>text.txt renamed to fake.jpg</td>
                        <td>"must be a valid image"</td>
                    </tr>
                    <tr>
                        <td>❌ Wrong Type</td>
                        <td>animation.gif</td>
                        <td>"must be JPG or PNG" (allowed_types test)</td>
                    </tr>
                    <tr>
                        <td>❌ Too Large</td>
                        <td>1920x1080 wallpaper.jpg</td>
                        <td>"width cannot exceed 800 pixels"</td>
                    </tr>
                    <tr>
                        <td>❌ Too Small</td>
                        <td>100x100 icon.jpg</td>
                        <td>"width must be at least 300 pixels"</td>
                    </tr>
                    <tr>
                        <td>❌ Not Square</td>
                        <td>800x600 landscape.jpg</td>
                        <td>"must be square"</td>
                    </tr>
                    <tr>
                        <td>⚠️ Malicious</td>
                        <td>image_with_php.jpg (has &lt;?php tag)</td>
                        <td>"security threat detected"</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Update test description when selection changes
    document.getElementById('test_type').addEventListener('change', function() {
        const descriptions = {
            'basic': '<p><strong>Basic Image Upload:</strong> Validates that file is a valid image with is_image rule.</p>',
            'allowed_types': '<p><strong>Allowed Types:</strong> Only JPG and PNG files are allowed. GIF and WEBP should be rejected.</p>',
            'is_image': '<p><strong>Is Image Test:</strong> Tests if file is a real image. Text files renamed to .jpg should fail.</p>',
            'max_dimensions': '<p><strong>Max Dimensions:</strong> Images larger than 800x600 should fail.</p>',
            'min_dimensions': '<p><strong>Min Dimensions:</strong> Images smaller than 300x200 should fail.</p>',
            'exact_dimensions': '<p><strong>Exact Dimensions:</strong> Images must be exactly 500x500 pixels.</p>',
            'square': '<p><strong>Square Image Test:</strong> Images must have equal width and height (1:1 aspect ratio).</p>',
            'security': '<p><strong>Security Threat Detection:</strong> Images containing PHP tags or malicious code should be blocked.</p>',
            'combined': '<p><strong>Combined Strict Rules:</strong> JPG/PNG only, 400-1200px wide, 300-900px tall, max 3MB.</p>'
        };
        document.getElementById('test-desc').innerHTML = descriptions[this.value] || descriptions['basic'];
    });
    </script>
</body>
</html>