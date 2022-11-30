import json

id = 0
with open('../../Sejm/clubs') as f:
    clubs = json.load(f)

    # generate sql insert statements (postgresql
    for club in clubs:
        # escape ' in club[0] and club[1]
        club[0] = club[0].replace("'", "''")
        club[1] = club[1].replace("'", "''")

        print(f"INSERT INTO club VALUES ({id}, '{club[0]}', '{club[1]}');")
        id += 1