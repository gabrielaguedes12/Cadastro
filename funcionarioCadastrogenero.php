<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
// require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = true;
$condicaoGravarOK = true;
$condicaoExcluirOK = true;

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

$page_title = "Gênero";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["configuracao"]["sub"]["usuarios"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Configurações"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Gênero</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuario" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>

                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">

                                                            <section class="col col-4">
                                                                <label class="label">Descrição</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="descricaoGenero" maxlength="255" name="descricaoGenero" class="required" type="text" placeholder=" " value="">
                                                                </label>
                                                            </section>

                                                        </div>
                                                    </fieldset>    
                                                </div>
                                            </div>
                                        </div>
                                        <footer>
                                            <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                                <span class="fa fa-trash"></span>
                                            </button>

                                            <button type="submited" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                                <span class="fa fa-floppy-o"></span>
                                            </button>
                                            <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                                <span class="fa fa-file-o"></span>
                                            </button>
                                            <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                                <span class="fa fa-backward "></span>
                                            </button>
                                        </footer>
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

<script src="<?php echo ASSETS_URL; ?>/js/businessFuncionarioGenero.js" type="text/javascript"></script>

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
<!-- <script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script> -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->



<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/inputMask/script.js"></script>

//mascaras

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        // $(".cpf").inputmask("999.999.999-99");
        // $(".dataNascimento").inputmask("99/99/9999");
        // $("#dataNascimento").on('change', function() {
        //     idade($("#dataNascimento").val());
        // });

        // $("#dataNascimento").on('focusout', function() {
        //     validaData()
        //     if (!validaData($("#dataNascimento").val())) {
        //         alert("Data Inválida,por favor tentar novamente.");
        //     }

        // });

        // $("#cpf").on('focusout', function() {
        //     validaCpf()
        // });

        // $("#cpf").on('change', function() {
        //     verificaCpf()
        // });

        carregaPagina();
    })

    //caixa de diálogo
    $('#dlgSimpleExcluir').dialog({
        autoOpen: false,
        width: 400,
        resizable: false,
        modal: true,
        title: 'Confirma Exclusão',
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
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir !", "error");
            $("#nome").focus();
            return;
        }

        if (id !== 0) {
            $('#dlgSimpleExcluir').dialog('open');
        }
    });

    $("#btnNovo").on("click", function() {
        novo();
    });

    $("#btnVoltar").on("click", function() {
        voltar();
    });;

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaFuncionario(idd);
            }
        }
        $("#nome").focus();

    }

    function novo() {
        $(location).attr('href', 'funcionarioCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'funcionarioFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFuncionario(id);
    }

    function gravar() {
        var id = +($("#codigo").val());
        var descricaoGenero = $("#descricaoGenero").val();
        gravaFuncionario(id,descricaoGenero);

        // var ativo = 0;
        // if ($("#ativo").is(':checked')) {
        //     ativo = 1;
        // }
        // var nome = $("#nome").val(); //pegando valor da variavel
        // var cpf = $("#cpf").val();
        // var dataNascimento = $("#dataNascimento").val();

        // if (nome == "") {
        //     smartAlert("Atenção", "Nome não preenchido.", "error")
        //     $("#nome").focus();
        //     return
        // }

        // if (cpf == "") {
        //     smartAlert("Atenção", "CPF não preenchido.", "error")
        //     cpf = $("#cpf").focus();
        //     return
        // }
        // if (dataNascimento == "") {
        //     smartAlert("Atenção", "Data de nascimento não preenchido.", "error")
        //     dataNascimento = $("#dataNascimento").focus();
        // }

    }

    //data na ordem e contagem de idade
    // function idade(dataNascimento) {
    //     const data = dataNascimento.split("/") //
    //     dataNascimento = data[1] + "-" + data[0] + "-" + data[2];
    //     const today = new Date();
    //     const birthDate = new Date(dataNascimento);
    //     let age = today.getFullYear() - birthDate.getFullYear();
    //     const m = today.getMonth() - birthDate.getMonth();

    //     if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    //         age--;
    //     }
    //     $("#idade").val(age)
    //     return age;
    // }

    // //data de nascimento válido
    // function validaData(dataNascimento) {

    //     var verificaData = document.getElementById('dataNascimento').value;
    //     var hoje = new Date().getFullYear().value;

    //     if (!/^\d{2}\/\d{2}\/\d{4}$/.test(dataNascimento)) {
    //         return false
    //     }

    //     //typeof é uma palavra-chave em JavaScript que retornará o tipo da variável quando você a chama
    //     if (typeof dataNascimento != 'string') {
    //         return false
    //     }

    //     //split é oq divide os algorismos em XX//X/XXXX
    //     const dataDiv = dataNascimento.split('/')
    //     const data = {
    //         dias: dataDiv[0],
    //         mes: dataDiv[1],
    //         ano: dataDiv[2]
    //     }

    //     //parseint --> para converter strings em número inteiro
    //     const dias = parseInt(data.dias)
    //     const mes = parseInt(data.mes)
    //     const ano = parseInt(data.ano)

    //     //dias para cada mês
    //     const dataDias = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

    //     //ano bissexto --> se o ano é múltiplo de 4 e 400, mas não é por 100
    //     if (ano % 400 == 0 || ano % 4 == 0 && ano % 100 != 0) {
    //         dataDias[2] == 29
    //     }

    //     if (hoje > new Date().getFullYear()) {
    //         return false;
    //     }

    //     //para restringir os meses de 1 a 12
    //     if (mes < 1 || mes > 12 || dias < 1) {
    //         return false
    //     }

    //     //para restringir número de dias no mês
    //     else if (dias > dataDias[mes]) {
    //         return false
    //     }

    //     return true
    // }

    // //validar cpf(exem: 111.111.111-11)
    // function validaCpf() {
    //     var cpf = $('#cpf').val()
    //     validarCpf(cpf)
    // }

    // //verificar se já foi cadastrado
    // function verificaCpf() {
    //     var cpf = $("#cpf").val()
    //     verificarCpf(cpf) //variável "passa" nesse ()
    // }
</script>