<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="style.css">-->
</head>

<body style="margin: 50px">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mybank";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (isset($_GET["sender_id"])) {
        $sender_id = $_GET["sender_id"];

        $sql = "SELECT * FROM customers WHERE id='$sender_id'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }

        $sender = $result->fetch_assoc();
    }

    if (isset($_POST["submit"])) {
        $sender_id = $_POST["sender_id"];
        $receiver_id = $_POST["receiver_id"];
        $amount = $_POST["amount"];

        // Get sender's information
        $sql = "SELECT * FROM customers WHERE id='$sender_id'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }

        $sender = $result->fetch_assoc();
        $sender_name = $sender["name"];
        $sender_balance = $sender["balance"];

        // Get receiver's information
        $sql = "SELECT * FROM customers WHERE id='$receiver_id'";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }

        $receiver = $result->fetch_assoc();
        $receiver_name = $receiver["name"];
        $receiver_balance = $receiver["balance"];

        // Check if sender has enough balance to transfer
        if ($sender_balance < $amount) {
            echo "<div class=\"alert alert-danger\">Insufficient balance</div>";
        } else {
            // Update sender's balance
            $new_sender_balance = $sender_balance - $amount;
            $sql = "UPDATE customers SET balance='$new_sender_balance' WHERE id='$sender_id'";

            if (!$connection->query($sql)) {
                die("Error updating sender's balance: " . $connection->error);
            }

            // Update receiver's balance
            $new_receiver_balance = $receiver_balance + $amount;
            $sql = "UPDATE customers SET balance='$new_receiver_balance' WHERE id='$receiver_id'";

            if (!$connection->query($sql)) {
                die("Error updating receiver's balance: " . $connection->error);
            }

            // Insert transaction record into transfers table
            $sql = "INSERT INTO transfers (sender_name, sender_id, receiver_name, receiver_id, amount) VALUES ('$sender_name', '$sender_id', '$receiver_name', '$receiver_id','$amount')";
            if (!$connection->query($sql)) {
                die("Error inserting transaction record: " . $connection->error);
            }

            echo "<div class=\"alert alert-success\">Transaction successful</div>";
        }
    }

    $sql = "SELECT * FROM customers WHERE id!='$sender_id'";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
    ?>

    <div class="container">
        <h1 style="padding:10px">Transfer Money</h1>
        <form method="POST">
            <div class="form-group">
                <label for="sender-name" style="padding:10px">Sender Name:</label>
                <input style="padding:10px" type="text" class="form-control" id="sender-name" name="sender_name"
                    value="<?php echo $sender["name"]; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="sender-balance" style="padding:10px">Sender Balance:</label>
                <input style="padding:10px" type="text" class="form-control" id="sender-balance" name="sender_balance"
                    value="<?php echo $sender["balance"]; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="receiver-id" style="padding:10px">Receiver:</label>
                <select style="padding:10px" class="form-control" id="receiver-id" name="receiver_id">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="amount" style="padding:10px">Amount:</label>
                <input style="padding:10px" type="number" class="form-control" id="amount" name="amount" min="0"
                    max="<?php echo $sender["balance"]; ?>" required>
            </div>
            <input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>">
            <div style="padding-top:10px"><button type="submit" class="btn btn-primary" name="submit"
                    style="padding:10px">Transfer</button></div>
        </form>
    </div>
    <div class="nav"> <a href="customers.php">Back to All Customers</a> </div>
</body>

</html>
