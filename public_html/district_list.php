<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="style.css">

  <meta charset="UTF-8">
    <title>Lista okręgów</title>
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
                <a href="clubs_list.php"> Kluby </a>
            </li>
            <li>
                <a href="ratings.php"> Rankingi </a>
            </li>
        </ul>

    </nav>
    </header>

    <main>
    <header>
        <h1>Lista okręgów</h1>
    </header>
    <?php
        // Create connection
        $conn = pg_connect("host=/var/run/postgresql dbname=sejm_db user=sejm password=hRVJCTzNN8PBNUB");
        // Check connection
        if (!$conn) {
          die("Connection failed: " . $conn->connect_error);
          echo "Connection failed";
        }

        $sql = "SELECT DISTINCT m1.district, CAST (split_part(m1.district, '  ', 1) as int), count(*) as ile_poslow
                    FROM member_of_parliament AS m1
                    LEFT JOIN member_of_parliament AS m2 ON m2.district = m1.district
                    GROUP BY m2.id, m1.district
                    ORDER BY CAST (split_part(m1.district, '  ', 1) as int)";
        $result = pg_exec($conn, $sql);

        echo '<section><table>';
        echo '<tr><th>Numer okręgu</th><th>Liczba posłów</th></tr>';
        while ($row = pg_fetch_row($result)) {
            // split district by   and get first part
            $district = $row[0];
            $district = explode(" ", $district);
            $district = $district[0];


            echo "<tr><td><a href='district.php?number=".$district."'>$row[0]</a></td><td>".$row[2]."</td></tr>";
        }
        echo '</table></section>';



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
