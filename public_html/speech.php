<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8">
    <title>Przemowa</title>
</head>
<body>



    <header>
    <nav>
        <h2>
            &nbsp Dane sejmowe
        </h2>

        <ul>


            <li>
                <a href="index.html"> Posłowie </a>
            </li>
            <li>
                <a href="speech_search.html"> Przemowy </a>
            </li>
            <li>
                <a href="vote_search.html"> Głosowania </a>
            </li>
            <li>
                <a href="district_list.php"> Okręgi </a>
            </li>
            <li>
                <a href="ratings.php"> Rankingi </a>
            </li>
        </ul>

    </nav>
    </header>

    <?php
        // assert $_GET['id'] is a number
        $id = $_GET['id'];
        if (!is_numeric($id)) {
            echo "Invalid id";
            exit();
        }

        // Create connection
        $conn = pg_connect("host=/var/run/postgresql dbname=sejm_db user=sejm password=hRVJCTzNN8PBNUB");
        // Check connection
        if (!$conn) {
          die("Connection failed: " . $conn->connect_error);
          echo "Connection failed";
        }


        $sql = "SELECT number, session_number, text
                    FROM speech
                    WHERE speech.id=".$_GET["id"]."";
        $result = pg_exec($conn, $sql);

        $row = pg_fetch_row($result);

        $number = $row[0];
        $session = $row[1];
        $text = $row[2];

        // Dane podstawowe

        echo '<main>'.$text;

        $sql = "SELECT member_of_parliament.id, name
                    FROM speech LEFT JOIN member_of_parliament ON member_of_parliament.id = member_of_parliament_id
                    WHERE speech.id=".$_GET["id"]."";

        $result = pg_exec($conn, $sql);

        if($row = pg_fetch_row($result)) {
            echo 'Profil posła: <a href = "member.php?id='.$row[0].'">'.$row[1].'</a>';
        }

        echo "</main>";


        pg_close($conn);?>



    <footer>
        <p>
            <small>
                Strona stworzona przez Pawła Gadzińskiego jako projekt na przedmiot ,,Bazy Danych'' w roku akademickim 2022/2023,
                prowadzonym na Wydziale Matematyki i Informatyki Uniwersytetu Warszawskiego.
            </small>
        </p>
    </footer>

</body>
</html>
