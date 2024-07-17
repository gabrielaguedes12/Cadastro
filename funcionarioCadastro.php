<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

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

$page_title = "Funcionário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["funcionario"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Cadastro"] = "";
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
                            <h2>Cadastro</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formUsuario" method="post"> <!-- remover o action-->

                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-1 hidden">
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Nome Completo</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="nome" maxlength="50" name="nome" class="required" type="text" value="" />
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input class="cpf" maxlength="20" id="cpf" type="text" class="required" placeholder="XXX.XXX.XXX-XX" value="" style="background-color: rgb(255, 255, 192);">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">RG</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input class="rg" maxlength="20" id="rg" type="text" class="required" placeholder="XX.XXX.XXX-X" value="" style="background-color: rgb(255, 255, 192);">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Data de Nascimento</label>
                                                                <label class="input"><i class="icon-prepend fa fa-calendar"></i>
                                                                    <input id="dataNascimento" name="dataNascimento" type="text" class="datepicker required" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" value="" data-mask="99/99/9999" data-mask-placeholder="XX/XX/XXXX" style="text-align: center" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">Idade</label>
                                                                <label class="input">
                                                                    <input id="idade" name="idade" maxlength="2" type="text" class="readonly">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Estado Civil</label>
                                                                <label class="select">
                                                                    <select id="estadoCivil" name="estadoCivil" class="required">
                                                                        <option hidden select > Selecione </option>
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
                                                                    </select>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Gênero</label>
                                                                <label class="select">
                                                                    <select id="descricao" name="descricao" class="required">
                                                                        <option hidden select>Selecione</option>
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
                                                                    </select>
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Primeiro emprego</label>
                                                                <label class="select">
                                                                    <select id="emprego" name="emprego" class="required" onpaste="return false" ondrop="return">
                                                                        <option hidden select>Selecione</option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">PIS/PASEP</label>
                                                                <label class="input">
                                                                    <input id="pis" name="pis" maxlength="20" type="text" placeholder="XXX. XXXXX. XX-X">
                                                                </label>
                                                            </section>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="" id="accordionContato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Contato
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseContato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset class="col col-6">
                                                        <div id="formTelefone">
                                                            <input type="" id="jsonTelefone" value="[]" hidden>
                                                            <div class="row">
                                                                <input type="" id="sequencialTel" name="sequencialTel" value="" hidden>
                                                                <input type="" id="telefoneId" name="telefoneId" value="" hidden>
                                                                <section class="col col-4">
                                                                    <label class="label">Telefone</label>
                                                                    <label class="input"><i class="icon-prepend fa fa-phone"></i>
                                                                        <input id="telefone" maxlength="15" name="telefone" class="required" placeholder="(XX) XXXXX-XXXX" value="">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label id="labelPrincipal" class="checkbox">
                                                                        <input checked="checked" id="principal" name="principal" type="checkbox" value="true"><i></i>
                                                                        Principal
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label id="labelWhats" class="checkbox">
                                                                        <input checked="checked" id="whats" name="whats" type="checkbox" value="true"><i></i>
                                                                        Whatsapp
                                                                    </label>
                                                                </section>

                                                                <section class="col col-md-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <button id="btnAddTelefone" type="button" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>

                                                                    <button id="btnRemoverTelefone" type="button" class="btn btn-danger">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableTelefone" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-center" style="min-width: 500%;">Telefone</th>
                                                                        <th class="text-center" style="min-width: 500%;">Principal</th>
                                                                        <th class="text-center" style="min-width: 500%;">Whatsapp</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </fieldset>

                                                    <fieldset class="col col-6">
                                                        <div id="formEmail">
                                                            <input type="" id="jsonEmail" value="[]" hidden>
                                                            <div class="row">
                                                                <input type="" id="sequencialEmail" name="sequencialEmail" value="" hidden>
                                                                <input type="" id="emailId" name="emailId" value="" hidden>
                                                                <section class="col col-6">
                                                                    <label class="label">E-mail</label>
                                                                    <label class="input"><i class="icon-prepend fa fa-envelope"></i>
                                                                        <input id="email" maxlength="255" name="email" class="required" placeholder="seuEmail@gmail.com" value="" type="email">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label id="labelPrincipalEmail" class="checkbox">
                                                                        <input checked="checked" id="principalEmail" name="principalEmail" type="checkbox" value="true"><i></i>
                                                                        Principal
                                                                    </label>
                                                                </section>

                                                                <section class="col col-md-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <button id="btnAddEmail" type="button" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>

                                                                    <button id="btnRemoverEmail" type="button" class="btn btn-danger">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>

                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableEmail" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-center" style="min-width: 500%;">Email</th>
                                                                            <th class="text-center" style="min-width: 500%;">Principal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEndereço" class="" id="accordionEndereço">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Endereço
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseEndereço" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <section class="col col-2">
                                                            <label class="label">CEP</label>
                                                            <label class="input"><i class="icon-prepend fa fa-home"></i>
                                                                <input class="cep" maxlength="10" id="cep" type="text" class="required" placeholder="XXXXX-XXX" value="" style="background-color: rgb(255, 255, 192);">
                                                            </label>
                                                            </fildset>
                                                        </section>
                                                        <section class="col col-2">
                                                            <label class="label">Logradouro</label>
                                                            <label class="input"><i class="icon-prepend fa fa-home"></i>
                                                                <input id="logradouro" maxlength="50" name="logradouro" class="required" type="text" placeholder=" " value="">
                                                            </label>
                                                        </section>

                                                        <section class="col col-1">
                                                            <label class="label">Número</label>
                                                            <label class="input"><i class="icon-prepend fa fa-home"></i>
                                                                <input id="numero" maxlength="6" name="numero" class="" type="text" placeholder=" " value="">
                                                            </label>
                                                        </section>

                                                        <section class="col col-3">
                                                            <label class="label">Complemento</label>
                                                            <label class="input"><i class="icon-prepend fa fa-home"></i>
                                                                <input id="complemento" maxlength="255" name="complemento" class="" type="text" placeholder=" " value="">
                                                            </label>
                                                        </section>

                                                        <section class="col col-1">
                                                            <label class="label">UF</label>
                                                            <label class="input">
                                                                <input id="uf" name="uf" maxlength="2" type="text" class="required">
                                                            </label>
                                                        </section>

                                                        <section class="col col-2">
                                                            <label class="label">Bairro</label>
                                                            <label class="input"><i class="icon-prepend fa fa-home"></i>
                                                                <input id="bairro" maxlength="50" name="bairro" class="required" type="text" placeholder=" " value="">
                                                            </label>
                                                        </section>

                                                        <section class="col col-3">
                                                            <label class="label">Cidade</label>
                                                            <label class="input"><i class="icon-prepend fa fa-home"></i>
                                                                <input id="cidade" maxlength="50" name="cidade" class="required" type="text" placeholder=" " value="">
                                                            </label>
                                                        </section>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDependente" class="" id="accordionDependente">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dependente
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseDependente" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>

                                                        <section class="col col-3">
                                                            <label class="label">Nome Completo</label>
                                                            <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                <input id="nomeDependentes" maxlength="50" name="nome" type="text" value="" />
                                                            </label>

                                                        </section>

                                                        <section class="col col-2">
                                                            <label class="label">CPF</label>
                                                            <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                <input class="cpfDependentes" maxlength="20" id="cpf" type="text" placeholder="XXX.XXX.XXX-XX" value="">
                                                            </label>
                                                        </section>

                                                        <section class="col col-2">
                                                            <label class="label">Data de Nascimento</label>
                                                            <label class="input"><i class="icon-prepend fa fa-calendar"></i>
                                                                <input id="dataNascimentoDependentes" name="dataNascimento" type="text" class="datepicker" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" value="" data-mask="99/99/9999" data-mask-placeholder="XX/XX/XXXX" style="text-align: center" autocomplete="off">
                                                            </label>
                                                        </section>

                                                        <section class="col col-2">
                                                            <label class="label">Tipo</label>
                                                            <label class="select">
                                                                <select id="dependentes" name="dependentes">
                                                                    <option hidden select value> Selecione </option>
                                                                    <option></option>
                                                                    <?php
                                                                    $reposit = new reposit();
                                                                    $sql = "SELECT codigo, dependentes, ativo FROM dbo.dependentes WHERE ativo = 1 ORDER BY dependentes";
                                                                    $result = $reposit->RunQuery($sql);
                                                                    foreach ($result as $row) {
                                                                        $codigo = (int) $row['codigo'];
                                                                        $dependentes = htmlspecialchars($row['dependentes'], ENT_QUOTES); //evitando caracteres especiais

                                                                        echo "<option value='$codigo'>$dependentes</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </label>
                                                        </section>

                                                        <section class="col col-md-2">
                                                            <label class="label">&nbsp;</label>
                                                            <button id="btnAddDependentes" type="button" class="btn btn-primary">
                                                                <i class="fa fa-plus"></i>
                                                            </button>

                                                            <button id="btnRemoverDependentes" type="button" class="btn btn-danger">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </section>

                                                        <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableDependente" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-center">Dependente</th>
                                                                        <th class="text-center">CPF</th>
                                                                        <th class="text-center" style="width: 25%;">Data de nascimento</th>
                                                                        <th class="text-center">Tipo</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
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
                                            <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnNovo ?>">
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

<script src="<?php echo ASSETS_URL; ?>/js/businessFuncionarioCadastro.js" type="text/javascript"></script>

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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        jsonEmailArray = JSON.parse($("#jsonEmail").val());
        // jsonDependentesArray = JSON.parse($("#jsonDependentes").val());

        //mascaras
        $(".cpf").mask("999.999.999-99");
        $(".rg").mask("99.999.999-9");
        $(".dataNascimento").mask("99/99/9999"); //classe--> geral
        $("#cep").mask("99999-999");
        $("#pis").mask("999.99999.99-9");
        $(".cpfDependentes").mask("999.999.999-99");
        $(".dataNascimentoDependentes").mask("99/99/9999");


        //funçoes
        $("#cpf").on('focusout', function() {
            validaCpf()
            // if (!validaCpf($("#cpf").val())) {
            //     smartAlert("Atenção", "CPF Inválido,por favor tentar novamente.", "error");
            //     $('#cpf').val("");
            // 
        });

        $("#cpf").on('change', function() {
            verificaCpf()
            // if (!verificaCpf($("#cpf").val())) {
            //     smartAlert("Atenção", "CPF já cadastrado,por favor tentar novamente.", "error");
            //     $('#cpf').val("");
            // }
        });


        $(".rg").on('change', function() {
            verificaRg()

        });
       
        $("#dataNascimento").on('change', function() {
            idade($("#dataNascimento").val());
        });

        $("#dataNascimento").on('focusout', function() {
            validaData()
            if (!validaData($("#dataNascimento").val())) {
                smartAlert("Atenção", "Data Inválida,por favor tentar novamente.", "error");
                $('#dataNascimento').val("");
            }
        });

        //id--> input unico

        //mascara celular e telefone
        var SPMaskBehavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00000';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

        $('#telefone').mask(SPMaskBehavior, spOptions);

        //------------- caixa de check-------------//
        $("#principalEmail").prop('checked', false);
        $("#principal").prop('checked', false);
        $("#whats").prop('checked', false);

        //cep
        $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro").val("...");
                    $("#uf").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro").val(dados.logradouro);
                            $("#uf").val(dados.uf);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });

        //condição com readondly
        $('#emprego').on("change", campo => +campo.currentTarget.value ? $('#pis').addClass("readonly").attr("disabled", true).val("") : $('#pis').removeClass("readonly").attr("disabled", false))

        carregaPagina();
    })

    //---------------->não permitir caracteres especiais e numeros<------------------//
    document.getElementById("nome").onkeypress = function(e) {
        var chr = String.fromCharCode(e.which);
        if ("qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNMáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ       ".indexOf(chr) < 0)
            return false;
    };
    //------------------------------>BOTÕES<--------------------------//
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
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
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
    });

    $("#btnGravar").on("click", function() {
        gravar();
    });

    //telefone
    $('#btnAddTelefone').on("click", function() {
        validaTelefone();
        adicionaTelefone();
    });


    $('#btnRemoverTelefone').on("click", function() {
        excluirContato();
    });

    //Email
    $('#btnAddEmail').on("click", function() {
        validaEmail();
        formataEmail();
        
    })

    $('#btnRemoverEmail').on("click", function() {
        excluirEmail()
    })



    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaFuncionario(idd);
                fillTableEmail();
                fillTableTelefone();
                // fillTableDependentes();
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
        //cadastro
        var id = +($("#codigo").val());
        var ativo = $("#ativo").val();
        var nome = $("#nome").val(); //pegando valor da variavel
        var cpf = $("#cpf").val();
        var rg = $("#rg").val();
        var dataNascimento = $("#dataNascimento").val();
        var estadoCivil = $("#estadoCivil").val();
        var descricao = $("#descricao").val();
        var emprego = $("#emprego").val();
        var pis = $("#pis").val();


        //contato
        var telefone = $("#telefone").val();
        var email = $("#email").val();

        //endereço
        var cep = $("#cep").val();
        var logradouro = $("#logradouro").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();
        var uf = $("#uf").val();
        var bairro = $("#bairro").val();
        var cidade = $("#cidade").val();


        if (nome == "") {
            smartAlert("Atenção", "Nome não preenchido.", "error")
            nome = $("#nome").focus();
            return
        }

        if (cpf == "") {
            smartAlert("Atenção", "CPF não preenchido.", "error")
            cpf = $("#cpf").focus();
            return
        }
        if (rg == "") {
            smartAlert("Atenção", "RG não preenchido.", "error")
            rg = $("#rg").focus();
            return
        }
        if (dataNascimento == "") {
            smartAlert("Atenção", "Data de nascimento não preenchido.", "error")
            dataNascimento = $("#dataNascimento").focus();
        }
        if (estadoCivil == "") {
            smartAlert("Atenção", "Estado Civil não preenchido.", "error")
            estadoCivil = $("#estadoCivil").focus();
        }
        if (descricao == "") {
            smartAlert("Atenção", "Gênero não preenchido.", "error")
            descricao = $("#descricao").focus();
        }

        if (emprego == "") {
            smartAlert("Atenção", "Primeiro emprego não preenchido.", "error")
            emprego = $("#emprego").focus();
        }

        if (cep == "") {
            smartAlert("Atenção", "CEP não preenchido.", "error")
            cep = $("#cep").focus();
        }

        if (logradouro == "") {
            smartAlert("Atenção", "Logradouro não preenchido.", "error")
            logradouro = $("#logradouro").focus();
        }

        if (uf == "") {
            smartAlert("Atenção", "UF não preenchido.", "error")
            uf = $("#uf").focus();
        }

        if (bairro == "") {
            smartAlert("Atenção", "Bairro não preenchido.", "error")
            bairro = $("#bairro").focus();
        }

        if (cidade == "") {
            smartAlert("Atenção", "Cidade não preenchido.", "error")
            cidade = $("#cidade").focus();
        }
        gravaFuncionario(id, ativo, nome, cpf, rg, dataNascimento, estadoCivil, descricao, jsonTelefoneArray, jsonEmailArray, emprego, pis, cep, logradouro, numero, complemento, uf, bairro, cidade);
    }

    //------------------>valida data e idade<---------------//
    //data na ordem e contagem de idade
    function idade(dataNascimento) {
        const data = dataNascimento.split("/") //
        dataNascimento = data[1] + "-" + data[0] + "-" + data[2];
        const today = new Date();
        const birthDate = new Date(dataNascimento);
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        $("#idade").val(age)
        return age;
    }

    //data de nascimento válido
    function validaData(dataNascimento) {

        var verificaData = document.getElementById('dataNascimento').value;
        var hoje = new Date().getFullYear().value;

        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(dataNascimento)) {
            return false
        }

        //typeof é uma palavra-chave em JavaScript que retornará o tipo da variável quando você a chama
        if (typeof dataNascimento != 'string') {
            return false
        }

        //split é oq divide os algorismos em XX//X/XXXX
        const dataDiv = dataNascimento.split('/')
        const data = {
            dias: dataDiv[0],
            mes: dataDiv[1],
            ano: dataDiv[2]
        }

        //parseint --> para converter strings em número inteiro
        const dias = parseInt(data.dias)
        const mes = parseInt(data.mes)
        const ano = parseInt(data.ano)

        //dias para cada mês
        const dataDias = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

        //ano bissexto --> se o ano é múltiplo de 4 e 400, mas não é por 100
        if (ano % 400 == 0 || ano % 4 == 0 && ano % 100 != 0) {
            dataDias[2] == 29
        }
        
        
       
        if (ano > new Date().getFullYear()) {
            return false;
        }

        //para restringir os meses de 1 a 12
        if (mes < 1 || mes > 12 || dias < 1) {
            return false
        }

        //para restringir número de dias no mês
        else if (dias > dataDias[dias]) {
            return false
        }

        return true
    }

    //---------------->validação cpf e rg<-------------------//
    //validar cpf(exem: 111.111.111-11)
    function validaCpf() {
        var cpf = $('#cpf').val()
        validarCpf(cpf)
    }

    //verificar se já foi cadastrado
    function verificaCpf() {
        var cpf = $('#cpf').val()
        verificarCpf(cpf) //variável "passa" nesse ()
    }

    //verificar se já foi cadastrado
    function verificaRg() {
        var rg = $('#rg').val()
        verificarRg(rg)
    }

    //------------------------------->TELEFONE<----------------------------------//
    function mascaraTelefone() {
        var telefone = $('#telefone').val()
    }

    function validaTelefone() {
        var adicionado = false;
        var existePrincipal = false;
        var telefone = $('#telefone').val();
        var sequencial = +$('#sequencialTel').val();
        var valido = false;
        var telMarcado = 0;

        if ($("#principal").is(':checked') === true) {
            telMarcado = 1;
        }
        if (telefone === '') {
            smartAlert("Erro", "Informe um telefone", "error");
            return false;
        }

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telMarcado === 1) {
                if ((jsonTelefoneArray[i].principal === 1) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    existePrincipal = true;
                    break;
                }
            }
            if ((jsonTelefoneArray[i].telefone === telefone) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                adicionado = true;
                break;
            }
        }
        if (adicionado === true) {
            smartAlert("Erro", "Telefone já adicionado", "error");
            clearFormTelefone();
            return false;
        }
        if ((existePrincipal === true) && (telMarcado === 1)) {
            smartAlert("Erro", "Já existe um telefone principal", "error");
            clearFormTelefone();
            return false;
        }
        return true;
    }

    //adiciona telefone
    function adicionaTelefone() {

        var item = $("#formTelefone").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataTel
        });

        if (item["sequencialTel"] === '') {
            if (jsonTelefoneArray.length === 0) {
                item["sequencialTel"] = 1;
            } else {
                item["sequencialTel"] = Math.max.apply(Math, jsonTelefoneArray.map(function(o) {
                    return o.sequencialTel;
                })) + 1;
            }
            item["telefoneId"] = 0;
        } else {
            item["sequencialTel"] = +item["sequencialTel"];
        }

        $('#telefone').val("");

        var index = -1;
        $.each(jsonTelefoneArray, function(i, obj) {
            if (+$('#sequencialTel').val() === obj.sequencialTel) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTelefoneArray.splice(index, 1, item);
        else
            jsonTelefoneArray.push(item);

        $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
        fillTableTelefone();
        clearFormTelefone();

    }

    //append-> adicionar um elemento no final da lista
    function fillTableTelefone() {
        $("#tableTelefone tbody").empty();

        for (var i = 0; i < jsonTelefoneArray.length; i++) {
            if (jsonTelefoneArray[i].telefone !== null && jsonTelefoneArray[i].telefone != '') {

                var row = $('<tr />');

                let auxPrincipal = 'Não';

                if (jsonTelefoneArray[i].principal === 1) {
                    auxPrincipal = 'Sim'
                }

                let auxWhats = 'Não';

                if (jsonTelefoneArray[i].whats === 1) {
                    auxWhats = 'Sim'
                }


                $("#tableTelefone tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTelefoneArray[i].sequencialTel + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaTelefone(' + jsonTelefoneArray[i].sequencialTel + ');">' + jsonTelefoneArray[i].telefone + '</td>'));

                row.append($('<td class="text-nowrap">' + auxPrincipal + '</td>'));
                row.append($('<td class="text-nowrap">' + auxWhats + '</td>'));
            }
        }
    }

    //processar e adicionar mascara
    function processDataTel(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "telefone")) {
            var valTelefone = $("#telefone").val();
            if (valTelefone !== '') {
                fieldName = "telefone";
            }
            return {
                name: fieldName,
                value: valTelefone
            };
        }
        if (fieldName !== '' && (fieldId === "principal")) {
            var principal = 0;
            if ($("#principal").is(':checked') === true) {
                principal = 1;
            }
            return {
                name: fieldName,
                value: principal
            };
        }
        if (fieldName !== '' && (fieldId === "whats")) {
            var whats = 0;
            if ($("#whats").is(':checked') === true) {
                whats = 1;
            }
            return {
                name: fieldName,
                value: whats
            };
        }

        return false;
    }

    function carregaTelefone(sequencialTel) {
        var arr = jQuery.grep(jsonTelefoneArray, function(item, i) {
            return (item.sequencialTel === sequencialTel);
        });

        clearFormTelefone();
        if (arr.length > 0) {
            var item = arr[0];
            $("#sequencialTel").val(item.sequencialTel);
            $("#telefoneId").val(item.telefoneId);
            $("#telefone").val(item.telefone);
        }
    }

    function clearFormTelefone() {
        $("#sequencialTel").val("");
        $("#telefoneId").val("");
        $("#telefone").val("");
        return true;
    }

    function excluirContato() {
        var arrSequencial = [];
        $('#tableTelefone input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
                var obj = jsonTelefoneArray[i];
                if (jQuery.inArray(obj.sequencialTel, arrSequencial) > -1) {
                    jsonTelefoneArray.splice(i, 1);
                }
            }
            $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
            fillTableTelefone();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 telefone para excluir.", "error");
    }


    //--------------------------------------------------------------->EMAIL<----------------------------------------------------------//
    function formataEmail() {
        var email = $('#email').val();
        var er = new RegExp(/^[A-Za-z0-9-.]+@[A-Za-z0-9-.]{2,}.[A-Za-z0-9]{2,}(.[A-Za-z0-9])?/);

        if (!er.test(email)) {
            smartAlert("Erro", "Email Inválido!", "error");
            clearFormEmail();           
            return false;
        } else {
            adicionaEmail();
        }
    }

    function validaEmail() {
        var cadastrado = false;
        var existePrincipal = false;
        var email = $('#email').val();
        var sequencial = +$('#sequencialEmail').val();
        var valido = false;
        var emailmarcado = 0;

        if ($("#principalEmail").is(':checked') === true) {
            emailmarcado = 1;
        }
        if (email === '') {
            smartAlert("Erro", "Informe um email.", "error");
            return false;
        }

        for (i = jsonEmailArray.length - 1; i >= 0; i--) {
            if (emailmarcado === 1) {
                if ((jsonEmailArray[i].principalEmail === 1) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
                    existePrincipal = true;
                    break;
                }
            }
            if ((jsonEmailArray[i].email === email) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
                cadastrado = true;
                break;
            }
        }
        if (cadastrado === true) {
            smartAlert("Erro", "Email já cadastrado", "error");
            clearFormEmail();
            return false;
        }
        if ((existePrincipal === true) && (emailmarcado === 1)) {
            smartAlert("Erro", "Já existe um email principal", "error");
            clearFormEmail();
            return false;
        }
        return true;
    }

    function adicionaEmail() {

        var item = $("#formEmail").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataEmail
        });


        if (item["sequencialEmail"] === '') {
            if (jsonEmailArray.length === 0) {
                item["sequencialEmail"] = 1;
            } else {
                item["sequencialEmail"] = Math.max.apply(Math, jsonEmailArray.map(function(o) {
                    return o.sequencialEmail;
                })) + 1;
            }
            item["emailId"] = 0;
        } else {
            item["sequencialEmail"] = +item["sequencialEmail"];
        }

        // formataEmail();
        $('#email').val("");

        var index = -1;
        $.each(jsonEmailArray, function(i, obj) {
            if (+$('#sequencialEmail').val() === obj.sequencialEmail) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEmailArray.splice(index, 1, item);
        else
            jsonEmailArray.push(item);

        $("#jsonEmail").val(JSON.stringify(jsonEmailArray));

        fillTableEmail();
        clearFormEmail();
    }

    function fillTableEmail() {
        $("#tableEmail tbody").empty();

        for (var i = 0; i < jsonEmailArray.length; i++) {
            if (jsonEmailArray[i].email !== null && jsonEmailArray[i].email != '') {
                var row = $('<tr />');
                let auxPrincipalEmail = 'Não';

                if (jsonEmailArray[i].principalEmail === 1) {
                    auxPrincipalEmail = 'Sim';
                }

                $("#tableEmail tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEmailArray[i].sequencialEmail + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaEmail(' + jsonEmailArray[i].sequencialEmail + ');">' + jsonEmailArray[i].email + '</td>'));
                row.append($('<td class="text-nowrap">' + auxPrincipalEmail + '</td>'));

            }
        }
    }

    function processDataEmail(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "email")) {
            var valEmail = $("#email").val();
            if (valEmail !== '') {
                fieldName = "email";
            }
            return {
                name: fieldName,
                value: valEmail
            };
        }
        if (fieldName !== '' && (fieldId === "principalEmail")) {
            var principalEmail = 0;
            if ($("#principalEmail").is(':checked') === true) {
                principalEmail = 1;
            }
            return {
                name: fieldName,
                value: principalEmail
            };
        }
        return false;
    }

    function carregaEmail(sequencialEmail) {
        var arr = jQuery.grep(jsonEmailArray, function(item, i) {
            return (item.sequencialEmail === sequencialEmail);
        });

        clearFormEmail();
        if (arr.length > 0) {
            var item = arr[0];
            $("#sequencialEmail").val(item.sequencialEmail);
            $("#emailId").val(item.emailId);
            $("#email").val(item.email);
        }
    }

    function clearFormEmail() {
        $("#sequencialEmail").val("");
        $("#emailId").val("");
        $("#email").val("");
        return true;
    }

    function excluirEmail() {
        var arrSequencial = [];
        $('#tableEmail input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonEmailArray.length - 1; i >= 0; i--) {
                var obj = jsonEmailArray[i];
                if (jQuery.inArray(obj.sequencialEmail, arrSequencial) > -1) {
                    jsonEmailArray.splice(i, 1);
                }
            }
            $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
            fillTableEmail();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Email para excluir.", "error");
    }
</script>