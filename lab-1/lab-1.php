<?php

const INDEX_TABLE_RANGE = 8;


#     Задача 1 Найти наименьший элемент в упорядоченном массиве А с помощью
#       линейного, бинарного и индексно-последовательного поиска. 
#


# Возвращает значение
function find_min_value(array $haystack): int
{
    $result = $haystack[0];

    foreach ($haystack as $value) {
        if ($result > $value) {
            $result = $value;
        }
    }
    return $result;
}

# Возвращает ключ
function find_ln(array $haystack, int $needle)
{
    $result = false;

    foreach ($haystack as $key => $value) {
        if ($value == $needle) {
            $result = $key;
            break;
        }
    }

    return $result;
}

# Возвращает ключ
function find_bin(array $haystack, int $needle)
{
    $result = false;
    $first = 0;
    $last = count($haystack) - 1;

    while ($first <= $last) {
        $mid_key = round(($first + $last) / 2);
        // $mid_key = (int) $mid_key;
        $mid_value = $haystack[$mid_key];

        if ($mid_value < $needle) {
            $first = $mid_key + 1;
        } elseif ($mid_value > $needle) {
            $last = $mid_key - 1;
        } else {
            $result = $mid_key;
            break;
        }
    }

    return $result;
}


# Возвращает ключ
//TODO Две индексные таблицы
function find_isq(array $haystack, int $needle)
{
    $result = false;

    $first_table = form_index_table($haystack);
    $second_table = form_index_table($first_table);

    // var_dump($second_table);
    // echo "<br>";
    // var_dump($first_table);

    # Получаем первый диапозон поиска
    if ($search_sq = get_search_sq($second_table, $needle)) {

        if(is_int($temp = find_in_sq($second_table, $needle, $search_sq[0], $search_sq[1])) ) {
            $result = $temp * INDEX_TABLE_RANGE * INDEX_TABLE_RANGE;

            //* Out of bounds quick fix. Problem reason: index table length not multiple to 8
            if ($temp == array_key_last($second_table)) {
                $result = array_key_last($haystack);
            }

        } else {
            # Получаем второй диапозон поиска
            $search_sq[0] *= INDEX_TABLE_RANGE;
            $search_sq[1] *= INDEX_TABLE_RANGE;

            if (is_int($temp = find_in_sq($first_table, $needle, $search_sq[0], $search_sq[1]))) {
                $result = $temp * INDEX_TABLE_RANGE;
            } else {
                # Получаем третий диапозон поиска
                $search_sq[0] *= INDEX_TABLE_RANGE;
                $search_sq[1] *= INDEX_TABLE_RANGE;

                if (is_int($temp = find_in_sq($haystack, $needle, $search_sq[0], $search_sq[1]))) {
                    $result = $temp;
                }

            }


        }


    }
    
    return $result;
}

/** Получает промежуток */
function get_search_sq(array $index_table, int $needle)
{
    $result = false;

    foreach ($index_table as $key => $val) {
        if ($val >= $needle) {
            $start_pos = ($key - 1) > 0 ? $key - 1 : 0;
            $end_pos = $start_pos + 1;
            $result = [$start_pos, $end_pos];
            break;
        }
    }

    return $result;
}

/** Ищет значения в промежутке */
function find_in_sq(array $haystack, int $needle, int $start_pos, int $end_pos)
{
    $result = false;
    for ($i = $start_pos; $i <= $end_pos; $i++) {
        if ($haystack[$i] == $needle) {
            $result = $i;
            break;
        }
    }
    return $result;
}


$ar = json_decode(file_get_contents('array.txt'));
// var_dump($ar);


echo find_ln($ar, 138) . '<br>';
echo find_isq($ar, 138) . '<br>';


/**
 * Формирует индексную таблицу
 * @param array $from массив из которого формируется индексная таблица
 * @param bool $include_end (optional) включить ли конечный элемент исходной таблицы в индексную
 * @return array
 */
function form_index_table(array $from, bool $include_end = true): array
{
    $index_table = [];

    $temp = 0;
    foreach ($from as $key => $val) {
        # Грязное прерывание цикла
        if (!isset($from[$temp])) {
            break;
        }

        # Фикс смещения, возникшего от 0 как начального ключа
        //*UPD Лучше не фиксить это, так как возникает проблема +- 1
        // if ($temp == INDEX_TABLE_RANGE) {
        //     $temp--;
        // }

        $index_table[] = $from[$temp];
        $temp += INDEX_TABLE_RANGE;
    }

    if ($include_end) {

        $last = end($from);
        if ($last != end($index_table)) {
            array_push($index_table, $last);
        }
    }

    return $index_table;
}



/** Задача 2 Найти элементы в упорядоченном массиве А, которые больше 30, с
помощью линейного, бинарного и индексно-последовательного поиска. */

# Возвращает значения
function find_greater_ln(array $haystack, int $needle = 30): array
{
    $result = [];
    foreach ($haystack as $value) {
        if ($value > $needle) {
            array_push($result, $value);
        }
    }

    return $result;
}

# Возвращает значения; Бинарный поиск ищет минимальное значение, большее чем искомое. После массив заполняется с этой позиции до конца
function find_greater_bin(array $haystack, int $needle = 30): array
{
    $result = [];

    if ($needle >= end($haystack)) # out of bounds
    {
        return $result;
    }

    $last = count($haystack) - 1;
    $mid_key = round($last / 2);
    $mid_value = $haystack[$mid_key];

    $pos = $last;
    $temp = $last;

    #region Поиск ключа, большего чем needle
    while (true) {
        if ($mid_value > $needle and $temp >= 0) {
            $mid_key = round($temp / 2);
            $mid_value = $haystack[$mid_key];
            $temp--;
        } elseif ($mid_value == $needle) {
            $pos = $mid_key + 1;
            break;
        } else {
            for ($i = $mid_key; $i <= $last; $i++) {
                if ($haystack[$i] > $needle) {
                    $pos = $i;
                    break 2;
                }
            }
        }
    }
    #endregion

    for ($i = $pos; $i <= $last; $i++) {
        array_push($result, $haystack[$i]);
    }

    return $result;
}

# Возвращает значения; Индексно-последовательный поиск ищет минимальное значение, большее чем искомое. После массив заполняется с этой позиции до конца
function find_greater_isq(array $haystack, int $needle = 30): array
{
    $result = [];
    $index_table = form_index_table($haystack);
    $last = count($haystack) - 1;

    $pos = $last;

    foreach ($index_table as $key => $value) {
        if ($value > $needle) {
            $pos = ($key - 1 > 0) ? ($key - 1) * INDEX_TABLE_RANGE : 0;
            break;
        }
    }

    for ($i = $pos; $i <= $last; $i++) {
        $var = $haystack[$i];
        if ($var > $needle) {
            array_push($result, $var);
        }
    }

    return $result;
}


/** Задача 3. Вывести на экран все числа массива А кратные n (3,6,9,...) с помощью
линейного, бинарного и индексно-последовательного поиска. */


# Возвращает значения
function find_multiple_ln(array $haystack, int $needle = 3): array
{
    $result = [];
    foreach ($haystack as $value) {
        if ($value == 0) {
            continue;
        }

        if ($value % $needle == 0) {
            array_push($result, $value);
        }
    }

    return $result;
}