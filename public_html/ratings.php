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

    <main>
    <?php
        // Create connection
        $conn = pg_connect("host=/var/run/postgresql dbname=sejm_db user=sejm password=hRVJCTzNN8PBNUB");
        // Check connection
        if (!$conn) {
          die("Connection failed: " . $conn->connect_error);
          echo "Connection failed";
        }

        // ranking przemówień
        $sql = "SELECT member_of_parliament.id, member_of_parliament.name, club.name, count(text)
                FROM member_of_parliament
                LEFT JOIN speech
                ON member_of_parliament.id = speech.member_of_parliament_id
                LEFT JOIN club
                ON member_of_parliament.club_id = club.id
                GROUP BY member_of_parliament.id, member_of_parliament.name, club.name
                ORDER BY count(text) DESC
                LIMIT 20;";
        $result = pg_query($conn, $sql);

        echo "<header><h2>Ranking przemówień</h2></header>";
        echo "<section><table>";
        echo "<tr><th>Imię i nazwisko</th><th>Klub/koło poselskie</th><th>Liczba przemówień</th></tr>";
        while($row = pg_fetch_row($result)) {
            echo "<tr><td><a href='member.php?id=$row[0]'>$row[1]</a></td><td>$row[2]</td><td>$row[3]</td></tr>";
        }
        echo "</table></section>";

        // ranking przemówień
        $sql = "SELECT member_of_parliament.id, member_of_parliament.name, club.name, count(text)
                FROM member_of_parliament
                LEFT JOIN speech
                ON member_of_parliament.id = speech.member_of_parliament_id
                LEFT JOIN club
                ON member_of_parliament.club_id = club.id
                GROUP BY member_of_parliament.id, member_of_parliament.name, club.name
                ORDER BY count(text)
                LIMIT 30;";
        $result = pg_query($conn, $sql);

        echo "<header><h2>Ranking przemówień – dolna część</h2></header>";
        echo "<section><table>";
        echo "<tr><th>Imię i nazwisko</th><th>Klub/koło poselskie</th><th>Liczba przemówień</th></tr>";
        while($row = pg_fetch_row($result)) {
            echo "<tr><td><a href='member.php?id=$row[0]'>$row[1]</a></td><td>$row[2]</td><td>$row[3]</td></tr>";
        }
        echo "</table></section>";





        pg_close($conn);

    ?>
    </main>


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
