# iter in loop files ./../../glosowania/
import json
import os


def get_files():
    files = []
    for file in os.listdir('./../../glosowania/'):
        files.append(file)
    return files

# iter
files = get_files()
for file in files:
    with open('./../../glosowania/' + file, 'r') as f:
        json_file = json.load(f)

    id = json_file[0]
    session_number = json_file[1]
    group_name = json_file[3]
    name = json_file[4]

    # escape ' in group_name and name
    group_name = group_name.replace("'", "''")
    name = name.replace("'", "''")

    # sql
    print(f"INSERT INTO voting VALUES ({id}, '{group_name}', '{name}', {session_number});")

