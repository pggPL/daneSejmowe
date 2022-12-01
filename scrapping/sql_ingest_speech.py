"""import psycopg2

conn=psycopg2.connect(
  database="sejm_db",
  user="sejm",
  host="/var/run/postgresql",
  password="hRVJCTzNN8PBNUB"
)

cur = conn.cursor()"""

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
    day = json_file["dzień"]
    text = json_file["speech"]

    # escape ' in group_name and name
    group_name = group_name.replace("'", "''")
    name = name.replace("'", "''")

    # sql
    print(f"INSERT INTO speech VALUES ({id}, {session_number}, '{text}', (SELECT id FROM member_of_parliament WHERE position(name in '" + speaker_str + "') > 0), {session_number});")

    id += 1