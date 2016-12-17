        <?php
        require 'simple_html_dom.php';
        
        $count = 0;
        
        $html = new simple_html_dom();
        $html->load_file('https://web.snmptn.ac.id/ptn/'.$_GET['univ_id']);
        $data = $html->find('tr');
        $dota = $html->find('tr');
        $kode = 'SAINTEK';
        
        for ($j=0; $j<count($dota); $j++){
        if(strpos($dota[$j]->innertext,'href="/ptn/'.$_GET["univ_id"])){
            $dota[$j] = delete_all_between('<td', '</td>', $dota[$j]->innertext);
            $dota[$j] = delete_all_between('<td', '">', $dota[$j]);
            $dota[$j] = delete_all_between('</a>', '</td>', $dota[$j]);
            $dota[$j] = delete_all_between('<td', '</td>', $dota[$j]);
//            str_replace('</td>', '', $dota[$j]);
                $univ = $dota[$j];
                break;
            }
        }
        for ($j=0; $j<count($data); $j++){
            
            if(strpos($data[$j]->innertext,'http') === false){
                if(strpos($data[$j]->innertext, 'Kode')){
                    $count++;
                }
                if($count > 1){
                    $kode = 'SOSHUM';
                }
                if(strpos($data[$j]->innertext, 'Kode') ===  false){
                    $anu[$j] = str_replace('<td class="no">', '',$data[$j]->innertext);
                    $anu[$j] = str_replace('<td class="ce">', '',$anu[$j]);
                    $anu[$j] = str_replace('</td>', '',$anu[$j]);
                    $anu[$j] = str_replace('<td>', '',$anu[$j]);
                    $anu[$j] = delete_all_between('<', '>', $anu[$j]);
                    $anu[$j] = str_replace('\t','', $anu[$j]);
                                        $anu[$j] = str_replace('</a>','', $anu[$j]);

                    $anu[$j] = explode(" 									", $anu[$j]);
//                    $anu[5] = 'SAINTEK';
                    echo 'INSERT INTO prodis(nomer,nama,ket,universitas) VALUES (';
                    for($i=0; $i<count($anu[$j]); $i++){
                        
                        if($i == 2 ){
                            echo $anu[$j][$i].',"';
                        }elseif($i == 3){
                            echo $anu[$j][$i].'","';
                        }
                    }
                    echo $kode.'","'.$univ.'");';
                    echo '<br>';
                 
                }
            }
        }
        
        function delete_all_between($beginning, $end, $string) {
  $beginningPos = strpos($string, $beginning);
  $endPos = strpos($string, $end);
  if ($beginningPos === false || $endPos === false) {
    return $string;
  }

  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

  return str_replace($textToDelete, '', $string);
}