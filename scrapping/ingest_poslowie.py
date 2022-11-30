#import meilisearch
import json
import os


#client = meilisearch.Client('http://127.0.0.1:7700', 'pukqRFGHCCCcZTQxV8tBebhd')

# iter over all files from ../mowy/
id = 0
for file in os.listdir('../../poslowie'):
    json_file = open(f'../../poslowie/{file}', encoding='utf-8')
    posel = json.load(json_file)
    print(posel["Imię i nazwisko"])
    print(id)

    mp = {}
    mp["id"] = id
    mp["name"] = posel["Imię i nazwisko"]
    # if wybrany dnia is not null
    if "Wybrany dnia:" in posel:
        mp["election_date"] = posel["Wybrany dnia:"]
    else:
        mp["election_date"] = posel["Wybrana dnia:"]

    mp["list"] = posel["Lista:"]
    mp["district"] = posel["Okręg wyborczy:"]
    mp["number_of_votes"] = posel["Liczba głosów:"]
    mp["date_of_oath"] = posel["Ślubowanie:"]
    mp["experience_in_parliament"] = posel["Staż parlamentarny:"]
    mp["club"] = posel["Klub/koło:"]
    mp["function_in_club"] = posel["Funkcja w klubie/kole:"] if "Funkcja w klubie/kole:" in posel else None
    
    mp["date_of_birth"] = posel["Data i miejsce urodzenia:"].split(" ")[0]
    if len(posel["Data i miejsce urodzenia:"].split(" ")) > 1:
        mp["place_of_birth"] = posel["Data i miejsce urodzenia:"].split(" ")[1]
    
    if "Wykształcenie:" in posel:
        mp["education"] = posel["Wykształcenie:"]
    if "Ukończona szkoła:" in posel:
        mp["finished_school"] = posel["Ukończona szkoła:"]
    mp["profession"] = posel["Zawód:"]
    id += 1
    #client.index('members_of_parliament').add_documents(mp)
    #print("added" + str(id))