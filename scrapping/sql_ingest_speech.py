import psycopg2

conn=psycopg2.connect(
  database="sejm_db",
  user="sejm",
  host="/var/run/postgresql",
  password="hRVJCTzNN8PBNUB"
)

cur = conn.cursor()

# iter through ../../BD/mowy/
import json

import os

def get_files():
    files = []
    for file in os.listdir('../../BD/mowy/'):
        files.append(file)
    return files

id = 0
# iter
files = get_files()
for file in files:
    with open('../../BD/mowy/' + file, 'r') as f:
        json_file = json.load(f)

    speaker_str = json_file["mowca"]

    session_number = json_file["posiedzenie"]
    number = json_file["wyp"]
    day = json_file["dzien"]
    text = json_file["speech"]

    # escape ' in group_name and name
    text = text.replace("'", "''")
    speaker_str = speaker_str.replace("'", "''")

    # remove last 1 char from speaker_str
    speaker_str = speaker_str[:-1]

    # sql
    #print(f"INSERT INTO speech (id, session_number, number, text, member_of_parliament_id) VALUES ({id}, {session_number}, {number}, '{text}', (SELECT id FROM member_of_parliament WHERE '" + speaker_str + f"' LIKE name || '%'))")
    cur.execute(f"INSERT INTO speech (id, session_number, number, text, member_of_parliament_id) VALUES ({id}, {session_number}, {number}, '{text}', (SELECT id FROM member_of_parliament WHERE '" + speaker_str + f"' LIKE name || '%'))")
    #break
    print("inserted " + str(id))

    id += 1
