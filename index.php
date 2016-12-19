<?php
        require 'simple_html_dom.php';
        
        $count = 0;
        
        $html = new simple_html_dom();
        $html->load_file('https://web.snmptn.ac.id/ptn/');
        $data = $html->find('tr');
        for ($j=0; $j<count($data); $j++){
            if(strpos($data[$j]->innertext,'http')){
                $data[$j] = str_replace('href="/ptn/', 'href="/scrapper/scrap.php?univ_id=', $data[$j]);
            }
            echo $data[$j];
        }