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
<h2><?php echo $concert_info['concert_name']; ?></h2>


    <style>
        .alpha td {
            border-collapse: separate;
            
            padding-right: 50px;
            padding-bottom: 30px;
            }
    </style>

<table class="alpha w3-table w3-bordered w3-card-4 center" style="width:70%">
    <br>
    <tr>
        <td>Venue </td>
        <td><?php echo $concert_info['venue_name']; ?></td>
    </tr>
    <tr>
        <td>Tour </td>
        <td><?php echo $concert_info['tour_name']; ?></td>
    </tr>
    <tr>
        <td>Date </td>
        <td><?php echo substr($concert_info['date_time'], 0, 10); ?></td>
    </tr>
    <tr>
        <td style="vertical-align:top">Artists </td>
        <td>

        <table class="beta w3-table w3-bordered w3-card-4" align="left" style="width:70%">
            <tr>
            <td>
                <?php foreach ($artists as $each_artist): ?>
                <li><?php echo $each_artist[0]; ?>  - 
                <?php foreach ($all_songs[$each_artist[1]] as $songs): ?>
                    <?php echo $songs[0]; ?>&nbsp;&nbsp;&nbsp;
                <?php endforeach ?>
                <br>
                <?php endforeach ?>
            </td>
            </tr>
            </table>
        </td>
    </tr>
    <br>
    <br>
</table>


    <div align="left">

        <form action="?command=addartist" method="POST">
            <button onclick="window.location.href='?command=addartist'" class="btn btn-dark">Add Artist</button>
            <input type="hidden" name="this_concert" value="<?php echo $concert_info['concert_id']; ?>" />
        </form>
    </div>

    <div>
        <form action="?command=deleteconcert" method="POST">
            <button onclick="window.location.href='?command=deleteconcert'" class="btn btn-danger">Delete Concert</button>
            <input type="hidden" name="concert_to_delete" value="<?php echo $concert_info['concert_id']; ?>" />
        </form>
    </div>

</div>


</html>