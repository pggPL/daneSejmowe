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

        echo '<main>'.$text;

        $sql = "SELECT group_name, name FROM voting WHERE id = ".$_GET["id"]."";

        $result = pg_exec($conn, $sql);

        $row = pg_fetch_row($result);

        echo '<h2>'.$row[0].'</h2>';
        echo '<h3>'.$row[1].'</h3>';

        // krótki wynik

        $sql = "SELECT type, count(*) FROM vote WHERE voting_id=".$_GET["id"]." GROUP BY type";

        $result = pg_exec($conn, $sql);

        echo '<header><h3>Wynik głosowania</h3></header>';

        echo '<section><table>';
        while ($row = pg_fetch_row($result)) {
            echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td></tr>';
        }
        echo '</table></section><br><br>';

        // teraz głosy

        $sql = "SELECT club.name,
                    sum(za) za,
                    sum(przeciw) przeciw,
                    sum(wstrzymano) wstrzymano,
                    sum(nieobecny) nieobecny,
                    count(*) razem
                FROM (SELECT vote.*,
                        (CASE WHEN type='za' THEN 1 ELSE 0 END) za,
                        (CASE WHEN type='przeciw' THEN 1 ELSE 0 END) przeciw,
                        (CASE WHEN type='wstrzymano się' THEN 1 ELSE 0 END) wstrzymano,
                        (CASE WHEN type='nieobecny' THEN 1 ELSE 0 END) nieobecny
                            FROM vote WHERE voting_id=".$_GET["id"]."
                ) vote
                LEFT JOIN club ON club.id = club_of_the_mp_at_the_time
                GROUP BY club_of_the_mp_at_the_time, club.name;";

        $result = pg_exec($conn, $sql);

        // every club in one row
        echo '<section><table>';
        echo '<tr><th>Klub</th><th>Za</th><th>Przeciw</th><th>Wstrzymano</th><th>Nieobecny</th><th>Razem</th></tr>';
        $total_0 = 0;
        $total_1 = 0;
        $total_2 = 0;
        $total_3 = 0;
        while($row = pg_fetch_row($result)) {
            echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[5].'</td></tr>';
            $total_0 += $row[1];
            $total_1 += $row[2];
            $total_2 += $row[3];
            $total_3 += $row[4];
        }

        echo '<tr><td><b>Suma</b></td><td>'.$total_0.'</td><td>'.$total_1.'</td><td>'.$total_2.'</td><td>'.$total_3.'</td><td>'.($total_0+$total_1+$total_2+$total_3).'</td></b></tr>';


        echo '<header><h3>Wynik głosowania</h3></header>';

        echo '<section><table>';
        while ($row = pg_fetch_row($result)) {
            echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td></tr>';
        }
        echo '</table></section><br><br>';

        echo '<header><h3>Szczegółowe głosy</h3></header>';

        $sql = "SELECT type, member_of_parliament.name, club.name FROM vote
                    LEFT JOIN member_of_parliament ON vote.member_of_parliament_id = member_of_parliament.id
                    LEFT JOIN club ON member_of_parliament.club_id = club.id
                    WHERE voting_id = ".$_GET["id"]."";

        $result = pg_exec($conn, $sql);

        echo '<section><table>';
        while($row = pg_fetch_row($result)) {
            echo '<tr><td>'.$row[0].'</td><td> '.$row[1].'</td><td> '.$row[2].'</td></tr>';
        }
        echo '</table></section>';

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
