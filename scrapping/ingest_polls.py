import meilisearch
import json
import os


client = meilisearch.Client('http://127.0.0.1:7700', 'pukqRFGHCCCcZTQxV8tBebhd')

# iter over all files from ../mowy/
id = 0
for file in os.listdir('../../BD/glosowania'):
    json_file = open(f'../../BD/glosowania/{file}', encoding='utf-8')
    glosowanie = json.load(json_file)

    vote = {}
    vote["id"] = glosowanie[0]
    vote["session"] = glosowanie[1]
    vote["number"] = glosowanie[2]
    vote["group_name"] = glosowanie[3]
    vote["name"] = glosowanie[4]
    id += 1
    # pretty print vote with json
    #print(json.dumps(vote, indent=4, ensure_ascii=False))

    client.index('votes').add_documents(vote)
    print("added" + str(id))