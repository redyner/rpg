function alerta(){
    alert("Alerta Geral")
}
/*
function slot1_over(){
    document.getElementById("slot1").style.backgroundColor = 'red'
}

function slot1_out(){
    document.getElementById("slot1").style.backgroundColor = 'white'
}

function slot2_over(){
    document.getElementById("slot2").style.backgroundColor = 'blue'
}

function slot2_out(){
    document.getElementById("slot2").style.backgroundColor = 'white'
}

function slot3_over(){
    document.getElementById("slot3").style.backgroundColor = 'green'
}

function slot3_out(){
    document.getElementById("slot3").style.backgroundColor = 'white'
}

function slot4_over(){
    document.getElementById("slot4").style.backgroundColor = 'yellow'
}

function slot4_out(){
    document.getElementById("slot4").style.backgroundColor = 'white'
}

function slot5_over(){
    document.getElementById("slot5").style.backgroundColor = 'red'
}

function slot5_out(){
    document.getElementById("slot5").style.backgroundColor = 'white'
}

function slot6_over(){
    document.getElementById("slot6").style.backgroundColor = 'blue'
}

function slot6_out(){
    document.getElementById("slot6").style.backgroundColor = 'white'
}

function slot7_over(){
    document.getElementById("slot7").style.backgroundColor = 'green'
}

function slot7_out(){
    document.getElementById("slot7").style.backgroundColor = 'white'
}

function slot8_over(){
    document.getElementById("slot8").style.backgroundColor = 'yellow'
}

function slot8_out(){
    document.getElementById("slot8").style.backgroundColor = 'white'
}

function slot9_over(){
    document.getElementById("slot9").style.backgroundColor = 'red'
}

function slot9_out(){
    document.getElementById("slot9").style.backgroundColor = 'white'
}

function slot10_over(){
    document.getElementById("slot10").style.backgroundColor = 'blue'
}

function slot10_out(){
    document.getElementById("slot10").style.backgroundColor = 'white'
}

function slot11_over(){
    document.getElementById("slot11").style.backgroundColor = 'green'
}

function slot11_out(){
    document.getElementById("slot11").style.backgroundColor = 'white'
}

function slot12_over(){
    document.getElementById("slot12").style.backgroundColor = 'yellow'
}

function slot12_out(){
    document.getElementById("slot12").style.backgroundColor = 'white'
}

function slot13_over(){
    document.getElementById("slot13").style.backgroundColor = 'red'
}

function slot13_out(){
    document.getElementById("slot13").style.backgroundColor = 'white'
}

function slot14_over(){
    document.getElementById("slot14").style.backgroundColor = 'blue'
}

function slot14_out(){
    document.getElementById("slot14").style.backgroundColor = 'white'
}

function slot15_over(){
    document.getElementById("slot15").style.backgroundColor = 'green'
}

function slot15_out(){
    document.getElementById("slot15").style.backgroundColor = 'white'
}

function slot16_over(){
    document.getElementById("slot16").style.backgroundColor = 'yellow'
}

function slot16_out(){
    document.getElementById("slot16").style.backgroundColor = 'white'
}

function slot17_over(){
    document.getElementById("slot17").style.backgroundColor = 'red'
}

function slot17_out(){
    document.getElementById("slot17").style.backgroundColor = 'white'
}

function slot18_over(){
    document.getElementById("slot18").style.backgroundColor = 'blue'
}

function slot18_out(){
    document.getElementById("slot18").style.backgroundColor = 'white'
}

document.getElementById("slot1").addEventListener("mouseover",slot1_over)
document.getElementById("slot1").addEventListener("mouseout",slot1_out)

document.getElementById("slot2").addEventListener("mouseover",slot2_over)
document.getElementById("slot2").addEventListener("mouseout",slot2_out)

document.getElementById("slot3").addEventListener("mouseover",slot3_over)
document.getElementById("slot3").addEventListener("mouseout",slot3_out)

document.getElementById("slot4").addEventListener("mouseover",slot4_over)
document.getElementById("slot4").addEventListener("mouseout",slot4_out)

document.getElementById("slot5").addEventListener("mouseover",slot5_over)
document.getElementById("slot5").addEventListener("mouseout",slot5_out)

document.getElementById("slot6").addEventListener("mouseover",slot6_over)
document.getElementById("slot6").addEventListener("mouseout",slot6_out)

document.getElementById("slot7").addEventListener("mouseover",slot7_over)
document.getElementById("slot7").addEventListener("mouseout",slot7_out)

document.getElementById("slot8").addEventListener("mouseover",slot8_over)
document.getElementById("slot8").addEventListener("mouseout",slot8_out)

document.getElementById("slot9").addEventListener("mouseover",slot9_over)
document.getElementById("slot9").addEventListener("mouseout",slot9_out)

document.getElementById("slot10").addEventListener("mouseover",slot10_over)
document.getElementById("slot10").addEventListener("mouseout",slot10_out)

document.getElementById("slot11").addEventListener("mouseover",slot11_over)
document.getElementById("slot11").addEventListener("mouseout",slot11_out)

document.getElementById("slot12").addEventListener("mouseover",slot12_over)
document.getElementById("slot12").addEventListener("mouseout",slot12_out)

document.getElementById("slot13").addEventListener("mouseover",slot13_over)
document.getElementById("slot13").addEventListener("mouseout",slot13_out)

document.getElementById("slot14").addEventListener("mouseover",slot14_over)
document.getElementById("slot14").addEventListener("mouseout",slot14_out)

document.getElementById("slot15").addEventListener("mouseover",slot15_over)
document.getElementById("slot15").addEventListener("mouseout",slot15_out)

document.getElementById("slot16").addEventListener("mouseover",slot16_over)
document.getElementById("slot16").addEventListener("mouseout",slot16_out)

document.getElementById("slot17").addEventListener("mouseover",slot17_over)
document.getElementById("slot17").addEventListener("mouseout",slot17_out)

document.getElementById("slot18").addEventListener("mouseover",slot18_over)
document.getElementById("slot18").addEventListener("mouseout",slot18_out)

}
*/

window.addEventListener("load",informacoes_item)

function informacoes_item(){
    div = document.getElementById('informacoes_item');

    if(div.style.display == "none"){
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }

    //Event.preventDefault();
}

// function add_eventos(){

//     var slot = document.querySelectorAll("div.slot")
    
//     for(var i=0;i<slot.length;i++){
//     slot[i].addEventListener("click",alerta)
//     }
// }



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
    },2000);
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
    if (power['personagem']>power['inimigo']) {
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

    if(porcentagem_hp_personagem==0||porcentagem_hp_inimigo==0) {
    if(porcentagem_hp_personagem>porcentagem_hp_inimigo) document.getElementById("relatorio").innerHTML += "Parabens! Voce derrotou seu inimigo!<br>";
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

