<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/07/13
 * Time: 16:18
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->write('title', 'Title - Test View'); ?></title>
</head>
<body>
<div>
    <?php echo $this->writeContent(); ?>
</div>
<?php echo $this->write('javascript'); ?>
</body>
</html>