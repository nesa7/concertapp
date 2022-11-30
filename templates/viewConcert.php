<head>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body style="background-color:#F5F5F5;">
    <?php include 'components/navbar.php'; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less@4"></script>
    <script src="https://kit.fontawesome.com/a146c2d6ac.js" crossorigin="anonymous"></script>

<div class="container">
<br>
<h2><?php echo $concert_info['concert_name']; ?></h2>

<style>
.button-like {
  border: 2px solid #8a8a8a;
  background-color: transparent;
  text-decoration: none;
  padding: 1rem;
  position: relative;
  vertical-align: middle;
  text-align: center;
  display: inline-block;
  border-radius: 3rem;
  color: #8a8a8a;
  transition: all ease 0.4s;
}

.button-like span {
  margin-left: 0.5rem;
}

.button-like .fa,
.button-like span {
  transition: all ease 0.4s;
}

.button-like:focus {
  background-color: transparent;
}

.button-like:focus .fa,
.button-like:focus span {
  color: #8a8a8a;
}

.button-like:hover {
  border-color: #cc4b37;
  background-color: transparent;
}

.button-like:hover .fa,
.button-like:hover span {
  color: #cc4b37;
}

.liked {
  background-color: #cc4b37;
  border-color: #cc4b37;
}

.liked .fa,
.liked span {
  color: #fefefe;
}

.liked:focus {
  background-color: #cc4b37;
}

.liked:focus .fa,
.liked:focus span {
  color: #fefefe;
}

.liked:hover {
  background-color: #cc4b37;
  border-color: #cc4b37;
}

.liked:hover .fa,
.liked:hover span {
  color: #fefefe;
}

</style>

<!-- like button source: https://get.foundation/building-blocks/blocks/button-like.html -->
<form action="?command=handlelike" method="POST">
    <button id="heartButton" onclick="window.location.href='?command=handlelike'" class="button button-like">
        <i class="fa fa-heart"></i>
        <span>Like</span>
    </button>
    <input type="hidden" name="current_concert" value="<?php echo $concert_info['concert_id']; ?>" />
    <input type="hidden" name="liked" value="<?php echo empty($liked); ?>" />
</form>

<script>
    var heart = document.getElementById("heartButton");
    <?php if (!empty($liked)): ?>
        heart.classList.add("liked");
    <?php endif ?>
</script>


    <style>
        .alpha td {
            border-collapse: separate;

            padding-right: 50px;
            padding-bottom: 30px;
            table-layout: fixed;
            }
        /* Style the button that is used to open and close the collapsible content */
        .collapsible {
            background-color: #cccccc;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            }

        /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
        .active, .collapsible:hover {
            background-color: #ccc;
            }

        /* Style the collapsible content. Note: hidden by default */
        .content {
            padding: 0 18px;
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
            }

        .collapsible:after {
            content: '\002B'; /* Unicode character for "plus" sign (+) */
            font-size: 13px;
            color: black;
            float: right;
            margin-left: 5px;
            }

        .active:after {
            content: "\FF0D"; /* Unicode character for "minus" sign (-) */
            color: black;
            }

            {box-sizing: border-box;}

            /* Button used to open the contact form - fixed at the bottom of the page */
            .open-button {
            background-color: #555;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            opacity: 0.8;
            position: fixed;
            bottom: 23px;
            right: 28px;
            width: 280px;
            }

            /* The popup form - hidden by default */
            .form-popup {
            display: none;
            position: fixed;
            bottom: 0;
            right: 15px;
            border: 3px solid #f1f1f1;
            z-index: 9;
            }

            /* Add styles to the form container */
            .form-container {
            max-width: 300px;
            padding: 10px;
            background-color: white;
            }

            /* Full-width input fields */
            .form-container input[type=text], .form-container input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
            }

            /* When the inputs get focus, do something */
            .form-container input[type=text]:focus, .form-container input[type=password]:focus {
            background-color: #ddd;
            outline: none;
            }

            /* Set a style for the submit/login button */
            .form-container .btn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom:10px;
            opacity: 0.8;
            }

            /* Add a red background color to the cancel button */
            .form-container .cancel {
            background-color: red;
            }

            /* Add some hover effects to buttons */
            .form-container .btn:hover, .open-button:hover {
            opacity: 1;
            }
    
    </style>

