<?php
    include 'conexao.php';

    class Consulta {
        public function __construct() {

        }

        public function sistema($sistema, $ambiente): array {
            $db = Database::conexao();
            $reg = $db->query("select distinct sistema, plataforma from servidores where sistema ilike '%{$sistema}%' and ambiente='{$ambiente}'")->fetchAll(PDO::FETCH_BOTH);
            return $reg;
        }

        public function modulo($modulo, $ambiente): array {
            $db = Database::conexao();
            $reg = $db->query("select distinct sistema, servidores_json, status from servidores where sistema = '{$modulo}' and ambiente='{$ambiente}'")->fetchAll(PDO::FETCH_BOTH);
            return $reg;
        }
    }
?>