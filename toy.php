<?php

    /* TO-DO: Include header.php
              Hint: header.php is inside the includes folder and already connects to the database
    */
    require_once __DIR__ . '/includes/header.php';



    // Retrieve the value of the 'toynum' parameter from the URL query string
	//          Example URL: .../toy.php?toynum=0001
	$toy_id = $_GET['toynum'];



    /* TO-DO: Create a function that retrieves ALL toy and manufacturer information 
              from the database based on the toynum parameter from the URL.

              Your function should:
                1. Query the appropriate database table to retrieve toy and manufacturer info based on toynum
                2. Execute the SQL query using the pdo() helper function and fetch the result
                3. Return toy information
	*/

    function get_info (PDO $pdo, string $toy_id) {
        $sql = "SELECT toy.*, manuf.*, toy.name AS toy_name, manuf.name AS manuf_name
                FROM toy
                JOIN manuf
                ON toy.manID = manuf.manID
                WHERE toy.toyID = :toy_id;";

        $info = pdo($pdo, $sql, ['toy_id' => $toy_id])->fetch();
        return $info;
    }



    /* TO-DO: Call function to retrieve toy information */
    $toy_info = get_info($pdo, $toy_id);


?>

<section class="toy-details-page container">
    <div class="toy-details-container">
        <div class="toy-image">

            <!-- TO-DO: Display the toy image and update the alt text to the toy name -->
            <img src="<?= $toy_info['img_src'] ?>" alt="<?= $toy_info['toy_name'] ?>">

        </div>

        <div class="toy-details">

            <!-- TO-DO: Display the toy name -->
            <h1><?= $toy_info['name'] ?></h1>

            <h3>Toy Information</h3>

            <!-- TO-DO: Display the toy description -->
            <p><strong>Description:</strong> <?= $toy_info['description'] ?></p>

            <!-- TO-DO: Display the toy price -->
            <p><strong>Price:</strong> $ <?= $toy_info['price'] ?></p>

            <!-- TO-DO: Display the toy age range -->
            <p><strong>Age Range:</strong> <?= $toy_info['age_range'] ?></p>

            <!-- TO-DO: Display stock of toy -->
            <p><strong>Number In Stock:</strong> <?= $toy_info['in_stock'] ?></p>

            <br />

            <h3>Manufacturer Information</h3>

            <!-- TO-DO: Display the manufacturer name -->
            <p><strong>Name:</strong> <?= $toy_info['manuf_name'] ?> </p>

            <!-- TO-DO: Display the manufacturer address -->
            <p><strong>Address:</strong> <?= $toy_info['street'] ?>, <?= $toy_info['city'] ?>, <?= $toy_info['state'] ?> <?= $toy_info['zip'] ?></p>

            <!-- TO-DO: Display the manufacturer phone -->
            <p><strong>Phone:</strong> <?= $toy_info['phone'] ?></p>

            <!-- TO-DO: Display the manufacturer contact -->
            <p><strong>Contact:</strong> <?= $toy_info['contact'] ?></p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>