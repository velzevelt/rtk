<?= file_get_contents('header.html'); ?>

<div>
    <h1>О нас</h1>
</div>

<?php 

$ar = range(0, 15);
foreach($ar as $key => $val)
{
    echo "$key => $val" . "<br>";
}

?>


<?= file_get_contents('footer.html'); ?>