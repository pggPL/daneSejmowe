<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="https://unpkg.com/mvp.css@1.12/mvp.css">

  <link rel="stylesheet" href="style_search.css" />
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
                        <a> Aktywność a tytuł naukowy </a>
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
    <?php
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

        echo "<h1>".$club_name."</h1>";

        pg_close($conn);?>

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
