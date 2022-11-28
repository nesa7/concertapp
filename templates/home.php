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
  <h1 class="text-center">Concert book</h1>
  <br>



  <ul class="blockdesc">
    <!-- list all concerts by name on the home page 

<?php foreach ($list_of_concerts as $concert_info) : ?>
  <td>
    <li class="desc">
        <form action="?command=viewconcert" method="post">
          <input type="submit" value="<?php echo $concert_info['concert_name']; ?>" name="btnViewConcert" class="btn btn-link" 
                title="Click to view this concert" />  
          <input type="hidden" name="concert_to_view" 
                value="<?php echo $concert_info['concert_id']; ?>"
          />            
        </form>
    </li>
  </td>
<?php endforeach; ?>
</ul> -->

    <div class="row justify-content-center">
      <div class="col-6">
        <?php foreach ($list_of_concerts as $concert_info) : ?>

          <div class="row" style="background-color: white; border: 1px solid #e5ebf0;" onclick="location.href='?command=viewconcert&id=<?= $concert_info['concert_id'] ?>'">
            <div class="col-5">
              <h4><?php echo $concert_info['concert_name']; ?></h4>
            </div>
            <div class="col-3">
              <p class="text-center" style="top:50%">
                @ <?php echo substr($concert_info['date_time'], 0, 10); ?>
              </p>
            </div>
            <div class="col-3">
              <form name="like" method="post" action="?command=handlelike">
                <input class="btn btn-primary float-end" type="submit" value="Like" />
                <input type="hidden" name="current_concert" value="<?php echo $concert_info['concert_id']; ?>" />
                <input type="hidden" name="liked" value="<?php echo empty($liked); ?>" />
              </form>
            </div>

          </div>
        <?php endforeach; ?>
      </div>

    </div>

    </html>