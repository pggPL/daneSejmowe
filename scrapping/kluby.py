# Scrap from https://www.sejm.gov.pl/Sejm9.nsf/kluby.xsp with BeautifulSoup

import requests
from bs4 import BeautifulSoup

url = 'https://www.sejm.gov.pl/Sejm9.nsf/kluby.xsp'
page = requests.get(url)
soup = BeautifulSoup(page.content, 'html.parser')


s = soup.findAll('h3')

# extract text from all s   list named l
l = [x.text for x in s]

l_shortcuts = []

s = soup.findAll('a')
for x in s:
    if x.has_attr('href'):
        if x['href'].startswith('/Sejm9.nsf/klub.xsp?klub='):
            # append shortcut to list
            l_shortcuts.append(x['href'][len('/Sejm9.nsf/klub.xsp?klub='):])

# dump l into file "clubs" with json and indent 4 and encoding utf-8

# make list of pairs from l and l_shortcuts
l = list(zip(l, l_shortcuts))

import json
with open('clubs', 'w', encoding='utf-8') as f:
    json.dump(l, f, indent=4, ensure_ascii=False)

