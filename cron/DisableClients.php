<?php
$Users = new Users();
$agents = $Users->GetActiveAgentsList();
$month_ini = new DateTime("first day of last month");
$from = strtotime($month_ini->format('d-m-Y'));
foreach($agents as $agent){
    $activation_date = strtotime($agent['activation_date']);
    if($activation_date < $from){
        $clients = $Users->GetUsersByAgent($agent['id_agent']);
        $limit = $GLOBALS['CONFIG']['agent_clients_lost'];
        for($i = 0; $i < $limit; $i++){
            if(!$clients[$i]){
                break;
            }
            if($clients[$i]['countable'] == 1){
                $Users->DisableAgentClient($clients[$i]['id']);
            }else{
                $limit++;
            }
        }
    }
}