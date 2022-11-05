# Baza danych sejmowych.

Jest to projekt na przedmiot "Bazy Danych" 2022/2023 na wydziale MIM Uniwersytetu Warszawskiego.

## Motywacja

Sejm udostępnia bardzo wiele danych – chociażby informacje o posłach, wyniki głosowań czy nawet spisane przemówienia. Niemniej jednak dane te są dość trudno dostępne z punktu widzenia programisty i bardziej dogłębna ich analiza jest trudna. Przykładowym pytaniem jakie można zadać jest ,,Jak bardzo skorelowane są wyniki głosowań jednej partii z drugą?''. Obecnie dostęp do takich danych jest praktycznie niemożliwy. Stworzenie sensownej bazy ułatwiłoby prace dziennikarzom czy politologom, którzy mimo posiadania pewnych umiejętności przetwarzania danych, niekoniecznie muszą umieć zescrappować stronę.

## Cele

 - zescrapowanie danych z poprzednich kadencji sejmu i umieszczenie ich w plikach możliwych do pobrania,
 - stworzenie wygodnego interfejsu to przeglądania danych, w tym kilku statystyk, których obecnie nie ma – np. korelacji głosowań między partiami

## Czego nie będzie i dlaczego

- nie będzie automatycznego pobierania danych z obecnej i następnych kadencji ze strony sejmu. Strona będzie miałą charakter archiwalny. Powód tego jest taki, że nie będę miał czasu supportować tej strony po zakończeniu przedmiotu. Poza tym strona sejmu może się zmienić i wtedy trzeba będzie pisać skrypt scrappujący od nowa.

## Technologie

 - Interfejs w JavaScript i PHP
 - Skrypty w pythonie do zescrapowania strony,
 - relacyjna baza danych SQL,
 - baza danych oparta o przeszukiwanie jak Meilisearch do wyszukiwania informacji w przemówieniach,
 
 ## Co zostanie wykonane
 
 - Scrapowanie podstawowych danych ze strony Sejmu,
 - Ładny interfejs do przeglądu danych posłów,
 - Wyszukiwarka przemówień,
 - Kilka ekranów do nietrywialnych statystyk takich jak korelacja miedzy głosowaniami,
