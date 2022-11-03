<!-- html page to display add concert page -->

<head>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body style="background-color:#F5F5F5;">
    <?php include 'components/navbar.php'; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less@4"></script>


<br>
<div class="container">
  <h1>Add a Concert:</h1>  

<form name="mainForm" action="" method="post">   
  <div class="row mb-3 mx-3">
    Concert name:
    <input type="text" class="form-control" name="concert_name" required 
    value="<?php if ($display_error) echo $recent_data['concert_name'] ?>"/>            
  </div>  
  <div class="row mb-3 mx-3">
    Tour name:
    <input type="text" class="form-control" name="tour_name"
    value="<?php if ($display_error) echo $recent_data['tour_name'] ?>"/>            
  </div> 
  <div class="row mb-3 mx-3">


    <label>Venue</label>
    <select name="venue_id">
        <option value="">  </option>
        <?php foreach ($list_of_venues as $a_venue): ?>
            <option value=<?php echo $a_venue['venue_id']; ?>><?php echo $a_venue['venue_name']; ?></option>
        <?php endforeach; ?>
    </select>

    <?php if ($display_error): ?>
      <p style="color:red">Please enter a venue</p>
    <?php endif ?>
           
  </div>   
  <div class="row mb-3 mx-3">
    Date:
    <input type="text" class="form-control" name="date_time" placeholder= "YYYY-MM-DD" required
    value="<?php if ($display_error) echo $recent_data['date_time'] ?>"/>            
  </div>   
  <!-- <div class="row mb-3 mx-3"> -->
  <div>
    <input type="submit" value="Add" name="btnAction" class="btn btn-dark" 
           title="Insert a concert" />                     
  </div>  

</form> 


</html>