<?php 
// show message if set or display inventory as space saver
echo isset($_SESSION['message'])
? "<pre id='sessionMessage'>" . $_SESSION['message'] . "</pre>"
: "<p id='messageSpaceSaver'>Inventory</p>";
unset($_SESSION['message']);

//get cars per page from session if set
if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
    $_SESSION['carsPerPage'] = (int) $_GET['limit'];
}

//default cars per page if not set
$limit = $_SESSION['carsPerPage'] ?? 25;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

//count total cars and calculate total pages
$totalResult = $mysqli->query("SELECT COUNT(DISTINCT VIN) AS total FROM inventory");
$totalCars = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalCars / $limit);

//highlight car that was just added or edited
$highlightEntry = $_SESSION['highlightEntry'] ?? null;
unset($_SESSION['highlightEntry']);

//get inventory rows with one image each
$queryTable = "
    SELECT inventory.*, MIN(images.IMAGEFILE) AS IMAGEFILE
    FROM inventory
    LEFT JOIN images ON inventory.VIN = images.VIN
    GROUP BY inventory.VIN
    ORDER BY MAKE, MODEL, ASKING_PRICE
    LIMIT $limit OFFSET $offset";

try {
    $result = $mysqli->query($queryTable);
    echo '<div class="carGrid">';
    while ($row = $result->fetch_assoc()) {
        $vin = $row['VIN'];
        $imageFile = $row['IMAGEFILE'];
        $imagePath = "images/uploads/$imageFile";
        //set default image if no image exists
        if (!$imageFile || !file_exists($imagePath)) {
            $imagePath = "images/default.jpg";
        }
        $year = htmlspecialchars($row['YEAR']);
        $make = htmlspecialchars($row['MAKE']);
        $model = htmlspecialchars($row['MODEL']);
        $price = '$' . number_format($row['ASKING_PRICE'], 0);
        $carName = "$year $make $model";
        //set highlight if car was just added or edited
        $highlightClass = ($vin === $highlightEntry) ? 'highlight' : '';
        $highlightId = ($vin === $highlightEntry) ? 'id="highlightedCar"' : '';
        //display each car with image and details
        echo "<div class='carCard $highlightClass' $highlightId>";
        echo "<a href='index.php?sectionView=view&VIN=$vin&page=$page&limit=$limit'>";
        echo "<img src='$imagePath' alt='Car image' class='carThumbnail'>";
        echo "</a>";
        echo "<div class='carInfo'>";
        echo "<p class='carTitle'>$carName</p>";
        echo "<p class='carVin'>$vin</p>";
        //show edit/delete if logged in
        if (isset($_SESSION['user_id'])) {
            echo "<div class='carActions'>";
            echo "<a href='index.php?sectionView=edit&VIN=$vin&page=$page&limit=$limit' class='button editBtn'>Edit</a>";
            echo "<a href='index.php?sectionView=delete&VIN=$vin&page=$page&limit=$limit' class='button deleteBtn' onclick='return confirm(\"Are you sure you want to delete this car?\")'>Delete</a>";
            echo "</div>";
        }

        echo "</div>"; // .carInfo
        echo "<div class='carPrice'>$price</div>";
        echo "</div>"; // .carCard
    }
    echo '</div>';

    // show page navigation if more than one page
    if ($totalPages > 1) {
        echo "<div class='pageNavigation'>";
        if ($page > 1) {
            echo "<a href='index.php?page=" . ($page - 1) . "&limit=$limit'>&laquo; Prev</a> ";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $link = "<a href='index.php?page=$i&limit=$limit'>$i</a>";
            echo ($i === $page) ? "<strong>$i</strong> " : $link;
        }

        if ($page < $totalPages) {
            echo "<a href='index.php?page=" . ($page + 1) . "&limit=$limit'>Next &raquo;</a>";
        }
        echo "</div>";
    }

} catch (mysqli_sql_exception $e) {
    echo "<p>Query Error</p>";
}

//cars per page dropdown
echo '<form method="GET" action="index.php" class="carsPerPageForm">';
echo '<input type="hidden" name="sectionView" value="view">';
echo '<div class="inlineControls">';
echo '<label for="limit">Cars per page:</label>';
echo '<select name="limit" id="limit" onchange="this.form.submit()">';
foreach ([25, 50, 100] as $opt) {
    $selected = $opt === $limit ? 'selected' : '';
    echo "<option value=\"$opt\" $selected>$opt</option>";
}
echo '</select>';
echo '</div>';
echo '</form>';
?>
