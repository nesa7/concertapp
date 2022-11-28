<?php
$username = $_SESSION["username"];
?>
<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: white;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Concert App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?command=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?command=createconcert">New Concert</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?command=mylikes">My Likes</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $username ?></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="?command=logout">Logout</a></li>
                </li>
            </ul>
        </div>
    </div>
</nav>