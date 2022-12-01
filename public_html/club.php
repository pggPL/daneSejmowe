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
             'id'];
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


        $sql = "SELECT name FROM club WHERE id=".$_GET["id"]."";
        $result = pg_exec($conn, $sql);

        $club_name = pg_fetch_row($result)[0];

        echo "<header><h4>".$club_name."</h4></header>";

        // Dane podstawowe

        echo "<section><table>";

        // liczba posłów w chwili obecnej

        $sql = "SELECT COUNT(*) FROM member_of_parliament WHERE club_id=".$_GET["id"]."";
        $result = pg_exec($conn, $sql);

        $number_of_mps = pg_fetch_row($result)[0];

        echo "<tr>";
        echo "<td>Liczba posłów</td>";
        echo "<td>".$number_of_mps."</td>";
        echo "</tr>";

        // liczba przemów posłów
        // liczba przemów posłów jako % całości

        $sql = "SELECT COUNT(*) FROM speech WHERE (SELECT club_id FROM member_of_parliament WHERE id = member_of_parliament_id) = ".$_GET["id"]."";
        $result = pg_exec($conn, $sql);

        $number_of_speeches_from_club = pg_fetch_row($result)[0];

        echo "<tr>";
        echo "<td>Liczba przemów posłów</td>";
        echo "<td>".$number_of_speeches_from_club."</td>";
        echo "</tr>";

        $sql = "SELECT COUNT(*) FROM speech";
        $result = pg_exec($conn, $sql);

        $total_speaches = pg_fetch_row($result)[0];

        echo "<tr>";
        echo "<td>Liczba przemów jako część przemów wszystkich posłów</td>";
        echo "<td>".round($number_of_speeches_from_club / $total_speaches * 100, 1)."% </td>";
        echo "</tr>";

        echo "</table></section>";


        $sql = "SELECT member_of_parliament.id, name, count(text)
                FROM member_of_parliament
                LEFT JOIN speech
                ON member_of_parliament.id = speech.member_of_parliament_id
                GROUP BY member_of_parliament.id, name
                HAVING club_id = ".$_GET["id"]."
                ORDER BY count(text) DESC
                LIMIT 5;";


        $result = pg_exec($conn, $sql);


        echo "<header><h5>Najbardziej aktywni posłowie pod względem wypowiedzi</h5></header>";

        echo "<section><table>";
        echo "<tr> <th>Posłowie</th> <th>Liczba przemów</th> </tr>";
        while($row = pg_fetch_row($result)) {
            echo "<tr><td>".$row[1]."</td> <td>".$row[2]."</td></tr>";
        }
        echo "</table></section>";



        $sql = "SELECT member_of_parliament.id, name, count(text)
                FROM member_of_parliament
                LEFT JOIN speech
                ON member_of_parliament.id = speech.member_of_parliament_id
                GROUP BY member_of_parliament.id, name
                HAVING club_id = ".$_GET["id"]."
                ORDER BY count(text) DESC
                LIMIT 5;";


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
