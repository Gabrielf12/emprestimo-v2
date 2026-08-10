<?php
// db_config.php - Leitura da DATABASE_URL do Render

$db_url = getenv('DATABASE_URL');

if ($db_url) {
    // Extrai os dados da URL do PostgreSQL que o Render fornece
    $dbopts = parse_url($db_url);
    
    $host = $dbopts['host'] ?? 'localhost';
    $port = $dbopts['port'] ?? '5432';
    $user = $dbopts['user'] ?? 'postgres';
    $password = $dbopts['pass'] ?? '';
    $dbname = ltrim($dbopts['path'] ?? '/ze_promocoes', '/');

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        die("Erro de Conexão com o Banco de Dados: " . $e->getMessage());
    }
} else {
    // Caso esteja rodando sem a DATABASE_URL configurada
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=ze_promocoes;charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $ex) {
        // Fallback SQLite para nunca dar tela branca
        $pdo = new PDO("sqlite:" . __DIR__ . "/database.sqlite");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
?>