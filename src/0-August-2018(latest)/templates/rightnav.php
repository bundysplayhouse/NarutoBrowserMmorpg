<?php
global $userrow;
include('funcoesinclusas.php');
//slots para backpack
for ($i = 1; $i < 5; $i ++){
if ($userrow["bp".$i] != "None"){
$varbackpack[$i] = explode(",",$userrow["bp".$i]);
$mostrar = "";
$pastadoslot = "";
if ($varbackpack[$i][2] > 3) {$pastadoslot = "drops/";}
if ($varbackpack[$i][3] == "X"){$varbackpack[$i][3] = "*";}
$varbackpack[$i][0] = conteudoexplic($varbackpack[$i][1], $varbackpack[$i][2], 'bp'.$i.'atr', $varbackpack[$i][3]);
if (!is_numeric($varbackpack[$i][1])) {$varbackpack[$i][1] .= $varbackpack[$i][2]; $pastadoslot = "";}
/*durabilidade
if ($varbackpack[$i][3] == "X"){$varbackpack[$i][3] = "INF";}
$mostrar .= " - Durabilidade: ".$varbackpack[$i][3];*/
$bpcodigo[$i] = "<a href=\"backpack.php?qual=$i\"><img src=\"layoutnovo/equipamentos/$pastadoslot".$varbackpack[$i][1].".gif\" width=\"34\" height=\"34\" hspace=\"0\" vspace=\"0\" border=\"0\" onmouseover=\"".$varbackpack[$i][0]."\" onmouseout=\"fecharexplic();\"  id=\"bp".$i."atr\"/></a>";}else{
$bpcodigo[$i] = "<img src=\"images/gif.gif\" width=\"34\" height=\"34\" hspace=\"0\" vspace=\"0\" border=\"0\"/>";}
}//fim for

//Jutsu de busca html
if ($userrow['jutsudebuscahtml'] == 1){
$jutsudebuscahtml = "<a href=\"mainmsg.php?do2=usarjutsubusca\" id=\"adm\" title=\"Jutsu Ocular\">Jutsu de Busca</a><br>";
}

//durabilidade
$durabm = explode(",",$userrow["durabilidade"]);
for ($i = 1; $i < 7; $i ++){
if ($durabm[$i] == "X"){$durabm[$i] = "*";}
}

//magiclist vazia
if ($userrow["magiclist"] == "None"){$userrow["magiclist"] = "Nenhum Jutsu.";}

//senjutsu olho
if ($userrow["senjutsuhtml"] == "fechado"){
	$olhosenjutsu = "<center><a href=\"senjutsu.php?do=usar\"><img src=\"images/olhos/".$userrow["senjutsuhtml"].".jpg\" border=\"0\" title=\"Ativar Senjutsu (1NP/3s)\"></a></center>";
}elseif($userrow["senjutsuhtml"] == "senjutsu"){
	include('funcoesinclusas.php');
	senjutsu();
	if ($userrow["currentnp"] == 0){$titulo = "Ativar Senjutsu (1NP/3s)";}else{$titulo = "Desativar Senjutsu";}
	$olhosenjutsu = "<center><a href=\"senjutsu.php?do=cancelar\"><img src=\"images/olhos/".$userrow["senjutsuhtml"].".jpg\" border=\"0\" title=\"$titulo\"></a></center>";
	

}

//atributo dos itens
$armaatr = conteudoexplic($userrow["weaponid"], '1', 'armaatr', $durabm[1]);	
$shieldatr = conteudoexplic($userrow["shieldid"], '3', 'shieldatr', $durabm[3]);	
$armoratr = conteudoexplic($userrow["armorid"], '2', 'armoratr', $durabm[2]);	
$slot1atr = conteudoexplic($userrow["slot1id"], '4', 'slot1atr', $durabm[4]);
$slot2atr = conteudoexplic($userrow["slot2id"], '4', 'slot2atr', $durabm[5]);
$slot3atr = conteudoexplic($userrow["slot3id"], '4', 'slot3atr', $durabm[6]);

//level bar
$lvlquery = doquery("SELECT ".$userrow['charclass']."_exp FROM {{table}} WHERE id='".$userrow['level']."'", "levels");
$lvlquery2 = doquery("SELECT ".$userrow['charclass']."_exp FROM {{table}} WHERE id='".($userrow['level'] + 1)."'", "levels");
$lvlrow = mysqli_fetch_array($lvlquery);
$lvlrow2 = mysqli_fetch_array($lvlquery2);
$xpproxlvl = $lvlrow2[$userrow['charclass']."_exp"] - $lvlrow[$userrow['charclass']."_exp"];
$porcconcluida = floor((($userrow['experience']  - $lvlrow[$userrow['charclass']."_exp"]) * 100) / $xpproxlvl);
$quantofaltaxp = $xpproxlvl - ($userrow['experience']  - $lvlrow[$userrow['charclass']."_exp"]);
$widthbar = round((155 * $porcconcluida)/100);
$barrahtml = "<div style=\"display: block; width:160px; height:37px\" onmouseover=\"explicdrop('qualquer', 'Dados do Level', 'XP Atual: ".$userrow['experience']."<br>XP P/ Lvl Up: ".$quantofaltaxp."<br>Porc. Conclu&iacute;da: ".$porcconcluida."%','1','1');\" onmouseout=\"fecharexplic();\"><div style=\"position: relative; z-index: 2;text-align: left\"><img src=\"images/levelbarin.jpg\" width=\"$widthbar\" height=\"36\"></div><div style=\"position: relative; z-index:3; top: -37px\"><img src=\"images/levelbar.png\" id=\"qualquer\"></div><div style=\"position: relative; top: -67px; z-index: 4;font-size: 15px;left: -30px;font-family: arial;\"><b><font color=\"#452202\">".$userrow['level']."</font></b></div></div>";




