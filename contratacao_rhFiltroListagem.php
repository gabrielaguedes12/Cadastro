<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">

                    <!-- <th class="text-left" style="min-width:30px;" scope="col">Código</th> -->

                    <th class="text-left" style="min-width:70px;" scope="col">Candidato</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Projeto</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Sindicato</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Cargo</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Verificado</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $nome = "";
                $projeto = "";
                $sindicato = "";
                $cargo = "";

                $sql = "SELECT P.descricao AS projeto, F.nomeCompleto, S.descricao AS sindicato, C.descricao AS cargo, CF.codigo AS codigoControleCandidato, F.codigo AS codigoCandidato, CF.salarioBase, CF.verificadoPeloGestor, CF.verificadoPeloRh
                FROM Contratacao.candidato F
                LEFT JOIN Contratacao.controleCandidato CF ON F.codigo = CF.candidato
                LEFT JOIN Ntl.projeto P ON P.codigo = CF.projeto 
                LEFT JOIN Ntl.sindicato S ON S.codigoSindicatoSCI = CF.sindicato
                LEFT JOIN Ntl.cargo C ON C.codigoCargoSCI = CF.cargo
                LEFT JOIN Contratacao.exportacao E ON E.candidato = CF.candidato
                WHERE verificadoPeloGestor = '1'";

                $where = " AND (0 = 0) AND (CF.ativo IS NULL OR CF.ativo = 1) AND (E.situacao = 0 OR E.situacao IS NULL)";

                if ($_POST["nome"] != "") {
                    $candidato = $_POST["nome"];
                    $where = $where . " AND (F.nomeCompleto like '%' + " . "replace('" . $candidato . "',' ','%') + " . "'%')";
                }
                if ($_POST["projeto"] != "") {
                    $projeto = $_POST["projeto"];
                    $where = $where . " AND (P.descricao like '%' + " . "replace('" . $projeto . "',' ','%') + " . "'%')";
                }
                if ($_POST["sindicato"] != "") {
                    $sindicato = $_POST["sindicato"];
                    $where = $where . " AND (S.descricao like '%' + " . "replace('" . $sindicato . "',' ','%') + " . "'%')";
                }
                if ($_POST["cargo"] != "") {
                    $cargo = $_POST["cargo"];
                    $where = $where . " AND (C.descricao like '%' + " . "replace('" . $cargo . "',' ','%') + " . "'%')";
                }

                if ($_POST["verificadoPeloRh"] != "") {
                    $verificadoPeloRh = $_POST["verificadoPeloRh"];
                    if ($verificadoPeloRh == "1") {
                        $where = $where . " AND (CF.verificadoPeloRh = 1)";
                    } else {
                        $where = $where . " AND (CF.verificadoPeloRh IS NULL ) ";
                    }
                }

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                while (($row = odbc_fetch_array($result))) {
                    $codigo = mb_convert_encoding($row['codigoControleCandidato'], 'UTF-8', 'HTML-ENTITIES');
                    $codigoCandidato = mb_convert_encoding($row['codigoCandidato'], 'UTF-8', 'HTML-ENTITIES');
                    $candidato = mb_convert_encoding($row['nomeCompleto'], 'UTF-8', 'HTML-ENTITIES');
                    $projeto = mb_convert_encoding($row['projeto'], 'UTF-8', 'HTML-ENTITIES');
                    $sindicato = mb_convert_encoding($row['sindicato'], 'UTF-8', 'HTML-ENTITIES');
                    $cargo = mb_convert_encoding($row['cargo'], 'UTF-8', 'HTML-ENTITIES');
                    $verificado = $row['verificadoPeloRh'];

                    if ($verificado == "") {
                        $verificado =  "<b><font color='#dbc616'> Pendente</font></b>";
                    } else {
                        $verificado =  "<b><font color='#228B22'> Verificado </font></b>";
                    }

                    echo '<tr >';
                    // echo '<td class="text-left"><a href="controleFuncionarioCadastro.php?codigo=' . $id . '">' . $funcionario . '</a></td>';
                    echo '<td class="text-left"><a href="contratacao_controleCandidatoCadastro.php?codigo=' . $codigo . '&candidato=' . $codigoCandidato . '">' . $candidato . '</a></td>';
                    echo "<td class='text-center'>$projeto</td>";
                    echo "<td class='text-center'>$sindicato</td>";
                    echo "<td class='text-left'>$cargo</td>";
                    echo "<td class='text-left'>$verificado</td>";
                    echo '</tr >';
                }

                function descricaoVerifica($numero)
                {
                    if ($numero == 2) {
                        return $numero = "<b><font color='#228B22'> Verificado </font></b>";
                    } else if ($numero == 1) {
                        return $numero = "<b><font color='#dbc616'> Pendente </font></b>";
                    } else if ($numero == 0) {
                        return $numero = "<b><font color='#FF0000'> Não Verificado </font></b>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<!--script src="js/plugin/datatables/dataTables.tableTools.min.js"></script-->
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="js/plugin/Buttons-1.5.2/css/buttons.dataTables.min.css" />

<script type="text/javascript" src="js/plugin/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function() {
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({

            // Tabletools options:
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'B'l'C>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                //"sLengthMenu": "_MENU_ Resultados por página",
                "sLengthMenu": "_MENU_",
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
            "buttons": [
                //{extend: 'copy', className: 'btn btn-default'},
                //{extend: 'csv', className: 'btn btn-default'},
                {
                    extend: 'excel',
                    className: 'btn btn-default'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-default'
                },
                //{extend: 'print', className: 'btn btn-default'}
            ],
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

        /* END TABLETOOLS */
    });
</script>