///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS DE BATALHA//
//////////////////////

//////////////////////////////////////////////////////////////////////////////


window.addEventListener("load", eventos_batalha);

function eventos_batalha() {
  document.getElementById("atacar").addEventListener("click", iniciar);
}

var intervalo;

function reiniciar() {
  location.reload();
}

function iniciar() {
  document.getElementById("atacar").disabled = true;
  document.getElementById("atacar").innerHTML = "Atacando"
  intervalo = setInterval(function (event) {
    var hp_1 = document.getElementById('hp_atual_1');
    var hp_2 = document.getElementById("hp_atual_2");
    combate(hp_1, hp_2);
  }, 1000);
}

function parar() {
  clearInterval(intervalo)
}

function combate(hp_1, hp_2) {
  var valida_crit_personagem = (str_personagem >= int_personagem) ? str_personagem : int_personagem * 2;
  var valida_crit_inimigo = (str_inimigo >= int_inimigo) ? str_inimigo : int_inimigo * 2;
  var power = [];
  var dano = [];
  speed();
  calculo_dano();
  hp_batalha_inimigo -= dano['personagem'];
  hp_batalha_personagem -= dano['inimigo'];
  var porcentagem_hp_inimigo = hp_batalha_inimigo * 100 / hp_inimigo;
  var porcentagem_hp_personagem = hp_batalha_personagem * 100 / hp_personagem;
  if (porcentagem_hp_inimigo < 0) porcentagem_hp_inimigo = 0;
  if (porcentagem_hp_personagem < 0) porcentagem_hp_personagem = 0;
  if (power['personagem'] >= power['inimigo']) {
    (dano['personagem'] > valida_crit_personagem) ? (document.getElementById("relatorio").innerHTML += "Voce causou " + dano['personagem'] + " de dano critico!<br><hr>") : document.getElementById("relatorio").innerHTML += "Voce causou " + dano['personagem'] + " de dano.<br><hr>";
    hp_2.style.width = porcentagem_hp_inimigo + "%";
    if (porcentagem_hp_inimigo > 0) {
      (dano['inimigo'] > valida_crit_inimigo) ? (document.getElementById("relatorio").innerHTML += "Voce recebeu " + dano['inimigo'] + " de dano critico!<br><hr>") : (document.getElementById("relatorio").innerHTML += "Voce recebeu " + dano['inimigo'] + " de dano.<br><hr>");
      hp_1.style.width = porcentagem_hp_personagem + "%";
    }
  } else {
    (dano['inimigo'] > valida_crit_inimigo) ? (document.getElementById("relatorio").innerHTML += "Voce recebeu " + dano['inimigo'] + " de dano critico!<br><hr>") : (document.getElementById("relatorio").innerHTML += "Voce recebeu " + dano['inimigo'] + " de dano.<br><hr>");
    hp_1.style.width = porcentagem_hp_personagem + "%";
    if (porcentagem_hp_personagem > 0) {
      (dano['personagem'] > valida_crit_personagem) ? (document.getElementById("relatorio").innerHTML += "Voce causou " + dano['personagem'] + " de dano critico!<br><hr>") : document.getElementById("relatorio").innerHTML += "Voce causou " + dano['personagem'] + " de dano.<br><hr>";
      hp_2.style.width = porcentagem_hp_inimigo + "%";
    }
  }

  $winner = (power['personagem'] >= power['inimigo']) ? porcentagem_hp_personagem >= porcentagem_hp_inimigo : porcentagem_hp_personagem > porcentagem_hp_inimigo;

  if (porcentagem_hp_personagem == 0 || porcentagem_hp_inimigo == 0) {
    if ($winner == true) {
      document.getElementById("relatorio").innerHTML += "Voce derrotou seu inimigo <br>E ganhou " + xp_inimigo + " pontos de experiencia!<br>";
      xp += xp_inimigo;
      if (xp >= xp_max) {
        lv += 1;
        xp_atual = xp - xp_max;
        xp = xp_atual;
        xp_max = xp_max + 50 * lv;
        sta_personagem += sta_lv;
        str_personagem += str_lv;
        int_personagem += int_lv;
        dex_personagem += dex_lv;
        gold += lv_inimigo * 10;
        document.getElementById("relatorio").innerHTML += "Parabens! voce subiu para o nivel " + lv + "<br>";
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
          data: { data: dados },
          success: function (result) {
            console.log(result)
          }
        });
      } else {
        gold += lv_inimigo * 10;
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
          data: { data: dados },
          success: function (result) {
            console.log(result)
          }
        });

      }
    }
    else document.getElementById("relatorio").innerHTML += "Voce foi derrotado!<br>";
    document.getElementById("atacar").innerHTML = "Reiniciar"
    document.getElementById("atacar").disabled = false;
    document.getElementById("atacar").id = "reiniciar"
    document.getElementById("reiniciar").addEventListener("click", reiniciar);
    parar();
  }

  function calculo_dano() {

    var taxa = 100;
    var chance_crit_inimigo = Math.round(Math.random() * (taxa - 1) + 1);
    var chance_crit_personagem = Math.round(Math.random() * (taxa - 1) + 1);
    var taxa_crit_inimigo = dex_inimigo / 2;
    var taxa_crit_personagem = dex_personagem / 2;


    if (chance_crit_personagem <= taxa_crit_personagem) dano['personagem'] = (str_personagem > int_personagem) ? (str_personagem + dex_personagem * 2) : (int_personagem * 2 + dex_personagem);
    else (str_personagem >= int_personagem) ? (dano['personagem'] = str_personagem) : (dano['personagem'] = int_personagem * 2);

    if (chance_crit_inimigo <= taxa_crit_inimigo) dano['inimigo'] = (str_inimigo > int_inimigo) ? (str_inimigo + dex_inimigo * 2) : (int_inimigo * 2 + dex_inimigo);
    else (str_inimigo >= int_inimigo) ? (dano['inimigo'] = str_inimigo) : (dano['inimigo'] = int_inimigo * 2);

    return dano;

  }

  function speed() {

    power['personagem'] = sta_personagem + str_personagem + int_personagem + dex_personagem;
    power['inimigo'] = sta_inimigo + str_inimigo + int_inimigo + dex_inimigo;
    return power;

  }

}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS   DUNGEONS//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_dungeons);

