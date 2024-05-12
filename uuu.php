<?php
require_once 'config.php';
$conexao = CONEXAO();

$poloNucleo = isset($_POST['polo_nucleo']) ? $_POST['polo_nucleo'] : NULL;
$curso = isset($_POST['curso']) ? $_POST['curso'] : NULL;
$portador = isset($_POST['portador']) ? $_POST['portador'] : NULL;


$poloNucleo = explode('_', $poloNucleo);

$polo = $poloNucleo[0];
$nucleo = $poloNucleo[1];

$retorno = array();
$SQL = "
	SELECT V.*
	  FROM SGA.VW_VALORES_CURSOS_EAD_NOVA V

	 WHERE V.CURSO 	= :CURSO
	   AND V.POLO 	= :POLO
	   AND V.NUCLEO = :NUCLEO 
	   AND tipo = 1
	  ORDER BY V.VR_BRUTO_MENS DESC";

$conexao->setSql($SQL);

$conexao->AddParam(':POLO', 	$polo);
$conexao->AddParam(':CURSO', 	$curso);
$conexao->AddParam(':NUCLEO', 	$nucleo);
	
if (!$query = $conexao->Query()) {
	throw new Exception('Erro no SQL que Busca a lista de Cidades.');
}
	
$row = $conexao->Fetch($query);


$matricula 		= $row->VR_MATRICULA;
$mensalidade 	= $row->VR_BRUTO_MENS;
$regional 		= $row->REGIONAL;
$desc_regional 	= $row->VR_DESCONTO_REGIONAL ;
$desconto_percentual = true;

if($row->VR_ESPECIAL > 0){
	$desc_regional 	= $row->VR_ESPECIAL ;
	$desconto_percentual = false;
}

$sou_mais 		= $row->SOU_MAIS;
$desc_sou_mais 	= $row->VR_DESCONTO_SOU_MAIS;
$outro_desconto = $row->OUTRO_DESCONTO;
$vr_liquido_portador = $row->VR_LIQUIDO_PORTADOR;
$portador_diploma = $row->PORTADOR_DIPLOMA;

$vr_transferencia = $row->VR_TRANSFERENCIA;
$transferencia = $row->TRANSFERENCIA;
//$mensalidade = money_format('%n', $mensalidade);
//$matricula = money_format('%n', $matricula);





$mensalidade = str_replace(",",".",$mensalidade);
$mensalidade = number_format($mensalidade, 2, ',', '');



$matricula = str_replace(",",".",$matricula);
$matricula = number_format($matricula, 2, ',', '');
?>

