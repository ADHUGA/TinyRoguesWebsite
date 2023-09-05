import mysql.connector
import json

# Replace with your own database configuration
db_config = {
    "host": "127.0.0.1",
    "port": 3306,
    "user": "root",
    "password": "root",
}

# Load JSON data from weapon_data.json
with open("weapon_data.json", "r") as json_file:
    weapon_data = json.load(json_file)

# Connect to MySQL server
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()

try:
    # Create the 'tiny' database if it doesn't exist
    cursor.execute("CREATE DATABASE IF NOT EXISTS tiny")
    print("Database 'tiny' created successfully.")

    # Use the 'tiny' database
    cursor.execute("USE tiny")

    # Define the CREATE TABLE query with appropriate data types
    create_table_query = """
        CREATE TABLE IF NOT EXISTS weapons (
            id INT AUTO_INCREMENT PRIMARY KEY,
            Icon LONGBLOB,
            Name VARCHAR(255),
            Weapon VARCHAR(255),
            Attack VARCHAR(255),
            Strength VARCHAR(20),
            Dexterity VARCHAR(20),
            Intelligence VARCHAR(20),
            Damage VARCHAR(20),
            Speed VARCHAR(20),
            WeaponRange VARCHAR(255),
            Tooltip TEXT
        )
        """

    # Create the 'weapons' table

    cursor.execute(create_table_query)
    print("Table 'weapons' created successfully.")

    # Insert data into the 'weapons' table
    insert_query = """
        INSERT INTO weapons (Icon, Name, Weapon, Attack, Strength, Dexterity, Intelligence, Damage, Speed, WeaponRange, Tooltip)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """

    for weapon in weapon_data:
        with open(weapon["Icon"], "rb") as image_file:
            image_data = image_file.read()

        data = (
            image_data,
            weapon["Name"],
            weapon["Weapon"],
            weapon["Attack"],
            weapon["Strength"],
            weapon["Dexterity"],
            weapon["Intelligence"],
            weapon["Damage"],
            weapon["Speed"],
            weapon["WeaponRange"],
            weapon["Tooltip"]
        )
        cursor.execute(insert_query, data)

    # Commit the changes
    conn.commit()
    print("Data inserted into 'weapons' table.")


except mysql.connector.Error as err:
    print("Error:", err)

finally:
    cursor.close()
    conn.close()
