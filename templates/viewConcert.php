<head>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body style="background-color:#F5F5F5;">
    <?php include 'components/navbar.php'; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less@4"></script>

<div class="container">

    <br>
    <p>Concert: <?php echo $concert_info['concert_name']; ?>
    <p>Venue: <?php echo $concert_info['venue_name']; ?>
    <p>Tour: <?php echo $concert_info['tour_name']; ?>
    <p>Date: <?php echo substr($concert_info['date_time'], 0, 10); ?>
    <br>
    <br>

    
    <p>Artists:
    <?php foreach ($artists as $each_artist): ?>
        <p>&emsp;<?php echo $each_artist[0]; ?>  - 
        <?php foreach ($all_songs[$each_artist[1]] as $songs): ?>
            <?php echo $songs[0]; ?>&nbsp;&nbsp;&nbsp;
        <?php endforeach ?>
        <br>
    <?php endforeach ?>

    <div align="left">
        <br>
        <br>
        <form action="?command=addartist" method="POST">
            <button onclick="window.location.href='?command=addartist'">Add Artist</button>
            <input type="hidden" name="this_concert" value="<?php echo $concert_info['concert_id']; ?>" />
        </form>
    </div>

</div>


</html>