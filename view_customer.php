<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
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

    $id = $_GET["id"];

    $sql = "SELECT * FROM customers WHERE id=$id";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }

    $row = $result->fetch_assoc();
    ?>

    <h1>Customer Details</h1>
    <br>

    <table class="table">

        <tbody>
            <tr>
                <td>Name:</td>
                <td>
                    <?php echo $row["name"]; ?>
                </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>
                    <?php echo $row["email"]; ?>
                </td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td>
                    <?php echo $row["phone"]; ?>
                </td>
            </tr>
            <tr>
                <td>Balance:</td>
                <td>
                    <?php echo $row["balance"]; ?>
                </td>
            </tr>
        </tbody>

    </table>

    <a href="customers.php">Back to All Customers</a>

</body>

</html>