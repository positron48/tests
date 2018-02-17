<?php
//
// Задача B. Размер имеет значение
//
$fp = fopen("input.txt", "r"); // Открываем файл в режиме чтения
$fpc = fopen("output.txt", "w");
$arr = array();
	$i = 0;
    while (!feof($fp))
    {
        $arr[$i] = fgets($fp, 9999);
        $i++;
    }

for ($u = 0; $u < count($arr); $u++) {
    $res = ":";// промежуточные результаты
    $result = ""; //Результат текущей строки

    // Если есть вхождения '::'
    if (stristr($arr[$u], "::") !== FALSE) {
        $count = substr_count($arr[$u], ':');
        if (strpos($arr[$u], "::") == strlen($arr[$u]) - 2)
            $count--;
        if(strpos($arr[$u], "::") == 0)
            $count--;
        for ($j = 0; $j < (8 - $count); $j++)
            $res .= "0000:";
    }


    $arr[$u] = str_replace("::", $res, $arr[$u]).":"; // Заменяем '::' на нужное количество нулей и ':'
    //echo $arr[$u], "\n";
    for ($r = 0; $r < 8; $r++) {

        $i = strpos($arr[$u], ':');
        $res = substr($arr[$u], '0', $i);

        if ($i % 4 != 0) {
            $temp = 4 - $i % 4;
            for ($j = 0; $j < $temp; $j++)
                $res = '0' . $res;
        }
        $arr[$u] = strstr($arr[$u], ':'); //Возвращает оставшуюся строку, кроме символов от 0 до ':'

        $arr[$u] = substr($arr[$u], 1); // Удаление ':'

        if ($i == 0 || empty($res))
        {
            $r--;
            continue;

        }
        $res .= ':';
        $result .= $res;
    }
    $result = substr($result, '0', strlen($result) - 1);
    fwrite("output.txt", $result."\n");
    fclose($fp);
    fclose($fpc);


?>
