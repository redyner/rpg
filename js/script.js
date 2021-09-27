///////////////////////////////////////////////////////////////////////////////

                              //////////////////////
                             //SCRIPTS DE BATALHA//
                            //////////////////////

//////////////////////////////////////////////////////////////////////////////


window.addEventListener("load",eventos_batalha);

function eventos_batalha(){
document.getElementById("atacar").addEventListener("click",iniciar);
}

var intervalo;

function reiniciar(){
    location.reload();
}

function iniciar (){
    document.getElementById("atacar").disabled = true;
    document.getElementById("atacar").innerHTML = "Atacando"
    intervalo = setInterval(function(event){
        var hp_1 = document.getElementById('hp_atual_1');
        var hp_2 = document.getElementById("hp_atual_2");
        combate(hp_1,hp_2);
    },1000);
}

function parar(){
    clearInterval(intervalo)
}

function combate(hp_1,hp_2){
    var valida_crit_personagem = (str_personagem>=int_personagem) ? str_personagem : int_personagem*2;
    var valida_crit_inimigo = (str_inimigo>=int_inimigo) ? str_inimigo : int_inimigo*2;
    var power = [];
    var dano = [];
    speed();
    calculo_dano();
    hp_batalha_inimigo -= dano['personagem'];
    hp_batalha_personagem -= dano['inimigo'];
    var porcentagem_hp_inimigo = hp_batalha_inimigo*100/hp_inimigo;
    var porcentagem_hp_personagem = hp_batalha_personagem*100/hp_personagem;
    if (porcentagem_hp_inimigo<0) porcentagem_hp_inimigo = 0;
    if (porcentagem_hp_personagem<0) porcentagem_hp_personagem = 0;
    if (power['personagem']>=power['inimigo']) {
        (dano['personagem']>valida_crit_personagem) ? (document.getElementById("relatorio").innerHTML += "Voce causou "+dano['personagem']+" de dano critico!<br><hr>") : document.getElementById("relatorio").innerHTML += "Voce causou "+dano['personagem']+" de dano.<br><hr>";
        hp_2.style.width = porcentagem_hp_inimigo+"%";
        if (porcentagem_hp_inimigo>0) {
        (dano['inimigo']>valida_crit_inimigo) ? (document.getElementById("relatorio").innerHTML += "Voce recebeu "+dano['inimigo']+" de dano critico!<br><hr>") : (document.getElementById("relatorio").innerHTML += "Voce recebeu "+dano['inimigo']+" de dano.<br><hr>");
        hp_1.style.width = porcentagem_hp_personagem+"%";
        }
    }else{
        (dano['inimigo']>valida_crit_inimigo) ? (document.getElementById("relatorio").innerHTML += "Voce recebeu "+dano['inimigo']+" de dano critico!<br><hr>") : (document.getElementById("relatorio").innerHTML += "Voce recebeu "+dano['inimigo']+" de dano.<br><hr>");
        hp_1.style.width = porcentagem_hp_personagem+"%";
        if (porcentagem_hp_personagem>0) {
        (dano['personagem']>valida_crit_personagem) ? (document.getElementById("relatorio").innerHTML += "Voce causou "+dano['personagem']+" de dano critico!<br><hr>") : document.getElementById("relatorio").innerHTML += "Voce causou "+dano['personagem']+" de dano.<br><hr>";
        hp_2.style.width = porcentagem_hp_inimigo+"%";
        }
    }

    $winner = (power['personagem']>=power['inimigo']) ? porcentagem_hp_personagem>=porcentagem_hp_inimigo : porcentagem_hp_personagem>porcentagem_hp_inimigo;

    if(porcentagem_hp_personagem==0||porcentagem_hp_inimigo==0) {
    if($winner==true) {
        document.getElementById("relatorio").innerHTML += "Voce derrotou seu inimigo <br>E ganhou "+xp_inimigo+" pontos de experiencia!<br>";
        xp += xp_inimigo;  
        if (xp >= xp_max){
            lv += 1;
            xp_atual = xp - xp_max;  
            xp = xp_atual;
            xp_max = xp_max + 50 * lv;  
            sta_personagem += sta_lv;
            str_personagem += str_lv;
            int_personagem += int_lv;
            dex_personagem += dex_lv;
            gold += lv_inimigo*10;
            document.getElementById("relatorio").innerHTML += "Parabens! voce subiu para o nivel "+lv+"<br>";
////////////////////////////////////////////////////////////////////////////////////////////
//Aqui eu preciso atualizar as informações do banco de dados e atualizá-los na sessão php//
//////////////////////////////////////////////////////////////////////////////////////////
            var personagem = {
            'lv': lv,
            'xp': xp,
            'xp_max': xp_max,
            'sta_personagem': sta_personagem,
            'str_personagem': str_personagem,
            'int_personagem': int_personagem,
            'dex_personagem': dex_personagem,
            'xp_inimigo': xp_inimigo,
            'gold': gold
            }

            var dados = JSON.stringify(personagem);

            $.ajax({
            url: 'http://localhost/RPG/paginas/levelup.php',
            type: 'POST',
            data: {data: dados},
            success: function(result){
            console.log(result)
            }
            });
        }else{
            gold += lv_inimigo*10;
////////////////////////////////////////////////////////////////////////////////////////////
//Aqui eu preciso atualizar as informações do banco de dados e atualizá-los na sessão php//
//////////////////////////////////////////////////////////////////////////////////////////
var personagem = {
    'xp': xp,
    'gold': gold
  }

  var dados = JSON.stringify(personagem);

  $.ajax({
    url: 'http://localhost/RPG/paginas/levelup.php',
    type: 'POST',
    data: {data: dados},
    success: function(result){
      console.log(result)
    }
  });

        }
    }
    else document.getElementById("relatorio").innerHTML += "Voce foi derrotado!<br>";  
    document.getElementById("atacar").innerHTML = "Reiniciar"
    document.getElementById("atacar").disabled = false;
    document.getElementById("atacar").id = "reiniciar"
    document.getElementById("reiniciar").addEventListener("click",reiniciar);
    parar();
    }

    function calculo_dano(){

        var taxa = 100;
        var chance_crit_inimigo = Math.round(Math.random()*(taxa-1)+1);
        var chance_crit_personagem = Math.round(Math.random()*(taxa-1)+1);
        var taxa_crit_inimigo = dex_inimigo/2;
        var taxa_crit_personagem = dex_personagem/2;
        
        
        if(chance_crit_personagem<=taxa_crit_personagem) dano['personagem'] = (str_personagem>int_personagem) ? (str_personagem + dex_personagem * 2) : (int_personagem * 2 + dex_personagem);
        else (str_personagem>=int_personagem) ? (dano['personagem'] = str_personagem) : (dano['personagem'] = int_personagem * 2);
    
        if(chance_crit_inimigo<=taxa_crit_inimigo) dano['inimigo'] = (str_inimigo>int_inimigo) ? ( str_inimigo + dex_inimigo * 2) : (int_inimigo * 2 + dex_inimigo);
        else (str_inimigo>=int_inimigo) ? (dano['inimigo'] = str_inimigo) : (dano['inimigo'] = int_inimigo * 2);
    
        return dano;
    
    }

    function speed(){

       power['personagem'] = sta_personagem+str_personagem+int_personagem+dex_personagem;
       power['inimigo'] = sta_inimigo+str_inimigo+int_inimigo+dex_inimigo;
       return power;
    
    }

}

