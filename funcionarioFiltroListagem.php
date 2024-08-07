<?php
include "js/repositorio.php";
include "js/girComum.php";

?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:35px;">Nome</th>
                    <th class="text-left" style="min-width:30px;">CPF</th>
                    <!-- <th class="text-left" style="min-width:25px;">Data de Nascimento</th> -->
                    <th class="text-left" style="min-width:30px;">Estado Civil</th>
                    <th class="text-left" style="min-width:30px;">Gênero</th>
                    <th class="text-left" style="min-width:10px;">Ativo</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $utils = new comum();
                $reposit = new reposit();

                $sql = "SELECT  F.codigo,nome,cpf, descricao, E.estadoCivil FROM dbo.funcionario F
                 LEFT JOIN estadoCivil E ON F.estadoCivil= E.codigo 
                 LEFT JOIN genero G ON F.idGenero = G.codigo WHERE (0 = 0)";


                $codigo = $_POST["codigo"];
                $nome = $_POST["nome"];
                $cpf = $_POST["cpf"];
                // $dataNascimento = $utils->formataDataSql($_POST['dataNascimento']);
                $estadoCivil = $_POST["estadoCivil"];
                $descricao = $_POST["descricao"];
                $ativo =  $_POST["ativo"];

                if ($codigo != "") {
                    $where = $where . " AND (codigo like '%" . $codigo . "%')";
                }

                if ($nome != "") {
                    $where = $where . " AND (nome like '%" . $nome . "%')";
                }
                if ($cpf != "") {
                    $where = $where . " AND (cpf like '%" . $cpf . "%')";
                }
                // if ($dataNascimento != "") {
                //     $where = $where . " AND (dataNas$dataNascimento like '%" . $dataNascimento . "%')";
                // }

                if ($estadoCivil != "") {
                    $where = $where . " AND (estadoCivil like '%" . $estadoCivil . "%')";
                }
                if ($descricao != "") {
                    $where = $where . " AND (descricao like '%" . $descricao . "%')";
                }
                if ($ativo != "") {
                    $where = $where . " AND (ativo = $ativo)";
                }

                $sql = $sql .  $where;

                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $id =  $row['codigo'];
                    $nome =  $row['nome'];
                    $cpf =  $row['cpf'];
                    // $dataNascimento =  $row['dataNascimento'];
                    $estadoCivil =  $row['estadoCivil'];
                    $descricao =  $row['descricao'];
                    $ativo = $row['ativo'];

                    if ($ativo == 1) {
                        $descricaoAtivo = "Sim";
                    } else {
                        $descricaoAtivo = "Não";
                    }

                    echo '<tr >';
                    echo '<td class="text-left">  <a href="funcionarioCadastro.php?id=' . $id . '">' . $nome;
                    echo '<td class="text-left">' . $cpf . '</td>';
                    // echo '<td class="text-left">' . $dataNascimento . '</td>';
                    echo '<td class="text-left">' . $estadoCivil . '</td>';
                    echo '<td class="text-left">' . $descricao . '</td>';
                    echo '<td class="text-left">' . $descricaoAtivo . '</td>';
                    echo '</tr >';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script>
    $(document).ready(function() {

        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({
            // Tabletools options: 
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sLengthMenu": "_MENU_ Resultados por página",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "oTableTools": {
                "aButtons": ["copy", "csv", "xls", {
                        "sExtends": "pdf",
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                    }
                ],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "autoWidth": true,
            "preDrawCallback": function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function(nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function(oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

    });
</script>