function eventos_dungeons() {
  // document.getElementsByClassName("dungeon").addEventListener("click",exibir_dungeons);
  document.getElementById("floresta").addEventListener("click", inimigos_floresta);
  document.getElementById("planice").addEventListener("click", inimigos_planice);
  document.getElementById("ice").addEventListener("click", inimigos_ice);
  document.getElementById("lava").addEventListener("click", inimigos_lava);
  document.getElementById("gruta").addEventListener("click", inimigos_gruta);
}

function exibir_dungeons() {
  document.getElementById("selecao_inimigo").style.display = "block"
}

function inimigos_floresta() {

  document.getElementById("selecao_inimigo").style.display = "block"
  document.getElementById("Javali").style.display = "block"
  document.getElementById("Goblin").style.display = "none"
  document.getElementById("Urso").style.display = "block"
  document.getElementById("Snake").style.display = "block"
  document.getElementById("Orc").style.display = "none"
  document.getElementById("Ogro").style.display = "none"
  document.getElementById("Lobo").style.display = "none"
  document.getElementById("Ice_Warrior").style.display = "none"
  document.getElementById("Ice_King").style.display = "none"
  document.getElementById("Drag").style.display = "none"
  document.getElementById("Cerberus").style.display = "none"
  document.getElementById("Demon").style.display = "none"
  document.getElementById("Blue_Drag").style.display = "none"
  document.getElementById("Boss").style.display = "none"
}

function inimigos_planice() {

  document.getElementById("selecao_inimigo").style.display = "block"
  document.getElementById("Javali").style.display = "none"
  document.getElementById("Goblin").style.display = "block"
  document.getElementById("Urso").style.display = "none"
  document.getElementById("Snake").style.display = "none"
  document.getElementById("Orc").style.display = "block"
  document.getElementById("Ogro").style.display = "block"
  document.getElementById("Lobo").style.display = "none"
  document.getElementById("Ice_Warrior").style.display = "none"
  document.getElementById("Ice_King").style.display = "none"
  document.getElementById("Drag").style.display = "none"
  document.getElementById("Cerberus").style.display = "none"
  document.getElementById("Demon").style.display = "none"
  document.getElementById("Blue_Drag").style.display = "none"
  document.getElementById("Boss").style.display = "none"
}

