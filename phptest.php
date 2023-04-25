<?php
    function print_title() {
        echo '<title>test&#33;</title>';
    }

    function print_pyramid($n) {
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < ($n - 1) - $i; $j++) {
                print("&nbsp;");
            }
            for ($j = 0; $j < 2 * $i + 1; $j++) {
                print("&#42;");
            }
            echo '<br>';
        }
    }
?>

<!doctype html>
<html>
    <head>
        <?php
            print_title();
        ?>
    </head>
    <body>
        <?php
            $n = $_GET['n'];
            if (!isset($n)) {
                $n = 0;
            }
            print_pyramid($n);
        ?>
    </body>
</html>