<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny Rogues Suguru</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <style>
        body {
        margin: 0; /* Remove default margin */
        overflow-x: hidden; /* Hide horizontal scrollbar */
        background-color: #181a1b;
    }

        .sidebar {
            background-color: #17191a ;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 350px;
            z-index: 1;
            padding-top: 70px;
            overflow-y: auto;
            color: white;
        }

        .main-content {
            background-image: url('background/fabric.jpg');
            background-color: #2b2e30; /* Add the background color */
            background-blend-mode: multiply;
            background-size: cover;
            background-position: center;
            margin-left: 350px;
            margin-right: 0;
            width: calc(100% - 350px);
            padding: 20px;
            min-height: 100vh;
            margin-top: 40px;
        }
        .header {
            font-family: "Open Sans", sans-serif;
            font-size: 24px;
            color: white;
            text-align: center;
            margin: 20px auto;
        }

        /* Add this CSS to display items horizontally */
        .image-container {
            margin: 10px;
            flex: 0 0 calc(33.33% - 20px);
            max-width: calc(33.33% - 20px);
            display: inline-block;
            vertical-align: top;
        }

        /* Add this CSS to hide filtered items */
        .image-container.hidden {
            display: none;
        }

        .image-container img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        table, th, td {
            border: 1px solid whitesmoke;
            padding: 5px;
        }

        /* Set a higher z-index for the navbar */
        .navbar {
            z-index: 1000;
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #232627;
        }

        /* Add a container div to fix the unwanted space issue */
        .navbar-container {
            padding: 0;
        }

        /* Add this CSS to style the header lines */
        .header-line {
            width: 100%; /* Make the line stretch across the entire width */
            height: 2px; /* Set the height of the line */
            background-color: #ffffff; /* Line color (white in this case) */
            margin: 10px auto; /* Adjust the margin as needed */
        }

        /* Search Bar */
        .form-inline input[type="search"] {
            background-color: #181a1b;
            color: white;
            border: 1px solid #7b7265; /* Add border color */
            border-radius: 5px; /* Add some border radius for styling */
        }

        .form-inline input[type="search"]::placeholder {
            color: #7b7265; /* Set the placeholder text color to #7b7265 */
        }

        /* Adjust the size of the modal */
        .modal-dialog {
            max-width: 972px; /* Set the maximum width */
            margin: 1.75rem auto; /* Center the modal horizontally */
        }

        /* Custom CSS for the modal */
        .modal-content {
            width: 100%; /* Set the width of the modal content */
            border-radius: 10px; /* Add rounded corners */
            border: 2px solid #fff; /* Add a white border */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Add a shadow */
            background-color: #222222;
            color: white;
        }
        /* Hide the close (x) icon */
        .modal-header .close {
            display: none;
        }

        

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <!-- Replace "Your Logo" with an image -->
        <a class="navbar-brand" href="#"><img src="logo/SimonKeyes.png" alt="Your Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Weapons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Me</a>
                </li>
                <!-- Add more menu items here -->
            </ul>
            <!-- Search Bar -->
            <form class="form-inline ml-auto"> <!-- Use ml-auto class to push the search bar to the right -->
                <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchInput">
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <!-- Sidebar content goes here -->
            <div id="hoverText" class="hover-text sidebar sticky-top">
                <!-- Your sidebar content here -->
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8 col-sm-6 col-12 main-content">
            <!-- Main content goes here -->
            <?php
            $servername = "";
            $username = ""; // Change this to your MySQL username
            $password = ""; // Change this to your MySQL password
            $dbname = "tiny";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to retrieve image data
            $sql = "SELECT Icon, Tooltip, `Name`, Attack, Strength, Dexterity, Intelligence, Damage, Speed, WeaponRange, WeaponType, Weapon, Handling, Rarity FROM weapons9";
            $result = $conn->query($sql);

            // Initialize empty arrays for each weapon type
            $rangedWeapons = [];
            $meleeWeapons = [];
            $magicWeapons = [];

            while ($row = $result->fetch_assoc()) {
                // Store weapons in respective arrays based on WeaponType
                if ($row["WeaponType"] == "Ranged") {
                    $rangedWeapons[] = $row;
                } elseif ($row["WeaponType"] == "Melee") {
                    $meleeWeapons[] = $row;
                } elseif ($row["WeaponType"] == "Magic") {
                    $magicWeapons[] = $row;
                }
            }

            // Function to display weapons based on an array
            function displayWeapons($weapons) {
                foreach ($weapons as $weapon) {
                    $imageData = base64_encode($weapon["Icon"]);
                    $name = $weapon['Name'];
                    $tooltip = $weapon["Tooltip"];
                    $attack = $weapon["Attack"];
                    $strength = $weapon["Strength"];
                    $dexterity = $weapon["Dexterity"];
                    $intelligence = $weapon["Intelligence"];
                    $damage = $weapon["Damage"];
                    $speed = $weapon["Speed"];
                    $weaponRange = $weapon["WeaponRange"];
                    $weaponType = $weapon["WeaponType"];
                    $actualWeapon = $weapon["Weapon"];
                    $handling = $weapon["Handling"];
                    $rarity = $weapon["Rarity"];

                    

                    // Generate an image tag with the base64 data and tooltip
                    echo '<div class="image-container" data-name="' . $name . '">';
                    echo '<a href="#" class="popup-link" data-description="' . $tooltip . '"'
                        . ' data-attack="' . $attack . '"'
                        . ' data-strength="' . $strength . '" data-dexterity="' . $dexterity . '"'
                        . ' data-intelligence="' . $intelligence . '" data-damage="' . $damage . '"'
                        . ' data-speed="' . $speed . '" data-weaponrange="' . $weaponRange . '"'
                        . ' data-weapontype="' . $weaponType . '"'
                        . ' data-actualweapon="' . $actualWeapon . '"'
                        . ' data-handling="' . $handling . '"'
                        . ' data-rarity="' . $rarity . '">';
                    // Add the icon within a new div
                    echo '<div class="weapon-icon">';
                    echo '<img src="data:image/png;base64,' . $imageData . '" alt="Weapon Icon">';
                    echo '</div>';

                    echo '</a>';
                    echo '</div>';
                }
            }

            // Display the weapons for each type
            echo '<div class="header">';
            echo '<h2 style="font-weight: bold; text-transform: uppercase; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;">Ranged</h2>';
            echo '<div class="header-line"></div>';
            echo '</div>';
            displayWeapons($rangedWeapons);

            echo '<div class="header">';
            echo '<h2 style="font-weight: bold; text-transform: uppercase; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;">Melee</h2>';
            echo '<div class="header-line"></div>';
            echo '</div>';
            echo '<br>';
            displayWeapons($meleeWeapons);

            echo '<div class="header">';
            echo '<h2 style="font-weight: bold; text-transform: uppercase; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;">Magic</h2>';
            echo '<div class="header-line"></div>';
            echo '</div>';
            echo '<br>';
            displayWeapons($magicWeapons);

            $conn->close();
            ?>
        </div>
    </div>
