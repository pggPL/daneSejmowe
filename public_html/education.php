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

    <header>
        <h1>Wykształcenie posłów</h1>
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

        // Statystyka ogólna - (wykształcenie, liczba posłów)


        $sql = "SELECT education, count(*)
                    FROM member_of_parliament
                    GROUP BY education
                    HAVING education != 'NULL'
                    ORDER BY count(*);";
        $result = pg_exec($conn, $sql);

        echo '<section><table>';
        echo '<tr><th>Wykształcenie</th><th>Liczba posłów</th></tr>';
        while($row = pg_fetch_row($result)) {
            echo "<tr><td>$row[0] </td> <td>$row[1]</td></p>";
        }
        echo '</table></section>';


        pg_close($conn);?>

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
