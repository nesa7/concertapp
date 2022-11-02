<?php
$helper = new helper();
$messages = $helper->getMessages();
if ($messages !== "") {
    foreach ($messages as $message) {
?>
        <script>
            console.log("Message: ");
            console.log(<?= json_decode($message) ?>);
        </script>
        <div class="alert alert-primary" role="alert">
            <?php echo json_decode($message) ?>
        </div>
<?php }
} ?>