</div>

<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemModalLabel">Item Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Information about the item will be displayed here -->
                <!-- Include the weapon icon within this div -->
                <div id="modalContent">
                    <div class="weapon-icon">
                        <!-- Icon goes here -->
                        <img src="" alt="Weapon Icon" id="weaponIconImage"> <!-- Add this img element -->
                    </div>
                    <!-- Other weapon details go here -->
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer bg-dark text-white py-4 sticky-top">
    <div class="container text-center">
        <p>Contact Details: Godot | Email: drewhos@outlook.com</p>
    </div>
</footer>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const popupLinks = document.querySelectorAll(".popup-link");
    const hoverText = document.getElementById("hoverText");
    const modalContent = document.getElementById("modalContent");
    const weaponIconImage = document.getElementById("weaponIconImage"); // Get the img element

    popupLinks.forEach(link => {
        link.addEventListener("mouseover", function (event) {
            event.preventDefault();

            const name = link.parentElement.getAttribute('data-name');
            const tooltip = link.getAttribute('data-description');
            const attack = link.getAttribute('data-attack');
            const strength = link.getAttribute('data-strength');
            const dexterity = link.getAttribute('data-dexterity');
            const intelligence = link.getAttribute('data-intelligence');
            const damage = link.getAttribute('data-damage');
            const speed = link.getAttribute('data-speed');
            const weaponRange = link.getAttribute('data-weaponrange');
            const weaponType = link.getAttribute('data-weapontype');
            const actualWeapon = link.getAttribute('data-actualweapon');
            const handling = link.getAttribute('data-handling');
            const rarity = link.getAttribute('data-rarity');
            

            // Remove non-alphanumeric characters and extra spaces from the attack attribute
            const cleanedAttack = attack.replace(/[^a-zA-Z0-9\s]/g, '').replace(/\s+/g, ' ');

            // Split the cleaned attack string into an array of words
            const attackWords = cleanedAttack.split(' ');

            // Define colors for each word
            const colorMap = {
                'Physical': '#5d4333',
                'Cold': '#4aa0f2',
                'Elemental': '#793cc2',
                'Slash': '#5d4333',
                'Thrust': '#5d4333',
                'Strike': '#5d4333',
                'Magical': '#5570fb',
                'Fire': '#d33000',
                'AoE': '#fffff7',
                'Dark': '#151456',
                'Sound': '#b9b4bd',
                'Lightning': '#e1cd4d',
                'Holy': '#ddd7ad',
                'Poison': '#009900',
                'Nature': '#82c200'
            };

            // Define colors for each rarity
            const rarityColorMap = {
                'Common': '#7b7c85',
                'Uncommon': '#61ceee',
                'Rare': '#e1c969',
                'Epic': '#a600fc',
                'Legendary': '#f64e04'
            };

            // Define a map of words to their corresponding colors and tooltips
            const tooltipData = {
                'Bleed': { color: '#ad0251', tooltip: 'Deals 60% of infliction DMG per second, for 4 seconds.' },
                'Poison': { color: '#009900', tooltip: 'Deals 40% of infliction DMG per second, for 4 seconds. Stacks up to 10 times. 25% more DMG per stack.' },
                'Scorch': { color: '#e36302', tooltip: 'Affected target takes 10% more Burn DMG per stack. Stacks up to 10 times.' },
                'Burn': { color: '#fa0035', tooltip: 'Deals 60% of infliction DMG per second, for 4 seconds.' },
                'Chill': { color: '#3366cc', tooltip: 'Slows movement speed by 30%.' },
                'Corruption': { color: '#1d3388', tooltip: 'Each stack increases damage taken by 1%. Can only be applied once per second.' },
                'Doom': { color: '#eb0039', tooltip: 'Stacks up to 2 times. Inflicts 100% bonus DMG on reaching max stacks.' },
                'Shock': { color: '#e5bb00', tooltip: 'Affected target takes 8% more DMG per stack. Stacks up to 3 times.' },
                'Defense Break': { color: '#647587', tooltip: 'Halves defense of affected target for 4 seconds.' },
                'Silver Bolt Mark': { color: '#384655', tooltip: 'Stacks up to 3 times. Inflicts 150% extra DMG on reaching max stacks.' },
                'Tailwind': { color: '#e8e8e8', tooltip: 'Stacks up to 4 times. Grants 5% increased attack and movement speed per stack.' },
                'Pure Power': { color: '#cf81d5', tooltip: 'Each stack of Pure Power grants +1 intelligence, up to 30 stacks.' },
                'Crushing Blow Chance': {color: '#6e4333', tooltip: 'Chance to deal % of current enemy health as extra damage. This effect has a 2.5 seconds cooldown.'},
                'From the Shadows': {color: '#a900f4', tooltip: 'Deal 100% more damage for 4 seconds after your next attack.' },
                'Charm': {color: '#e7e5e2', tooltip: 'Charms target, making it deal 50% less damage for 4 seconds.'},
                'Piranha Bites': {color: '#15c2f1', tooltip: 'Deals 200% of infliction DMG per second, for 4 seconds.'},
                'Sticky Goo': {color: '#82c200', tooltip: 'Slows movement speed by 50%.'},
                'Paperbomb Sticker': {color: '#eb0039', tooltip: 'Stacks up to 5 times. Explodes for 250% bonus DMG on reaching max stacks.'},
                'Disintegration': {color: '#d30139', tooltip: 'Deals 50% of infliction DMG per second, for 4 seconds. Stacks up to 20 times. 25% more DMG per stack.'},
                'Judgement': {color: '#d8c618', tooltip: 'Stacks up to 3 times. Inflicts 50% extra DMG on reaching max stacks.'},
                'Divine Departure': {color: '#eb0039', tooltip: 'Stacks up to 10 times. Inflicts 100% bonus DMG on reaching max stacks.'},
                'Frostbite': {color: '#67aef3', tooltip: 'Deals 60% of infliction DMG per second, for 4 seconds.'},
                'Bone Shatter': {color: '#9e9b8d', tooltip: 'Reduces defense by 5% per stack. Up to 5 stacks.'}

            };

            // Process the tooltip to handle multi-word effects and make them bold
            const coloredTooltipArray = [];

            // Function to create a span element with the specified color, bold text, and tooltip
            function createColoredSpan(word) {
                const data = tooltipData[word];
                if (data) {
                    return `<strong><span style="color: ${data.color};" title="${data.tooltip}">${word}</span></strong>`;
                }
                return `<strong>${word}</strong>`;
            }

            // Regular expression to match multi-word tooltips
            const multiWordRegex = new RegExp(Object.keys(tooltipData).join('|'), 'g');

            // Replace matched multi-word tooltips with colored versions
            const coloredTooltipString = tooltip.replace(multiWordRegex, match => createColoredSpan(match));

            const rarityColor = rarityColorMap[rarity] || 'white';

            // Map each word to its corresponding color (or use the word itself if there's no color defined)
            const coloredAttack = attackWords.map(word => colorMap[word] ? `<span style="color: ${colorMap[word]};">${word}</span>` : word);

            // Join the colored words back into a single string
            const coloredAttackString = coloredAttack.join(' ');
            




            const content = `
                <strong><u><center style="font-size: 24px; text-transform: uppercase;">${name}</center></u></strong>
                <p style="margin-top: 2px; margin-bottom: 0; text-align: center;">Handling: ${handling}</p>
                <p style="margin-top: 0; text-align: center;">Rarity: <strong style="color: ${rarityColor};">${rarity}</strong></p>
                <i>Effect:</i> ${coloredTooltipString}<br><br>

                <table style="margin: 0 auto;"> <!-- Center the table -->
                    <tr>
                        <th style="color:rgb(208,32,113);">Strength</th>
                        <th style="color:rgb(113,181,103);">Dexterity</th>
                        <th style="color:DodgerBlue;">Intelligence</th>
                    </tr>
                    <tr>
                        <td><strong><center>${strength}</center></strong></td>
                        <td><strong><center>${dexterity}</center></strong></td>
                        <td><strong><center>${intelligence}</center></strong></td>
                    </tr>
                </table><br>

                <i>Attack:</i> <strong>${coloredAttackString}</strong><br>
                <i>Damage:</i> ${damage}<br>
                <i>APS:</i> ${speed}<br>
                <i>Weapon Range:</i> ${weaponRange}<br>

                <i>Weapon Type:</i> ${actualWeapon} / ${weaponType}<br><br>
            `;

            hoverText.innerHTML = content;
        });

        link.addEventListener("click", function (event) {
            event.preventDefault();

            const name = link.parentElement.getAttribute('data-name');
            const tooltip = link.getAttribute('data-description');
            const attack = link.getAttribute('data-attack');
            const strength = link.getAttribute('data-strength');
            const dexterity = link.getAttribute('data-dexterity');
            const intelligence = link.getAttribute('data-intelligence');
            const damage = link.getAttribute('data-damage');
            const speed = link.getAttribute('data-speed');
            const weaponRange = link.getAttribute('data-weaponrange');
            const weaponType = link.getAttribute('data-weapontype');
            const actualWeapon = link.getAttribute('data-actualweapon');
            const handling = link.getAttribute('data-handling');
            const rarity = link.getAttribute('data-rarity');
            const imageSrc = link.querySelector('img').getAttribute('src'); // Get the image source

            // Remove non-alphanumeric characters and extra spaces from the attack attribute
            const cleanedAttack = attack.replace(/[^a-zA-Z0-9\s]/g, '').replace(/\s+/g, ' ');

            // Split the cleaned attack string into an array of words
            const attackWords = cleanedAttack.split(' ');

            // Define colors for each word
            const colorMap = {
                'Physical': '#5d4333',
                'Cold': '#4aa0f2',
                'Elemental': '#793cc2',
                'Slash': '#5d4333',
                'Thrust': '#5d4333',
                'Strike': '#5d4333',
                'Magical': '#5570fb',
                'Fire': '#d33000',
                'AoE': '#fffff7',
                'Dark': '#151456',
                'Sound': '#b9b4bd',
                'Lightning': '#e1cd4d',
                'Holy': '#ddd7ad',
                'Poison': '#009900',
                'Nature': '#82c200'
            };

            // Define colors for each rarity
            const rarityColorMap = {
                'Common': '#7b7c85',
                'Uncommon': '#61ceee',
                'Rare': '#e1c969',
                'Epic': '#a600fc',
                'Legendary': '#f64e04'
            };

            // Define a map of words to their corresponding colors and tooltips
            const tooltipData = {
                'Bleed': { color: '#ad0251', tooltip: 'Deals 60% of infliction DMG per second, for 4 seconds.' },
                'Poison': { color: '#009900', tooltip: 'Deals 40% of infliction DMG per second, for 4 seconds. Stacks up to 10 times. 25% more DMG per stack.' },
                'Scorch': { color: '#e36302', tooltip: 'Affected target takes 10% more Burn DMG per stack. Stacks up to 10 times.' },
                'Burn': { color: '#fa0035', tooltip: 'Deals 60% of infliction DMG per second, for 4 seconds.' },
                'Chill': { color: '#3366cc', tooltip: 'Slows movement speed by 30%.' },
                'Corruption': { color: '#1d3388', tooltip: 'Each stack increases damage taken by 1%. Can only be applied once per second.' },
                'Doom': { color: '#eb0039', tooltip: 'Stacks up to 2 times. Inflicts 100% bonus DMG on reaching max stacks.' },
                'Shock': { color: '#e5bb00', tooltip: 'Affected target takes 8% more DMG per stack. Stacks up to 3 times.' },
                'Defense Break': { color: '#647587', tooltip: 'Halves defense of affected target for 4 seconds.' },
                'Silver Bolt Mark': { color: '#384655', tooltip: 'Stacks up to 3 times. Inflicts 150% extra DMG on reaching max stacks.' },
                'Tailwind': { color: '#e8e8e8', tooltip: 'Stacks up to 4 times. Grants 5% increased attack and movement speed per stack.' },
                'Pure Power': { color: '#cf81d5', tooltip: 'Each stack of Pure Power grants +1 intelligence, up to 30 stacks.' },
                'Crushing Blow Chance': {color: '#6e4333', tooltip: 'Chance to deal % of current enemy health as extra damage. This effect has a 2.5 seconds cooldown.'},
                'From the Shadows': {color: '#a900f4', tooltip: 'Deal 100% more damage for 4 seconds after your next attack.' },
                'Charm': {color: '#e7e5e2', tooltip: 'Charms target, making it deal 50% less damage for 4 seconds.'},
                'Piranha Bites': {color: '#15c2f1', tooltip: 'Deals 200% of infliction DMG per second, for 4 seconds.'},
                'Sticky Goo': {color: '#82c200', tooltip: 'Slows movement speed by 50%.'},
                'Paperbomb Sticker': {color: '#eb0039', tooltip: 'Stacks up to 5 times. Explodes for 250% bonus DMG on reaching max stacks.'},
                'Disintegration': {color: '#d30139', tooltip: 'Deals 50% of infliction DMG per second, for 4 seconds. Stacks up to 20 times. 25% more DMG per stack.'},
                'Judgement': {color: '#d8c618', tooltip: 'Stacks up to 3 times. Inflicts 50% extra DMG on reaching max stacks.'},
                'Divine Departure': {color: '#eb0039', tooltip: 'Stacks up to 10 times. Inflicts 100% bonus DMG on reaching max stacks.'},
                'Frostbite': {color: '#67aef3', tooltip: 'Deals 60% of infliction DMG per second, for 4 seconds.'},
                'Bone Shatter': {color: '#9e9b8d', tooltip: 'Reduces defense by 5% per stack. Up to 5 stacks.'}

            };

            // Process the tooltip to handle multi-word effects and make them bold
            const coloredTooltipArray = [];

            // Function to create a span element with the specified color, bold text, and tooltip
            function createColoredSpan(word) {
                const data = tooltipData[word];
                if (data) {
                    return `<strong><span style="color: ${data.color};" title="${data.tooltip}">${word}</span></strong>`;
                }
                return `<strong>${word}</strong>`;
            }

            // Regular expression to match multi-word tooltips
            const multiWordRegex = new RegExp(Object.keys(tooltipData).join('|'), 'g');

            // Replace matched multi-word tooltips with colored versions
            const coloredTooltipString = tooltip.replace(multiWordRegex, match => createColoredSpan(match));

            

            const rarityColor = rarityColorMap[rarity] || 'white';

            // Map each word to its corresponding color (or use the word itself if there's no color defined)
            const coloredAttack = attackWords.map(word => colorMap[word] ? `<span style="color: ${colorMap[word]};">${word}</span>` : word);

            // Join the colored words back into a single string
            const coloredAttackString = coloredAttack.join(' ');

            

            

            const content = `
                <div style="position: relative;">
                    <!-- Set the src attribute of the img element to the image source -->
                    <img src="${imageSrc}" alt="Weapon Icon" style="max-width: 100px; height: auto; position: absolute; top: 0; right: 0;">
                    <strong><u><center style="font-size: 24px; text-transform: uppercase;">${name}</center></u></strong>
                    <p style="margin-top: 2px; margin-bottom: 0; text-align: center;">Handling: ${handling}</p>
                    <p style="margin-top: 0; text-align: center;">Rarity: <strong style="color: ${rarityColor};">${rarity}</strong></p>
                    <i>Effect:</i> ${coloredTooltipString}<br><br>
                    <table style="margin: 0 auto;">
                        <tr>
                            <th style="color:rgb(208,32,113);">Strength</th>
                            <th style="color:rgb(113,181,103);">Dexterity</th>
                            <th style="color:DodgerBlue;">Intelligence</th>
                        </tr>
                        <tr>
                            <td><strong><center>${strength}</center></strong></td>
                            <td><strong><center>${dexterity}</center></strong></td>
                            <td><strong><center>${intelligence}</center></strong></td>
                        </tr>
                    </table>
                    <i>Attack:</i> <strong>${coloredAttackString}</strong><br>
                    <i>Damage:</i> ${damage}<br>
                    <i>Speed:</i> ${speed}<br>
                    <i>Weapon Range:</i> ${weaponRange}<br>
                    <i>Weapon Type:</i> ${actualWeapon} / ${weaponType}<br><br>
                </div>
            `;

            // Set the modal content
            modalContent.innerHTML = content;

            // Open the modal
            $('#itemModal').modal('show');
        });

        link.addEventListener("mouseout", function () {
            hoverText.innerHTML = "";
        });
    });

    // Get the input element and the items to be filtered
    var searchInput = document.getElementById('searchInput');
    var imageContainers = document.querySelectorAll('.image-container');

    // Add event listener for input changes
    searchInput.addEventListener('input', function() {
    // Get the current search query and convert it to lowercase
    var query = searchInput.value.toLowerCase();

    // Loop through image containers and check if the data-name, data-tooltip, data-handling, data-weapon-type, data-attack, and data-rarity attributes contain the query
    imageContainers.forEach(function(container) {
        var itemName = container.getAttribute('data-name').toLowerCase();
        var itemTooltip = container.querySelector('.popup-link').getAttribute('data-description').toLowerCase();
        var itemHandling = container.querySelector('.popup-link').getAttribute('data-handling').toLowerCase();
        var itemWeaponType = container.querySelector('.popup-link').getAttribute('data-weapontype').toLowerCase();
        var itemAttack = container.querySelector('.popup-link').getAttribute('data-attack').toLowerCase();
        var itemRarity = container.querySelector('.popup-link').getAttribute('data-rarity').toLowerCase();

        // If any of the attributes include the query, remove the 'hidden' class; otherwise, add it to hide the item
        if (itemName.includes(query) || itemTooltip.includes(query) || itemHandling.includes(query) || itemWeaponType.includes(query) || itemAttack.includes(query) || itemRarity.includes(query)) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    });
});
});
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
