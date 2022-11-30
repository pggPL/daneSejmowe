# iterate over files from ../glosowania

import json
import os
import time

import requests
from bs4 import BeautifulSoup

glos_id = 0
skip = 0
file_id = 0

for file in os.listdir('../glosowania'):
    file_id += 1
    if skip > 0:
        skip -= 1
        continue
    with open(f'../glosowania/{file}', 'r', encoding='utf-8') as f:
        data = json.load(f)
        id_glosowania = data[0]

        # iterate over shortcuts from file clubs
        with open('clubs', 'r', encoding='utf-8') as club_file:
            clubs = json.load(club_file)
            for club in clubs:
                # get data from url
                url = f'https://www.sejm.gov.pl/Sejm9.nsf/agent.xsp?symbol=klubglos&IdGlosowania={id_glosowania}&KodKlubu={club[1]}'
                print(url)
                time.sleep(3)
                response = requests.get(url)
                soup = BeautifulSoup(response.text, 'html.parser')
                #print(soup.prettify())

                # irate over td and make pairs from 3k + 1 and 3k +2
                try:
                    td = soup.find('div', {'id': 'contentBody'}).findAll('td')
                    for i in range(0, len(td), 3):
                        # get data from td
                        name = td[i + 1].text
                        vote = td[i + 2].text
                        print(f'Name: {name}, Vote: {vote}, file_id: {file_id}')

                        # save data to file as json with polish characters
                        with open(f'../glosy/{glos_id}.json', 'w', encoding='utf-8') as glosy_file:
                            json.dump([id_glosowania, club[1], name, vote], glosy_file, ensure_ascii=False)
                            glos_id += 1
                except:
                    continue



