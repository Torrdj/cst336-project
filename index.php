<?php
    session_start();

    include "inc/connect.php";

    $db = getDBConnection();
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

        <link rel="stylesheet" href="css/styles.css" type="text/css" />

        <title>TinyPokedex - Home</title>
    </head>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="documentation.php">Documentation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log in</a>
                    </li>
                    <?php
                        if (isset($_SESSION['username']))
                        {
                            echo '
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#">|</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="profile.php">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Log out</a>
                                </li>';
                        }
                    ?>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </header>
    <body>
        <h1 class='text-center'>TinyPokedex</h1>
        <br/>
        <table id='pokedex' class='table table-hover text-center' style='width: 90%; margin: auto;'>
            <thead class='thead-dark'>
                <tr>
                    <th>Image</th>
                    <th>N° <button id='sort' class='badge text-hide'>S</button></button></th>
                    <th>Types</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $pokemons = $db->query("SELECT * FROM pokemons");
                    while ($pokemon = $pokemons->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<tr id=".$pokemon['id'].">
                                <td><img src='".$pokemon['img_url']."' class='rounded' alt = 'img'></td>
                                <td>".$pokemon['id']."</td>
                                <td>".$pokemon['type1']."<br/>".$pokemon['type2']."</td>
                                <td class='text-capitalize'>".$pokemon['name']."</td>
                            </tr>";
                    }
                ?>
            </tbody>
        </table>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

        <script type="text/javascript" src="js/idk.js"></script>
    </body>
</html>