//Segunda imagem da arma
if (file_exists('layoutnovo/equipamentos/'.$userrow['weaponid'].'d.gif')){
	$segundaarmaimagem = '<a href="desequipar.php?qual=1"><img src="layoutnovo/equipamentos/'.$userrow['weaponid'].'d.gif" border="0" onMouseOver="'.$armaatr.'" onmouseout="fecharexplic();" id="armaatr"></a>';
}else{$segundaarmaimagem = '';}


//erro que tava dando

$template = <<<THEVERYENDOFYOU
<br><br>

<div style="position:relative; width:204px">
<div style="background-image: url(layoutnovo/buttons/personagem.png);height:97px;z-index:1"></div>
<div style="z-index:0;background-image: url(layoutnovo/buttons/meio.png)">
<div style="position:relative;padding-left:7px;padding-right:7px;top:-25px;z-index:2">



<center><a href="outros.php?do=avatar"><img src="layoutnovo/avatares/{{avatar}}.jpg" border="0" title="Selecionar Avatar"></a><br>
</center>$olhosenjutsu
<center><font color="#452708"><b>{{charname}}</b></font>$barrahtml</center>
<center><div onmouseover="explicdrop('qualquer', 'Barras de Status', '<center>' +
 '<div style=\'margin-top:0px;color:white;background-color:#780404;padding-top:3px;padding-left:3px;padding-right:3px;padding-bottom:3px;display:block\'>HP: {{currenthp}}/{{maxhp}}</div>' +
 '<div style=\'margin-top:0px;color:white;background-color:#024179;padding-top:3px;padding-left:3px;padding-right:3px;padding-bottom:3px;display:block\'>CH:  {{currentmp}}/{{maxmp}}</div>' +
  '<div style=\'margin-top:0px;color:white;background-color:#766402;padding-top:3px;padding-left:3px;padding-right:3px;padding-bottom:3px;display:block\'>TP: {{currenttp}}/{{maxtp}}</div>' +
   '<div style=\'margin-top:0px;color:white;background-color:#0d6504;padding-top:3px;padding-left:3px;padding-right:3px;padding-bottom:3px;display:block\'>NP: {{currentnp}}/{{maxnp}}</div>' +
    '<div style=\'margin-top:0px;color:white;background-color:#6f0576;padding-top:3px;padding-left:3px;padding-right:3px;padding-bottom:3px;display:block\'>EP: {{currentep}}/{{maxep}}</div></center>',
    '1','1')" onmouseout='fecharexplic();'>{{statbars}}</div></center>
<ul>
<div style="position:relative;left:-15px;">
<li/><a href="javascript:mostrarchar('{{charname}}')">Todos os Status</a>
<li/><a href="outroseatributos.php?do=atributos">Distribuir Pontos</a>
<li/><a href="treinamentoequests.php?do=quests">Painel de Miss&otilde;es</a>
<li/><a href="treinamentoequests.php?do=treinamento">Painel de Treinos</a></ul>
</div>



</div>
</div>
<div style="position:relative;top:-32px;z-index:1;background-image: url(layoutnovo/buttons/fim.png);height:51px;"></div>
</div>





<div style="position:relative; width:204px">
<div style="background-image: url(layoutnovo/buttons/inventario.png);height:97px;z-index:1"></div>
<div style="z-index:0;background-image: url(layoutnovo/buttons/meio.png)">
<div style="position:relative;padding-left:7px;padding-right:7px;top:-25px;z-index:2">



<center>
<div style="position:relative;background-image:url(layoutnovo/equipamentos/equipamentos.png);width:168px;height:116px;background-repeat:no-repeat">
<div style="position:absolute;top:14px;left:66px"><a href="desequipar.php?qual=3"><img src="layoutnovo/equipamentos/{{shieldid}}.gif" onMouseOver="$shieldatr" onmouseout="fecharexplic();" id="shieldatr" border="0"></a></div>
<div style="position:absolute;top:52px;left:29px"><a href="desequipar.php?qual=1"><img src="layoutnovo/equipamentos/{{weaponid}}.gif" border="0" onMouseOver="$armaatr" onmouseout="fecharexplic();" id="armaatr"></a></div>
<div style="position:absolute;top:52px;left:103px">$segundaarmaimagem</div>
<div style="position:absolute;top:52px;left:66px"><a href="desequipar.php?qual=2"><img src="layoutnovo/equipamentos/{{armorid}}.gif" border="0" onMouseOver="$armoratr" onmouseout="fecharexplic();" id="armoratr"></a></div>
</div>



