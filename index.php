<?php
$alunos=$_REQUEST['alunos'];
$turmValida = false;
$alunosValido = false;
if(isset($_REQUEST["btnTurma"])){
    //validação dos dados
    if(isset($_REQUEST["turma"])){
       $turma = $_REQUEST['turma'];
       $turmValida=true;
    }
    else{
        echo "Informação [turma] inválida!";
    }

    if(isset($_REQUEST['alunos'])
        &&
        is_numeric($_REQUEST['alunos'])
        &&
        (
                $_REQUEST['alunos']>=1
                &&
                $_REQUEST['alunos']<=40
        )

    ){
       $alunos = $_REQUEST['alunos'];
        $alunosValido = true;
    }
    else{
        echo "Informação [alunos] inválida!";
    }
}
if(isset($_REQUEST['btnDisciplina']))
{
    $turmValida = true;
    $alunosValido = true;
    $mediaGeral=0.0;
    if(isset($_REQUEST['boletim']))
    {
        $alunos = $_REQUEST['alunos'];
        $boletim = $_REQUEST['boletim'];
        for($n=0; $n<$alunos; $n++){
           $mediafinal = ($boletim[$n]['media1s'] +
                          $boletim[$n]['media2s']) / 2.0;
           $situacao = $mediafinal>=6.0 ? "Aprovado" : "Reprovado";
           $boletim[$n]['mediafinal'] = $mediafinal;
           $boletim[$n]['situacao'] = $situacao;
           $mediaGeral+=$mediafinal;
        }
        $mediaGeral = $mediaGeral/$n;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>BOLETIM</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<div class="container-fluid text-lg-center bg-dark text-white">
    <h1>COLÉGIO TÉCNICO DE LIMEIRA - COTIL</h1>
    <H2>DESENVOLVIMENTO DE APLICAÇÕES WEB</H2>
    <BR>
    <H2>SISTEMA DE CONTROLE DE NOTAS E FREQUÊNCIA</H2>
</div>
<div class="container">
    <form class="form form-group" method="post">
                    <label for="turma">Turma: </label>
                    <select name="turma" id="idTurma" class="form-control">
                        <option value="infd1">INFD1</option>
                        <option value="infd2">INFD2</option>
                        <option value="infd3">INFD3</option>
                    </select>
                    <label for="alunos">Número de Alunos: </label>
                    <input class="form-control"
                            type="text"
                            name="alunos"
                            placeholder="Número de alunos ..."
                            value="<?php echo $alunos;?>">
                    <input  class="form-control btn btn-primary"
                            type="submit"
                            name="btnTurma"
                            value="Enviar">
    </form>
    <?php
    if($turmValida and $alunosValido) {
        ?>
            <form class="form form-group" method="post">
            <input type="hidden"
                name="alunos"
                   value="<?php echo $alunos;?>"
            >
            <table class="table table-bordered table-secondary">
                <thead >
                <tr>
                    <th COLSPAN="5">
                        <label for="disciplina">Disciplina: </label>
                        <select name="disciplina" id="disciplina" class="custom-select">
                            <option value="daw">Desenv. Aplic. WEB</option>
                            <option value="ddm">Desenv. Disp. Móveis</option>
                            <option value="dad">Desenv. Aplic. Desktop</option>
                            <option value="ed">Estruturas de Dados</option>
                        </select>
                    </th>
                    <th colspan="2"  class="text-lg-center">
                        <input class="btn btn-success"
                               type="submit"
                               name="btnDisciplina"
                               value="Processar"
                               >
                    </th>
                </tr>
                <tr>
                    <th >RA/NR.</th>
                    <th>MEDIA 1S</th>
                    <th>FALTAS 1S</th>
                    <th>MEDIA 2S</th>
                    <th>FALTAS 2S</th>
                    <th>MEDIA FINAL</th>
                    <th>SITUAÇÃO</th>
                </tr>
                </thead>

                <tbody>
                <?php
                for($n=0; $n<$alunos; $n++) {
                    ?>
                    <tr>
                        <td align="center" class="ra">
                            <input class="text-lg-center"
                                    type="text" disabled
                                   name="boletim[<?php echo $n;?>][ra]"
                                   value="<?php echo $n+1;?>">
                        </td>
                        <td class="text-lg-center">
                            <input class="text-lg-center"
                                    type="text"
                                   name="boletim[<?php echo $n;?>][media1s]"
                                   size="5"
                                   maxlength="4"
                                   value="<?php echo $boletim[$n]['media1s'];?>"
                            >
                        </td>
                        <td class="text-lg-center">
                            <input  class="text-lg-center"
                                    type="text" name="boletim[<?php echo $n;?>][faltas1s]" size="2" maxlength="2"
                                   value="<?php echo $boletim[$n]['faltas1s'];?>"
                            >
                        </td>
                        <td class="text-lg-center">
                            <input  class="text-lg-center"
                                    type="text" name="boletim[<?php echo $n;?>][media2s]" size="5" maxlength="4"
                                   value="<?php echo $boletim[$n]['media2s'];?>"
                            >
                        </td>
                        <td class="text-lg-center">
                            <input  class="text-lg-center"
                                    type="text" name="boletim[<?php echo $n;?>][faltas2s]" size="2" maxlength="2"
                                   value="<?php echo $boletim[$n]['faltas2s'];?>"
                            >
                        </td>
                        <td class="text-lg-center">
                            <input class="text-lg-center"
                                    type="text" name="boletim[<?php echo $n;?>][mediafinal]" disabled
                                   value="<?php echo number_format($boletim[$n]['mediafinal'],1);?>"
                            >
                        </td>
                        <td class="text-lg-center">
                            <input class="text-lg-center"
                                    type="text" name="boletim[<?php echo $n;?>][situacao]" disabled
                                   value="<?php echo $boletim[$n]['situacao'];?>"
                            >
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5" class="text-lg-center text-info">Media Geral da Classe </td>
                    <td align="center">
                        <input class="text-lg-center text-info"
                               type="text" name="boletim[<?php echo $n;?>][situacao]" disabled
                               value="<?php echo number_format($mediaGeral,2);?>"
                        >
                    <td> </td>
                </tr>
                </tfoot>
            </table>
        </form>
        <?php
    }
    ?>
</div>
</body>
</html>