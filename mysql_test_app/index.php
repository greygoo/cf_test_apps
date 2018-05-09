<!DOCTYPE html>
<html>

<head>
    <title>PHP MySQL Test Application</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
    PHP/Mysql test<br>
    <?php
        $vcap_services = json_decode($_ENV["VCAP_SERVICES" ]);
        $db = $vcap_services->{'mysql'}[0]->credentials;


        //$mysql_database = $db->database;
        $mysql_database = "mysql";
        $mysql_port=$db->port;
        $mysql_server_name =$db->hostname . ':' . $db->port;
        //$mysql_username = $db->username;
        //$mysql_password = $db->password;
        $mysql_username = "root";
        $mysql_password = "mysql";


        echo "Debug:<br>\n";  
        echo "  mysql_server_name: " . $mysql_server_name . "<br>\n";
        echo "  mysql_username: " . $mysql_username . "<br>\n";
        echo "  mysql_password: " . $mysql_password . "<br>\n";
        echo "  mysql_database: " . $mysql_database . "<br>\n";
        echo "Debug vcap_services: <br>\n";
        echo "  vcap_services: " . $_ENV["VCAP_SERVICES"] . "<br>\n";
        echo "<br>\n";

        $mysqli = new mysqli($mysql_server_name, $mysql_username, $mysql_password, $mysql_database);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error . "<br>\n";
            die();
        }  else {
          echo "Connection successful<br>\n";
        }

        // sql to create table
        $sql = "CREATE TABLE Adress (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        reg_date TIMESTAMP
        )";

        if ($mysqli->query($sql) === TRUE) {
            echo "Table MyGuests created successfully";
        } else {
            echo "Error creating table: " . $mysqli->error;
            die();
        }


    ?>
</body>
</html>
