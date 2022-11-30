# Scrap from https://www.sejm.gov.pl/sejm9.nsf/terminarz.xsp?rok=2022 with beautiful  soup from years from 2000 to 2023

import requests
from bs4 import BeautifulSoup
import json

# create empty list
l = []

# loop for years from 2000 to 2023
for year in range(2000, 2024):
    # create url
    url = f'https://www.sejm.gov.pl/sejm9.nsf/terminarz.xsp?rok={year}'
    # get page
    page = requests.get(url)
    # create soup
    soup = BeautifulSoup(page.content, 'html.parser')
    # find all h3
    s = soup.findAll('td')
    # extract text from all s   list named l
    l += [x.text for x in s]

# remove elements without Posiedzenie from list
l = [x for x in l if 'Posiedzenie' in x]

# remove elements without number as first character from list
l = [x for x in l if x[0].isdigit()]

# save l to file with json, indent 4 and ahndle encoding polish letters
with open('posiedzenia', 'w', encoding='utf-8') as f:
    json.dump(l, f, indent=4, ensure_ascii=False)
