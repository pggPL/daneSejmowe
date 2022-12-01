# read from ../Sejm/posiedzenia
# and generate sql insert statements (postgresql)

# for each posiedzenie
#   for each sejmik
#     for each klub
#       for each posel
#         insert into klub_posel (id_klubu, id_posla, id_sejmiku)
#       for each glos
#         insert into glos (id_posla, id_sejmiku, id_posiedzenia, glos)

import json

id = 0
with open('../../Sejm/posiedzenia') as f:
    posiedzenia = json.load(f)

    # generate sql insert statements (postgresql
    for posiedzenie in posiedzenia:
        # escape ' in club[0] and club[1]
        posiedzenie = posiedzenie.replace("'", "''")

        print(f"INSERT INTO session VALUES ({id}, '{posiedzenie}');")
        id += 1
