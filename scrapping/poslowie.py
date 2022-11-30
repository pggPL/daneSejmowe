# Download https://www.sejm.gov.pl/Sejm9.nsf/posel.xsp?id=001&type=A to beautifulsoup

import requests
from bs4 import BeautifulSoup
import json

def posel(id):
    url = 'https://www.sejm.gov.pl/Sejm9.nsf/posel.xsp?id=' + id + '&type=A'
    r = requests.get(url)
    soup = BeautifulSoup(r.text, 'html.parser')

    d = {}

    # Imię i nazwisko
    name = soup.find('div', {'id': 'title_content'}).find('h1').text
    d['Imię i nazwisko'] = name

    data = soup.findAll('ul', {'class': 'data'})

    data_name = data[0].findAll('p', {'class': 'left'})
    data_value = data[0].findAll('p', {'class': 'right'})

    for i in range(len(data_name)):
        print(data_name[i].text, data_value[i].text)
        d[data_name[i].text] = data_value[i].text

    cv_name = data[1].findAll('p', {'class': 'left'})
    cv_value = data[1].findAll('p', {'class': 'right'})

    for i in range(len(cv_name)):
        print(cv_name[i].text, cv_value[i].text)
        d[cv_name[i].text] = cv_value[i].text

    return d

for id in range(1, 1000):
    id_three_digits = str(id).zfill(3)
    p = posel(id_three_digits)


    # make dir poslowie if there is no
    import os
    if not os.path.exists('poslowie'):
        os.makedirs('poslowie')

    # if name in p is none or has length 0, then break
    if not p['Imię i nazwisko'] or len(p['Imię i nazwisko']) == 0:
        break

    # save p to file in dir poslowe with indent 4 with proper encoding
    with open('poslowie/' + id_three_digits + '.json', 'w', encoding='utf-8') as f:
        json.dump(p, f, indent=4, ensure_ascii=False)


