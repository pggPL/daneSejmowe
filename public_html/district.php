<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="style.css">

  <meta charset="UTF-8">
    <title>Okręg</title>
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
            $id = $_GET['number'];
        if (!is_numeric($id)) {
            echo "Invalid number";
            exit();
        }
        // Create connection
        $conn = pg_connect("host=/var/run/postgresql dbname=sejm_db user=sejm password=hRVJCTzNN8PBNUB");
        // Check connection
        if (!$conn) {
          die("Connection failed: " . $conn->connect_error);
          echo "Connection failed";
        }

        $sql = "SELECT district FROM member_of_parliament WHERE district LIKE '".$_GET["number"]." ' || '%'";
        $result = pg_exec($conn, $sql);


        $row = pg_fetch_row($result);

        echo "<header><h2>Posłowie z okręgu: ".$row[0]."</h2></header>";

        echo "<section><table><tr><th>Imię i nazwisko</th><th>Klub</th><th>Lista</th><th>Liczba głosów</th><th>Liczba przemów</th><th>Ile razy głosował(a)</th></tr>";

        $sql = "SELECT member_of_parliament.id, member_of_parliament.name, club.name, list, number_of_votes,
                (SELECT count(*) FROM speech WHERE speech.member_of_parliament_id = member_of_parliament.id) AS speeches,
                (SELECT count(*) FROM vote WHERE vote.member_of_parliament_id = member_of_parliament.id) AS votes
                FROM member_of_parliament
                LEFT JOIN club ON member_of_parliament.club_id = club.id
                WHERE district LIKE '".$_GET["number"]." ' || '%'
                ORDER BY number_of_votes DESC";
        $result = pg_exec($conn, $sql);


        while($row = pg_fetch_row($result)) {
            echo '<tr><td><a href="member.php?id='.$row[0].'">'.$row[1]."</a></td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td></tr>";
        }

        echo "</table></section>";



        pg_close($conn);

    ?>


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
