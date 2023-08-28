<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to Admin Dashboard</h1>
    <a href="<?php echo $baseUrl ;?>views/admin/crawl">Start Crawling</a>
    <h2>Website Links:</h2>
    <ul>
        <?php foreach ($allLinks as $link) : ?>
            <li><?= $link['url']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>