<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Coda;

/**
 * Description of WordTemplate
 *
 * @author Adão José PC->cidinha
 * adao.jose123.a.r@gmail.com
 * fb.com/adao.jose123.a
 */

class WordTemplate {
    private $template, $pathForSave, $sqlComand;
    function getTemplate() {
        return $this->template;
    }

    function getPathForSave() {
        return $this->pathForSave;
    }

    function getSqlComand() {
        return $this->sqlComand;
    }

    function setTemplate($template) {
        $this->template = $template;
        if (!is_file($template)){
            throw new \Exception("Erro! Arquivo modelo não encontrado. Favor corrija ! :)");
        }
    }

    function setPathForSave($pathForSave) {
        if (!is_dir($pathForSave)){
            throw new \Exception("Erro! pasata de salvamento de arquivos não encontrada favor corrija! :)");
        }
        $this->pathForSave = $pathForSave;
    }

    function setSqlComand($sqlComand) {
        $this->sqlComand = $sqlComand;
    }

    public function  generateFiles(){
        $readBd = new \BD\Read();
        $readBd->FullRead($this->getSqlComand());
        $res = $readBd->getResult();
        foreach ($res as $key => $value) {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($this->getTemplate());
            //$templateProcessor->setValue( $value);
            foreach ($value as $keyDentro => $valueDentro) {
                $templateProcessor->setValue($keyDentro, $valueDentro);
            }
            $templateProcessor->saveAs($this->getPathForSave()."/".$key.'_'.date("d_m_y_s").'.docx');
            
        }
        Echo "arquivos criados na pasta '".$this->getPathForSave()."'";
    }
}
