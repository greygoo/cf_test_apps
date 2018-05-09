<!DOCTYPE html>
<html>

<head>
    <title>PHP Postgres Test Application</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
    PHP/Postgresql test<br>
    <?php
        $vcap_services = json_decode($_ENV["VCAP_SERVICES" ]);
        $db = $vcap_services->{'postgres'}[0]->credentials;


        $postgres_database = $db->database;
        //$postgres_database = "postgres";
        $postgres_port=$db->port;
        $postgres_server_name =$db->hostname . ':' . $db->port;
        $postgres_username = $db->username;
        $postgres_password = $db->password;


        echo "Debug:<br>\n";  
        echo "  postgres_server_name: " . $postgres_server_name . "<br>\n";
        echo "  postgres_username: " . $postgres_username . "<br>\n";
        echo "  postgres_password: " . $postgres_password . "<br>\n";
        echo "  postgres_database: " . $postgres_database . "<br>\n";
        echo "Debug vcap_services: <br>\n";
        echo "  vcap_services: " . $_ENV["VCAP_SERVICES"] . "<br>\n";
        echo "<br>\n";


        echo "Connecting to database<br>\n";

        $dbconn = pg_connect("host=$db->hostname port=$postgres_port dbname=$postgres_database user=$postgres_username password=$postgres_password") or die('Could not connect: ' . pg_last_error());

        if(!$dbconn) {
            echo "Error : Unable to open database<br>\n";
        } else {
            echo "Opened database successfully<br>\n";
        }


        // sql to create table
        $sql =<<<EOF
            CREATE TABLE COMPANY
            (ID INT PRIMARY KEY     NOT NULL,
            NAME           TEXT    NOT NULL,
            AGE            INT     NOT NULL,
            ADDRESS        CHAR(50),
            SALARY         REAL);
EOF;

        $ret = pg_query($dbconn, $sql);

        if (!$ret) {
            echo "Error creating table: " . pg_last_error($dbconn) . "<br>\n";
        } else {
            echo "Table Company created successfully<br>\n";
        }


        $sql =<<<EOF
            DROP TABLE IF EXISTS COMPANY;
EOF;
        
        $ret = pg_query($dbconn, $sql);

        if (!$ret) {
            echo "Error dropping table table: " . pg_last_error($dbconn) . "<br>\n";
        } else {
            echo "Table Company dropped successfully<br>\n";
        }

    ?>
</body>
</html>
