<!DOCTYPE html>
<html>
    <?php include 'header.php';?>
    <body>
        <h1>Kujang</h1>
        <div>a microframework for PHP</div>
        <?php if (isset($name)) : ?>
            <h2>Hello <?= htmlspecialchars($name); ?>!</h2>
        <?php else: ?>
            <p>Try <a href="#">Kujang Framework</a></p>
        <?php endif; ?>
    </body>
</html>
