<?php

/**
 * Conn.class [ CONEXÃO ]
 * Classe abstrata de conexão. Padrão SingleTon.
 * Retorna um objeto PDO pelo método estático getConn();
 * 
 * @copyright (c) 2013, Robson V. Leite UPINSIDE TECNOLOGIA
 */
namespace BD;
use \PDO;
use \Exception;
if($_SERVER["REQUEST_METHOD"] == "POST" and !(isset($_POST['bdhost']) or isset($_POST['bduser']) or isset($_POST['bdpass']) or isset($_POST['bddbsa']))){
    throw new Exception("È possivel que você tenha esquecido de passar alguns parametros para conexão com o banco de dados! Verifique por favor!");
}
define("HOST", $_POST['bdhost']);
define("USER", $_POST['bduser']);
define("PASS", $_POST['bdpass']);
define("DBSA", $_POST['bddbsa']);

abstract class Conn {

    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Dbsa = DBSA;

    /** @var PDO */
    private static $Connect = null;

    /**
     * Conecta com o banco de dados com o pattern singleton.
     * Retorna um objeto PDO!
     */
    protected static function restart(){
        self::$Connect = null;
        self::Conectar();
    }
    private static function Conectar() {
        try {
            if (self::$Connect == null):
                $dsn = 'mysql:host=' . self::$Host . ';dbname=' . self::$Dbsa;
                $options = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
        } catch (PDOException $e) {
            echo $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine();
            die;
        }

        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }

    /** Retorna um objeto PDO Singleton Pattern. */
    protected static function getConn() {
        return self::Conectar();
    }

}