<table class="alpha w3-table w3-bordered w3-card-4 center">
    <br>
    <tr>
        <td class="col-md-2">Venue </td>
        <td><?php echo $concert_info['venue_name']; ?></td>
    </tr>
    <tr>
        <td class="col-md-2">Tour </td>
        <?php if (is_null($concert_info["tour_name"])): ?>
        <td><i>This concert is not a part of a tour.<i><td>
        <?php else : ?>
        <td><?php echo $concert_info['tour_name']; ?></td>
        <?php endif; ?>

    </tr>
    <tr>
        <td class="col-md-2">Date </td>
        <td><?php echo substr($concert_info['date_time'], 0, 10); ?></td>
    </tr>
    <tr>
        <td class="col-md-2" style="vertical-align:top">Artists </td>
        <td>

        <table class="beta w3-table w3-bordered w3-card-4" align="left" style="width:70%">
            <tr>
            <td>
                <?php if (count($artists)==0): ?>
                <td><i>Unknown.<i><td>
                <?php else : ?>
                
                <?php foreach ($artists as $each_artist): ?>

                    <!-- https://www.w3schools.com/howto/howto_js_collapsible.asp -->
                    <button type="button" class="collapsible"><?php echo $each_artist[0]; ?></button>
                    <div class="content">
                        <?php foreach ($all_genres[$each_artist[1]] as $genre): ?>
                            <b><span title="Genre" style="color:#0D7D6A"><?php echo $genre[0]; ?></span></b>
                            <br>
                        <?php endforeach ?>
                        <?php foreach ($all_songs[$each_artist[1]] as $songs): ?>
                            <br>
                            <?php echo $songs[0]; ?>&nbsp;&nbsp;&nbsp;
                            <br>
                        <?php endforeach ?>
                        <br>
                            <button onclick="openForm(this.value, this.id)" class="btn btn-primary" title="Add a song" value="<?php echo $each_artist[0]; ?>" id="<?php echo $each_artist[1]; ?>">+</button>
                        <br>
                    </div>

                <?php endforeach ?>
                <?php endif; ?>
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

    <div>
        <form action="?command=updateconcert" method="POST">
            <button onclick="window.location.href='?command=updateconcert'" class="btn btn-primary">Update Concert</button>
            <input type="hidden" name="concert_to_update" value="<?php echo $concert_info['concert_id']; ?>" />
            <input type="hidden" name="update_concert_name" value="<?php echo $concert_info['concert_name']; ?>" />
            <input type="hidden" name="update_venue_name" value="<?php echo $concert_info['venue_name']; ?>" />
            <input type="hidden" name="update_tour_name" value="<?php echo $concert_info['tour_name']; ?>" />
            <input type="hidden" name="update_date_time" value="<?php echo $concert_info['date_time']; ?>" />
        </form>
    </div>

</div>



<!-- The form -->
<div class="form-popup" id="myForm">
  <form action="?command=entersong" class="form-container" method="POST">
    <h3 id="myformartist"></h3>

    <input type="text" placeholder="Song name" name="song_name" required>

    <input type="text" id="albumid" name="album_name" list="albums" placeholder="Album name" autocomplete="off" multiple="multiple" />
    <datalist id="albums">
        <?php foreach ($all_albums as $album): ?>
                <!-- ugh... how to filter by album per artist!!!! -->
                <option><?php echo $album[0][1]; ?></option>&nbsp;&nbsp;&nbsp;
                <br>
        <?php endforeach ?>
    </datalist>

    <button type="submit" class="btn">Submit</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
    <input type="hidden" name="current_artist" id="this_artist" />
    <input type="hidden" name="current_concert" value="<?php echo $concert_info['concert_id']; ?>" />
  </form>
</div>


<!-- Javascript code to handle collapsible content -->
<!-- https://www.w3schools.com/howto/howto_js_collapsible.asp -->
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
        content.style.display = "none";
        } else {
        content.style.display = "block";
        }
    });
    }

    function openForm(val, id) {
        document.getElementById("myForm").style.display = "block";
        document.getElementById("myformartist").innerHTML = val;
        document.querySelector("#this_artist").value = id;
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }

</script>


</html>