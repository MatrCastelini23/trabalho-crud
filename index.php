<?php

$host = 'localhost';
$dbname = 'empregados';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}


$consulta = $pdo->query("SELECT id, nome, cargo, salario FROM funcionario");
$funcionarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Funcionários</title>
</head>
<body>

    <h1>Lista de Funcionários</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Salário</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios as $f): ?>
            <tr>
                <td><?= $f['id'] ?></td>
                <td><?= htmlspecialchars($f['nome']) ?></td>
                <td><?= htmlspecialchars($f['cargo']) ?></td>
                <td>R$ <?= number_format($f['salario'], 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</body>
</html>