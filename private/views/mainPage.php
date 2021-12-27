<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="/stylesheets/main-page.css">
    <script src="/js/main-page.js"></script>
</head>
<body>

<?php if (isset($user)) : ?>
<div id="current-user" data-email="<?= $user->email ?>">Welcome back <?php echo $user->name ?></div>
<?php endif; ?>

<div id="users-list">
    <table class="users-table">
        <tr class="users-header">
            <th>Name</th>
            <th>Entrance time</th>
            <th>Last update time</th>
            <th>User IP</th>
        </tr>
    </table>
</div>