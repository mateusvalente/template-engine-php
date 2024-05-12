<h3> 
    <?=$teste?> 
    <if condition="$teste == 6"> 2222222 </if> 
    </h3> <h3 style="background-color: aquamarine;padding: 20px;">Show IF 6 ou 7 funciona</h3> </showIf> <showIf condition="$soma == 9 || $soma == 10"> <h3 style="background-color: aquamarine;padding: 20px;">Show IF 9 ou 10funciona</h3> <h3> <if condition="<?$teste == 2?>"> <label><?=$nome?></label><input type="password"/> <if condition="$teste == 3"> Show4 </if> </if> </h3> <? foreach ($people as $key=>$p) <? ?> <?=$p?> <foreach data="$carro:$c"> <?=$c?> </br> </endEach> </br> </br> <? ?> ?>