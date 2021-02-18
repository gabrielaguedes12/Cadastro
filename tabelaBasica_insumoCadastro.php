<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de perminssão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('INSUMO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('INSUMO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('INSUMO_EXCLUIR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
  unset($_SESSION['login']);
  header("Location:login.php");
}
$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
  $esconderBtnGravar = "none";
}
$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
  $esconderBtnExcluir = "none";
}
/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Insumo";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['tabelaBasica']['sub']['Insumo']["active"] = true;
include("inc/nav.php");
?>

<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
  <?php
  //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
  //$breadcrumbs["New Crumb"] => "http://url.com"
  $breadcrumbs["Tabela Básica"] = "";
  include("inc/ribbon.php");
  ?>

  <!-- MAIN CONTENT -->
  <div id="content">

    <!-- widget grid -->
    <section id="widget-grid" class="">
      <!-- <div class="row" style="margin: 0 0 13px 0;">
                <?php if ($condicaoGravarOK) { ?>
                    <a class="btn btn-primary fa fa-file-o" aria-hidden="true" title="Novo" href="<?php echo APP_URL; ?>/cadastroInss.php" style="float:right"></a>
                <?php } ?>
            </div> -->

      <div class="row">
        <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
          <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
            <header>
              <span class="widget-icon"><i class="fa fa-cog"></i></span>
              <h2>Insumo
              </h2>
            </header>
            <div>
              <div class="widget-body no-padding">
                <form action="javascript:gravar()" class="smart-form client-form" id="formInss" method="post">
                  <div class="panel-group smart-accordion-default" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                            <i class="fa fa-lg fa-angle-up pull-right"></i>
                            Cadastro
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFiltro" class="panel-collapse collapse in">
                        <div class="panel-body no-padding">
                          <fieldset>
                            <input id="codigo" name="codigo" type="text" class="hidden">

                            <div class="row ">

                              <section class="col col-2">
                                <label class="label">Descrição</label>
                                <label class="input">
                                  <input id="descricao" name="descricao" style="text-align: right;" type="text" class="required" autocomplete="off" required>
                                </label>
                              </section>

                              <section class="col col-2">
                                <label class="label">Descrição</label>
                                <label class="input">
                                  <input id="valor" name="valor" style="text-align: right;" type="text" class="required" placeholder="00,00" autocomplete="off" required>
                                </label>
                              </section>

                            </div>
                          </fieldset>
                        </div>
                      </div>
                    </div>
                  </div>
                  <footer>
                    <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                      <span class="fa fa-trash"></span>
                    </button>
                    <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                      <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                        <span id="ui-id-2" class="ui-dialog-title">
                        </span>
                      </div>
                      <div id="dlgSimpleExcluir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                        <p>CONFIRMA A EXCLUSÃO ? </p>
                      </div>
                      <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                        <div class="ui-dialog-buttonset">
                        </div>
                      </div>
                    </div>
                    <button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                      <span class="fa fa-floppy-o"></span>
                    </button>
                    <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                      <span class="fa fa-file-o"></span>
                    </button>

                    <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                      <span class="fa fa-backward"></span>
                    </button>

                  </footer>
                </form>
              </div>

            </div>
          </div>
        </article>
      </div>
    </section>
    <!-- end widget grid -->
  </div>
  <!-- END MAIN CONTENT -->
</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>
<script src="<?php echo ASSETS_URL; ?>/js/business_tabelaBasicaInsumo.js" type="text/javascript"></script>
<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>


<script language="JavaScript" type="text/javascript">
  $(document).ready(function() {

    $('#valor').focusout(function() {
      var valor, element;
      element = $(this);
      element.unmask();
      valor = element.val().replace(/\D/g, '');
      if (valor.length > 3) {
        element.mask("99,9?9");
      } else {
        element.mask("9,99?9");
      }
    }).trigger('focusout');

    $('#dlgSimpleExcluir').dialog({
      autoOpen: false,
      width: 400,
      resizable: false,
      modal: true,
      title: "Atenção",
      buttons: [{
        html: "Excluir registro",
        "class": "btn btn-success",
        click: function() {
          $(this).dialog("close");
          excluir();
        }
      }, {
        html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
        "class": "btn btn-default",
        click: function() {
          $(this).dialog("close");
        }
      }]
    });


    $("#btnExcluir").on("click", function() {
      var id = $("#codigo").val();

      if (id === 0) {
        smartAlert("Atenção", "Selecione um registro para excluir !", "error");
        $("#descricao").focus();
        return;
      }

      if (id !== 0) {
        $('#dlgSimpleExcluir').dialog('open');
      }
    });



    $('#btnNovo').on("click", function() {
      $(location).attr('href', 'tabelaBasica_insumoCadastro.php');
    });
    $("#btnGravar").on("click", function() {
      gravar();
    });
    $("#btnVoltar").on("click", function() {
      voltar();
    });

    carregaInss();


  });

  function voltar() {
    $(location).attr('href', 'tabelaBasica_insumoFiltro.php');

  }

  function gravar() {

    //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
    $("#btnGravar").prop('disabled', true);

    var codigo = +$("#codigo").val();
    var descricao = $("#descricao").val();
    var valor = $("#valor").val();

    // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
    if (!valor) {
      smartAlert("Erro", "Informe o valor.", "error");
      return;
    }

    gravaInsumo(codigo, descricao, valor,
      function(data) {

        if (data.indexOf('sucess') < 0) {
          var piece = data.split("#");
          var mensagem = piece[1];
          if (mensagem !== "") {
            smartAlert("Atenção", mensagem, "error");
            return false;
          } else {
            smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
            return false;
          }
        } else {
          var piece = data.split("#");
          smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
          voltar();
        }
      }
    );
  }

  function excluir() {
    debugger;
    var id = parseInt($("#codigo").val());

    if (id === 0) {
      smartAlert("Atenção", "Selecione um registro para excluir!", "error");
      return;
    }

    excluirInsumo(id, function(data) {
      if (data.indexOf('failed') > -1) {
        var piece = data.split("#");
        var mensagem = piece[1];

        if (mensagem !== "") {
          smartAlert("Atenção", mensagem, "error");
        } else {
          smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
        }
        voltar();
      } else {
        smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
        voltar();
      }
    });
  }



  function carregaInsumo() {
    var urlx = window.document.URL.toString();
    var params = urlx.split("?");
    if (params.length === 2) {
      var id = params[1];
      var idx = id.split("=");
      var idd = idx[1];
      if (idd !== "") {
        recuperaInsumo(idd,
          function(data) {
            data = data.replace(/failed/g, '');
            var piece = data.split("#");

            //Atributos de Cliente
            var mensagem = piece[0];
            var out = piece[1];

            piece = out.split("^");
            console.table(piece);
            //Atributos de cliente 
            debugger;
            var codigo = parseInt(piece[0]);
            var descricao = piece[1];
            var valor = piece[2];

            //Atributos de cliente        
            $("#codigo").val(codigo);
            $("#descricao").val(descricao);
            $("#valor").val(valor);

          }

        );
      }
    }


  }
</script>