<div class="panel-group" id="accordionValores" role="tablist" aria-multiselectable="true" style="margin-bottom:15px;">
  	<div class="panel panel-primary card-1" style="border:none;">
     	<div class="panel-heading" role="tab" id="headingValores" data-toggle="collapse" href="#collapseValores">
        	<h4 class="panel-title" style="text-align:center"> 
            	<a data-toggle="collapse" data-parent="#accordionReconhecimento" href="#collapseValores" aria-expanded="true" aria-controls="collapseValores" style="text-decoration:none;"><span class="titulo" style="font-size:1.5em">
                	<?
                    
                    if(!empty($row)){
                    	(!empty($matricula) ? 'MATRÍCULA - R$ '.$matricula : '');
                    }else{
						echo '<span style="font-size:0.8em">ENTRE EM CONTATO COM O POLO PARA MAIS INFORMAÇÕES</span>';
					}?>
                
                </a> 
          	</h4>
       	</div><?
		
        if(!empty($row)){
			if(!$portador){?>
            
				<div id="collapseValores" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingValores" style="font-size:1.5em">
					<div class="panel-body text-center">                 	        
						<strong class="azul">Mensalidade</strong><br><?
						 
						if(!empty($regional) || !empty($sou_mais)){?>                           
							<spam style="text-decoration:line-through; color:#F00">De: R$ <?=$mensalidade?></spam><br><?
							if(!empty($desc_regional)){
									
								$desc_regional = str_replace(",",".",$desc_regional);
								$desc_regional = number_format($desc_regional, 2, ',', '');
								//$desc_regional = money_format('%n', $desc_regional);
															
								if(!empty($sou_mais)){
										
									$desc_sou_mais = str_replace(",",".",$desc_sou_mais);
									$desc_sou_mais = number_format($desc_sou_mais, 2, ',', '');							
									//$desc_sou_mais = money_format('%n', $desc_sou_mais);?>
								
									<spam style="color:#333;text-decoration:line-through;">+<?=$regional?>%: R$ <?=$desc_regional?>*</spam><br> 
								
									<spam style="color:#333; font-weight:bold; font-size:1.1em">+<?=$sou_mais?>% por: R$ <?=$desc_sou_mais?>**</spam><br> <?
								}else{
									if($desconto_percentual) {
										?>	
										<spam style="color:#333; font-weight:bold; font-size:1.1em">+<?=$regional?>% por: R$ <?=$desc_regional?>*</spam><br><?
									 } else {
										?>	
										<spam style="color:#333; font-weight:bold; font-size:1.1em">por: R$ <?=$desc_regional?>*</spam><br><?
									}
								}
							}elseif(!empty($sou_mais)){
									
								$desc_sou_mais = str_replace(",",".",$desc_sou_mais);
								$desc_sou_mais = number_format($desc_sou_mais, 2, ',', '');							
								//$desc_sou_mais = money_format('%n', $desc_sou_mais);?>
									
								<spam style="color:#333; font-weight:bold; font-size:1.1em">+<?=$sou_mais?>% por: R$ <?=$desc_sou_mais?>**</spam><br><?
							}
						}else{?>
							<spam style="color:#333">R$ <?=$mensalidade?></spam><br><?
						}?><?
							 
						if(!empty($outro_desconto)){?>
							<spam style="color:#333;font-size:0.8em">+ <?=$outro_desconto?>.</spam><br><?
						}?>
										
						<?=!empty($regional) ? '</br><spam style="color:#333;font-size:0.8em">*&nbsp;Desconto promocional.</spam>' : ''?> 
						<?=!empty($sou_mais) ? '</br><spam style="color:#333;font-size:0.8em">**&nbsp;Desconto Sou Mais Uniube.</spam>' : ''?>                                                           
					</div><?
					
				}else{?>
					<div id="collapseValores" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingValores" style="font-size:1.5em">
						<div class="panel-body text-center">                 	        
							<strong class="azul">Mensalidade - Portador</strong><br><?
							
							if(!empty($vr_liquido_portador)){?>
								
								
								<spam style="text-decoration:line-through; color:#F00">De: R$ <?=$mensalidade?></spam><br><?

									$vr_liquido_portador = str_replace(",",".",$vr_liquido_portador);
									$vr_liquido_portador = number_format($vr_liquido_portador, 2, ',', '');							
									//$desc_sou_mais = money_format('%n', $desc_sou_mais);?>
										
									<spam style="color:#333; font-weight:bold; font-size:1.1em">+<?=$portador_diploma?>% por: R$ <?=$vr_liquido_portador?></spam><br>  <?
					
					
							}else{?>
								<spam style="color:#333">R$ <?=$mensalidade?></spam><br><?
							}?>
					
					
						</div>
					</div>
                    
                    <hr />
                    
                    
                    <div id="collapseValores" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingValores" style="font-size:1.5em">
						<div class="panel-body text-center">                 	        
							<strong class="azul">Mensalidade - Transferência</strong><br><?
							
							if(!empty($vr_transferencia)){?>
								
								
								<spam style="text-decoration:line-through; color:#F00">De: R$ <?=$mensalidade?></spam><br><?

									$vr_transferencia = str_replace(",",".",$vr_transferencia);
									$vr_transferencia = number_format($vr_transferencia, 2, ',', '');							
									//$desc_sou_mais = money_format('%n', $desc_sou_mais);?>
										
									<spam style="color:#333; font-weight:bold; font-size:1.1em">+<?=$transferencia?>% por: R$ <?=$vr_transferencia?></spam><br>  <?
					
					
							}else{?>
								<spam style="color:#333">R$ <?=$mensalidade?></spam><br><?
							}?>
					
					
						</div>
					</div>
					
					<?
                }
            }?>
		</div>
	</div>
</div><?



$SQL = "
SELECT DISTINCT P.*
  FROM SGA.POLOS P
 INNER JOIN SGA.NUCLEOS N
    ON P.POLO = CASE
         WHEN (N.POLO, N.NUCLEO) IN ((139, 92)) THEN
          224
         ELSE
          NVL(N.POLO_REFERENCIA, N.POLO)
       END

 WHERE CASE
         WHEN (N.POLO, N.NUCLEO) IN ((139, 92)) THEN
          224
         ELSE
          NVL(N.POLO_REFERENCIA, 0)
       END NOT IN (139, 140, 143)
      
   AND P.STATUS = 1
   AND P.ATIVO = 1
   AND N.STATUS = 1
   AND N.ATIVO = 1
   AND N.POLO = :POLO
   AND N.NUCLEO = :NUCLEO
   ";

$conexao->setSql($SQL);

$conexao->AddParam(':POLO', 	$polo);
$conexao->AddParam(':NUCLEO', 	$nucleo);

if (!$query = $conexao->Query()) {
	throw new Exception('Erro no SQL que Busca a lista de Cidades.');
}
	
$row = $conexao->Fetch($query);

if(!empty($row->SUBDOMINIO)){

	$subdominio 		= $row->SUBDOMINIO;

}else{
	$subdominio  =  'https://uniube.br/processoSeletivoOnline/listaEstados.php?co=&pe=&ci=&po=&nu=&cu=918&pr=0&en=0&fp=5&mi=&ti=&ve=';
	
}?>

 <div>
                             	<div style="padding: 7px 0px; text-align:center" ><?
                                
                                   //if($_GET['modalidade'] == 1 && ($_GET['cursoTipo'] == 1 )){?>

                                
                           	 		<a href="<?=$subdominio?>" target="_blank">
              							<button type="button" class="btn btn-primary" style="border-radius:0px; width:200px;">CONHEÇA O POLO</button>
             			 			</a><?
								  // }
									?>
                                </div>
                            </div><?



	
$conexao->Fechar();