<table border="5" cellspacing="0" 
cellpadding="0" background="layoutnovo/equipamentos/drops/fundo.png" style="background-repeat:no-repeat;;background-position:left top" width="128">
<tr height="3"></tr>
<tr><td height="34" style="width: 0px;"></td><td background="layoutnovo/equipamentos/drops/{{slot1id}}.gif" width="37" style="background-repeat:no-repeat;background-position:left top" ><a href="desequipar.php?qual=4"><img src="images/gif30.gif" onMouseOver="$slot1atr" onmouseout="fecharexplic();" id="slot1atr" border="0"></a></td><td background="layoutnovo/equipamentos/drops/{{slot2id}}.gif" width="37" style="background-repeat:no-repeat;background-position:left top"><a href="desequipar.php?qual=5"><img src="images/gif30.gif" onMouseOver="$slot2atr" onmouseout="fecharexplic();" id="slot2atr" border="0"></a></td><td background="layoutnovo/equipamentos/drops/{{slot3id}}.gif" width="35" style="background-repeat:no-repeat;background-position:left top"><a href="desequipar.php?qual=6"><img src="images/gif30.gif" onMouseOver="$slot3atr" onmouseout="fecharexplic();" id="slot3atr" border="0"></a></td><td></td></tr>
<tr height="4"><td colspan="7"></td></tr>
</table>
</center>

<table width="178">
<tr><td><img src="images/icon_weapon.gif" alt="Arma" title="Durabilidade: $durabm[1]" /></td><td width="100%">Arma: {{weaponname}}</td></tr>
<tr><td><img src="images/icon_armor.gif" alt="Colete" title="Durabilidade: $durabm[2]" /></td><td width="100%">Colete: {{armorname}}</td></tr>
<tr><td><img src="images/icon_shield.gif" alt="Bandana" title="Durabilidade: $durabm[3]" /></td><td width="100%">Bandana: {{shieldname}}</td></tr>
<tr><td><img src="images/orb.gif" alt="Item Adicional" title="Durabilidade: $durabm[4]" /></td><td width="100%">Slot 1: {{slot1name}}</td></tr>
<tr><td><img src="images/orb.gif" alt="Item Adicional" title="Durabilidade: $durabm[5]" /></td><td width="100%">Slot 2: {{slot2name}}</td></tr>
<tr><td><img src="images/orb.gif" alt="Item Adicional" title="Durabilidade: $durabm[6]" /></td><td width="100%">Slot 3: {{slot3name}}</td></tr>
</table>






</div>
</div>
<div style="position:relative;top:-32px;z-index:1;background-image: url(layoutnovo/buttons/fim.png);height:51px;"></div>
</div>







<div style="position:relative; width:204px">
<div style="background-image: url(layoutnovo/buttons/mochila.png);height:97px;z-index:1"></div>
<div style="z-index:0;background-image: url(layoutnovo/buttons/meio.png)">
<div style="position:relative;padding-left:7px;padding-right:7px;top:-25px;z-index:2">




<center><a href="javascript: menudrop('bp', 'Titulo', 'Testando conteudo', '1', '1')" ><img src="images/{{bpimagem}}.jpg" border="0" id="bp"></a><br>
<table border="0" cellpadding="0" cellspacing="0" width="170" height="10" background="images/bpslots.jpg">
<tr><td height="7" colspan="6"></td></tr>
<tr><td width="12"></td><td width="34" height="34">$bpcodigo[1]</td><td width="34" height="34">$bpcodigo[2]</td><td width="34" height="34">$bpcodigo[3]</td><td width="34" height="34">$bpcodigo[4]</td><td width="12"></td></tr>
</table>
</center>


</div>
</div>
<div style="position:relative;top:-32px;z-index:1;background-image: url(layoutnovo/buttons/fim.png);height:51px;"></div>
</div>






<div style="position:relative; width:204px">
<div style="background-image: url(layoutnovo/buttons/jutsus.png);height:97px;z-index:1"></div>
<div style="z-index:0;background-image: url(layoutnovo/buttons/meio.png)">
<div style="position:relative;padding-left:7px;padding-right:7px;top:-25px;z-index:2">


<center><img src="layoutnovo/menuslados/jutsu.png"></center>
$jutsudebuscahtml
{{magiclist}}
</div>
</div>
<div style="position:relative;top:-32px;z-index:1;background-image: url(layoutnovo/buttons/fim.png);height:51px;"></div>
</div>
THEVERYENDOFYOU;
?>