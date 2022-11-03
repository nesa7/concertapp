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
    Add Artist for <?php echo $concert_name['concert_name']; ?>
    <br>
    <br>
    <br>

    <form name="mainForm" action="?command=addartist" method="post">   
        <div class="row mb-3 mx-3">
            Artist name:
            <input type="text" class="form-control" name="artist_name" required />            
        </div>  
        <div class="row mb-3 mx-3">
            Artist genres:
            <input type="text" class="form-control" name="genre_1" required />
            <br>
            <input type="text" class="form-control" name="genre_2" required />            
        </div> 
        <input type="submit" value="Add" name="btnAction" class="btn btn-dark" 
           title="Add artist" />
           <input type="hidden" name="this_concert" value="<?php echo $concert_name['concert_id']; ?>" />   
    </form>



</div>



</html>