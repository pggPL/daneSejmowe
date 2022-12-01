import meilisearch
import json

client = meilisearch.Client('http://localhost:7700')

v = client.index('speech.php').search('aborcja')
#pretty print v with polish characters
print(json.dumps(v, ensure_ascii=False, indent=4))
#print(client.get_task(0))