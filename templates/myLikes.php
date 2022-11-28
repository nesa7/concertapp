<?php
    $username = $_SESSION["username"];
?>

<head>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body style="background-color:#F5F5F5;">
    <?php include 'components/navbar.php'; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less@4"></script>

<br>
<div class="container" style="padding:3px">
<h1 class="d-table-cell"><?= $username ?>'s Likes Page</h1>
<br>

<?php if (empty($result)): ?>
    You don't have any likes.
<?php else: ?>
    <?php foreach ($result as $liked_concert): ?>

        <div class="row" style="background-color: white; border: 1px solid #e5ebf0;" onclick="location.href='?command=viewconcert&id=<?= $liked_concert[1] ?>'">
            <div class="col-5">
                        <h4><?php echo $liked_concert[0]; ?></h4>
            </div>
        </div>

    <?php endforeach ?>
<?php endif ?>

</body>
</html>