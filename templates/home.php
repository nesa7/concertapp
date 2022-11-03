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
<h1 class="d-table-cell">Concert book</h1>
<br>



<!-- list all concerts by name on the home page -->
<?php foreach ($list_of_concerts as $concert_info): ?>
  <td>
        <!-- eventually add "action" here to link to specific concert and more information -->
        <form action="?command=viewconcert" method="post">
          <input type="submit" value="<?php echo $concert_info['concert_name']; ?>" name="btnViewConcert" class="btn btn-link" 
                title="Click to view this concert" />  
          <input type="hidden" name="concert_to_view" 
                value="<?php echo $concert_info['concert_id']; ?>"
          />            
        </form>
     </td>
<?php endforeach; ?>

</div>

</html>