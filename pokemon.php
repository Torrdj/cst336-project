<?php
    session_start();

    include "inc/connect.php";
    $db = getDBConnection();

    $pokemon = $db->query('select * from pokemons where id = '.$_GET['id'])->fetch(PDO::FETCH_ASSOC);
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

        <title class='text-capitalize'>TinyPokedex - <?php echo ucfirst($pokemon['name']); ?></title>
    </head>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#"><?php echo ucfirst($pokemon['name']); ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="documentation.php">Documentation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Log in</a>
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
        <div class='container-fluid'>
            <div class='row align-items-center'>
                <div class='col-5'>
                    <table class='table table-bordered text-center' style='width: 24em;'>
                        <thead>
                            <tr>
                                <th>#<?php echo $pokemon['id']; ?></th>
                                <th><?php echo ucfirst($pokemon['name']); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan=2><?php echo $pokemon['type1'].(($pokemon['type2'] != '') ? ' / '.$pokemon['type2'] : ''); ?></td>
                            </tr>
                            <tr>
                                <?php echo "<td colspan=2><img src='".$pokemon['img_url']."' alt = 'img' width='256em'></td>"; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class='col-6'>
                    <?php echo $pokemon['entry']; ?>
                </div>
            </div>
            <div class='row align-items-center'>
                <div class='col'>
                    <label for="stats"><h5>Base stats:</h5></label>
                    <table id='stats' class='table table-bordered text-center' style='width: 32em;'>
                        <tr>
                            <td>hp</td>
                            <td class="col-7">
                                <div class="progress">
                                  <?php echo '<div class="progress-bar" role="progressbar" style="width: '.($pokemon['hp']/250*100).'%" aria-valuenow="'.$pokemon['hp'].'" aria-valuemin="0" aria-valuemax="250">'.$pokemon['hp'].'</div>'; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>attack</td>
                            <td>
                                <div class="progress">
                                  <?php echo '<div class="progress-bar" role="progressbar" style="width: '.($pokemon['atk']/134*100).'%" aria-valuenow="'.$pokemon['atk'].'" aria-valuemin="0" aria-valuemax="134">'.$pokemon['atk'].'</div>'; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>defense</td>
                            <td>
                                <div class="progress">
                                  <?php echo '<div class="progress-bar" role="progressbar" style="width: '.($pokemon['def']/180*100).'%" aria-valuenow="'.$pokemon['def'].'" aria-valuemin="0" aria-valuemax="180">'.$pokemon['def'].'</div>'; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>special-attack</td>
                            <td>
                                <div class="progress">
                                  <?php echo '<div class="progress-bar" role="progressbar" style="width: '.($pokemon['spatk']/154*100).'%" aria-valuenow="'.$pokemon['spatk'].'" aria-valuemin="0" aria-valuemax="154">'.$pokemon['spatk'].'</div>'; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>special-defense</td>
                            <td>
                                <div class="progress">
                                  <?php echo '<div class="progress-bar" role="progressbar" style="width: '.($pokemon['spdef']/120*100).'%" aria-valuenow="'.$pokemon['spdef'].'" aria-valuemin="0" aria-valuemax="120">'.$pokemon['spdef'].'</div>'; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>speed</td>
                            <td>
                                <div class="progress">
                                  <?php echo '<div class="progress-bar" role="progressbar" style="width: '.($pokemon['speed']/150*100).'%" aria-valuenow="'.$pokemon['speed'].'" aria-valuemin="0" aria-valuemax="150">'.$pokemon['speed'].'</div>'; ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='row align-items-center'>
                <div class='col'>
                    <label for="moves"><h5>Moves:</h5></label>
                    <table id='moves' class='table table-bordered text-center'>
                        <thead>
                            <tr>
                                <th>learn at lvl</th>
                                <th>name</th>
                                <th>type</th>
                                <th>category</th>
                                <th>power</th>
                                <th>accuracy</th>
                                <th>pp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $skills = $db->query("select * from pokemons_skills where pokemon_name = '".$pokemon['name']."';");
                                while ($skill = $skills->fetch(PDO::FETCH_ASSOC))
                                {
                                    $lvl = $skill['lvl'];
                                    $skill = $db->query("select * from skills where name = '".$skill['skill_name']."';")->fetch(PDO::FETCH_ASSOC);
                                    echo "<tr>
                                            <td>".$lvl."</td>
                                            <td>".$skill['name']."</td>
                                            <td>".$skill['type']."</td>
                                            <td>".$skill['category']."</td>
                                            <td>".$skill['power']."</td>
                                            <td>".$skill['accuracy']."</td>
                                            <td>".$skill['pp']."</td>
                                        </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

        <script type="text/javascript" src="js/idk.js"></script>
    </body>
</html>