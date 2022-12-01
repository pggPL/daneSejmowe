<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="style.css">

  <meta charset="UTF-8">
    <title>Wyszukiwarka posłów</title>
</head>
<body>


    <header>
    <nav>
        <h2>
            &nbsp Dane sejmowe
        </h2>

        <ul>
            <li>
                <a> Wyszukiwanie </a>
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
                </ul>

            </li>
            <li>
                <a> Statystyki </a>
                <ul>
                    <li>
                        <a> Najaktywniejsi z klubu </a>
                    </li>
                    <li>
                        <a> Najaktywniejsi na posiedzeniu </a>
                    </li>
                    <li>
                        <a> Najaktywniejsi w okręgach </a>
                    </li>
                    <li>
                        <a href="education.php"> Wykształcenie posłów </a>
                    </li>
                    <li>
                        <a> Statystyki klubów i kół </a>
                    </li>
                </ul>
            </li>
        </ul>

    </nav>
    </header>

    <section>
          <table >
    <?php
        // Create connection
        $conn = pg_connect("host=/var/run/postgresql dbname=sejm_db user=sejm password=hRVJCTzNN8PBNUB");
        // Check connection
        if (!$conn) {
          die("Connection failed: " . $conn->connect_error);
          echo "Connection failed";
        }

        $sql = "SELECT * FROM member_of_parliament WHERE id=".$_GET["id"]."";
        $result = pg_exec($conn, $sql);


        $row = pg_fetch_row($result);

        $sql = "SELECT name FROM club WHERE id=".$row[14]."";
        $result = pg_exec($conn, $sql);

        $club_name = pg_fetch_row($result)[0];


        echo "<tr><td>Imię i nazwisko</td><td>".$row[1]."</td></tr> ";
        echo "<tr><td>Data wyboru</td><td>".$row[2]."</td></tr> ";
        echo "<tr><td>Lista</td><td>".$row[3]."</td></tr> ";
        // get first number from $row[4]
        echo "<tr><td>Okręg</td><td><a href=\"district.php/number=".substr($row[4], 0, 2)."\">".$row[4]."</a></td></tr> ";
        echo "<tr><td>Liczba głosów</td><td>".$row[5]."</td></tr> ";
        echo "<tr><td>Ślubowanie</td><td>".$row[6]."</td></tr> ";
        echo "<tr><td>Doświadczenie parlamentarne</td><td>".$row[7]."</td></tr> ";
        if($row[8] != null) echo "<tr><td>Funkcja w klubie</td><td>".$row[8]."</td></tr> ";
        echo "<tr><td>Miejsce urodzenia</td><td>".$row[10]."</td></tr> ";
        echo "<tr><td>Wykształcenie</td><td>".$row[11]."</td></tr> ";
        echo "<tr style=\"white-space: break-spaces\"><td>Ukończona szkoła</td><td>".$row[12]."</td></tr> ";
        echo "<tr><td>Zawód</td><td>".$row[13]."</td></tr> ";
        echo "<tr><td>Klub/koło poselskie</td><td><a href=\"club.php?id=".$row[14]."\">".$club_name."</a></td></tr> ";

        $sql = "SELECT count(*) FROM speech WHERE member_of_parliament_id=".$_GET["id"]."";
        $result = pg_exec($conn, $sql);
        echo "<tr><td>Liczba przemówień</td><td>".pg_fetch_row($result)[0]."</td></tr> ";

        $sql = "SELECT count(*) FROM vote WHERE member_of_parliament_id=".$_GET["id"]."";
        $result = pg_exec($conn, $sql);
        $number_of_votes = pg_fetch_row($result)[0];

        $sql = "SELECT count(*) FROM voting";
        $result = pg_exec($conn, $sql);
        $total_votes = pg_fetch_row($result)[0];

        echo "<tr><td>Liczba głosowań</td><td>".$number_of_votes." na ".$total_votes."</td></tr> ";


        pg_close($conn);

    ?>

          </table>
    </section>


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
