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

// Processa o UPDATE quando o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id      = (int) $_POST['id'];
    $nome    = trim($_POST['nome']);
    $cargo   = trim($_POST['cargo']);
    $salario = $_POST['salario'];

    $stmt = $pdo->prepare("UPDATE funcionario SET nome = :nome, cargo = :cargo, salario = :salario WHERE id = :id");
    $stmt->execute([
        ':nome'    => $nome,
        ':cargo'   => $cargo,
        ':salario' => $salario,
        ':id'      => $id,
    ]);

    header("Location: index.php");
    exit;
}

// ID sendo editado (vindo da URL ?editar=X)
$editandoId = isset($_GET['editar']) && is_numeric($_GET['editar']) ? (int) $_GET['editar'] : null;

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
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios as $f): ?>
                <?php if ($editandoId === (int)$f['id']): ?>
                <!-- LINHA EM MODO EDIÇÃO -->
                <tr>
                    <form method="POST" action="index.php">
                        <input type="hidden" name="id" value="<?= $f['id'] ?>">
                        <td><?= $f['id'] ?></td>
                        <td><input type="text" name="nome" value="<?= htmlspecialchars($f['nome']) ?>" required></td>
                        <td><input type="text" name="cargo" value="<?= htmlspecialchars($f['cargo']) ?>" required></td>
                        <td><input type="number" step="0.01" name="salario" value="<?= $f['salario'] ?>" required></td>
                        <td>
                            <button type="submit" class="btn-salvar">Salvar</button> |
                            <a href="index.php" class="btn-cancelar">Cancelar</a>
                        </td>
                    </form>
                </tr>
                <?php else: ?>
                <!-- LINHA EM MODO VISUALIZAÇÃO -->
                <tr>
                    <td><?= $f['id'] ?></td>
                    <td><?= htmlspecialchars($f['nome']) ?></td>
                    <td><?= htmlspecialchars($f['cargo']) ?></td>
                    <td>R$ <?= number_format($f['salario'], 2, ',', '.') ?></td>
                    <td><a href="index.php?editar=<?= $f['id'] ?>" class="btn-editar">Editar</a></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>