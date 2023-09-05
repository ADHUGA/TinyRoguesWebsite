import os
import json

# Load JSON data from weapon_data.json
with open("weapon_data.json", "r") as json_file:
    weapon_data = json.load(json_file)

for weapon in weapon_data:
    weapon_name = weapon["Name"]
    new_icon_path = f"icons/{weapon_name}.png"
    weapon["Icon"] = new_icon_path

# Write the updated JSON data back to the file
with open("weapon_data.json", "w") as json_file:
    json.dump(weapon_data, json_file, indent=4)