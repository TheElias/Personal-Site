<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
    <?= htmlspecialchars($pageTitle) ?>
</title>

<link rel="stylesheet" href="<?= CSS_PATH ?>/variables.css">
<link rel="stylesheet" href="<?= CSS_PATH ?>/reset.css">
<link rel="stylesheet" href="<?= CSS_PATH ?>/global.css">
<link rel="stylesheet" href="<?= CSS_PATH ?>/forms.css">
<link rel="stylesheet" href="<?= CSS_PATH ?>/site.css">

<?php foreach ($pageStyles as $style): ?>

    <link rel="stylesheet"
          href="<?= htmlspecialchars($style) ?>">

<?php endforeach; ?>