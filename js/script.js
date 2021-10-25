///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS DE BATALHA//
//////////////////////

//////////////////////////////////////////////////////////////////////////////


window.addEventListener("load", eventos_batalha);

function eventos_batalha() {
  $("#atacar").on("click", iniciar_batalha);
}

var intervalo;

function reiniciar() {
  location.reload();
}

function iniciar_batalha() {
  document.getElementById("atacar").disabled = true;
  document.getElementById("atacar").innerHTML = "Atacando"
  intervalo = setInterval(function (event) {
    var hp_1 = document.getElementById('hp_atual_1');
    var hp_2 = document.getElementById("hp_atual_2");
    combate(hp_1, hp_2);
  }, 1000);
}

function parar_batalha() {
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
        $('.gold').html("GOLD "+gold);
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
          'gold': gold,          
        }

        var dados = JSON.stringify(personagem);

        $.ajax({
          url: 'http://localhost/RPG/paginas/sql.php',
          type: 'POST',
          data: { data: dados, opcao: "levelup" },
          success: function (result) {
            console.log(result)
          }
        });
      } else {
        gold += lv_inimigo * 10;
        $('.gold').html("GOLD "+gold);
        ////////////////////////////////////////////////////////////////////////////////////////////
        //Aqui eu preciso atualizar as informações do banco de dados e atualizá-los na sessão php//
        //////////////////////////////////////////////////////////////////////////////////////////
        var personagem = {
          'xp': xp,
          'gold': gold,         
        }

        var dados = JSON.stringify(personagem);

        $.ajax({
          url: 'http://localhost/RPG/paginas/sql.php',
          type: 'POST',
          data: { data: dados, opcao: "levelup" },
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
    parar_batalha();
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
  $("#floresta").on("click", inimigos_floresta);
  $("#planice").on("click", inimigos_planice);
  $("#ice").on("click", inimigos_ice);
  $("#lava").on("click", inimigos_lava);
  $("#gruta").on("click", inimigos_gruta);
}

function exibir_dungeons() {
  $("#selecao_inimigo").show()
}

function inimigos_floresta() {

  $("#selecao_inimigo").show()

  $('.avatar_inimigo_selecao').hide()
  $("#Javali").show()
  $("#Urso").show()
  $("#Snake").show()

}

function inimigos_planice() {

  $("#selecao_inimigo").show()
  $('.avatar_inimigo_selecao').hide()
  $("#Goblin").show()
  $("#Orc").show()
  $("#Ogro").show()
}

function inimigos_ice() {

  $("#selecao_inimigo").show()
  $('.avatar_inimigo_selecao').hide()
  $("#Lobo").show()
  $("#Ice_Warrior").show()
  $("#Ice_King").show()
}

function inimigos_lava() {

  $("#selecao_inimigo").show()
  $('.avatar_inimigo_selecao').hide()
  $("#Drag").show()
  $("#Cerberus").show()
  $("#Demon").show()
}

function inimigos_gruta() {

  $("#selecao_inimigo").show()
  $('.avatar_inimigo_selecao').hide()
  $("#Blue_Drag").show()
  $("#Boss").show()
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
      url: 'http://localhost/RPG/paginas/sql.php',
      method: 'POST',
      data: { busca_nick: nick_buscado, opcao: "buscaarena" },
      dataType: 'json'
    }).done(function (result) {
      $('.avatar_batalha_inimigo').attr("name", result['classe_inimigo'])
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

  $('.slot').on("mouseover", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '5px solid grey');
    $(info).show();
  });

  $('.slot').on("mouseout", function (event) {
    var box = this.id
    var info = $(this).data("info");
    $('#'+box).css('border', '5px solid black')
    $(info).hide()
  });

  $('.slote').on("mouseover", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '2px solid grey');
    $(info).show();
  });

  $('.slote').on("mouseout", function (event) {
    var box = this.id
    var info = $(this).data("info");
    $('#'+box).css('border', '2px solid black')
    $(info).hide()
  });

  $('.slot').on("click", function (event) {
    event.preventDefault();
    var id_inventario = $(this).data("id_inventario")
    var box = this.id
      var equipar = confirm("Deseja equipar este item?")
      if (equipar == true) {
        $('.slot').css('border', '5px solid black');
        $('#'+box).css('border', '5px solid grey');
        $.ajax({
          url: 'http://localhost/RPG/paginas/sql.php',
          method: 'POST',
          data: { id_inventario: id_inventario, equipado: "N", opcao: "equipar" },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['atributos']['sta']
            str = result['atributos']['str']
            int = result['atributos']['int']
            dex = result['atributos']['dex']
            tipo = result['infos_item']['tipo']
            img = "http://localhost/rpg/visual/imagens/itens/" + result['infos_item']['imagem']
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
            $('#slote'+tipo).attr("src", img)
            $('#slote'+tipo).attr("class", "slote")
            location.reload();
          },
          error: function (result) {
            alert(JSON.stringify(result));
          }
        })
      }

  });


    $('.slote').on("click", function (event) {
      event.preventDefault();
      var id_equipamento = $(this).data("id_equipamento")
      equipar = confirm("Deseja desequipar este item?")
      if (equipar == true) {
        $.ajax({
          url: 'http://localhost/RPG/paginas/sql.php',
          method: 'POST',
          data: { id_equipamento: id_equipamento, equipado: "S", opcao: "desequipar" },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            sta = result['atributos']['sta']
            str = result['atributos']['str']
            int = result['atributos']['int']
            dex = result['atributos']['dex']
            tipo = result['infos_item']['tipo']
            img = "http://localhost/rpg/visual/imagens/itens/vazio.png"
            $("#sta_personagem").html("STA - " + sta)
            $("#str_personagem").html("STR - " + str)
            $("#int_personagem").html("INT - " + int)
            $("#dex_personagem").html("DEX - " + dex)
            $('#slote'+tipo).attr( "src", img)
            location.reload();
          },
          error: function (result) {
            alert(JSON.stringify(result));
          }
        })
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

  var ref_att = 0;

  var sucesso = 0;

  var falha = 0;

  var porcentagem_refinar = 0;

  var selecionado = false;

  var item_selecionado = 0;

  $('.slotf').on("mouseover", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '5px solid grey');
    $(info).show();
  });

  $('.slotf').on("mouseout", function (event) {
    var box = this.id
    var info = $(this).data("info");
    $('#'+box).css('border', '5px solid black');
    $(info).hide()
  });

  $('.slotf').on("click", function (event) {
    var box = this.id
    var id_inventario = $(this).data("id_inventario")
    var indice = $(this).data("indice")
    if (!selecionado || (selecionado && (item_selecionado != id_inventario || item_selecionado == 0))) {
      equipar = confirm("Deseja selecionar este item?")
      if (equipar == true) {
        $('#sucesso').html("");
        $('#falha').html("");
        $('#refinar_atual').width("0%");
        $('.slotf').css('border', '5px solid black');
        $.ajax({
          url: 'http://localhost/RPG/paginas/sql.php',
          method: 'POST',
          data: { id_inventario: id_inventario, equipado: "N", opcao: "forja" },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            nome = result['nome']
            imagem = result['imagem']
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            img = 'http://localhost/rpg/visual/imagens/itens/' + imagem
            ref_att = parseInt(result['ref'])
            id_inventario = result['id_inventario']
            equipado = result['equipado']
            $('.icone_item').attr("data-id_inventario", id_inventario)
            $('.icone_item').attr("data-equipado", equipado)
            $('.icone_item').attr("data-indice", indice)
            $('.icone_item').attr("name", result['nome'])
            $('.icone_item').attr( "src", img)
            $('#status_refinar').html("Chance de sucesso: "+Math.round(((100-ref_att*4)/100)**4*100)+"%")
            selecionado = true;
            item_selecionado = id_inventario;
          }
        })
      }
    }
    else {
      equipar = confirm("Deseja remover este item?")
      if (equipar == true) {
        $('#sucesso').html("");
        $('#falha').html("");
        $('#refinar_atual').width("0%");
        $('#'+box).css('border', '5px solid black');
        $.ajax({
          url: 'http://localhost/RPG/paginas/sql.php',
          method: 'POST',
          data: { id_inventario: id_inventario, equipado: "N", opcao: "forja" },
          dataType: 'json',
          success: function (result) {
            console.log(result)
            nome = result['nome']
            sta = result['sta']
            str = result['str']
            int = result['int']
            dex = result['dex']
            img = "http://localhost/rpg/visual/imagens/itens/vazio.png"
            ref_att = parseInt(result['ref'])
            id_inventario = result['id_inventario']
            equipado = result['equipado']
            $('.icone_item').attr("data-id_inventario", "")
            $('.icone_item').attr("data-equipado", "")
            $('.icone_item').attr("data-indice", "")
            $('.icone_item').attr("name", "")
            $('.icone_item').attr( "src", img)
            selecionado = false;
          }
        })
      }
    }
  });

  $('#botao_refinar').on("click", function (event) {
    var id_inventario = $('.icone_item').data("id_inventario")
    var equipado = $('.icone_item').data("equipado")
    if (selecionado == true)
    {
      var custo_refinar = (ref_att+1)*25
      comfirma_refinar = confirm("Deseja refinar este item?\n"+"Custo: "+custo_refinar)
      if (comfirma_refinar == true) {
        $('#botao_refinar').prop( "disabled", true );
        $.ajax({          
          url: 'http://localhost/RPG/paginas/sql.php',
          method: 'POST',
          data: {opcao: "custo", custo_refinar: custo_refinar, id_inventario: id_inventario},
          dataType: 'json',
          success: function (result) {
          $('.gold').html("GOLD "+(result['gold']));
          $('#sucesso').html("");
          $('#falha').html("");
          $('#refinar_atual').width("0%"); 
          $('#botao_refinar').prop( "disabled", true );         
          porcentagem_refinar = 0;
          sucesso = 0;
          falha = 0;
          if(result['custo_refinar']>result['gold_anterior']) alert("Gold Insuficiente!")
          else iniciar_refino(id_inventario,equipado)
          },error: function (result) {
            alert(JSON.stringify(result));
          }
        });
      }
    }  
    });

    function iniciar_refino(id_inventario,equipado)
    {
        refinando = setInterval(function (event) {
        var refinar_atual = $('#refinar_atual');        

        refinar(refinar_atual,id_inventario,equipado);
      }, 1000);
    }

    function refinar(refinar_atual,id_inventario,equipado)
    {
          var indice = $('.icone_item').data("indice")
          $('#sucesso').html("");
          $('#falha').html("");        
          var taxa_de_sucesso = 100;
          var dificuldade = 100-ref_att*4; 
          var chance_de_sucesso = Math.round(Math.random() * (taxa_de_sucesso - 1) + 1);
          if(chance_de_sucesso<=dificuldade){
            porcentagem_refinar += 25;
            sucesso +=1;
          }else falha +=1;

          refinar_atual.width(porcentagem_refinar + "%");

          if(sucesso == 4 || falha > 0)
          {
          if(sucesso == 4)
          {
            $.ajax({
              url: 'http://localhost/RPG/paginas/sql.php',
              method: 'POST',
              data: {id_inventario: id_inventario, equipado: equipado, ref: ref_att, opcao: "refinar"},
              dataType: 'json',
              success: function (result) {
                console.log(result)
                nome = result['nome']
                sta = result['sta']
                str = result['str']
                int = result['int']
                dex = result['dex']
                ref_att = parseInt(result['ref'])
                id_inventario = result['id_inventario']
                equipado = result['equipado']
                $('#ref_sta'+indice).html("STA - "+sta)
                $('#ref_str'+indice).html("STR - "+str)
                $('#ref_int'+indice).html("INT - "+int)
                $('#ref_dex'+indice).html("DEX - "+dex)
                $('#ref_ref'+indice).html("REF - "+ref_att)
                $('#status_refinar').html("Chance de sucesso: "+Math.round(((100-ref_att*4)/100)**4*100)+"%")
                $('#botao_refinar').prop( "disabled", false ); 
              },error: function (result) {
                alert(JSON.stringify(result));
              }
            })
            $('#sucesso').html("Item Refinado com sucesso!")
            $('#botao_refinar').prop( "disabled", false );
            parar_refino();
          }
          else{
            $('#falha').html("O fortalecimento falhou!")
            $('#botao_refinar').prop( "disabled", false );
            parar_refino();
          }
        }
    }
    
    function parar_refino() {
      clearInterval(refinando)
    }

    

}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS     MARKET//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", eventos_market)

