<?php
    //include 'connect.php';

    function fillDatabase($pokemon)
    {
        if (!$pokemon) return;
        
        $db = getDBConnection();
        
        // POKEMON
        $name = $pokemon['name'];
        
        $type1 = $pokemon['types'][0]['type']['name'];
        $slot = $pokemon['types'][0]['slot'];
        $type2 = ($slot == 2) ? $pokemon['types'][1]['type']['name'] : "";
        $id = $pokemon['id'];
        $height = $pokemon['height'];
        $weight = $pokemon['weight'];
        $stats = $pokemon['stats'];
        foreach($stats as $stat)
        {
            switch ($stat['stat']['name']) {
                case "speed":
                    $speed = $stat['base_stat'];
                    break;
                case "special-defense":
                    $spdef = $stat['base_stat'];
                    break;
                case "special-attack":
                    $spatk = $stat['base_stat'];
                    break;
                case "defense":
                    $def = $stat['base_stat'];
                    break;
                case "attack":
                    $atk = $stat['base_stat'];
                    break;
                case "hp":
                    $hp = $stat['base_stat'];
                    break;
                
                default:
                    // code...
                    break;
            }
        }
        $img_url = $pokemon['sprites']['front_default'];
        
        $entries = json_decode(sendRequest($pokemon['species']['url']), true)['flavor_text_entries'];
        $i = 0; $end = sizeof($entries);
        while ($i < $end
        && $entries[$i]['version']['name'] != 'red'
        && $entries[$i]['version']['name'] != 'blue')
            $i++;
        $entry = $i == $end ? "" : $entries[$i]['flavor_text'];
        
        $sql = "INSERT INTO pokemons 
        (name, type1, type2, id, height, weight, hp, atk, def, 
        spatk, spdef, speed, img_url, entry) 
        SELECT name, type1, type2, id, height, weight, hp, atk, def, 
        spatk, spdef, speed, img_url, entry
        FROM (SELECT :name as name, :type1 as type1, :type2 as type2, 
        :id as id, :height as height, :weight as weight, :hp as hp, :atk as atk, 
        :def as def, :spatk as spatk, :spdef as spdef, :speed as speed, 
        :img_url as img_url, :entry as entry) t 
        WHERE NOT EXISTS (SELECT * FROM pokemons WHERE name = :name);";
        
        $statement = $db->prepare($sql);
        $statement->execute(array(
            ':name' => $name,
            ':type1' => $type1,
            ':type2' => $type2,
            ':id' => $id,
            ':height' => $height,
            ':weight' => $weight,
            ':hp' => $hp,
            ':atk' => $atk,
            ':def' => $def,
            ':spatk' => $spatk, 
            ':spdef' => $spdef,
            ':speed' => $speed,
            ':img_url' => $img_url,
            ':entry' => $entry));
        
        
        //SKILLS
        $moves = $pokemon['moves'];
        foreach($moves as $move)
        {
            $versions = $move['version_group_details'];
            $i = 0; $end = sizeof($versions);
            while ($i < $end
            && ($versions[$i]['version_group']['name'] != "red-blue"
            || $versions[$i]['move_learn_method']['name'] != "level-up"))
                $i++;
            
            if ($i != $end)
            {
                $skill = json_decode(sendRequest($move['move']['url']), true);
                
                $skill_name = $skill['name'];
                $type = $skill['type']['name'];
                $category = $skill['damage_class']['name'];
                $power = $skill['power'] == null ? 0 : $skill['power'];
                $accuracy = $skill['accuracy'] == null ? 0 : $skill['accuracy'];
                $pp = $skill['pp'];
        
                $sql = "INSERT INTO skills 
                (name, type, category, power, accuracy, pp) 
                SELECT name, type, category, power, accuracy, pp 
                FROM (SELECT :name as name, :type as type, :category as category, 
                :power as power, :accuracy as accuracy, :pp as pp) t 
                WHERE NOT EXISTS (SELECT * FROM skills WHERE name = :name);";
                
                $statement = $db->prepare($sql);
                $statement->execute(array(
                    ':name' => $skill_name,
                    ':type' => $type,
                    ':category' => $category,
                    ':power' => $power,
                    ':accuracy' => $accuracy,
                    ':pp' => $pp));
                    
                //BIND SKILL/POKEMON
                $lvl = $versions[$i]['level_learned_at'];
                
                $sql = "INSERT INTO pokemons_skills 
                (pokemon_name, skill_name, lvl) 
                SELECT pokemon_name, skill_name, lvl 
                FROM (SELECT :pokemon_name as pokemon_name, :skill_name as skill_name, :lvl as lvl) t 
                WHERE NOT EXISTS 
                (SELECT * FROM pokemons_skills 
                WHERE 
                pokemon_name = :pokemon_name AND skill_name = :skill_name);";
                
                $statement = $db->prepare($sql);
                $statement->execute(array(
                    ':pokemon_name' => $name,
                    ':skill_name' => $skill_name,
                    ':lvl' => $lvl));
            }
        }
    }

    function sendRequest($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != 200) {
            return json_encode('An error has occured.');
        }
        return $data;
    }
    
    for ($i = 0; $i < 152; $i++) //To use with caution!!!
    {
        fillDatabase(json_decode(sendRequest('https://pokeapi.co/api/v2/pokemon/'.$i), true));
    }
?>