function inimigos_ice() {

  document.getElementById("selecao_inimigo").style.display = "block"
  document.getElementById("Javali").style.display = "none"
  document.getElementById("Goblin").style.display = "none"
  document.getElementById("Urso").style.display = "none"
  document.getElementById("Snake").style.display = "none"
  document.getElementById("Orc").style.display = "none"
  document.getElementById("Ogro").style.display = "none"
  document.getElementById("Lobo").style.display = "block"
  document.getElementById("Ice_Warrior").style.display = "block"
  document.getElementById("Ice_King").style.display = "block"
  document.getElementById("Drag").style.display = "none"
  document.getElementById("Cerberus").style.display = "none"
  document.getElementById("Demon").style.display = "none"
  document.getElementById("Blue_Drag").style.display = "none"
  document.getElementById("Boss").style.display = "none"
}

function inimigos_lava() {

  document.getElementById("selecao_inimigo").style.display = "block"
  document.getElementById("Javali").style.display = "none"
  document.getElementById("Goblin").style.display = "none"
  document.getElementById("Urso").style.display = "none"
  document.getElementById("Snake").style.display = "none"
  document.getElementById("Orc").style.display = "none"
  document.getElementById("Ogro").style.display = "none"
  document.getElementById("Lobo").style.display = "none"
  document.getElementById("Ice_Warrior").style.display = "none"
  document.getElementById("Ice_King").style.display = "none"
  document.getElementById("Drag").style.display = "block"
  document.getElementById("Cerberus").style.display = "block"
  document.getElementById("Demon").style.display = "block"
  document.getElementById("Blue_Drag").style.display = "none"
  document.getElementById("Boss").style.display = "none"
}

function inimigos_gruta() {

  document.getElementById("selecao_inimigo").style.display = "block"
  document.getElementById("Javali").style.display = "none"
  document.getElementById("Goblin").style.display = "none"
  document.getElementById("Urso").style.display = "none"
  document.getElementById("Snake").style.display = "none"
  document.getElementById("Orc").style.display = "none"
  document.getElementById("Ogro").style.display = "none"
  document.getElementById("Lobo").style.display = "none"
  document.getElementById("Ice_Warrior").style.display = "none"
  document.getElementById("Ice_King").style.display = "none"
  document.getElementById("Drag").style.display = "none"
  document.getElementById("Cerberus").style.display = "none"
  document.getElementById("Demon").style.display = "none"
  document.getElementById("Blue_Drag").style.display = "block"
  document.getElementById("Boss").style.display = "block"
}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS      ARENA//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_arena);

function eventos_arena() {
  $('#buscar_arena').submit(function (e) {
    e.preventDefault();

    var nick_buscado = $('#busca_nick').val();

    $.ajax({
      url: 'http://localhost/RPG/paginas/buscaarena.php',
      method: 'POST',
      data: { busca_nick: nick_buscado },
      dataType: 'json'
    }).done(function (result) {
      $('.avatar_inimigo_batalha').attr("name", result['classe_inimigo'])
      nick_inimigo = result['nick_inimigo']
      sta_inimigo = result['sta_inimigo']
      str_inimigo = result['str_inimigo']
      int_inimigo = result['int_inimigo']
      dex_inimigo = result['dex_inimigo']
      lv_inimigo = result['lv_inimigo']
      hp_inimigo = sta_inimigo * 10;
      hp_batalha_inimigo = hp_inimigo;
    });
  });
}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS      ITENS//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_inventario)

