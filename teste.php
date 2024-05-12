<?php

$teste = 2;
$teste3 = 2;

$t2 = file_get_contents(__DIR__ . "\\teste.ghj");

//echo htmlspecialchars(renderIf(str_replace("\n" , "" ,$t2)));



//var_dump($matches);


//$subistituicao = htmlspecialchars( $subistituicao);

//echo '<br><br>'; 


function renderIf($my_file){
    preg_match('~(.+|)(.+|)(?:<if.+condition="\[)(.+)(?:\]">)(.+)(?:<\/if>)(.+|)~', $my_file, $matches);
    
    //echo  htmlspecialchars($my_file);

    if(sizeof($matches)){
        $subistituicao = '<?php if (' . $matches[3] . ') { ?>' . $matches[4]  . ' <?php } ?>';
        if($matches[1] != null || $matches[5] != null){
            renderIF($matches[1] . $subistituicao . $matches[5]);
        } 
    }  else {
        //echo  htmlspecialchars($my_file);

        $teste = 2;
        $teste3 = 2;
        renderForEach($my_file);
        
    }
    

}

function renderForEach($my_file){
    preg_match('~(.+|)(.+|)(?:<foreach.+data=")(.+)(?:\:)(.+)(?:">)(.+)(?:<\/endEach>)(.+|)~', $my_file, $matches);
    
    //echo  htmlspecialchars($my_file);

    if(sizeof($matches)){
        $subistituicao = '<? foreach (' . $matches[3] . ' as $key=>' . $matches[4]  . ') { ?>' . $matches[5] . '<? } ?>';



        if($matches[1] != null || $matches[6] != null){
            renderIF($matches[1] . $subistituicao . $matches[6]);
        } 
    }  else {
        //echo  htmlspecialchars($my_file);
         $teste = 2;
        $teste3 = 2;
        renderIfShowIf($my_file);
        
    }
}


function renderIfShowIf($my_file){
    preg_match('~(.+|)(?:<showIf.+condition="\[)(.+)(?:\]">)(.+)(?:<\/showIf>)(.+|)~', $my_file, $matches);
   
    if(sizeof($matches)){

        $teste = 4;
        $result = false;
        $soma = 7;

        eval( '?><? $result = ' . $matches[2]  . '?><?' ); 
 
        if(!$result){
            $subistituicao = "";
        } else{
             $subistituicao =  $matches[3];
         }
        
       if($matches[1] != null || $matches[4] != null){
            
            renderIF($matches[1] . $subistituicao . $matches[4]);
        } 
    }  else {
        $nome = 'Senha';
        $soma = 7;
        $people = array('a1','a2','a3','a4');
        $carro = array('c1','c2','c3','c4');
        $teste = 2;
        $teste3 = 2;

        //echo  htmlspecialchars($my_file);

        eval('?>' . $my_file . '<?');
        
    }
    

}

$t2 = str_replace("\n" , "" ,$t2);
$t2 = str_replace("{" , "<?" ,$t2);
$t2 = str_replace("}" , "?>" ,$t2);

renderIf(str_replace("\n" , "" ,$t2));

 


/*$strs = explode(' - ', $re[1]);
print_r($str); */
 


?>

