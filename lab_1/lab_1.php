<?php 

const INDEX_TABLE_RANGE = 8;


function rand_sq(int $start, int $length, int $r_threshhold = 20): array
{
    $result = [$start];

    for($i = 1; $i < $length; $i++)
    {
        while($result[$i] <= $result[$i - 1])
        {
            $result[$i] += rand(1, $r_threshhold);
        }
    }

    return $result;
}


#     Задача 1 Найти наименьший элемент в упорядоченном массиве А с помощью
#       линейного, бинарного и индексно-последовательного поиска. 
#


# Возвращает значение
function find_min_value(array $haystack): int
{
    $result = $haystack[0];

    foreach($haystack as $key => $value)
    {
        if($result > $value)
        {
            $result = $value;
        }
    }
    return $result;
}

# Возвращает ключ
function find_ln(array $haystack, int $needle): string
{
    $result = false;

    foreach($haystack as $key => $value)
    {
        if($value == $needle)
        {
            $result = $key;
            break;
        }
    }

    return $result;
}

# Возвращает ключ
function find_bin(array $haystack, int $needle): string
{
    $result = false;
    $first = 0;
    $last = count($haystack) - 1;

    while ( $first <= $last )
    {
        $mid_key = round( ( $first + $last ) / 2 );
        $mid_value = $haystack[$mid_key];

        if($mid_value < $needle)
        {
            $first = $mid_key + 1;
        }
        elseif($mid_value > $needle)
        {
            $last = $mid_key - 1;
        }
        else
        {
            $result = $mid_key;
            break;
        }
    }

    return $result;
}


# Возвращает ключ
//TODO Две индексные таблицы
function find_isq(array $haystack, int $needle, int $nest_level = 1) 
{
    $result = false;
    $index_table = form_index_table($haystack);

    // for($i = 1; $i < $nest_level; $i++) {
    //     $index_table = form_index_table($index_table);
    // }


    foreach($index_table as $key => $value)
    {
        if($value >= $needle)
        {
            # Значение больше искомого ? -> получаем диапозон для поиска из предыдущего ключа и текущего
            $start_pos = ( $key - 1 > 0 ) ? ($key - 1) : 0; # доп проверка, чтобы не выйти за границы массива
            $end_pos = $key;
            
            # Получаем ключи относительно основной таблицы
            $start_pos *= INDEX_TABLE_RANGE; 
            $end_pos *= INDEX_TABLE_RANGE;

            // var_dump($start_pos);
            // var_dump($end_pos);
            
            // var_dump($index_table);
            

            for($i = $start_pos; $i <= $end_pos; $i++)
            {
                if($haystack[$i] == $needle)
                {
                    $result = $i;
                    break 2;
                }
            }
        }

    }

    return $result;
}


// $ar = rand_sq(0, 100);
// $ar = json_encode($ar);
// file_put_contents('array.txt', $ar);

$ar = json_decode(file_get_contents('array.txt'));
var_dump($ar);


echo find_ln($ar, 0) . '<br>';
echo find_isq($ar, 0) . '<br>';


function form_index_table(array $from, bool $include_end = true): array
{
    $index_table = [];
    $length = count($from);
    
    for($i = 0; $i < $length; $i += INDEX_TABLE_RANGE)
    {
         $index_table[] = $from[$i];
    }
    
    if ( $include_end) {
        
        $last = end($from);
        if($last != end($index_table))
        {
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
    foreach($haystack as $value)
    {
        if($value > $needle)
        {
            array_push($result, $value);
        }
    }

    return $result;
}

# Возвращает значения; Бинарный поиск ищет минимальное значение, большее чем искомое. После массив заполняется с этой позиции до конца
function find_greater_bin(array $haystack, int $needle = 30): array
{
    $result = [];

    if($needle >= end($haystack)) # out of bounds
    {
        return $result;
    }

    $last = count($haystack) - 1;
    $mid_key = round( $last / 2 );
    $mid_value = $haystack[$mid_key];
    
    $pos = $last;
    $temp = $last;

    #region Поиск ключа, большего чем needle
    while(true)
    {
        if($mid_value > $needle and $temp >= 0)
        {
            $mid_key = round( $temp / 2 );
            $mid_value = $haystack[$mid_key];
            $temp--;
        }
        elseif($mid_value == $needle)
        {
            $pos = $mid_key + 1;
            break;
        }
        else
        {
            for($i = $mid_key; $i <= $last; $i++)
            {
                if( $haystack[$i] > $needle)
                {
                    $pos = $i;
                    break 2;
                }
            }
        }

    }
    #endregion
    
    for($i = $pos; $i <= $last; $i++)
    {
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
    
    foreach($index_table as $key => $value)
    {   
        if($value > $needle)
        {
            $pos = ( $key - 1 > 0 ) ? $key - 1 * INDEX_TABLE_RANGE : 0;
            break;
        }
    }

    for($i = $pos; $i <= $last; $i++)
    {
        $var = $haystack[$i];
        if( $var > $needle)
        {
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
    foreach($haystack as $value)
    {
        if($value == 0)
        {
            continue;
        }

        if($value % $needle == 0)
        {
            array_push($result, $value);
        }
    }

    return $result;
}


?>