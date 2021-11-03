<?php

$pokemon = null;

if (!empty($_GET['pokemon'])) {

    $pokiApi = "https://pokeapi.co/api/v2/pokemon/" . $_GET['pokemon'];
    $pokiJson = file_get_contents($pokiApi);
    $pokemon = json_decode($pokiJson);

    $dataMoves = $pokemon->moves;


    $pokiEvoApi = "https://pokeapi.co/api/v2/pokemon-species/" . $_GET['pokemon'];
    $pokiEvoJson = file_get_contents($pokiEvoApi);
    $pokiEvo = json_decode($pokiEvoJson);

    $pokiEvoChainURL = $pokiEvo->evolution_chain->url;
    $pokiEvoChainJson = file_get_contents($pokiEvoChainURL);
    $pokiEvoChain = json_decode($pokiEvoChainJson);

    $poki1stEvo = $pokiEvoChain->chain->species->name;

    function evolutions($name)
    {
        $pokiImgURL = "https://pokeapi.co/api/v2/pokemon/" . $name;
        $pokiJson = file_get_contents($pokiImgURL);
        $pokiImg = json_decode($pokiJson);
        return $evoImg = $pokiImg->sprites->front_default;
    }
    // $poki1 = $pokiEvoChain->species
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Lobster" rel="stylesheet">
    <title>The pokemon challenge - PHP style</title>

</head>

<body>
    <div class="container">
        <h1 class="game-name">Pokemon</h1>

        <div class="pokedex">
            <div class="main-section_white">
                <div class="main-section_black">
                    <div class="main-screen">
                        <div class="screen_header">
                            <span class="poke-id">
                                <?php
                                if ($pokemon != null) {
                                    echo $pokemon->id;
                                }
                                ?>
                            </span>
                            <span class="poke-name">
                                <?php
                                if ($pokemon != null) {
                                    echo $pokemon->name;
                                }
                                ?>
                            </span>

                        </div>
                        <div class="screen_image">
                            <img src="<?php
                            if ($pokemon != null) {
                                echo $pokemon->sprites->front_default;} 
                            ?>
                            class="poke-image" alt="front">
                        </div>
                        <div class="screen_description">
                            <div class="moves">
                                <!-- stats_types -->
                                <!-- made a foreach loop where dataMoves is moves. Key is to show 4 moves so. -->
                                <?php foreach ($dataMoves as $key => $moves) {
                                    if ($key < 4) { ?>
                                        <span class="poke-move-one hide">
                                            <?php echo $moves->move->name; ?>
                                        </span>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="next-layer">
                <div class="text-and-button">
                    <form action="index.php" method="get">
                        <input type="text" id="user-input" name="pokemon" />
                        <button type="submit" id="run">Enter</button>
                    </form>

                </div>

                <div class="evolution top-evolution">

                    <p>evolution</p>
                    <img class="evolution evolution-img" src="
                        <?php echo evolutions($poki1stEvo) ?>
                    ">

                    <?php foreach ($pokiEvoChain->chain->evolves_to as $pokimonEvolution) { ?>
                        <img class="evolution evolution-img" src="
                        <?php echo evolutions($pokimonEvolution->species->name) ?>
                    ">
                        <?php foreach ($pokimonEvolution->evolves_to as $pokimonEvolution2) { ?>
                            <img class="evolution evolution-img" src="
                        <?php echo evolutions($pokimonEvolution2->species->name) ?>
                    ">
                        <?php } ?>
                    <?php } ?>




                </div>
            </div>
        </div>
    </div>
</body>

</html>