///////////////////////////////////////////////////////////////////////////////

                              //////////////////////
                             //SCRIPTS   DUNGEONS//
                            //////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load",eventos_dungeons);

function eventos_dungeons(){
// document.getElementsByClassName("dungeon").addEventListener("click",exibir_dungeons);
document.getElementById("floresta").addEventListener("click",inimigos_floresta);
document.getElementById("planice").addEventListener("click",inimigos_planice);
document.getElementById("ice").addEventListener("click",inimigos_ice);
document.getElementById("lava").addEventListener("click",inimigos_lava);
document.getElementById("gruta").addEventListener("click",inimigos_gruta);
}

function exibir_dungeons(){
document.getElementById("selecao_inimigo").style.display="block"
}

function inimigos_floresta(){

    document.getElementById("selecao_inimigo").style.display="block"
    document.getElementById("Javali").style.display="block"
    document.getElementById("Goblin").style.display="none"
    document.getElementById("Urso").style.display="block"
    document.getElementById("Snake").style.display="block"
    document.getElementById("Orc").style.display="none"
    document.getElementById("Ogro").style.display="none"
    document.getElementById("Lobo").style.display="none"
    document.getElementById("Ice_Warrior").style.display="none"
    document.getElementById("Ice_King").style.display="none"
    document.getElementById("Drag").style.display="none"
    document.getElementById("Cerberus").style.display="none"
    document.getElementById("Demon").style.display="none"
    document.getElementById("Blue_Drag").style.display="none"
    document.getElementById("Boss").style.display="none"
}

