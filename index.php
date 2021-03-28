<?php

include 'vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord; //usando a classe PhpWord
use PhpOffice\PhpWord\IOFactory; //usando a classe IOFactory
use PhpOffice\PhpWord\TemplateProcessor;

$templateProcessor = new TemplateProcessor('first.docx');
$templateProcessor->setValue('firstname', 'John');
$templateProcessor->setValue('lastname', 'Doe');
$templateProcessor->saveAs("teste.docx");
try {
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $wt = new Coda\WordTemplate;
        $wt->setTemplate($_POST['model']);
        $wt->setPathForSave($_POST['path']);
        $wt->setSqlComand($_POST['sql']);
        $wt->generateFiles();
    }
} catch (Exception $exc) {
    echo $exc->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">
        <form action="index.php" method="post">
        <fieldset>
            <legend>Banco de dados</legend>
            <input type="text" name="bdhost" id="" class="form-control" placeholder="Hoste do banco de dados" value="localhost">
            <input type="text" name="bduser" id="" class="form-control" placeholder="Usuario do banco de dados" value="root">
            <input type="text" name="bdpass" id="" class="form-control" placeholder="Senha do banco de dados" value="">
            <input type="text" name="bddbsa" id="" class="form-control" placeholder="Nome da base de dados a ser usada" value="">
        </fieldset>
        <fieldset>
            <legend>Arquivos</legend>
            <input type="text" name="model" id="" class="form-control" placeholder="Caminho com o modelo Ex. C:\arquivos\ar.docx" value="">
            <input type="text" name="path" id="" class="form-control" placeholder="Pasta de salvamento dos arquivos Ex. C:\arquivos\camila" value="">
            <input type="text-area" name="sql" id="" class="form-control" placeholder="comando sql de substituição do modelo Ex. Hello ${nome} ${email} sql = select nome, email from usuario!" value="">
        </fieldset>
        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary col-6">Criar arquivos</button>
        </div>
        
        </form>
    </div>
</body>
</html>