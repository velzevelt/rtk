<?php

/**
 * Создает возрастающую последовательность
 * @param int $start
 * @param int $length
 * @param int $r_threshhold порог возможной разности между элементами
 * @return array
 */
function rand_sq(int $start, int $length, int $r_threshhold = 20): array
{
    $result = [$start];

    for ($i = 1; $i < $length; $i++) {
        while ($result[$i] <= $result[$i - 1]) {
            $result[$i] += rand(1, $r_threshhold);
        }
    }

    return $result;
}

// $ar = rand_sq(100, 1000, 5);
// $ar = json_encode($ar);
// file_put_contents('array.txt', $ar);

echo 'Array generated:' . __DIR__ . 'array.txt';