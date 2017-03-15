
<?php
//print("hello");
$val=number_format($stock["price"],2,'.', '');
print("A Share of " . $stock["name"]);
print("(" . $stock["symbol"] );
print(") costs $" .$val);

?>