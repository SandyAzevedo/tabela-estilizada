<?php
require_once 'init.php';
// abre a conexão
$PDO = db_connect();
// SQL para contar o total de registros
// A biblioteca PDO possui o método rowCount(), 
// mas ele pode ser impreciso.
// É recomendável usar a função COUNT da SQL
$sql_count = "SELECT COUNT(*) AS total FROM products ORDER BY name ASC";
// SQL para selecionar os registros
$sql = "SELECT id, name, color, price, startdate, quantity "
        . "FROM products ORDER BY name ASC";
// conta o toal de registros
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();
$total = $stmt_count->fetchColumn();
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->execute();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <title>Sistema de Cadastro</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Sistema de Cadastro</h1>
                    <p><a href="form-add.php">Adicionar Produto</a></p>
                    <h2>Lista de Produtos</h2>
                    <p>Total de Produtos: <?php echo $total ?></p>
                    <?php if ($total > 0): ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Cor</th>
                                                <th>preço</th>
                                                <th>Data de Compra</th>
                                                <th>quantidade</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($products = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                                <tr>
                                                    <td><?php echo $products['name'] ?></td>
                                                    <td><?php echo $products['color'] ?></td>
                                                    <td><?php echo $products['price'] ?></td>
                                                    <td><?php echo dateConvert($products['startdate']) ?></td>
                                                    <td><?php echo $products['quantity'] ?></td>
                                                    <td>
                                                        <a href="form-edit.php?id=<?php echo $products['id'] ?>">Editar</a>
                                                        <a href="delete.php?id=<?php echo $products['id'] ?>" 
                                                           onclick="return confirm('Tem certeza de que deseja remover?');">
                                                            Remover
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="bootstrap/js/bootstrap.js" type="text/javascript"></script>
            <script src="bootstrap/js/npm.js" type="text/javascript"></script>
        <?php else: ?>
            <p>Nenhum produto registrado</p>
        <?php endif; ?>
    </body>
</html
