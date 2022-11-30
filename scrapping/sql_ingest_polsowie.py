
import json
import os


# convert dd-mm-yyyy to yyyy-mm-dd
# if none, return None
def convert_date(date):
    if date is None:
        return "Null"
    # if date is invalid, return None
    if len(date.split("-")) != 3:
        return "Null"
    # if there is no integer in date, return None
    if not date.split("-")[0].isnumeric() or not date.split("-")[1].isnumeric() or not date.split("-")[2].isnumeric():
        return "Null"
    return "'" + date[-4:] + "-" + date[3:5] + "-" + date[:2] + "'"

# iter over all files from ../mowy/
id = 0
for file in os.listdir('../../BD/poslowie'):
    json_file = open(f'../../BD/poslowie/{file}', encoding='utf-8')
    posel = json.load(json_file)

    mp = {}
    id = id
    name = posel["Imię i nazwisko"]
    # if wybrany dnia is not null
    if "Wybrany dnia:" in posel:
        election_date = posel["Wybrany dnia:"]
    else:
        election_date = posel["Wybrana dnia:"]

    lista = posel["Lista:"]
    district = posel["Okręg wyborczy:"]
    number_of_votes = posel["Liczba głosów:"]
    date_of_oath = posel["Ślubowanie:"]
    experience_in_parliament = posel["Staż parlamentarny:"]
    club = posel["Klub/koło:"]
    function_in_club = posel["Funkcja w klubie/kole:"] if "Funkcja w klubie/kole:" in posel else "null"

    date_of_birth = posel["Data i miejsce urodzenia:"].split(" ")[0]

    place_of_birth = "NULL"
    if len(posel["Data i miejsce urodzenia:"].split(" ")) > 1:
        place_of_birth = posel["Data i miejsce urodzenia:"].split(" ")[1]

    education = "NULL"
    finished_school = "NULL"
    if "Wykształcenie:" in posel:
        education = posel["Wykształcenie:"]
    if "Ukończona szkoła:" in posel:
        finished_school = posel["Ukończona szkoła:"]
    profession = posel["Zawód:"]
    id += 1

    date_of_birth = convert_date(date_of_birth)
    date_of_oath = convert_date(date_of_oath)
    election_date = convert_date(election_date)

    if function_in_club != "null":
        function_in_club = "'" + function_in_club + "'"

    # escape apostrophes in club
    club = club.replace("'", "''")

    sql = f"INSERT INTO member_of_parliament VALUES ({id}, '{name}', {election_date}, '{lista}', '{district}', {number_of_votes}, " \
          f"{date_of_oath}, '{experience_in_parliament}', {function_in_club}, {date_of_birth}, '{place_of_birth}', '{education}', '{finished_school}', '{profession}', (SELECT id FROM club WHERE name = '{club}'));"

    print(sql)