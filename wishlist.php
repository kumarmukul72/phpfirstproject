<!DOCTYPE html>
<html>
    <body>
        Wish List of <?php echo $_GET['user'] . "<br/>"; ?>
        <?php
        $con = mysqli_connect("localhost", "root", "kumarsayank");
        if (!$con) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        //set the default client character set 
        mysqli_set_charset($con, 'utf-8');

        mysqli_select_db($con, "wishlist");
        $user = mysqli_real_escape_string($con, $_GET['user']);
        $wisher = mysqli_query($con, "SELECT id FROM wishers WHERE name='" . $user . "'");
        if (mysqli_num_rows($wisher) < 1) {
            exit("The person " . $_GET['user'] . " is not found. Please check the spelling and try again");
        }
        $row = mysqli_fetch_row($wisher);
        $wisherID = $row[0];
        mysqli_free_result($wisher);
        ?>
        <table border="black">
            <tr>
                <th>Item</th>
                <th>Due Date</th>
            </tr>
            <?php
            $result = mysqli_query($con, "SELECT description, due_date FROM wishes WHERE wisher_id=" . $wisherID);
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . htmlentities($row['description']) . "</td>";
                echo "<td>" . htmlentities($row['due_date']) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            mysqli_close($con);
            ?>

</body>
</html>
