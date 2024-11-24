<?php
// Array of colors for the rainbow
$colors = ["#FF0000", "#FF7F00", "#FFFF00", "#00FF00", "#0000FF", "#4B0082", "#9400D3"];

// Start the for loop
for ($i = 0; $i < count($colors); $i++) {
    echo "<div style='width:200px; height:30px; background-color:{$colors[$i]};'></div>";
}
?>

