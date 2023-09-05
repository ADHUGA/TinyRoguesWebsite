<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Tiny Rogues Suguru</title>
    <style>
        /* Custom styles for the sidebar and main content */
        .sidebar {
            background-color: #272727;
            padding: 20px;
            min-height: 100vh; /* Make sidebar extend to the full height of the viewport */
            position: fixed; /* Fixed positioning to keep the sidebar fixed while scrolling */
            top: 0;
            left: 0;
            width: 250px; /* Set a fixed width for the sidebar */
            overflow-y: auto; /* Add scroll to the sidebar content if it exceeds the height */
            padding-top: 70px; /* Makes it not cut off the sidebar*/
        }
        /* Adjust main content to push it away from the sidebar */
        .main-content {
        background-image: url('background/fabric.jpg'); /* Replace 'your-image.jpg' with the path to your image */
        background-color: #474747;
        background-blend-mode: multiply; /* This will blend the background image with the background color */
        background-size: cover; /* Cover the entire container with the background image */
        background-position: center; /* Center the background image */
        padding: 20px;
        margin-left: 250px;
        }
        .header {
        font-family: "Open Sans", sans-serif;
        font-size: 24px;
        color: white;
        position: relative; /* Add position relative to the headers */
        }
        .header-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
            position: relative; /* Add position relative to the header containers */
        }
        .header::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: white;
            bottom: -5px; /* Adjust the position of the underline */
            left: 0;
        }
        .image-container {
        margin: 10px;
        flex: 0 0 calc(33.33% - 20px); /* Set the width to 33.33% for three images per row */
        max-width: calc(33.33% - 20px); /* Maintain a maximum width for responsiveness */
        display: inline-block; /* Display images inline */
        vertical-align: top; /* Align images at the top */
    }

    /* Ensure images are centered horizontally within their containers */
    .image-container img {
        display: block;
        margin: 0 auto;
        max-width: 100%;
        height: auto;
    }

    .red-text {
    color: red;
}

    
    
        
        
    </style>
</head>
    <body>
        <!-- Your HTML content goes here -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <!-- Replace "Your Logo" with an image -->
        <a class="navbar-brand" href="#"><img src="logo/SimonKeyes.png" alt="Your Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
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
                <div class="col-lg-2 col-md-3 col-sm-4 sidebar">
                    <!-- Sidebar content goes here -->
                    <div id="hoverText" class="hover-text"></div>
                    
                </div>
    
               
                            
            <div class="col-lg-10 col-md-9 col-sm-8 main-content">
                <!-- Main content goes here -->
                <?php
                $servername = "localhost";
                $username = "root"; // Change this to your MySQL username
                $password = "root"; // Change this to your MySQL password
                $dbname = "tiny";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to retrieve image data
                $sql = "SELECT WeaponType, Icon, Tooltip, `Name`, Attack, Strength, Dexterity, Intelligence, Damage, Speed, WeaponRange, WeaponType FROM weapons";
                $result = $conn->query($sql);

                // Loop through results and display images
                if ($result->num_rows > 0) {
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

                            echo '<div class="image-container">';
                            echo '<a href="#" class="popup-link"
                                    data-description="' . $tooltip . '"
                                    data-name="' . $name . '"
                                    data-attack="' . $attack . '"
                                    data-strength="' . $strength . '"
                                    data-dexterity="' . $dexterity . '"
                                    data-intelligence="' . $intelligence . '"
                                    data-damage="' . $damage . '"
                                    data-speed="' . $speed . '"
                                    data-weaponrange="' . $weaponRange . '"
                                    data-weapontype="' . $weaponType . '">';
                            echo '<img src="data:image/png;base64,' . $imageData . '" alt="Weapon Icon">';
                            echo '</a>';
                            echo '</div>';
                        }
                    }

                    // Display the weapons for each type
                    echo '<div class="header-container">';
                    echo '<h2 class="header">Ranged</h2>';
                    echo '</div>';
                    displayWeapons($rangedWeapons);

                    echo '<div class="header-container">';
                    echo '<h2 class="header">Melee</h2>';
                    echo '</div>';
                    displayWeapons($meleeWeapons);

                    echo '<div class="header-container">';
                    echo '<h2 class="header">Magic</h2>';
                    echo '</div>';
                    displayWeapons($magicWeapons);
                } else {
                    echo "No images found.";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>


        <footer class="footer bg-dark text-white py-4">
            <div class="container text-center">
                <p>Contact Details: Godot | Email: andrewdmhoskins@gmail.com</p>
            </div>
        </footer>
    
          
          
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        
        <script>
            // Get the input element
            var searchInput = document.getElementById('searchInput');
        
             // Add event listener for input changes
            searchInput.addEventListener('input', function() {
            // Get the current search query
            var query = searchInput.value;
            
            // Perform search or filtering based on the query
            // This is where you can implement your search logic
            // For demonstration purposes, we'll simply log the query
            console.log('Search query:', query);
            });
        </script>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const popupLinks = document.querySelectorAll(".popup-link");
            const hoverText = document.getElementById("hoverText");

            popupLinks.forEach(link => {
                link.addEventListener("mouseover", function (event) {
                    event.preventDefault();

                    const name = link.getAttribute('data-name');
                    const tooltip = link.getAttribute('data-description');
                    const attack = link.getAttribute('data-attack');
                    const strength = link.getAttribute('data-strength');
                    const dexterity = link.getAttribute('data-dexterity');
                    const intelligence = link.getAttribute('data-intelligence');
                    const damage = link.getAttribute('data-damage');
                    const speed = link.getAttribute('data-speed');
                    const weaponRange = link.getAttribute('data-weaponrange');
                    const weaponType = link.getAttribute('data-weapontype');

                    const content = `
                        <strong>${name}</strong><br>
                        Tooltip: ${tooltip}<br>
                        Attack: ${attack}<br>
                        Strength: ${strength}<br>
                        Dexterity: ${dexterity}<br>
                        Intelligence: ${intelligence}<br>
                        Damage: ${damage}<br>
                        Speed: ${speed}<br>
                        Weapon Range: ${weaponRange}<br>
                        Weapon Type: ${weaponType}
                    `;

                    hoverText.innerHTML = content;
                });

                link.addEventListener("mouseout", function () {
                    hoverText.innerHTML = "";
                });
            });
        });
        </script>
</body>
      
  