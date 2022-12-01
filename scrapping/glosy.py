# iterate over files from ../glosowania

import json
import os
import time

import psycopg2

conn=psycopg2.connect(
  database="sejm_db",
  user="sejm",
  host="/var/run/postgresql",
  password="hRVJCTzNN8PBNUB"
)

import requests
from bs4 import BeautifulSoup


cur = conn.cursor()

cur.execute("DELETE FROM vote")

id = 0
for file in os.listdir('../../BD/glosowania'):
    with open(f'../../BD/glosowania/{file}', 'r', encoding='utf-8') as f:
        data = json.load(f)
        id_glosowania = data[0]

        # iterate over shortcuts from file clubs
        with open('../../BD/Sejm/clubs', 'r', encoding='utf-8') as club_file:
            clubs = json.load(club_file)
            i = 0
            while i < len(clubs):
                club  = clubs[i]
                # get data from url
                url = f'https://www.sejm.gov.pl/Sejm9.nsf/agent.xsp?symbol=klubglos&IdGlosowania={id_glosowania}&KodKlubu={club[1]}'
                print(url)
                time.sleep(3)

                try:
                    response = requests.get(url)
                except:
                    time.sleep(100)
                    continue

                soup = BeautifulSoup(response.text, 'html.parser')
                #print(soup.prettify())

                # irate over td and make pairs from 3k + 1 and 3k +2
                td = soup.find('div', {'id': 'contentBody'}).findAll('td')
                for j in range(0, len(td), 3):
                    # get data from td
                    id_glosowania = id_glosowania
                    name = td[j + 1].text

                    # "surname name1 name2 .." to "name1 name2 .. surname" in name
                    name = ' '.join(name.split(' ')[1:]) + ' ' + name.split(' ')[0]

                    vote = td[j + 2].text
                    club_shortcut = clubs[i][1]

                    vote_dict = {
                        'Za': 'za',
                        'Przeciw': 'przeciw',
                        'Wstrzymał się': 'wstrzymano się',
                        'Nie głosował': 'nie glosowal',
                        'Nieobecny': 'nieobecny'
                    }

                    vote = vote_dict[vote]

                    if name == "vel Sęk Szymon Szynkowski":
                        name = "Szymon Szynkowski vel Sęk"

                    sql = f"INSERT INTO vote (id, type, member_of_parliament_id, voting_id, club_of_the_mp_at_the_time) " \
                          f"VALUES " \
                          f"({id}, '{vote}', (SELECT id FROM member_of_parliament WHERE name = '{name}'), '{id_glosowania}', (SELECT id FROM club WHERE abbreviation = '{club_shortcut}'));"

                    print(sql)
                    cur.execute(sql)
                    id += 1

                    conn.commit()  # <- We MUST commit to reflect the inserted data
                i += 1
    os.remove(f'../../BD/glosowania/{file}')
cur.close()
conn.close()

