import meilisearch
import json
import os

client = meilisearch.Client('http://127.0.0.1:7700', 'pukqRFGHCCCcZTQxV8tBebhd')

# iter over all files from ../mowy/
id = 0
for file in os.listdir('../../BD/mowy'):
    json_file = open(f'../../BD/mowy/{file}', encoding='utf-8')
    mowa = json.load(json_file)

    speech = {}
    speech["id"] = id
    speech["session_number"] = mowa["posiedzenie"]
    speech["day"] = mowa["dzien"]
    speech["order"] = mowa["wyp"]
    speech["speaker"] = mowa["mowca"]
    speech["text"] = mowa["speech.php"]
    id += 1
    # print pretty move
    
    client.index('speeches').add_documents(speech)
    print("added" + str(id))