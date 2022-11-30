# https://www.sejm.gov.pl/Sejm9.nsf/wypowiedz.xsp?posiedzenie=66&dzien=1&wyp=107&type=P&symbol=WYPOWIEDZ_POSLA&id=123

import requests
from bs4 import BeautifulSoup

# Download spech from sejm webiste
def download_speech(posiedzenie, dzien, wyp):
    #convert args to srt
    posiedzenie = str(posiedzenie)
    dzien = str(dzien)
    wyp = str(wyp)
    url = 'https://www.sejm.gov.pl/Sejm9.nsf/wypowiedz.xsp?posiedzenie=' + posiedzenie + '&dzien=' + dzien + '&wyp=' + wyp + '&type=P&symbol=WYPOWIEDZ_POSLA&id=123'
    r = requests.get(url)
    soup = BeautifulSoup(r.text, 'html.parser')
    speech = soup.find('div', {'class': 'stenogram'})
    if speech is None:
        return None, None
    mowca = soup.find('h2', {'class': 'mowca'})
    if mowca is None:
        return None, None
    return speech, mowca.text

for posiedzenie in range(26, 1000):
    for dzien in range(1, 100):
        for wyp in range(1, 1000):
            speech, mowca = download_speech(posiedzenie, dzien, wyp)
            if speech:
                # create mowy dir if not exists
                import os
                if not os.path.exists('mowy'):
                    os.makedirs('mowy')

                mowa = {}
                mowa['mowca'] = mowca
                mowa['posiedzenie'] = posiedzenie
                mowa['dzien'] = dzien
                mowa['wyp'] = wyp
                mowa['speech'] = speech.prettify()

                # convert mova to json and save to file
                import json
                with open('mowy/' + str(posiedzenie) + '_' + str(dzien) + '_' + str(wyp) + '.json', 'w', encoding='utf-8') as f:
                    json.dump(mowa, f, indent=4, ensure_ascii=False)

                print(posiedzenie, dzien, wyp)
            else:
                break
