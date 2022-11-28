<?php
//  Function variables are accessible by included templates

class controller
{
    private $command;

    private $db;
    private $helper;

    public function __construct($command)
    {
        $this->command = $command;

        $this->db = new database();
        $this->helper = new helper();
    }

    public function run()
    {
        switch ($this->command) {
            case "login":
                $this->login();
                break;
            case "register":
                $this->register();
                break;
            case "logout":
                session_destroy();
                $this->login();
                break;
            case "home":
                $this->home();
                break;
            case "createconcert":
                $this->createConcertFunc();
                break;
            case "viewconcert":
                $this->viewConcertFunc();
                break;
            case "addartist":
                $this->addArtistFunc();
                break;
            case "deleteconcert":
                $this->deleteConcertFunc();
                break;
            case "entersong":
                $this->enterSongFunc();
            case "mylikes":
                $this->likesFunc();
                break;
            case "handlelike":
                $this->handleLikeFunc();
                break;
            case "updateconcert":
                $this->updateConcertFunc();
                break;
            default:
                $this->login();
                break;
        }
    }

    // To login the user.
    // If a match is found for the given credentials in the database, the user lands on the home page.
    // Else, the user is prompted to try again.
    private function login()
    {
        if (isset($_POST["username"])) {
            $data = $this->db->query("select * from user where username = ?;", "s", $_POST["username"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                $test1 = $data[0]["password"];
                $test2 = $_POST["password"];
                if (password_verify($test2, $test1)) {
                    $_SESSION["username"] = $data[0]["username"];
                    $_SESSION["userid"] = $data[0]["userid"];

                    header("Location: ?command=home");
                } else {
                    $error_msg = "Wrong password";
                    echo("broken");
                }
            }
        }
        include("templates/login.php");
    }

    // To register new users.
    // Prompts for the user's name, email, and a password, and adds them to the database.
    // User then lands on the home page.
    private function register() {
        if (isset($_POST["username"])) {
            $email = $_POST["username"];
            $insert = $this->db->query(
                "insert into user (username, password) values (?, ?);",
                "ss",
                $_POST["username"],
                password_hash($_POST["password"], PASSWORD_DEFAULT)
            );
            if ($insert === false) {
                $error_msg = "Error inserting user";
            }
            if ($insert === true) {
                $data = $this->db->query("select * from user where username = ?;", "s", $_POST["username"]);
                $_SESSION["username"] = $data[0]["username"];
                $_SESSION["userid"] = $data[0]["userid"];

                header("Location: ?command=home");
            }
        }
        include("templates/register.php");
    }

    // Loads and sorts the posts by newest, and displays them as a home page.
    private function home()
    {
        // get list of concerts to display on home page
        $list_of_concerts = $this->db->query("CALL `getConcerts`();");

        include("templates/home.php");
    }

    private function addConcert($venue_id, $tour_name, $concert_name, $date_time)
    {

        $statementfirst = $this->db->mysqli->prepare("SELECT MAX(concert_id)+1 FROM concert");
        $statementfirst->execute();
        $statementfirst->bind_result($result);
        $statementfirst->fetch();
        $statementfirst->close();

        $statement = $this->db->mysqli->prepare("INSERT INTO concert (concert_id, venue_id, tour_name, concert_name, date_time) VALUES (?, ?, ?, ?, ?)");
        $statement -> bind_param("iisss", $result, $venue_id, $tour_name, $concert_name, $date_time);
        $statement -> execute();
        $statement->close();


    }


    private function createConcertFunc()
    {

        $recent_data = null; // not used unless submission fails
        $display_error = false;

        // pass in a list of venues to be displayed in the dropdown
        $list_of_venues = $this->db->query("SELECT venue_id, venue_name FROM venue");

        // an intermediary page to handle new concert submission issues
        // if a venue has not been selected...
        if (isset($_POST["concert_name"])) {
            if ($_POST['venue_id']  == "") {
                $display_error = true;
                // save entered data to repopulate these fields
                $recent_data['concert_name'] = $_POST['concert_name'];
                $recent_data['tour_name'] = $_POST['tour_name'];
                $recent_data['date_time'] = $_POST['date_time'];
            }
            else {
                $display_error = false;
                $this->addConcert($_POST['venue_id'], $_POST['tour_name'], $_POST['concert_name'], $_POST['date_time']);
                header ("Location: ?command=home"); // redirect to simpleform.php page after submission
            }
        }

        include("templates/createConcert.php");
    }


    private function viewConcertFunc() {
        if (isset($_GET["id"])) {
            $concert_id = $_GET["id"];

            $concert_statement = $this->db->mysqli->prepare("SELECT concert.concert_id, concert.concert_name, venue.venue_name, concert.tour_name, concert.date_time
            FROM concert, venue
            WHERE concert.concert_id = ?
            AND concert.venue_id = venue.venue_id");
            $concert_statement->bind_param('i', $concert_id);
            $concert_statement->execute();
            $result = $concert_statement->get_result();
            $concert_info = $result->fetch_assoc();
            $concert_statement->close();


            $artist_statement = $this->db->mysqli->prepare("SELECT artist.artist_name, artist.artist_id
            FROM artist, concert, performs
            WHERE concert.concert_id = ?
            AND artist.artist_id = performs.artist_id
            AND concert.concert_id = performs.concert_id");
            $artist_statement->bind_param('s', $concert_id);
            $artist_statement->execute();
            $artist_result = $artist_statement->get_result();
            $artists = $artist_result->fetch_all();
            $artist_statement->close();

            $all_songs = array();
            $all_genres = array();
            foreach ($artists as $each_artist) {
                $genre_per_artist = $this->db->mysqli->prepare("SELECT artist_genre.genre
                FROM artist_genre
                WHERE artist_genre.artist_id = ?");
                $genre_per_artist->bind_param('i', $each_artist[1]);
                $genre_per_artist->execute();
                $genre_result = $genre_per_artist->get_result();
                $genre_list = $genre_result->fetch_all();
                $all_genres[$each_artist[1]] = $genre_list;
                $genre_per_artist->close();

                $song_per_artist = $this->db->mysqli->prepare("SELECT song.song_name, song.song_id
                FROM song, artist, in_setlist
                WHERE song.artist_id = artist.artist_id
                AND artist.artist_id = ?
                AND song.song_id = in_setlist.song_id
                AND in_setlist.concert_id = ?");
                $song_per_artist->bind_param('ii', $each_artist[1], $concert_id);
                $song_per_artist->execute();
                $song_result = $song_per_artist->get_result();
                $song_list = $song_result->fetch_all();
                $all_songs[$each_artist[1]] = $song_list;
                $song_per_artist->close();
            }


            $all_albums = array();
            foreach ($all_songs as $song_list) {
                foreach ($song_list as $a_song) {
                    $album_per_artist = $this->db->mysqli->prepare("SELECT album.album_id, album.album_name, song.artist_id
                    FROM album, song
                    WHERE album.album_id = song.album_id
                    AND song.song_id = ?");
                    $album_per_artist->bind_param('i', $a_song[1]);
                    $album_per_artist->execute();
                    $album_result = $album_per_artist->get_result();
                    $album_list = $album_result->fetch_all();
                    if (!empty($album_list)) {
                        $all_albums[$album_list[0][0]] = $album_list;
                    }
                    $album_per_artist->close();
                }
            }

            //check if the concert is liked by this user
            $username = $_SESSION["username"];
            $check_liked = $this->db->mysqli->prepare("SELECT * FROM likes WHERE username = ? AND concert_id = ?");
            $check_liked->bind_param('si', $username, $concert_info['concert_id']);
            $check_liked->execute();
            $check_liked_result = $check_liked->get_result();
            $liked = $check_liked_result->fetch_all();
            $check_liked->close();

        }

        include("templates/viewConcert.php");
    }


    private function addArtistQuery($concert_id, $artist_name, $artist_genre_1, $artist_genre_2) {
            $statementfirst = $this->db->mysqli->prepare("SELECT MAX(artist_id)+1 FROM artist");
            $statementfirst->execute();
            $statementfirst->bind_result($result);
            $statementfirst->fetch();
            $statementfirst->close();


            // create new artist
            $add_artist_statement = $this->db->mysqli->prepare("INSERT INTO artist (artist_id, artist_name) VALUES (?, ?)");
            $add_artist_statement->bind_param('is', $result, $artist_name);
            $add_artist_statement->execute();
            $add_artist_statement->close();

            // link artist to concert
            $link_artist_statement = $this->db->mysqli->prepare("INSERT INTO performs (artist_id, concert_id) VALUES (?, ?)");
            $link_artist_statement->bind_param('ii', $result, $concert_id);
            $link_artist_statement->execute();
            $link_artist_statement->close();

            // specify artist genres
            $genre1_artist_statement = $this->db->mysqli->prepare("INSERT INTO artist_genre (artist_id, genre) VALUES (?, ?)");
            $genre1_artist_statement->bind_param('is', $result, $artist_genre_1);
            $genre1_artist_statement->execute();
            $genre1_artist_statement->close();

            $genre2_artist_statement = $this->db->mysqli->prepare("INSERT INTO artist_genre (artist_id, genre) VALUES (?, ?)");
            $genre2_artist_statement->bind_param('is', $result, $artist_genre_2);
            $genre2_artist_statement->execute();
            $genre2_artist_statement->close();

            $statement = $this->db->mysqli->prepare("CALL `getConcerts`();");
            $statement->execute();
            $statement->close();

    }

    private function addArtistFunc() {
        if (isset($_POST['this_concert'])) {
            $concert_id = $_POST['this_concert'];

            $this_concert_statement = $this->db->mysqli->prepare("SELECT concert.concert_name, concert.concert_id
            FROM concert
            WHERE concert.concert_id = ?");
            $this_concert_statement->bind_param('s', $concert_id);
            $this_concert_statement->execute();
            $concert_artist_result = $this_concert_statement->get_result();
            $concert_name = $concert_artist_result->fetch_assoc();

            $this_concert_statement->close();
        }

        if (isset($_POST['artist_name'])) {
            $this->addArtistQuery($_POST['this_concert'], $_POST['artist_name'], $_POST['genre_1'], $_POST['genre_2']);

            header("Location: ?command=home");
        }


        include("templates/addArtist.php");
    }


    private function deleteConcertFunc() {
        if (isset($_POST["concert_to_delete"])) {
            $concert_id = $_POST["concert_to_delete"];
            $delete_concert_statement = $this->db->mysqli->prepare("DELETE FROM in_setlist WHERE in_setlist.concert_id = ?");
            $delete_concert_statement->bind_param('i', $concert_id);
            $delete_concert_statement->execute();
            $delete_concert_statement->close();

            $delete_concert_statement = $this->db->mysqli->prepare("DELETE FROM likes WHERE likes.concert_id = ?");
            $delete_concert_statement->bind_param('i', $concert_id);
            $delete_concert_statement->execute();
            $delete_concert_statement->close();

            $delete_concert_statement = $this->db->mysqli->prepare("DELETE FROM performs WHERE performs.concert_id = ?");
            $delete_concert_statement->bind_param('i', $concert_id);
            $delete_concert_statement->execute();
            $delete_concert_statement->close();

            $delete_concert_statement = $this->db->mysqli->prepare("DELETE FROM concert WHERE concert.concert_id = ?");
            $delete_concert_statement->bind_param('i', $concert_id);
            $delete_concert_statement->execute();
            $delete_concert_statement->close();
        }

        header("Location: ?command=home");
    }

    private function addSongQuery($song_name, $artist_id, $concert_id, $album_name) {

        // get id for new song
        $statementfirst = $this->db->mysqli->prepare("SELECT MAX(song_id)+1 FROM song");
        $statementfirst->execute();
        $statementfirst->bind_result($result);
        $statementfirst->fetch();
        $statementfirst->close();

        // --------------------------HANDLE ALBUM STUFF---------------------------
        $album_name = trim($album_name);

        // check if NO album name specified
        if ($album_name == " " || $album_name == "") {
            // do not specify album_id for the new song
            // CREATE NEW SONG WITH NO CONNECTED ALBUM
            $add_song_statement = $this->db->mysqli->prepare("INSERT INTO song (song_id, song_name, artist_id) VALUES (?, ?, ?)");
            $add_song_statement->bind_param('isi', $result, $song_name, $artist_id);
            $add_song_statement->execute();
            $add_song_statement->close();
        }
        else {
            // search for album_name:
            $statementalbum = $this->db->mysqli->prepare("SELECT album.album_id FROM album WHERE album.album_name = ?");
            $statementalbum->bind_param('s', $album_name);
            $statementalbum->execute();
            $statementalbum->bind_result($resultAlbum);
            $statementalbum->fetch();
            $statementalbum->close();

            // album already saved in db!
            if ($resultAlbum != "") {
                $newAlbumId = $resultAlbum;
            }
            else {
                // create a new album
                $getAlbumId = $this->db->mysqli->prepare("SELECT MAX(album_id)+1 FROM album");
                $getAlbumId->execute();
                $getAlbumId->bind_result($newAlbumId);
                $getAlbumId->fetch();
                $getAlbumId->close();

                $add_album = $this->db->mysqli->prepare("INSERT INTO album (album_id, album_name, artist_id) VALUES (?, ?, ?)");
                $add_album->bind_param('isi', $newAlbumId, $album_name, $artist_id);
                $add_album->execute();
                $add_album->close();
            }

            // CREATE NEW SONG WITH A SELECTED ALBUM
            $add_song_statement = $this->db->mysqli->prepare("INSERT INTO song (song_id, song_name, artist_id, album_id) VALUES (?, ?, ?, ?)");
            $add_song_statement->bind_param('isii', $result, $song_name, $artist_id, $newAlbumId);
            $add_song_statement->execute();
            $add_song_statement->close();

        }

        // link song to concert
        $link_song_concert_statement = $this->db->mysqli->prepare("INSERT INTO in_setlist (song_id, concert_id) VALUES (?, ?)");
        $link_song_concert_statement->bind_param('ii', $result, $concert_id);
        $link_song_concert_statement->execute();
        $link_song_concert_statement->close();

    }

    private function enterSongFunc() {
        if (isset($_POST["current_artist"])) {

            $this->addSongQuery($_POST['song_name'], $_POST['current_artist'], $_POST['current_concert'], $_POST['album_name']);

            header("Location: ?command=home");
        }
    }

    private function likesFunc() {
        $username = $_SESSION["username"];

        $getLikes = $this->db->mysqli->prepare("SELECT concert.concert_name, concert.concert_id FROM likes NATURAL JOIN concert WHERE likes.username = ?");
        $getLikes->bind_param('s', $username);
        $getLikes->execute();
        $likes_result = $getLikes->get_result();
        $result = $likes_result->fetch_all();
        $getLikes->close();

        include("templates/myLikes.php");
    }

    private function handleLikeFunc() {
        if (isset($_POST['current_concert'])) {
            $concert_id = $_POST['current_concert'];
            $liked = $_POST['liked'];
            $username = $_SESSION["username"];

            // like concert
            if (!empty($liked)) {
                //print_r("liked empty");
                $add_like = $this->db->mysqli->prepare("INSERT INTO likes (username, concert_id) VALUES (?, ?)");
                $add_like->bind_param('si', $username, $concert_id);
                $add_like->execute();
                $add_like->close();
            }
            else {
                // unlike concert
                //print_r("liked not empty");
                $del_like = $this->db->mysqli->prepare("DELETE FROM likes WHERE username = ? AND concert_id = ?");
                $del_like->bind_param('si', $username, $concert_id);
                $del_like->execute();
                $del_like->close();
            }

        }
        header("Location: ?command=mylikes");
    }

    private function updateConcertFunc() {

        // pass in a list of venues to be displayed in the dropdown
        $list_of_venues = $this->db->query("SELECT venue_id, venue_name FROM venue");

        if (isset($_POST["btnAction"])) {

            $concert_id = $_POST['concert_to_update'];
            $concert_name = $_POST['update_concert_name'];
            $venue_id = $_POST['update_venue_id'];
            $tour_name = $_POST['update_tour_name'];
            $date_time = $_POST['update_date_time'];

            $update_concert_statement = $this->db->mysqli->prepare("UPDATE concert
                SET venue_id = ?, tour_name = ?, concert_name = ?, date_time = ?
                WHERE concert_id = ?");
            $update_concert_statement->bind_param("isssi", $venue_id, $tour_name, $concert_name, $date_time, $concert_id);
            $update_concert_statement->execute();
            $update_concert_statement->close();

            header ("Location: ?command=home"); // redirect to simpleform.php page after submission

        } else {
            $recent_data = null; // not used unless submission fails
            $recent_data['concert_id'] = $_POST['concert_to_update'];
            $recent_data['concert_name'] = $_POST['update_concert_name'];
            $recent_data['venue_name'] = $_POST['update_venue_name'];
            $recent_data['tour_name'] = $_POST['update_tour_name'];
            $recent_data['date_time'] = $_POST['update_date_time'];
        }

        include("templates/updateConcert.php");
    }

}