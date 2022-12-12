<?php
echo date('H:i:s');
// sleep(15);

?>
<script>setTimeout(function(){}, 10000);</script>

<?php
flush();
echo "<br>";
echo date('H:i:s');
?>
