<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesap Makinesi (Basit)</title>
</head>
<body>
    <form method="post" action="">
        <input type="number" id="num1" name="num1">
        <br>
        <input type="number" id="num2" name="num2">
        <br>
        <select id="op" name="op">
            <option value="topla" id="topla">Topla</option>
            <option value="cikar" id="cikar">Çıkar</option>
            <option value="carp" id="carp">Çarp</option>
            <option value="bol" id="bol">Böl</option>
        </select>
        <br>
        <input type="submit" name="hesapla" value="Hesapla">
    </form>

    <?php
    if (isset($_POST['hesapla']))
        {
            $num1 = (float) $_POST['num1'];
            $num2 = (float) $_POST['num2'];
            $op = $_POST['op'];

            switch ($op)
            {
                case "topla":
                    $result = $num1 + $num2;
                    echo $result;
                    break;
                case "cikar":
                    $result = $num1 - $num2;
                    echo $result;
                    break;
                case "carp":
                    $result = $num1 * $num2;
                    echo $result;
                    break;
                case "bol":
                    if ($num2 == 0)
                    {
                        echo "Sıfıra bölünemez!";
                    }
                    else
                    {
                        $result = $num1 / $num2;
                        echo $result;
                    }
                    break;
            }
        }

        ?>
</body>
</html>