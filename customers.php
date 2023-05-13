<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- navbar starts here  -->
    <nav class="navbar">
        <a href="index.php">Nimbuspay Bank</a>
    </nav>
    <!-- navbar ends here  -->

    <div style="margin: 50px">
        <h1 style="text-align:center">All Customers</h1>
        <br>

        <table class="table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "mybank";

                $connection = new mysqli($servername, $username, $password, $database);

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $sql = "SELECT * FROM customers";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "
                <tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["phone"] . "</td>
                    <td>" . $row["balance"] . "</td>
                    <td>
                        <a href=\"view_customer.php?id=" . $row["id"] . "\">View</a> | 
                        <a href=\"transfer_money.php?sender_id=" . $row["id"] . "\">Transfer</a>
                    </td>
                </tr>";
                }
                ?>
            </tbody>

        </table>

        <div class="nav">
            <a href="index.php">Go to Home</a>

            <a href="transactions.php">See All Transactions</a>
        </div>
    </div>
</body>

</html>
