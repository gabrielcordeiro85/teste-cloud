<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Simples em PHP</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .calculator { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        input[type="number"], select, input[type="submit"] { padding: 10px; margin: 5px 0; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { background-color: #5cb85c; color: white; cursor: pointer; }
        input[type="submit"]:hover { background-color: #4cae4c; }
        .result { margin-top: 15px; padding: 10px; border: 1px solid #ddd; background-color: #e9e9e9; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>

<div class="calculator">
    <h2>Calculadora PHP</h2>
    
    <form method="post" action="">
        <input type="number" name="num1" placeholder="Primeiro Número" required step="any"
               value="<?php echo isset($_POST['num1']) ? htmlspecialchars($_POST['num1']) : ''; ?>">
        
        <select name="operacao" required>
            <option value="soma" <?php echo (isset($_POST['operacao']) && $_POST['operacao'] == 'soma') ? 'selected' : ''; ?>>+</option>
            <option value="subtracao" <?php echo (isset($_POST['operacao']) && $_POST['operacao'] == 'subtracao') ? 'selected' : ''; ?>>-</option>
            <option value="multiplicacao" <?php echo (isset($_POST['operacao']) && $_POST['operacao'] == 'multiplicacao') ? 'selected' : ''; ?>>*</option>
            <option value="divisao" <?php echo (isset($_POST['operacao']) && $_POST['operacao'] == 'divisao') ? 'selected' : ''; ?>>/</option>
        </select>
        
        <input type="number" name="num2" placeholder="Segundo Número" required step="any"
               value="<?php echo isset($_POST['num2']) ? htmlspecialchars($_POST['num2']) : ''; ?>">
        
        <input type="submit" name="calcular" value="Calcular">
    </form>

    <?php
    // --- Bloco PHP para o Cálculo ---
    if (isset($_POST['calcular'])) {
        // 1. Coleta e sanitização dos dados
        $num1 = filter_input(INPUT_POST, 'num1', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $num2 = filter_input(INPUT_POST, 'num2', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $operacao = $_POST['operacao'] ?? '';
        
        $resultado = '';
        $erro = '';

        // 2. Validação básica (garante que os inputs são numéricos)
        if (!is_numeric($num1) || !is_numeric($num2)) {
            $erro = "Por favor, insira números válidos.";
        } else {
            // 3. Estrutura de controle para a operação
            switch ($operacao) {
                case 'soma':
                    $resultado = $num1 + $num2;
                    break;
                case 'subtracao':
                    $resultado = $num1 - $num2;
                    break;
                case 'multiplicacao':
                    $resultado = $num1 * $num2;
                    break;
                case 'divisao':
                    if ($num2 == 0) {
                        $erro = "Erro: Divisão por zero não é permitida.";
                    } else {
                        $resultado = $num1 / $num2;
                    }
                    break;
                default:
                    $erro = "Operação inválida.";
            }
        }

        // 4. Exibição do resultado ou erro
        echo '<div class="result">';
        if ($erro) {
            echo "Erro: " . htmlspecialchars($erro);
        } else {
            echo "Resultado: " . htmlspecialchars($num1) . 
                 " " . (
                    ($operacao == 'soma') ? '+' : 
                    ($operacao == 'subtracao') ? '-' : 
                    ($operacao == 'multiplicacao') ? '*' : 
                    '/'
                 ) . 
                 " " . htmlspecialchars($num2) . 
                 " = **" . htmlspecialchars(number_format($resultado, 2, ',', '.')) . "**";
        }
        echo '</div>';
    }
    // --- Fim do Bloco PHP ---
    ?>

</div>

</body>
</html>
