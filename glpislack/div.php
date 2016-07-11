<?php

$url = "https://hooks.slack.com/services/"."T154MA97H/B186F0MNW/7y0qNSClp4mOpuSZhqYR0V2y";

$data = array(
    'attachments' => array(
        array(
            "fallback" => "Nouveau Ticket créé: <https://www.tmavdp.fr/glpi/front/ticket.form.php?id=212|212>",
            "pretext" => "Nouveau Ticket créé: <https://www.tmavdp.fr/glpi/front/ticket.form.php?id=212|212>",
            "author_name" => "De Gourcy Amaury",
            "title" => "CME - Perte du tunnel PDP",
            "title_link" => "https://www.tmavdp.fr/glpi/front/ticket.form.php?id=212",
            "text" => htmlspecialchars_decode(htmlspecialchars("L'opérateur appelle l'astreinte à 00h36 pour signaler la perte du tunnel de PDP, pendant un test de scénario. C'est donc une CME.\nSDEL et la ville de Paris se trouvent sur le terrain.\n\nAu niveau de U3, l'automate est en RUN OFFLINE/unknown, des switch sont en fault. Ils constatent surtout que l'usine U2 est tombée. Tous les TGBT sont OFF.\nAprès un \"redémarrage\" de l'usine U2, les différents switchs reprennent. Après un redémarrage de l'API de U2 passe en NO CONF/OFF.\n\nAprès une mise en STOP de l'automate puis à nouveau START, l'automate de U3 passe en RUN PRIM/STB BY.\n\nJ'appelle l'opérateur à 2h00 pour lui demander si la situation est bien revenue à la normale, ce qu'il me confirme."),ENT_QUOTES),
            "color" => "#8daec2",
            // "fields" => array (
            //     array(
            //     "title" => "Notes",
            //     "value" => "Ouvert par De Gourcy Amaury\nCME - Perte du tunnel PDP",
            //     "short" => false
            //     )
            // )
        ),
    ),
);

$data_json = json_encode($data); 

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_COOKIESESSION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
curl_setopt($curl, CURLOPT_POST, 1);        
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);

$result = curl_exec($curl);

?>