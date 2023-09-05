import os
import requests
import json
import hashlib
from bs4 import BeautifulSoup
from urllib.parse import urlparse, unquote

url = "https://tiny-rogues.fandom.com/wiki/Weapons"

response = requests.get(url)
soup = BeautifulSoup(response.text, "html.parser")

# Find the table by its class
table = soup.find('table', {'class': 'sortable fandom-table'})

if table:
    data = []
    for row in table.find_all("tr"):
        columns = row.find_all("td")
        if len(columns) >= 11:
            icon_element = columns[0].find("a", class_="image")
            if icon_element:
                icon_image = icon_element['href']

            Name = columns[1].text.strip()

            # Replace 'image_url' with the actual URL of the image you want to download
            image_url = icon_image

            # Get the image data from the URL
            response = requests.get(image_url)

            # Check if the request was successful
            if response.status_code == 200:
                # Get the image content
                image_content = response.content

                # Save the image as a PNG file
                with open(f'icons/{Name}.png', 'wb') as f:
                    f.write(image_content)
                print('Image downloaded and saved as image.png.')
            else:
                print('Failed to download image.')

            Weapon = columns[2].text.strip()
            Attack = columns[3].text.strip()
            Strength = columns[4].text.strip()
            Dexterity = columns[5].text.strip()
            Intelligence = columns[6].text.strip()
            Damage = columns[7].text.strip()
            Speed = columns[8].text.strip()
            Range = columns[9].text.strip()
            Tooltip = columns[10].text.strip()

            data.append({
                "Icon": icon_image,
                "Name": Name,
                "Weapon": Weapon,
                "Attack": Attack,
                "Strength": Strength,
                "Dexterity": Dexterity,
                "Intelligence": Intelligence,
                "Damage": Damage,
                "Speed": Speed,
                "Range": Range,
                "Tooltip": Tooltip
            })

    json_filename = "weapon_data.json"
    with open(json_filename, "w") as json_file:
        json.dump(data, json_file, indent=4)
    print("Data saved to weapon_data.json")

    for item in data:
        print(item)
else:
    print("Table not found.")
