<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = true;
$condicaoGravarOK = true;

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Funcionário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['cadastro']['sub']["funcionario"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">

    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Filtro"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Funcionário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuarioFiltro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseFiltro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Nome</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="nome" maxlength="255" name="nome" type="text" placeholder=" " value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input class="cpf" maxlength="20" id="cpf" type="text" placeholder="XXX.XXX.XXX-XX" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Data de nascimento-Inicial</label>
                                                                <label class="input">
                                                                    <input id="dataNascimentoInicial" name="dataInicial" type="text" placeholder="dd/mm/aaaa" class="datepicker" data-dateformat="dd/mm/yy" value="" data-mask="99/99/9999" data-mask-placeholder="_" style="text-align: center" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de nascimento-Final</label>
                                                                <label class="input">
                                                                    <input id="dataNascimentoFinal" name="dataFinal" type="text" placeholder="dd/mm/aaaa" class="datepicker" data-dateformat="dd/mm/yy" value="" data-mask="99/99/9999" data-mask-placeholder="_" style="text-align: center" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Estado Civil</label>
                                                                <label class="select">
                                                                    <select id="estadoCivil" name="estadoCivil">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, estadoCivil, ativo FROM dbo.estadoCivil WHERE ativo = 1 ORDER BY estadoCivil";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $estadoCivil = htmlspecialchars($row['estadoCivil'], ENT_QUOTES); //evitando caracteres especiais
                                                                            echo "<option value='$codigo'>$estadoCivil</option>";
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Gênero</label>
                                                                <label class="select">
                                                                    <select id="descricao" name="descricao">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao, ativo FROM dbo.genero WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $descricao = htmlspecialchars($row['descricao'], ENT_QUOTES); //evitando caracteres especiais
                                                                            echo "<option value='$codigo'>$descricao</option>";
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <footer>
                                        <?php if ($condicaoGravarOK) { ?>
                                            <button id="btnSearch" type="button" class="btn btn-primary pull-right" title="Buscar">
                                                <span class="fa fa-search"></span>
                                            </button>

                                            <button id="btnNovo" type="button" class="btn btn-primary pull-left" title="Novo">
                                                <span class="fa fa-file"></span>
                                            </button>

                                            <button type="button" id="btnPdf" class="btn btn-primary" aria-hidden="true" title="PDF" style="display:<?php echo $esconderBtnPdf ?>">
                                                <span class="fa fa-file-pdf-o"></span>
                                            </button>
                                        <?php } ?>
                                    </footer>

                                </form>
                            </div>
                            <div id="resultadoBusca">
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
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
<!--script src="<?php echo ASSETS_URL; ?>/js/businessTabelaBasica.js" type="text/javascript"></script-->
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


<script>
    $(document).ready(function() {
        $('#btnSearch').on("click", () => listarFiltro());
        $('#btnNovo').on("click", () => novo());
        $("#btnPdf").on("click", () => pdf());

        $(".cpf").inputmask("999.999.999-99");
        $(".dataNascimento").mask("99/99/9999");

        $("#cpf").on('focusout', campo => validarCpf(campo.currentTarget.value));
        //Inicial       
        $("#dataNascimentoInicial").on("change", function(campo) {
            var dataNascimentoInicial = campo.currentTarget.value;
            if (dataNascimentoInicial.length < 10) {
                $("#dataNascimentoInicial").val("");
            }
            if (validaDataInicial(dataNascimentoInicial) == false) {
                smartAlert("Atenção", "Data Inválida", "error");
                $("#dataNascimentoInicial").val("");
            }
        });
        //Final       
        $("#dataNascimentoFinal").on("change", function(campo) {
            var dataNascimentoFinal = campo.currentTarget.value;
            if (dataNascimentoFinal.length < 10) {
                $("#dataNascimentoFinal").val("");
            }
            if (validaDataFinal(dataNascimentoFinal) == false) {
                smartAlert("Atenção", "Data Inválida", "error");
                $("#dataNascimentoFinal").val("");
            }
        });

        document.getElementById("nome").onkeypress = function(e) {
            var chr = String.fromCharCode(e.which);
            if ("qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNMáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ       ".indexOf(chr) < 0)
                return false;
        };
        carregaPagina();
    });
    //funçoes
    function validarCpf(cpf) {
        $.ajax({
            url: 'js/sqlscopeFuncionarioCadastro.php',
            dataType: ' html',
            type: 'post',
            data: {
                funcao: 'validaCpf',
                cpf: cpf
            },
            success: function(data, textStatus) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];

                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                    } else {
                        smartAlert("Atenção", "CPF inválido", "error");
                        $('#cpf').val("");
                    }
                }
            },
            error: function(xhr, er) {
                //tratamento de erro
            }
        });
    }

    function validaDataInicial(dataNascimentoInicial) {
        var data = document.getElementById("dataNascimentoInicial").value; // pega o valor do input
        data = data.replace(/\//g, "-"); // substitui eventuais barras (ex. IE) "/" por hífen "-"
        var data_array = data.split("-"); // quebra a data em array

        // para o IE onde será inserido no formato dd/MM/yyyy
        if (data_array[0].length != 4) {
            data = data_array[2] + "-" + data_array[1] + "-" + data_array[0];
        }

        // compara as datas e calcula a idade
        var diaHoje = new Date();
        var nasc = new Date(data);
        var idade = diaHoje.getFullYear() - nasc.getFullYear();
        var m = diaHoje.getMonth() - nasc.getMonth();
        if (m < 0 || (m === 0 && diaHoje.getDate() < nasc.getDate()));

        if (nasc > diaHoje)
            // se for maior que 60 não vai acontecer nada!
            return false;
    }

    function validaDataFinal(dataNascimentoFinal) {
        var data = document.getElementById("dataNascimentoFinal").value; // pega o valor do input
        data = data.replace(/\//g, "-"); // substitui eventuais barras (ex. IE) "/" por hífen "-"
        var data_array = data.split("-"); // quebra a data em array

        // para o IE onde será inserido no formato dd/MM/yyyy
        if (data_array[0].length != 4) {
            data = data_array[2] + "-" + data_array[1] + "-" + data_array[0];
        }

        // compara as datas e calcula a idade
        var diaHoje = new Date();
        var nasc = new Date(data);
        var idade = diaHoje.getFullYear() - nasc.getFullYear();
        var m = diaHoje.getMonth() - nasc.getMonth();
        if (m < 0 || (m === 0 && diaHoje.getDate() < nasc.getDate()));

        if (nasc > diaHoje)
            // se for maior que 60 não vai acontecer nada!
            return false;
    }

    function listarFiltro() {
        var nome = $('#nome').val().trim();
        var cpf = $('#cpf').val();
        var dataNascimentoInicial = $('#dataNascimentoInicial').val();
        var dataNascimentoFinal = $('#dataNascimentoFinal').val();
        var estadoCivil = $('#estadoCivil').val();
        var descricao = $("#descricao").val();
        var ativo = $("#ativo").val();

        $('#resultadoBusca').load('funcionariofiltroListagem.php?', {
            nome: nome,
            cpf: cpf,
            dataNascimentoInicial: dataNascimentoInicial,
            dataNascimentoFinal: dataNascimentoFinal,
            estadoCivil: estadoCivil,
            descricao: descricao,
            ativo: ativo

        });
    }

    function novo() {
        $(location).attr('href', 'funcionarioCadastro.php');
    }

    function pdf() {
        // $(location).attr('href', 'pdfGeral.php');
        window.open('pdfgeral.php');

    }
</script>