function eventos_inventario() {

  // $(".slot").on("click",function (){
  //   var slot = $(this).data("slot")
  //   var info = $(this).data("info")
  //   alert(slot);
  //   alert(info);
  // })

  $('.slot').on("mouseover", function (event) {
    var slot = $(this).data("slot")
    var info = $(this).data("info")
    $(slot).css('border', '5px solid grey');
    $(info).show();
  });

  $('.slot').on("mouseout", function (event) {
    var slot = $(this).data("slot")
    var info = $(this).data("info")
    $(slot).css('border', '5px solid black');
    $(info).hide();
  });


  $('#sloti0').on("click", function (event) {
    if (slot[0][1] == "N") slot[0][1] = false
    if (slot[0][1] == false) {
      slot[0][1] = confirm("Deseja equipar este item?")
      if (slot[0][1] == true) {
        $(slot).css('border', '5px solid grey');
        slot[0][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[0][1] = "N";
    }
    else {
      slot[0][1] = confirm("Deseja desequipar este item?")
      if (slot[0][1] == true) {
        $('#sloti0').css('border', '5px solid black');
        slot[0][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[0][1] = "S";
    }
  });

  $('#sloti1').on("click", function (event) {
    if (slot[1][1] == "N") slot[1][1] = false
    if (slot[1][1] == false) {
      slot[1][1] = confirm("Deseja equipar este item?")
      if (slot[1][1] == true) {
        $('#sloti1').css('border', '5px solid grey');
        slot[1][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[1][1] = "N";
    }
    else {
      slot[1][1] = confirm("Deseja desequipar este item?")
      if (slot[1][1] == true) {
        $('#sloti1').css('border', '5px solid black');
        slot[1][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[1][1] = "S";
    }
  });

  $('#sloti2').on("click", function (event) {
    if (slot[2][1] == "N") slot[2][1] = false
    if (slot[2][1] == false) {
      slot[2][1] = confirm("Deseja equipar este item?")
      if (slot[2][1] == true) {
        $('#sloti2').css('border', '5px solid grey');
        slot[2][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[2][1] = "N";
    }
    else {
      slot[2][1] = confirm("Deseja desequipar este item?")
      if (slot[2][1] == true) {
        $('#sloti2').css('border', '5px solid black');
        slot[2][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[2][1] = "S";
    }
  });

  $('#sloti3').on("click", function (event) {
    if (slot[3][1] == "N") slot[3][1] = false
    if (slot[3][1] == false) {
      slot[3][1] = confirm("Deseja equipar este item?")
      if (slot[3][1] == true) {
        $('#sloti3').css('border', '5px solid grey');
        slot[3][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[3][1] = "N";
    }
    else {
      slot[3][1] = confirm("Deseja desequipar este item?")
      if (slot[3][1] == true) {
        $('#sloti3').css('border', '5px solid black');
        slot[3][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[3][1] = "S";
    }
  });

  $('#sloti4').on("click", function (event) {
    if (slot[4][1] == "N") slot[4][1] = false
    if (slot[4][1] == false) {
      slot[4][1] = confirm("Deseja equipar este item?")
      if (slot[4][1] == true) {
        $('#sloti4').css('border', '5px solid grey');
        slot[4][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[4][1] = "N";
    }
    else {
      slot[4][1] = confirm("Deseja desequipar este item?")
      if (slot[4][1] == true) {
        $('#sloti4').css('border', '5px solid black');
        slot[4][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[4][1] = "S";
    }
  });

  $('#sloti5').on("click", function (event) {
    if (slot[5][1] == "N") slot[5][1] = false
    if (slot[5][1] == false) {
      slot[5][1] = confirm("Deseja equipar este item?")
      if (slot[5][1] == true) {
        $('#sloti5').css('border', '5px solid grey');
        slot[5][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[5][1] = "N";
    }
    else {
      slot[5][1] = confirm("Deseja desequipar este item?")
      if (slot[5][1] == true) {
        $('#sloti5').css('border', '5px solid black');
        slot[5][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[5][1] = "S";
    }
  });

  $('#sloti6').on("click", function (event) {
    if (slot[6][1] == "N") slot[6][1] = false
    if (slot[6][1] == false) {
      slot[6][1] = confirm("Deseja equipar este item?")
      if (slot[6][1] == true) {
        $('#sloti6').css('border', '5px solid grey');
        slot[6][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[6][1] = "N";
    }
    else {
      slot[6][1] = confirm("Deseja desequipar este item?")
      if (slot[6][1] == true) {
        $('#sloti6').css('border', '5px solid black');
        slot[6][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[6][1] = "S";
    }
  });

  $('#sloti7').on("click", function (event) {
    if (slot[7][1] == "N") slot[7][1] = false
    if (slot[7][1] == false) {
      slot[7][1] = confirm("Deseja equipar este item?")
      if (slot[7][1] == true) {
        $('#sloti7').css('border', '5px solid grey');
        slot[7][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[7][1] = "N";
    }
    else {
      slot[7][1] = confirm("Deseja desequipar este item?")
      if (slot[7][1] == true) {
        $('#sloti7').css('border', '5px solid black');
        slot[7][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[7][1] = "S";
    }
  });

  $('#sloti8').on("click", function (event) {
    if (slot[8][1] == "N") slot[8][1] = false
    if (slot[8][1] == false) {
      slot[8][1] = confirm("Deseja equipar este item?")
      if (slot[8][1] == true) {
        $('#sloti8').css('border', '5px solid grey');
        slot[8][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[8][1] = "N";
    }
    else {
      slot[8][1] = confirm("Deseja desequipar este item?")
      if (slot[8][1] == true) {
        $('#sloti8').css('border', '5px solid black');
        slot[8][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[8][1] = "S";
    }
  });

  $('#sloti9').on("click", function (event) {
    if (slot[9][1] == "N") slot[9][1] = false
    if (slot[9][1] == false) {
      slot[9][1] = confirm("Deseja equipar este item?")
      if (slot[9][1] == true) {
        $('#sloti9').css('border', '5px solid grey');
        slot[9][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[9][1] = "N";
    }
    else {
      slot[9][1] = confirm("Deseja desequipar este item?")
      if (slot[9][1] == true) {
        $('#sloti9').css('border', '5px solid black');
        slot[9][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[9][1] = "S";
    }
  });

  $('#sloti10').on("click", function (event) {
    if (slot[10][1] == "N") slot[10][1] = false
    if (slot[10][1] == false) {
      slot[10][1] = confirm("Deseja equipar este item?")
      if (slot[10][1] == true) {
        $('#sloti10').css('border', '5px solid grey');
        slot[10][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[10][1] = "N";
    }
    else {
      slot[10][1] = confirm("Deseja desequipar este item?")
      if (slot[10][1] == true) {
        $('#sloti10').css('border', '5px solid black');
        slot[10][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[10][1] = "S";
    }
  });

  $('#sloti11').on("click", function (event) {
    if (slot[11][1] == "N") slot[11][1] = false
    if (slot[11][1] == false) {
      slot[11][1] = confirm("Deseja equipar este item?")
      if (slot[11][1] == true) {
        $('#sloti11').css('border', '5px solid grey');
        slot[11][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[11][1] = "N";
    }
    else {
      slot[11][1] = confirm("Deseja desequipar este item?")
      if (slot[11][1] == true) {
        $('#sloti11').css('border', '5px solid black');
        slot[11][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[11][1] = "S";
    }
  });

  $('#sloti12').on("click", function (event) {
    if (slot[12][1] == "N") slot[12][1] = false
    if (slot[12][1] == false) {
      slot[12][1] = confirm("Deseja equipar este item?")
      if (slot[12][1] == true) {
        $('#sloti12').css('border', '5px solid grey');
        slot[12][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[12][1] = "N";
    }
    else {
      slot[12][1] = confirm("Deseja desequipar este item?")
      if (slot[12][1] == true) {
        $('#sloti12').css('border', '5px solid black');
        slot[12][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[12][1] = "S";
    }
  });

  $('#sloti13').on("click", function (event) {
    if (slot[13][1] == "N") slot[13][1] = false
    if (slot[13][1] == false) {
      slot[13][1] = confirm("Deseja equipar este item?")
      if (slot[13][1] == true) {
        $('#sloti13').css('border', '5px solid grey');
        slot[13][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[13][1] = "N";
    }
    else {
      slot[13][1] = confirm("Deseja desequipar este item?")
      if (slot[13][1] == true) {
        $('#sloti13').css('border', '5px solid black');
        slot[13][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[13][1] = "S";
    }
  });

  $('#sloti14').on("click", function (event) {
    if (slot[14][1] == "N") slot[14][1] = false
    if (slot[14][1] == false) {
      slot[14][1] = confirm("Deseja equipar este item?")
      if (slot[14][1] == true) {
        $('#sloti14').css('border', '5px solid grey');
        slot[14][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[14][1] = "N";
    }
    else {
      slot[14][1] = confirm("Deseja desequipar este item?")
      if (slot[14][1] == true) {
        $('#sloti14').css('border', '5px solid black');
        slot[14][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[14][1] = "S";
    }
  });

}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS      FORJA//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_forja)

function eventos_forja() {

  $('#slotf0').on("click", function (event) {
    if (slot[0][1] == "N") slot[0][1] = false
    if (slot[0][1] == false) {
      slot[0][1] = confirm("Deseja selecionar este item?")
      if (slot[0][1] == true) {
        $('#slotf0').css('border', '5px solid grey');
        slot[0][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itensf.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            nome = result['nome']
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            ref = result['ref']
            $('.avatar_item').attr("name", result['nome'])
          }
        })
      } else slot[0][1] = "N";
    }
    else {
      slot[0][1] = confirm("Deseja remover este item?")
      if (slot[0][1] == true) {
        $('#slotf0').css('border', '5px solid black');
        slot[0][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itensf.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            nome = result['nome']
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            ref = result['ref']
            $('.avatar_item').attr("name", "")
          }
        })
      } else slot[0][1] = "S";
    }
  });

  $('#slotf1').on("click", function (event) {
    if (slot[1][1] == "N") slot[1][1] = false
    if (slot[1][1] == false) {
      slot[1][1] = confirm("Deseja selecionar este item?")
      if (slot[1][1] == true) {
        $('#slotf1').css('border', '5px solid grey');
        slot[1][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[1][1] = "N";
    }
    else {
      slot[1][1] = confirm("Deseja remover este item?")
      if (slot[1][1] == true) {
        $('#slotf1').css('border', '5px solid black');
        slot[1][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[1][1] = "S";
    }
  });

  $('#slotf2').on("click", function (event) {
    if (slot[2][1] == "N") slot[2][1] = false
    if (slot[2][1] == false) {
      slot[2][1] = confirm("Deseja selecionar este item?")
      if (slot[2][1] == true) {
        $('#slotf2').css('border', '5px solid grey');
        slot[2][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[2][1] = "N";
    }
    else {
      slot[2][1] = confirm("Deseja remover este item?")
      if (slot[2][1] == true) {
        $('#slotf2').css('border', '5px solid black');
        slot[2][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[2][1] = "S";
    }
  });

  $('#slotf3').on("click", function (event) {
    if (slot[3][1] == "N") slot[3][1] = false
    if (slot[3][1] == false) {
      slot[3][1] = confirm("Deseja selecionar este item?")
      if (slot[3][1] == true) {
        $('#slotf3').css('border', '5px solid grey');
        slot[3][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[3][1] = "N";
    }
    else {
      slot[3][1] = confirm("Deseja remover este item?")
      if (slot[3][1] == true) {
        $('#slotf3').css('border', '5px solid black');
        slot[3][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[3][1] = "S";
    }
  });

  $('#slotf4').on("click", function (event) {
    if (slot[4][1] == "N") slot[4][1] = false
    if (slot[4][1] == false) {
      slot[4][1] = confirm("Deseja selecionar este item?")
      if (slot[4][1] == true) {
        $('#slotf4').css('border', '5px solid grey');
        slot[4][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[4][1] = "N";
    }
    else {
      slot[4][1] = confirm("Deseja remover este item?")
      if (slot[4][1] == true) {
        $('#slotf4').css('border', '5px solid black');
        slot[4][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[4][1] = "S";
    }
  });

  $('#slotf5').on("click", function (event) {
    if (slot[5][1] == "N") slot[5][1] = false
    if (slot[5][1] == false) {
      slot[5][1] = confirm("Deseja selecionar este item?")
      if (slot[5][1] == true) {
        $('#slotf5').css('border', '5px solid grey');
        slot[5][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[5][1] = "N";
    }
    else {
      slot[5][1] = confirm("Deseja remover este item?")
      if (slot[5][1] == true) {
        $('#slotf5').css('border', '5px solid black');
        slot[5][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[5][1] = "S";
    }
  });

  $('#slotf6').on("click", function (event) {
    if (slot[6][1] == "N") slot[6][1] = false
    if (slot[6][1] == false) {
      slot[6][1] = confirm("Deseja selecionar este item?")
      if (slot[6][1] == true) {
        $('#slotf6').css('border', '5px solid grey');
        slot[6][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[6][1] = "N";
    }
    else {
      slot[6][1] = confirm("Deseja remover este item?")
      if (slot[6][1] == true) {
        $('#slotf6').css('border', '5px solid black');
        slot[6][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[6][1] = "S";
    }
  });

  $('#slotf7').on("click", function (event) {
    if (slot[7][1] == "N") slot[7][1] = false
    if (slot[7][1] == false) {
      slot[7][1] = confirm("Deseja selecionar este item?")
      if (slot[7][1] == true) {
        $('#slotf7').css('border', '5px solid grey');
        slot[7][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[7][1] = "N";
    }
    else {
      slot[7][1] = confirm("Deseja remover este item?")
      if (slot[7][1] == true) {
        $('#slotf7').css('border', '5px solid black');
        slot[7][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[7][1] = "S";
    }
  });

  $('#slotf8').on("click", function (event) {
    if (slot[8][1] == "N") slot[8][1] = false
    if (slot[8][1] == false) {
      slot[8][1] = confirm("Deseja selecionar este item?")
      if (slot[8][1] == true) {
        $('#slotf8').css('border', '5px solid grey');
        slot[8][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[8][1] = "N";
    }
    else {
      slot[8][1] = confirm("Deseja remover este item?")
      if (slot[8][1] == true) {
        $('#slotf8').css('border', '5px solid black');
        slot[8][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[8][1] = "S";
    }
  });

  $('#slotf9').on("click", function (event) {
    if (slot[9][1] == "N") slot[9][1] = false
    if (slot[9][1] == false) {
      slot[9][1] = confirm("Deseja selecionar este item?")
      if (slot[9][1] == true) {
        $('#slotf9').css('border', '5px solid grey');
        slot[9][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[9][1] = "N";
    }
    else {
      slot[9][1] = confirm("Deseja remover este item?")
      if (slot[9][1] == true) {
        $('#slotf9').css('border', '5px solid black');
        slot[9][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[9][1] = "S";
    }
  });

  $('#slotf10').on("click", function (event) {
    if (slot[10][1] == "N") slot[10][1] = false
    if (slot[10][1] == false) {
      slot[10][1] = confirm("Deseja selecionar este item?")
      if (slot[10][1] == true) {
        $('#slotf10').css('border', '5px solid grey');
        slot[10][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[10][1] = "N";
    }
    else {
      slot[10][1] = confirm("Deseja remover este item?")
      if (slot[10][1] == true) {
        $('#slotf10').css('border', '5px solid black');
        slot[10][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[10][1] = "S";
    }
  });

  $('#slotf11').on("click", function (event) {
    if (slot[11][1] == "N") slot[11][1] = false
    if (slot[11][1] == false) {
      slot[11][1] = confirm("Deseja selecionar este item?")
      if (slot[11][1] == true) {
        $('#slotf11').css('border', '5px solid grey');
        slot[11][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[11][1] = "N";
    }
    else {
      slot[11][1] = confirm("Deseja remover este item?")
      if (slot[11][1] == true) {
        $('#slotf11').css('border', '5px solid black');
        slot[11][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[11][1] = "S";
    }
  });

  $('#slotf12').on("click", function (event) {
    if (slot[12][1] == "N") slot[12][1] = false
    if (slot[12][1] == false) {
      slot[12][1] = confirm("Deseja selecionar este item?")
      if (slot[12][1] == true) {
        $('#slotf12').css('border', '5px solid grey');
        slot[12][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[12][1] = "N";
    }
    else {
      slot[12][1] = confirm("Deseja remover este item?")
      if (slot[12][1] == true) {
        $('#slotf12').css('border', '5px solid black');
        slot[12][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[12][1] = "S";
    }
  });

  $('#slotf13').on("click", function (event) {
    if (slot[13][1] == "N") slot[13][1] = false
    if (slot[13][1] == false) {
      slot[13][1] = confirm("Deseja selecionar este item?")
      if (slot[13][1] == true) {
        $('#slotf13').css('border', '5px solid grey');
        slot[13][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[13][1] = "N";
    }
    else {
      slot[13][1] = confirm("Deseja remover este item?")
      if (slot[13][1] == true) {
        $('#slotf13').css('border', '5px solid black');
        slot[13][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[13][1] = "S";
    }
  });

  $('#slotf14').on("click", function (event) {
    if (slot[14][1] == "N") slot[14][1] = false
    if (slot[14][1] == false) {
      slot[14][1] = confirm("Deseja selecionar este item?")
      if (slot[14][1] == true) {
        $('#slotf14').css('border', '5px solid grey');
        slot[14][1] = "S";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[14][1] = "N";
    }
    else {
      slot[14][1] = confirm("Deseja remover este item?")
      if (slot[14][1] == true) {
        $('#slotf14').css('border', '5px solid black');
        slot[14][1] = "N";
        $.ajax({
          url: 'http://localhost/RPG/paginas/itens.php',
          method: 'POST',
          data: { id_inventario: slot[0][0], equipado: slot[0][1] },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
          }
        })
      } else slot[14][1] = "S";
    }
  });

}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS     MARKET//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_market)

function eventos_market() {

  var slots_venda = $(".sloti");
  slots_venda.hide();

  var slots_compra = $(".slotm");
  slots_compra.show();

  $('#vendercomprar').on("click", function (event) {
    if ($('#vendercomprar').html() == 'Vender') {
      $('#vendercomprar').html("Comprar");
      slots_venda.show();
      slots_compra.hide();
    }
    else {
      $('#vendercomprar').html("Vender")
      slots_venda.hide();
      slots_compra.show();
    }
  });

  $('.sloti').on("mouseover", function (event) {
    var slot = $(this).data("slot")
    var info = $(this).data("info")
    $(slot).css('border', '5px solid grey');
    $(info).show();
  });

  $('.sloti').on("mouseout", function (event) {
    var slot = $(this).data("slot")
    var info = $(this).data("info")
    $(slot).css('border', '5px solid black');
    $(info).hide();
  });

  $('.slotm').on("mouseover", function (event) {
    var slot = $(this).data("slot")
    var info = $(this).data("info")
    $(slot).css('border', '5px solid grey');
    $(info).show();
  });

  $('.slotm').on("mouseout", function (event) {
    var slot = $(this).data("slot")
    var info = $(this).data("info")
    $(slot).css('border', '5px solid black');
    $(info).hide();
  });


  $('#slotm0').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[0][0], valor: slot[0][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          $(".gold").html("GOLD - "+result['gold']);
        },
        error: function (result) {
          alert(JSON.stringify(result));
        }
      })

    }
  });

  $('#slotm1').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[1][0], valor: slot[1][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm2').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[2][0], valor: slot[2][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm3').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[3][0], valor: slot[3][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm4').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[4][0], valor: slot[4][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm5').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[5][0], valor: slot[5][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm6').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[6][0], valor: slot[6][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm7').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[7][0], valor: slot[7][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm8').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[8][0], valor: slot[8][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm9').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[9][0], valor: slot[9][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm10').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[10][0], valor: slot[10][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm11').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[11][0], valor: slot[11][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm12').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[12][0], valor: slot[12][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm13').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[13][0], valor: slot[13][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm14').on("click", function (event) {
    var compra = confirm("Deseja comprar este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[14][0], valor: slot[14][1], tipo: 'c' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm15').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[15][0], valor: slot[15][1], id_inventario: slot[15][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
          $(".gold").html("GOLD - " + result['gold']);
          $('#slotm15').removeAttr('name');
          $('#slotm15').removeAttr('id');

        }
      })
    }
  });

  $('#slotm16').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[16][0], valor: slot[16][1], id_inventario: slot[16][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm17').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[17][0], valor: slot[17][1], id_inventario: slot[17][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm18').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[18][0], valor: slot[18][1], id_inventario: slot[18][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm19').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[19][0], valor: slot[19][1], id_inventario: slot[19][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm20').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[20][0], valor: slot[20][1], id_inventario: slot[20][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm21').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[21][0], valor: slot[21][1], id_inventario: slot[21][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm22').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[22][0], valor: slot[22][1], id_inventario: slot[22][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm23').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[23][0], valor: slot[23][1], id_inventario: slot[23][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm24').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[24][0], valor: slot[24][1], id_inventario: slot[24][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm25').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[25][0], valor: slot[25][1], id_inventario: slot[25][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm26').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[26][0], valor: slot[26][1], id_inventario: slot[26][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm27').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[27][0], valor: slot[27][1], id_inventario: slot[27][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm28').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[28][0], valor: slot[28][1], id_inventario: slot[28][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

  $('#slotm29').on("click", function (event) {
    var compra = confirm("Deseja vender este item?")
    if (compra == true) {
      $.ajax({
        url: 'http://localhost/RPG/paginas/itensm.php',
        method: 'POST',
        data: { id_item: slot[29][0], valor: slot[29][1], id_inventario: slot[29][2], tipo: 'v' },
        dataType: 'json',
        success: function (result) {
          console.log(result)
        }
      })
    }
  });

}


