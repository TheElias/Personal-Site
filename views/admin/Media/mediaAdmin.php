<!DOCTYPE html>

<?php

?>
    <head>
        <meta charset="UTF-8">
        <title>Elias Broniecki's Personal Site</title>
        <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS_PATH; ?>">
    </head>        
        <!--Header-->
        <?php 
            include MAIN_ADMIN_HEADER_PATH;
        ?>

<html  lang="en">
    <body>
<h1>Media Upload Test</h1>

<div class="box">
    <form method="post" enctype="multipart/form-data">
        <label>
            Choose file:
            <input type="file" name="file" required>
        </label>
        <button type="submit">Upload</button>
    </form>
    <p><small>This saves the file to a test upload folder and inserts a row into <code>media</code>.</small></p>
</div>

<?php if ($error): ?>
    <div class="box error">
        <h2>Error</h2>
        <pre><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></pre>
    </div>
<?php endif; ?>

<?php if ($result): ?>
    <div class="box ok">
        <h2>Inserted Media</h2>
        <pre><?= htmlspecialchars(print_r($result, true), ENT_QUOTES, 'UTF-8') ?></pre>
    </div>
<?php endif; ?>
    </body>
</html>