function inimigos_planice(){

    document.getElementById("selecao_inimigo").style.display="block"
    document.getElementById("Javali").style.display="none"
    document.getElementById("Goblin").style.display="block"
    document.getElementById("Urso").style.display="none"
    document.getElementById("Snake").style.display="none"
    document.getElementById("Orc").style.display="block"
    document.getElementById("Ogro").style.display="block"
    document.getElementById("Lobo").style.display="none"
    document.getElementById("Ice_Warrior").style.display="none"
    document.getElementById("Ice_King").style.display="none"
    document.getElementById("Drag").style.display="none"
    document.getElementById("Cerberus").style.display="none"
    document.getElementById("Demon").style.display="none"
    document.getElementById("Blue_Drag").style.display="none"
    document.getElementById("Boss").style.display="none"
}

function inimigos_ice(){

    document.getElementById("selecao_inimigo").style.display="block"
    document.getElementById("Javali").style.display="none"
    document.getElementById("Goblin").style.display="none"
    document.getElementById("Urso").style.display="none"
    document.getElementById("Snake").style.display="none"
    document.getElementById("Orc").style.display="none"
    document.getElementById("Ogro").style.display="none"
    document.getElementById("Lobo").style.display="block"
    document.getElementById("Ice_Warrior").style.display="block"
    document.getElementById("Ice_King").style.display="block"
    document.getElementById("Drag").style.display="none"
    document.getElementById("Cerberus").style.display="none"
    document.getElementById("Demon").style.display="none"
    document.getElementById("Blue_Drag").style.display="none"
    document.getElementById("Boss").style.display="none"
}

function inimigos_lava(){

    document.getElementById("selecao_inimigo").style.display="block"
    document.getElementById("Javali").style.display="none"
    document.getElementById("Goblin").style.display="none"
    document.getElementById("Urso").style.display="none"
    document.getElementById("Snake").style.display="none"
    document.getElementById("Orc").style.display="none"
    document.getElementById("Ogro").style.display="none"
    document.getElementById("Lobo").style.display="none"
    document.getElementById("Ice_Warrior").style.display="none"
    document.getElementById("Ice_King").style.display="none"
    document.getElementById("Drag").style.display="block"
    document.getElementById("Cerberus").style.display="block"
    document.getElementById("Demon").style.display="block"
    document.getElementById("Blue_Drag").style.display="none"
    document.getElementById("Boss").style.display="none"
}

function inimigos_gruta(){

    document.getElementById("selecao_inimigo").style.display="block"
    document.getElementById("Javali").style.display="none"
    document.getElementById("Goblin").style.display="none"
    document.getElementById("Urso").style.display="none"
    document.getElementById("Snake").style.display="none"
    document.getElementById("Orc").style.display="none"
    document.getElementById("Ogro").style.display="none"
    document.getElementById("Lobo").style.display="none"
    document.getElementById("Ice_Warrior").style.display="none"
    document.getElementById("Ice_King").style.display="none"
    document.getElementById("Drag").style.display="none"
    document.getElementById("Cerberus").style.display="none"
    document.getElementById("Demon").style.display="none"
    document.getElementById("Blue_Drag").style.display="block"
    document.getElementById("Boss").style.display="block"
}
    
///////////////////////////////////////////////////////////////////////////////

                              //////////////////////
                             //SCRIPTS      ARENA//
                            //////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load",eventos_arena);

function eventos_arena(){
$('#buscar_arena').submit(function(e){
    e.preventDefault();

    var nick_buscado = $('#busca_nick').val();

    $.ajax({
        url: 'http://localhost/RPG/paginas/buscaarena.php',
        method: 'POST',
        data: {busca_nick: nick_buscado},
        dataType: 'json'
    }).done(function(result){
        $('#busca_nick').val('');
        var inimigo = JSON.stringify(result);
        document.getElementById("relatorio").innerHTML += inimigo; 
    });
});
}

///////////////////////////////////////////////////////////////////////////////

                              //////////////////////
                             //SCRIPTS      ITENS//
                            //////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load",eventos_inventario)

