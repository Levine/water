<?php
/**
 * User: Ivan C. Sanches
 * Date: 10/09/13
 * Time: 13:48
 */

$this->extend(__DIR__ . '/layout.php');
?>
    <h1>Test View</h1>
<?php $this->startBlock('javascript'); ?>
    <script type="text/javascript">
        alert('Opa!!');
    </script>
<?php $this->endBlock(); ?>