function eventos_market() {

  var slots_compra = $("#comprar_item");
  slots_compra.show();

  var slots_venda = $("#vender_item");
  slots_venda.hide();

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

  $('.slotm').on("mouseover", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '5px solid grey');
    $(info).show();
  });

  $('.slotm').on("mouseout", function (event) {
    var box = this.id
    var info = $(this).data("info")
    $('#'+box).css('border', '5px solid black');
    $(info).hide();
  });

  $('.slotm').on("click", function (event) {
    var indice = $(this).data("indice")
    var id = this.id
    var id_inventario = $(this).data("id_inventario")
    if ($('#vendercomprar').html()=="Vender") var compra = confirm("Deseja comprar este item?")
    if ($('#vendercomprar').html()=="Comprar") var venda = confirm("Deseja vender este item?")
    if (compra == true || venda == true) {
      if (compra == true) var tipo = "c"
      else var tipo = "v"
      $.ajax({
        url: 'http://localhost/RPG/paginas/sql.php',
        method: 'POST',
        data: { id_item: slot[indice][0], id_inventario: id_inventario, valor: slot[indice][1], tipo: tipo, opcao: "market" },
        dataType: 'json',
        success: function (result) {
          $(".gold").html("GOLD "+result['gold']);    
          
          if (tipo == "c")
          {
          if(result['valor']>result['gold']) alert("Gold Insuficiente!")
          else location.reload();
          event.preventDefault();
          }
          if (tipo == "v")
          {
            
            $('#'+id).off('click');
            $('#'+id).attr( "src", "http://localhost/rpg/visual/imagens/itens/vazio.png")
            $('#'+id).attr("data-info", "")
            $('#'+id).attr("data-slot", "")
            $('#'+id).attr("data-id_inventario", "")
            $('#'+id).attr("data-indice", "")
            $('#'+id).attr("name", "")
            $('#'+id).attr("id", "")              
            $('#'+id).attr("class", "slot_empty")   
            $('.slot_empty').css('border', '5px solid black')            
            $('.informacoes_item').hide()
          }
          else{
             ///////////////////////////////////////////////////////////////
            //adicionar evento para adicionar imagem aos itens para venda//
          ////////////////////////////////////////////////////////////////
          }
        },
        error: function (result) {
          alert(JSON.stringify(result));
        }
      })
    }
  });

}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS   PERFIL//
//////////////////////

//////////////////////////////////////////////////////////////////////////////

window.addEventListener("load", alterar_senha)

function alterar_senha()
  {
  $('button').on("click", function (event) { 
  $('#alterar_senha').show();
  $('#opcoes_perfil').hide();    
  });
}

///////////////////////////////////////////////////////////////////////////////

//////////////////////
//SCRIPTS     TESTE//
////////////////////

//////////////////////////////////////////////////////////////////////////////

  function um(botao){
    $('#um').html("Dois")
    $('#um').attr('id',"dois")
    botao.attr('onclick', 'dois($(this));');
  }

  function dois(botao){
    $('#dois').html("Um")
    $('#dois').attr('id',"um")
    botao.attr('onclick', 'um($(this));');
  }