function eventos_inventario(){

    var slot0 = $( "#info_slot0" );
    $( 'div[name="slot0"]' ).on( "mouseover", function( event ) {
      slot0.show();
    });

    var slot0 = $( "#info_slot0" );
    $( 'div[name="slot0"]').on( "mouseout", function( event ) {
      slot0.hide();
    });

    var slot1 = $( "#info_slot1" );
    $( 'div[name="slot1"]' ).on( "mouseover", function( event ) {
      slot1.show();
    });

    var slot1 = $( "#info_slot1" );
    $( 'div[name="slot1"]').on( "mouseout", function( event ) {
      slot1.hide();
    });

    var slot2 = $( "#info_slot2" );
    $( 'div[name="slot2"]' ).on( "mouseover", function( event ) {
      slot2.show();
    });

    var slot2 = $( "#info_slot2" );
    $( 'div[name="slot2"]').on( "mouseout", function( event ) {
      slot2.hide();
    });

    var slot3 = $( "#info_slot3" );
    $( 'div[name="slot3"]' ).on( "mouseover", function( event ) {
      slot3.show();
    });

    var slot3 = $( "#info_slot3" );
    $( 'div[name="slot3"]').on( "mouseout", function( event ) {
      slot3.hide();
    });

    var slot4 = $( "#info_slot4" );
    $( 'div[name="slot4"]' ).on( "mouseover", function( event ) {
      slot4.show();
    });

    var slot4 = $( "#info_slot4" );
    $( 'div[name="slot4"]').on( "mouseout", function( event ) {
      slot4.hide();
    });

    var slot5 = $( "#info_slot5" );
    $( 'div[name="slot5"]' ).on( "mouseover", function( event ) {
      slot5.show();
    });

    var slot5 = $( "#info_slot5" );
    $( 'div[name="slot5"]').on( "mouseout", function( event ) {
      slot5.hide();
    });

    var slot6 = $( "#info_slot6" );
    $( 'div[name="slot6"]' ).on( "mouseover", function( event ) {
      slot6.show();
    });

    var slot6 = $( "#info_slot6" );
    $( 'div[name="slot6"]').on( "mouseout", function( event ) {
      slot6.hide();
    });

    var slot7 = $( "#info_slot7" );
    $( 'div[name="slot7"]' ).on( "mouseover", function( event ) {
      slot7.show();
    });

    var slot7 = $( "#info_slot7" );
    $( 'div[name="slot7"]').on( "mouseout", function( event ) {
      slot7.hide();
    });

    var slot8 = $( "#info_slot8" );
    $( 'div[name="slot8"]' ).on( "mouseover", function( event ) {
      slot8.show();
    });

    var slot8 = $( "#info_slot8" );
    $( 'div[name="slot8"]').on( "mouseout", function( event ) {
      slot8.hide();
    });

    var slot9 = $( "#info_slot9" );
    $( 'div[name="slot9"]' ).on( "mouseover", function( event ) {
      slot9.show();
    });

    var slot9 = $( "#info_slot9" );
    $( 'div[name="slot9"]').on( "mouseout", function( event ) {
      slot9.hide();
    });

    var slot10 = $( "#info_slot10" );
    $( 'div[name="slot10"]' ).on( "mouseover", function( event ) {
      slot10.show();
    });

    var slot10 = $( "#info_slot10" );
    $( 'div[name="slot10"]').on( "mouseout", function( event ) {
      slot10.hide();
    });

    var slot11 = $( "#info_slot11" );
    $( 'div[name="slot11"]' ).on( "mouseover", function( event ) {
      slot11.show();
    });

    var slot11 = $( "#info_slot11" );
    $( 'div[name="slot11"]').on( "mouseout", function( event ) {
      slot11.hide();
    });

    var slot12 = $( "#info_slot12" );
    $( 'div[name="slot12"]' ).on( "mouseover", function( event ) {
      slot12.show();
    });

    var slot12 = $( "#info_slot12" );
    $( 'div[name="slot12"]').on( "mouseout", function( event ) {
      slot12.hide();
    });

    var slot13 = $( "#info_slot13" );
    $( 'div[name="slot13"]' ).on( "mouseover", function( event ) {
      slot13.show();
    });

    var slot13 = $( "#info_slot13" );
    $( 'div[name="slot13"]').on( "mouseout", function( event ) {
      slot13.hide();
    });

    var slot14 = $( "#info_slot14" );
    $( 'div[name="slot14"]' ).on( "mouseover", function( event ) {
      slot14.show();
    });

    var slot14 = $( "#info_slot14" );
    $( 'div[name="slot14"]').on( "mouseout", function( event ) {
      slot14.hide();
    });

    $( 'div[name="slot0"]' ).on( "click", function( event ) {
      if (slot[0][1] == "N") slot[0][1] = false
      if (slot[0][1] == false) {
        slot[0][1]  = confirm("Deseja equipar este item?")
        if (slot[0][1] == true) {
        $('div[name="slot0"]').css('border','5px solid red');
        slot[0][1] == "S"
        }else slot[0][1] = "N"
      }
      else {
        slot[0][1] = confirm("Deseja desequipar este item?")
        if (slot[0][1] == true) {
            $('div[name="slot0"]').css('border','5px solid black');
            slot[0][1] = "N";
        }else slot[0][1] = "S";
      }
    });

}




