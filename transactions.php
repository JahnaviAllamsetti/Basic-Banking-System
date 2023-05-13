<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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

    // Select all records from transfers table
    $sql = "SELECT * FROM transfers";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
    ?>
    <div class="container">
        <h2>Transfers</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Sender Name</th>
                    <th>Sender ID</th>
                    <th>Receiver Name</th>
                    <th>Receiver ID</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each record and display in table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["sender_name"] . "</td>
                    <td>" . $row["sender_id"] . "</td>
                    <td>" . $row["receiver_name"] . "</td>
                    <td>" . $row["receiver_id"] . "</td>
                    <td>" . $row["amount"] . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <a href="customers.php">Back to All Customers</a>
</body>

</html>