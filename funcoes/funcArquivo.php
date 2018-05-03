<?php
function gravaBoletim($turma, $disc, $arrayBoletim)
{
    $nomeDir = 'dados/'.$turma;
    if(!@mkdir($nomeDir,0777,true)){
        chmod($nomeDir, 0777);
    };

    $nomeArquivo = $nomeDir.'/'.$disc.".txt";

    if(!$handle=fopen($nomeArquivo,"w")){
        echo "Falha ao abrir/criar arquivo de dados!<br>";
    }else{
        $aBoletim=array("turma"=>$turma,"disciplina"=>$disc,"dados"=>$arrayBoletim);
        $jsonBoletim = json_encode($aBoletim);
        if(fwrite($handle,$jsonBoletim)=== FALSE){
            echo "Falha ao gravar no arquivo de dados!<br>";
        }else{
            echo "Boletim salvo!<br>";
        }
    }
}

function carregaBoletim($turma, $disc){
    $nomeDir = 'dados/'.$turma;
    $nomeArquivo = $nomeDir.'/'.$disc.".txt";

    $aBoletim=array();
    if(!$handle=fopen($nomeArquivo,"r")){
        echo "Falha ao abrir arquivo de dados ($nomeArquivo)!<br>";
    }else{
        $jsonBoletim=file_get_contents($nomeArquivo);
        $aBoletim=json_decode($jsonBoletim,true);
    }
    return $aBoletim['dados'];
}