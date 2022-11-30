# https://www.sejm.gov.pl/Sejm9.nsf/agent.xsp?symbol=glosowania&NrKadencji=9&NrPosiedzenia=66&NrGlosowania=3
# https://www.sejm.gov.pl/Sejm9.nsf/agent.xsp?symbol=klubglos&IdGlosowania=59201&KodKlubu=PiS
import json

import requests
from bs4 import BeautifulSoup


def glosowanie(posiedzenie, glosowanie):
    print(f'Posiedzenie: {posiedzenie}, glosowanie: {glosowanie}')
    url = f'https://www.sejm.gov.pl/Sejm9.nsf/agent.xsp?symbol=glosowania&NrKadencji=9&NrPosiedzenia={posiedzenie}&NrGlosowania={glosowanie}'
    response = requests.get(url)
    soup = BeautifulSoup(response.text, 'html.parser')
    # print div contentBody id
    try:
        title = soup.find('div', {'id': 'contentBody'}).find('font', {'color': '#3A3A3A'}).text
        subtitle = soup.find('div', {'id': 'contentBody'}).findAll('p', {'class': 'subbig'})[1].text
        # match IdGlosowania=int in soup and get this int to id
        id = int(soup.find('div', {'id': 'contentBody'}).findAll('a')[1]['href'].split('=')[2].split('&')[0])
        print(f'Title: {title}')
        print(f'Subtitle: {subtitle}')
        print(f'Id: {id}')
    except:
        return False

    data = [id, posiedzenie, glosowanie, title, subtitle]

    # save data as json with polish characters to file posiedzenie_glosowanie in directory glosowania (create if not exists)
    import os
    if not os.path.exists('../glosowania'):
        os.makedirs('../glosowania')

    with open(f'../glosowania/{posiedzenie}_{glosowanie}.json', 'w', encoding='utf-8') as f:
        json.dump(data, f, ensure_ascii=False)

    # get KodKlubu from hrefs in soup
    hrefs = soup.find('div', {'id': 'contentBody'}).findAll('a')
    klub = []
    for href in hrefs:
        if 'KodKlubu' in href['href']:
            klub.append(href.text)
            klub.append(href['href'].split('=')[3].split('&')[0])

    # remove numbers and duplicates from klub
    klub = [x for x in klub if not x.isdigit()]
    klub = list(dict.fromkeys(klub))

    # open clubs and load json
    with open('clubs', 'r', encoding='utf-8') as club_file:
        clubs = json.load(club_file)
        # get this in klub which are not in the second of the pair in clubs
        klub = [x for x in klub if x not in [y[1] for y in clubs]]
        # add new klub to clubs
        for x in klub:
            clubs.append([x, x])
        # save clubs as json with polish characters to file clubs
        with open('clubs', 'w', encoding='utf-8') as club_file2:
            json.dump(clubs, club_file2, ensure_ascii=False, indent=4)


    return True


# iter over all posiedzenia and glosowania
for posiedzenie in range(61, 67):
    for glo in range(1, 300):
        if not glosowanie(posiedzenie, glo):
            continue
glosowanie(1, 1)