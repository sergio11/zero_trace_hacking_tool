import requests

API_KEY_GOOGLE = 'Aqui tu API KEY de Google'
SEARCH_ENGINE_ID = 'Aqui tu Search Engine ID para Google'

query = 'filetype:sql "MySQL dump" (pass|password|passwd|pwd)'
page = 1
lang = "lang_es"

url = f"https://www.googleapis.com/customsearch/v1?key={API_KEY_GOOGLE}&cx={SEARCH_ENGINE_ID}&q={query}&start={page}&lr={lang}"

response = requests.get(url)
data = response.json()

results = data.get("items", [])

for result in results:
    print("------- Nuevo resultado -------")
    print(f"Título: {result.get('title')}")
    print(f"Descripción: {result.get('snippet')}")
    print(f"Enlace: {result.get('link')}")
    print("-------------------------------")
