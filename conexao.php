<?php
/**
 * Classe de conexão ao banco de dados usando PDO no padrão Singleton.
 * 
 * Exemplo de uso:
 * ```
 * require_once './Database.class.php';
 * $db = Database::conexao(); // Pega a instância da conexao com o banco de dados.
 * $insercao = $db->prepare("INSERT INTO pessoa (nome, idade) VALUES (:nome, :idade)"); // Prepara a instrução de inserção de uma pessoa no banco de dados.
 * $insercao->bindParam(':nome', $nome); // Faz a ligação entre o parâmetro ":name" da instrução preparada acima com a variável $nome (supondo que $nome contém uma sequência de caracteres fornecida pelo usuário).
 * $insercao->bindParam(':idade', $idade); // Faz a ligação entre o parâmetro ":idade" com a variável $idade (supondo que $idade contém um número fornecido pelo usuário).
 * $insercao->execute(); // Executa a instrução no banco de dados (com os parâmetros já substituídos por seus respectivos valores).
 * ```
 * 
 * Para mais informações, confira o Manual do PDO: https://www.php.net/manual/en/intro.pdo.php
 */
class Database
{
    # Variável que guarda a conexão PDO.
    protected static $db;

    # Private construct - garante que a classe só possa ser instanciada internamente.
    private function __construct()
    {
        # Informações sobre o banco de dados:
 /*       $db_host = "10.116.92.41";
        $db_nome = "vopdb201";
        $db_usuario = "svopdb201";
        $db_senha = "Cxa256971";
        $db_driver = "pgsql";
        $db_port = "5172";*/

        $db_host = "localhost";
        $db_nome = "postgres";
        $db_usuario = "p596209";
        $db_senha = "";
        $db_driver = "pgsql";
        $db_port = "5432";
        # Informações sobre o sistema:
        $sistema_titulo = "Nome do Sistema";
        $sistema_email = "alguem@gmail.com";

        try
        {
            # Atribui o objeto PDO à variável $db.
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome; port=$db_port", $db_usuario, $db_senha);
            # Garante que o PDO lance exceções durante erros.
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            die("Connection Error: " . $e->getMessage());
        }
    }

    # Método estático - acessível sem instanciação.
    public static function conexao()
    {
        # Garante uma única instância. Se não existe uma conexão, criamos uma nova.
        if (!self::$db)
        {
            new Database();
        }

        # Retorna a conexão.
        return self::$db;
    }

}