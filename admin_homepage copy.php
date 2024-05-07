<?php
session_start();


if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$database_name = 'barangay_db';
$conn = mysqli_connect("localhost", "username", "password", $database_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query all residents
$sql = "SELECT id, birthday FROM residents";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Update each resident's age
    while ($row = mysqli_fetch_assoc($result)) {
        $residentId = $row['id'];
        $birthday = $row['birthday'];
        
        // Calculate the age based on the birthday
        $birthdate = new DateTime($birthday);
        $today = new DateTime();
        $age = $birthdate->diff($today)->y;

        // Update the age in the database
        $updateSql = "UPDATE residents SET age = $age WHERE id = $residentId";
        mysqli_query($conn, $updateSql);
    }
}

// Check if the barangays table exists
$sqlCheckTable = "SHOW TABLES LIKE 'barangays'";
$resultCheckTable = mysqli_query($conn, $sqlCheckTable);

if (mysqli_num_rows($resultCheckTable) == 0) {
    die("Error: The 'barangays' table doesn't exist in the database.");
}

// Check if the residents table exists
$sqlCheckResidentTable = "SHOW TABLES LIKE 'residents'";
$resultCheckResidentTable = mysqli_query($conn, $sqlCheckResidentTable);

if (mysqli_num_rows($resultCheckResidentTable) == 0) {
    die("Error: The 'residents' table doesn't exist in the database.");
}

// Get the total population in Manila
$sqlTotalManilaPopulation = "SELECT COUNT(id) as total_population FROM residents";
$resultTotalManilaPopulation = mysqli_query($conn, $sqlTotalManilaPopulation);

// Check if the query was successful
if ($resultTotalManilaPopulation) {
    $rowTotalManilaPopulation = mysqli_fetch_assoc($resultTotalManilaPopulation);
    $totalManilaPopulation = $rowTotalManilaPopulation['total_population'];
} else {
    die("Error fetching total population: " . mysqli_error($conn));
}

// Display the total population in Manila


// Get the total number of barangays in Manila
$sqlTotalBarangays = "SELECT COUNT(id) as total_barangays FROM barangays";
$resultTotalBarangays = mysqli_query($conn, $sqlTotalBarangays);

// Check if the query was successful
if ($resultTotalBarangays) {
    $rowTotalBarangays = mysqli_fetch_assoc($resultTotalBarangays);
    $totalBarangays = $rowTotalBarangays['total_barangays'];
} else {
    die("Error fetching total barangays: " . mysqli_error($conn));
}

// Display the total number of barangays in Manila


// Get the total number of employed people in Manila
$sqlTotalEmployed = "SELECT COUNT(id) as total_employed FROM residents WHERE employment_status = 'Employed'";
$resultTotalEmployed = mysqli_query($conn, $sqlTotalEmployed);

// Check if the query was successful
if ($resultTotalEmployed) {
    $rowTotalEmployed = mysqli_fetch_assoc($resultTotalEmployed);
    $totalEmployed = $rowTotalEmployed['total_employed'];
} else {
    die("Error fetching total employed people: " . mysqli_error($conn));
}


// Display the total number of employed people in Manila


$sqlTotalStudents = "SELECT COUNT(id) as total_students FROM residents WHERE employment_status = 'Student'";
$resultTotalStudents = mysqli_query($conn, $sqlTotalStudents);

// Check if the query was successful
if ($resultTotalStudents) {
    $rowTotalStudents = mysqli_fetch_assoc($resultTotalStudents);
    $totalStudents = $rowTotalStudents['total_students'];
} else {
    die("Error fetching total students: " . mysqli_error($conn));
}

// Display the total number of students in Manila



// Get the total number of males in Manila
$sqlTotalMales = "SELECT COUNT(id) as total_males FROM residents WHERE gender = 'Male'";
$resultTotalMales = mysqli_query($conn, $sqlTotalMales);

// Check if the query was successful
if ($resultTotalMales) {
    $rowTotalMales = mysqli_fetch_assoc($resultTotalMales);
    $totalMales = $rowTotalMales['total_males'];
} else {
    die("Error fetching total males: " . mysqli_error($conn));
}

// Get the total number of females in Manila
$sqlTotalFemales = "SELECT COUNT(id) as total_females FROM residents WHERE gender = 'Female'";
$resultTotalFemales = mysqli_query($conn, $sqlTotalFemales);

// Check if the query was successful
if ($resultTotalFemales) {
    $rowTotalFemales = mysqli_fetch_assoc($resultTotalFemales);
    $totalFemales = $rowTotalFemales['total_females'];
} else {
    die("Error fetching total females: " . mysqli_error($conn));
}

// Display the total number of males and females in Manila

// Get the total number of infants in Manila (assuming infants are aged 0-2)
$sqlTotalInfants = "SELECT COUNT(id) as total_infants FROM residents WHERE age >= 0 AND age <= 2";
$resultTotalInfants = mysqli_query($conn, $sqlTotalInfants);

// Check if the query was successful
if ($resultTotalInfants) {
    $rowTotalInfants = mysqli_fetch_assoc($resultTotalInfants);
    $totalInfants = $rowTotalInfants['total_infants'];
} else {
    die("Error fetching total infants: " . mysqli_error($conn));
}

// Get the total number of children in Manila (assuming children are aged 3-12)
$sqlTotalChildren = "SELECT COUNT(id) as total_children FROM residents WHERE age >= 3 AND age <= 12";
$resultTotalChildren = mysqli_query($conn, $sqlTotalChildren);

// Check if the query was successful
if ($resultTotalChildren) {
    $rowTotalChildren = mysqli_fetch_assoc($resultTotalChildren);
    $totalChildren = $rowTotalChildren['total_children'];
} else {
    die("Error fetching total children: " . mysqli_error($conn));
}

// Get the total number of teens in Manila (assuming teens are aged 13-17)
$sqlTotalTeens = "SELECT COUNT(id) as total_teens FROM residents WHERE age >= 13 AND age <= 17";
$resultTotalTeens = mysqli_query($conn, $sqlTotalTeens);

// Check if the query was successful
if ($resultTotalTeens) {
    $rowTotalTeens = mysqli_fetch_assoc($resultTotalTeens);
    $totalTeens = $rowTotalTeens['total_teens'];
} else {
    die("Error fetching total teens: " . mysqli_error($conn));
}

// Get the total number of adults in Manila (assuming adults are aged 18-59)
$sqlTotalAdults = "SELECT COUNT(id) as total_adults FROM residents WHERE age >= 18 AND age <= 59";
$resultTotalAdults = mysqli_query($conn, $sqlTotalAdults);

// Check if the query was successful
if ($resultTotalAdults) {
    $rowTotalAdults = mysqli_fetch_assoc($resultTotalAdults);
    $totalAdults = $rowTotalAdults['total_adults'];
} else {
    die("Error fetching total adults: " . mysqli_error($conn));
}

// Display the total number of infants, children, teens, and adults in Manila


// Get the total number of seniors in Manila (assuming seniors are aged 60+)
$sqlTotalSeniors = "SELECT COUNT(id) as total_seniors FROM residents WHERE age >= 60";
$resultTotalSeniors = mysqli_query($conn, $sqlTotalSeniors);

// Check if the query was successful
if ($resultTotalSeniors) {
    $rowTotalSeniors = mysqli_fetch_assoc($resultTotalSeniors);
    $totalSeniors = $rowTotalSeniors['total_seniors'];
} else {
    die("Error fetching total seniors: " . mysqli_error($conn));
}



//time an date
date_default_timezone_set('Asia/Manila'); 
//<div class="current-date-time">' . date("l, F jS Y - g:i A") . '</div>


//download file 
//echo '<a href="#" onclick="downloadDocument()">RBI Certification</a>'; 
echo '<script>
    function downloadDocument() {
        var downloadLink = document.createElement(\'a\');
        downloadLink.href = \'https://drive.google.com/uc?export=download&id=1SemJto-3jEkdLMWp1kJb3NIt_Ns5hBlX\';
        downloadLink.download = \'RBI-Certification.docx\';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>';

echo '<header class="navbar navbar-default fixed-top" style=" height: 75px; box-shadow: 0px 2px 5px #00000070;"> 
    <div class="container-fluid">
    <div class="navb-logo" style="display: flex; padding-left:">
    <img src="images/logo.png"  draggable="false" alt="logo-needed" class="img-fluid" style="height: 50px; width: auto; max-width: 100%;margin-right:30px; ">
    <div class="current-date-time" id="currentDateTime" style="margin-left: 0px; margin-top: 18px;"></div>
       
</div>

                <div class="navb-items d-none d-lg-flex"> <!-- Hide on small screens, show on large screens -->
                    <div class="item">
                      
                    </div>
                    <div class="line"></div>
                    <div class="logout-navb">
                        <button type="button" class="btn btn-outline-danger logout-navb" onclick="window.location.href=\'logout.php\'">LOGOUT</button>
                    </div>
                </div>

                <div class="mobile-toggler d-lg-none">
                    <a href="#" onclick="showModal();" id="modalToggle" data-bs-toggle="modal" data-bs-target="#navbModal">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>

                <div class="modal fade" id="navbModal" tabindex="-1" role="dialog" aria-labelledby="navbModalLabel">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="navb-logo">
                                <img src="images/logo.png" alt="logo-needed" class="img-fluid">
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-xmark"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-line">
                                <a href="#"><i class="fas fa-house"></i>&nbsp;&nbsp;Home</a>
                            </div>
                            <div class="logout-navb">
                                <div class="logout-navb">
                                    <button type="button" class="btn btn-outline-danger logout-navb" onclick="window.location.href=\'logout.php\'">LOGOUT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>';

        echo '<div id="carouselExampleIndicators" class="mt-5 carousel slide carousel-fade" data-ride="carousel" data-interval="4000">';
        echo '<div class="carousel-inner">';
        echo '<div class="carousel-item active">';
        echo '<img src="images/carousel1.png" class="d-block w-100" alt="Second slide" draggable="false">';
        echo '</div>';
        echo '<div class="carousel-item">';
        echo '<img src="images/carousel2.png" class="d-block w-100" alt="Second slide" draggable="false">';
        echo '</div>';
        echo '<div class="carousel-item">';
        echo '<img src="images/carousel3.png" class="d-block w-100" alt="Second slide" draggable="false">';
        echo '</div>';
        echo '<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" onclick="updateCustomDot(\'prev\')">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="sr-only">Previous</span>';
        echo '</a>';
        echo '<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" onclick="updateCustomDot(\'next\')">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '<span class="sr-only">Next</span>';
        echo '</a>';
        echo '</div>';
        
        echo '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>';
        echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
        
        echo '<script>
          $(document).ready(function(){
            $(".carousel").carousel();
          });
        
          function goToSlide(slideIndex) {
            $(".carousel").carousel(slideIndex);
            $(".custom-dot").removeClass("active");
            $(".custom-dot:eq(" + slideIndex + ")").addClass("active");
          }
        
          function updateCustomDot(direction) {
            var currentSlide = $(".carousel-item.active");
            var currentIndex = currentSlide.index();
            var totalSlides = $(".carousel-item").length;
            var nextIndex = direction === "next" ? (currentIndex + 1) % totalSlides : (currentIndex - 1 + totalSlides) % totalSlides;
        
            $(".custom-dot").removeClass("active");
            $(".custom-dot:eq(" + nextIndex + ")").addClass("active");
          }
        </script>';
        
        
                      
        echo'<style>    
        
        .carousel-item {
            transition: opacity 2s ease;
          }
          
          .carousel-fade .carousel-item {
            opacity: 1;
          }
          
          .carousel-fade .carousel-item.active,
          .carousel-fade .carousel-item-next.carousel-item-left,
          .carousel-fade .carousel-item-prev.carousel-item-right {
            opacity: 0;
          }
          
          .carousel-fade .active.carousel-item-left,
          .carousel-fade .active.carousel-item-right {
            opacity: 1; 
          }
        .carousel-item img {
            max-height: 400px; 
            width: 100%;
            object-fit: cover;
          }
        
          .carousel-inner {
            position: relative;
          }
          
          .custom-indicators {
            position: absolute;
            bottom: 10px; 
            top: 470px;
            left: 50%;
            transform: translateX(-50%);
          }
          
          .custom-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: transparent;
            border: 1px solid blue;
            margin: 0 5px;
            cursor: pointer;
          }
          
          .custom-dot.active {
            background-color:  blue;
          }
        </style>';

// Display the total number of seniors in Manila
echo ' <div class="main-container">';
   echo '<div class="container-fluid mt-4 mx-auto">';
      echo '  <div class="container container-max-width mx-auto mx-3">';
         echo '    <div class="row justify-content-center my-4">';

             //Total Population -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435" >';
             echo '<h4 class="text-start ms-3 mt-3" style="color: black; font-size: 23px;">Total Population</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' . $totalManilaPopulation . '</h1>';
             echo '</div>';
             echo '</div>';
 
             //Total Barangays -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color: black; font-size: 23px;">Barangays</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' . $totalBarangays. '</h1>';
             echo '</div>';
             echo '</div>';
             
             //Total Employed People -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color:black; font-size: 23px;">Total Employed</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' .$totalEmployed. '</h1>';
             echo '</div>';
             echo '</div>';
             
             //Total Males -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color:black; font-size: 23px;">Total Males</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' .$totalMales. '</h1>';
             echo '</div>';
             echo '</div>';
             
             //Total Females -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color: black;font-size: 23px;">Total Females</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' .$totalFemales. '</h1>';
             echo '</div>';
             echo '</div>';
 
             //Total Infants -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color: black; font-size: 23px;">Total Students</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' .$totalStudents. '</h1>';
             echo '</div>';
             echo '</div>';
               
             //Total Children -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color:black;font-size: 23px;">Total Children</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' .$totalChildren. '</h1>';
             echo '</div>';
             echo '</div>';
 
             //Total Teens -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color:black; font-size: 23px;">Total Teens</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' .$totalTeens. '</h1>';
             echo '</div>';
             echo '</div>';
 
             //Total Adults -->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color: black; font-size: 23px;">Total Adults</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' .$totalAdults. '</h1>';
             echo '</div>';
             echo '</div>';
 
             // Total Seniors-->
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display">';
             echo '<div class="box-display-popl" style="width: 260px; border: 4px solid #000435; box-shadow: 6px 3px 0px #000435">';
             echo '<h4 class="text-start ms-3 mt-3" style="color:black; font-size: 23px;">Total Seniors</h4>';
             echo '<h1 class="text-end me-3" style="color: #000435; font-weight: 800">' . $totalSeniors. '</h1>';
             echo '</div>';
             echo '</div>';
            
            echo '<div class="row my-4 mx-0">';
        echo '</div>'; 
    echo '</div>';
echo '</div>';
// Add hover effect for all boxes
echo '<style>
    .box-display {
        transition: transform 0.3s, box-shadow 0.3s; 
    }
    .box-display:hover {
        transform: translateY(-8px) scale(1.03); 
    }
</style>';
// Display the search bar for barangays

echo '<style>';
echo ' .main-container{
      justify-content: center;
      align-items: center;

}';

echo '.search-bar-form {';
echo '    display: flex;';
echo '    align-items: center;';
echo '    margin: 20px;';
echo '}';
echo 'form {';
echo '    justify-content: center;';
echo '    align-items: center;';

echo '}';
echo 'label {';
echo '    margin-right: 10px;';
echo '}';

echo 'input[type="number"] {';
echo '    padding: 10px;';
echo '    border: 3px solid #000453;';
echo '    border-radius: 10px 0px 0px 10px;';
echo '    margin-right: 1px;';
echo '    width: 700px;';
echo '    height: 50px;';
echo '}';

echo 'input[type="number"]:hover {';
echo '    border-color: #001574;'; 
echo '    border-width: 4px;';
echo '}';

echo 'input[type="number"]::placeholder {';
echo '    font-size: 20px;'; 
echo '}';

echo 'input[type="number"]::-webkit-outer-spin-button,';
echo 'input[type="number"]::-webkit-inner-spin-button {';
echo '    -webkit-appearance: none;';
echo '    margin: 0;'; 
echo '}';
echo 'input[type="number"] {';
echo '    -moz-appearance: textfield;'; 
echo '}';

echo 'input[type="submit"] {';
echo '    background-color: #000453;';
echo '    color: #fff;';
echo '    padding: 10px 15px;';
echo '    border: none;';
echo '    border-radius: 0px 10px 10px 0px;';
echo '    cursor: pointer;';
echo '    transition: background-color 0.3s;';
echo '    height: 50px';
echo '}';

echo 'input[type="submit"]:hover {';
echo '    background-color: #0056b3;';
echo '}';
echo '</style>';

echo '<form class="search-bar-form" method="post" action="" onsubmit="return validateForm()">';
echo '    <input type="number" name="barangayInput" placeholder= "Enter Barangay number" id="barangayInput" onkeyup="filterBarangay()" required>';
echo '    <input type="submit" name="showResidents" value="Show Residents">';
echo '</form>';


// Check if the showResidents button is clicked
if (isset($_POST['showResidents'])) {
    $enteredBarangay = mysqli_real_escape_string($conn, $_POST['barangayInput']);
    $sqlResidents = "SELECT * FROM residents WHERE barangay_id IN (SELECT id FROM barangays WHERE barangay_name LIKE '%$enteredBarangay%')";
}

// JavaScript for form validation
echo "<script>
    function validateForm() {
        var barangayInput = document.getElementById('barangayInput').value;
        if (barangayInput.trim() === '') {
            alert('Please enter a Barangay.');
            return false;
        }
        return true;
    }
</script>";



if (isset($sqlResidents)) {
    $resultResidents = mysqli_query($conn, $sqlResidents);

    if (isset($_POST['showResidents']) || isset($_POST['searchResidents'])) {
        $selectedBarangayId = isset($_POST['showResidents']) ? $_POST['barangayInput'] : null;
    
        if ($selectedBarangayId !== null) {
            $sqlEmploymentStatus = "SELECT employment_status, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId GROUP BY employment_status";
            $resultEmploymentStatus = mysqli_query($conn, $sqlEmploymentStatus);
    
            if (!$resultEmploymentStatus) {
                die("Error in Employment Status query: " . mysqli_error($conn));
            }
 
            echo "<div class='resident-info-container'>";
            echo "<div class='resident-age'>";
            echo "<h2>Resident Information</h2>";
            echo "<label for='ageGroup'>Age Group:</label>";
            echo "<select name='ageGroup' id='ageGroup'>";
            echo "<option value=''>All</option>";
            echo "<option value='Infant'>Infant</option>";
            echo "<option value='Child'>Child</option>";
            echo "<option value='Teen'>Teen</option>";
            echo "<option value='Adult'>Adult</option>";
            echo "<option value='Senior'>Senior</option>";
            echo "</select>";
            echo "<button id='filterBtn'>Search</button>";
            echo "<input type='text' id='ageRangeInput' placeholder='Enter Age Range (e.g., 10-20)' style=' width: 230px; margin-left: 10px; '>";
            echo "<button id='ageRangeBtn' data-action='filter' style='background-color: #007bff; color: white;'>Filter by Age Range</button>";
            echo '<label for="sexuality"  style="margin-left: 10px;">Sexuality:</label>';
echo '<select name="sexuality" id="sexuality">';
echo '<option value="">All</option>';
echo '<option value="Straight">Straight – heterosexual</option>';
echo '<option value="Bisexual">Bisexual</option>';
echo '<option value="Lesbian">Lesbian</option>';
echo '<option value="Gay">Gay</option>';
echo '<option value="Transgender">Transgender</option>';
echo '<option value="Bisexual">Bisexual</option>';
echo '<option value="Questioning">Questioning</option>';
echo '<option value="Pansexual">Pansexual</option>';
echo '<option value="Polysexual">Polysexual</option>';
echo '<option value="Asexual">Asexual</option>';
echo '<option value="Demisexual">Demisexual</option>';
echo '<option value="Graysexual">Graysexual</option>';
echo '<option value="Queer">Queer</option>';
echo '<option value="Autosexual">Autosexual</option>';
echo '<option value="Androsexual">Androsexual</option>';
echo '<option value="Gynosexual">Gynosexual</option>';
echo '<option value="Homoflexible">Homoflexible</option>';
echo '<option value="Heteroflexible">Heteroflexible</option>';
echo '<option value="Intersex">Intersex</option>';
echo '<option value="Two Spirit">Two Spirit</option>';
echo '<option value="Androgynous">Androgynous</option>';
echo '<option value="Allosexual">Allosexual</option>';
echo '</select>';
echo "<button onclick='printTable()' id='print'>Print Table</button>";



echo "<style>

#ageRangeInput{
    margin-left: 20px;
    width: 250px;
    padding: 8px;
    border-radius: 4px;
}

#ageGroup{
    height: 36px;
    
}


.resident-age {
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
}


.resident-info-container {
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
    margin-top: 20px;
    margin-left: 25px;
    overflow-x: auto;
}

.resident-info-container h2 {
    margin-bottom: 10px;
}

.resident-info-container label {
    margin-right: 10px;
}

.resident-info-container select {
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.resident-info-container button {
    padding: 8px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #007bff;
    color: #fff;
    transition: background-color 0.3s;
}

.resident-info-container button:hover {
    background-color: #0056b3;
}


#print{
    margin-left:150px;
    height: 38px;

</style>";

echo "</div>";
      

    echo "<table id='residentTable' class='table table-hover table-light' style='font-size: 14px;' >";
    
    echo "
        <thead>
            <tr>
            <th style='color: #000453;'>Resident</th>
            <th style='color: #000453;'>Last Name</th>
            <th style='color: #000453;' class='d-none d-sm-table-cell d-md-table-cell'>Sex</th>
            <th style='color: #000453;' class='d-none d-sm-table-cell d-md-table-cell'>Age</th>
            <th style='color: #000453;'>Actions</th>
            </tr>
        </thead>
        ";

    echo "<tbody>";

    $residentNumber = 1;
    while ($row = mysqli_fetch_assoc($resultResidents)) {
        echo "<tr>";
        echo "<td style='max-width: 10px;'>{$residentNumber}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['id']}</td>";
        echo "<td style='max-width: 10px;'>{$row['lastname']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['name']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['nameextension']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['middlename']}</td>";
        echo "<td class='d-none d-sm-table-cell d-md-table-cell'>{$row['gender']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['sexuality']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['employment_status']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['income']}</td>";
        echo "<td class='d-none d-sm-table-cell d-md-table-cell'>{$row['age']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['disabilityStatus']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['disability']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['address']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['birthday']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['civil_status']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['nationality']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['religion']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['contact_number']}</td>";
        echo "<td class='d-none d-md-table-cell' style='display: none !important;'>{$row['email']}</td>";
        echo "<td><button type='button' class='btn btn-info view-details-btn' data-toggle='modal' data-target='#detailsModal'>View</button></td>";
        echo "</tr>";
        $residentNumber++;
    }
}
      // Table closing tags
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo '
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Resident Details</h5>
                <a href="#" class="fas fa-xmark" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
                </a>
            </div>
            <div class="modal-body ps-5 pe-5">
                <p><strong>Last Name:</strong> <span id="last-name-details"></span></p>
                <p><strong>First Name:</strong> <span id="first-name-details"></span></p>
                <p><strong>Middle Name:</strong> <span id="middle-name-details"></span></p>
                <p><strong>Sex:</strong> <span id="sex-details"></span></p>
                <p><strong>Age:</strong> <span id="age-details"></span></p>
                <p><strong>Civil Status:</strong> <span id="civil-status-details"></span></p>
                <p><strong>Contact No.:</strong> <span id="contact-details"></span></p>
                <p><strong>Barangay:</strong> <span id="address-details"></span></p>
                <p><strong>Birthday:</strong> <span id="birthday-details"></span></p>
                <p><strong>Nationality:</strong> <span id="nationality-details"></span></p>
                <p><strong>Religion:</strong> <span id="religion-details"></span></p>
                <p><strong>Employment Status:</strong> <span id="status-details"></span></p>
                <p><strong>Email:</strong> <span id="email-details"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
';
    

    
echo '<h3 style="text-align:center;">Barangay Dashboard</h3>';
   
echo '<div class="dashboard-container">';
    
echo '<div class="dashboard-box">';
echo "<h4 style='text-align:center;'> Employment Status</h4>";
echo "<ul>";

while ($rowEmploymentStatus = mysqli_fetch_assoc($resultEmploymentStatus)) {
    echo "<li>{$rowEmploymentStatus['employment_status']}: {$rowEmploymentStatus['count']}</li>";
}
echo "</ul>";

$sqlAgeGroups = "SELECT 
        SUM(CASE WHEN age <= 2 THEN 1 ELSE 0 END) AS infants,
        SUM(CASE WHEN age BETWEEN 3 AND 12 THEN 1 ELSE 0 END) AS children,
        SUM(CASE WHEN age BETWEEN 13 AND 17 THEN 1 ELSE 0 END) AS teens,
        SUM(CASE WHEN age BETWEEN 18 AND 59 THEN 1 ELSE 0 END) AS adults,
        SUM(CASE WHEN age >= 60 THEN 1 ELSE 0 END) AS seniors
    FROM residents WHERE barangay_id = $selectedBarangayId";

$resultAgeGroups = mysqli_query($conn, $sqlAgeGroups);

if (!$resultAgeGroups) {
   die("Error in Age Groups query: " . mysqli_error($conn));
}
echo '</div>';

//Age Group container
echo '<div class="dashboard-box" >';
echo "<h4 style='text-align:center;'>Age Groups</h4>";
echo "<ul>";

$rowAgeGroups = mysqli_fetch_assoc($resultAgeGroups);
echo "<li>Infants (0 - 2): {$rowAgeGroups['infants']}</li>";
echo "<li>Children (3 - 12): {$rowAgeGroups['children']}</li>";
echo "<li>Teens (13 - 17): {$rowAgeGroups['teens']}</li>";
echo "<li>Adults (18 - 59): {$rowAgeGroups['adults']}</li>";
echo "<li>Seniors (60 and above): {$rowAgeGroups['seniors']}</li>";
echo "</ul>";
echo '</div>';

$sqlStraightMaleDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId AND sexuality = 'Straight' AND gender = 'Male'";
$resultStraightMaleDistribution = mysqli_query($conn, $sqlStraightMaleDistribution);

if (!$resultStraightMaleDistribution) {
    die("Error in Gender Distribution query: " . mysqli_error($conn));
}

$sqlStraightFemaleDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId AND sexuality = 'Straight' AND gender = 'Female'";
$resultStraightFemaleDistribution = mysqli_query($conn, $sqlStraightFemaleDistribution);

if (!$resultStraightFemaleDistribution) {
    die("Error in Gender Distribution query: " . mysqli_error($conn));
}

$sqlLGBTMaleDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId AND sexuality != 'Straight' AND gender = 'Male'";
$resultLGBTMaleDistribution = mysqli_query($conn, $sqlLGBTMaleDistribution);

if (!$resultStraightMaleDistribution) {
    die("Error in Gender Distribution query: " . mysqli_error($conn));
}

$sqlLGBTFemaleDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId AND sexuality != 'Straight' AND gender = 'Female'";
$resultLGBTFemaleDistribution = mysqli_query($conn, $sqlLGBTFemaleDistribution);

if (!$resultStraightMaleDistribution) {
    die("Error in Gender Distribution query: " . mysqli_error($conn));
}

echo '<div class="dashboard-box">';
echo "<h4 style='text-align:center;'>Gender Distribution</h4>";
echo "<ul>";
while ($rowStraightMaleDistribution = mysqli_fetch_assoc($resultStraightMaleDistribution)) {
    echo "<li>Straight Males: {$rowStraightMaleDistribution['count']}</li>";
}

while ($rowStraightFemaleDistribution = mysqli_fetch_assoc($resultStraightFemaleDistribution)) {
    echo "<li>Straight Females: {$rowStraightFemaleDistribution['count']}</li>";
}

echo "<hr>";

while ($rowLGBTMaleDistribution = mysqli_fetch_assoc($resultLGBTMaleDistribution)) {
    echo "<li>LGBT Males: {$rowLGBTMaleDistribution['count']}</li>";
}

while ($rowLGBTFemaleDistribution = mysqli_fetch_assoc($resultLGBTFemaleDistribution)) {
    echo "<li>LGBT Females: {$rowLGBTFemaleDistribution['count']}</li>";
}
echo "</ul>";
echo '</div>';

echo '<div class="dashboard-box">';
$sqlTotalPopulation = "SELECT COUNT(id) as total_population FROM residents WHERE barangay_id = $selectedBarangayId";
$resultTotalPopulation = mysqli_query($conn, $sqlTotalPopulation);
$rowTotalPopulation = mysqli_fetch_assoc($resultTotalPopulation);

if (!$resultTotalPopulation) { 
    die("Error in Total Population query: " . mysqli_error($conn));
}

echo "<h4 style='text-align:center;'>Total Population</h4>";
echo "<p style='text-align:center;'>{$rowTotalPopulation['total_population']}</p>";
echo '</div>';
echo '</div>'; // End of dashboard-container
echo '</div>';

echo '<style>
.dashboard-container {
    display: flex;
    justify-content: center; 
    gap: 10px;
}
.dashboard-box {
    flex: 1;
    margin: 15px;
    padding: 20px;
    border: none; /* Remove border */
    box-shadow: 6px 3px 2px rgba(0, 0, 0, 0.8);
    transition: all 0.3s ease;
    cursor: pointer;
    color: white; 
    border-radius: 20px; 
}
.dashboard-heading {
    font-size: 35px;
    font-weight: bold;
    text-align: center;
    color: #333; 
}
.dashboard-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}
.dashboard-box h4 {
    margin-bottom: 10px;
    font-size: 24px;
    font-weight: bold;
    text-align: center; 
}
.dashboard-box ul {
    padding: 0;
    margin-top: 13px;
    list-style-type: none;
    font-size: 40px; 
}
.dashboard-box ul li {
    margin-top: 13px;
    font-size: 20px; 
}
.dashboard-box p {
    margin: 0; 
    font-size: 50px; 
    text-align: center; 
    line-height: 150px; 
    height: 100px;
    width: 100%; 
    display: flex;
    align-items: center;
    justify-content: center; 
}
</style>';
    }}
    

// Fetch all barangays from the database
$sqlBarangays = "SELECT id, barangay_name FROM barangays";
$resultBarangays = mysqli_query($conn, $sqlBarangays);

echo '<div class="container">';
echo '    <table class="table table-striped table-bordered text-center">';
echo '        <thead class="thead-dark">';
echo '            <tr>';
echo '                <th>ID</th>';
echo '                <th>Barangay Name</th>';
echo '                <th>District</th>';
echo '                <th>Zone</th>';
echo '<th class="action-header">Actions</th>'; 
echo '            </tr>';
echo '        </thead>';
echo '        <tbody>';

echo '<style>

.action-header {
    width: 350px; 
}

    .container {
        overflow-x: auto;
        width: 98%;
        margin: 0 auto;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        background-color: #f9f9f9;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .table thead th {
        background-color: #0e4d92; /* Light blue background color */
        color: #fff; /* White text color */
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2; /* Alternate row background color */
    }

</style>';
// Fetch and display barangays
$sqlBarangays = "SELECT id, barangay_name FROM barangays";
$resultBarangays = mysqli_query($conn, $sqlBarangays);

while ($rowBarangays = mysqli_fetch_assoc($resultBarangays)) {
    echo '            <tr>';
    echo '                <td>' . $rowBarangays['id'] . '</td>';
    echo '                <td>' . $rowBarangays['barangay_name'] . '</td>';
    echo '                <td>';

    $district = '';
    $barangayId = $rowBarangays['id'];

    // Determine district
    if ($barangayId >= 1 && $barangayId <= 146) {
        $district = 'District I';
    } elseif ($barangayId >= 147 && $barangayId <= 267) {
        $district = 'District II';
    } elseif ($barangayId >= 268 && $barangayId <= 394) {
        $district = 'District III';
    } elseif ($barangayId >= 395 && $barangayId <= 586) {
        $district = 'District IV';
    } elseif ($barangayId >= 649 && $barangayId <= 828) {
        $district = 'District V';
    } elseif (($barangayId >= 587 && $barangayId <= 648) || ($barangayId >= 829 && $barangayId <= 905)) {
        $district = 'District VI';
    }


    // Determine zone
    $zone = '';
    switch ($district) {
        case 'District I':
            if ($barangayId >= 1 && $barangayId <= 10) {
                $zone = 1;
            } elseif ($barangayId >= 11 && $barangayId <= 32) {
                $zone = 2;
            } elseif ($barangayId >= 33 && $barangayId <= 47) {
                $zone = 3;
            } elseif ($barangayId >= 48 && $barangayId <= 55) {
                $zone = 4;
            } elseif ($barangayId >= 56 && $barangayId <= 61) {
                $zone = 5;
            } elseif ($barangayId >= 62 && $barangayId <= 75) {
                $zone = 6;
            } elseif ($barangayId >= 76 && $barangayId <= 90) {
                $zone = 7;
            } elseif ($barangayId >= 91 && $barangayId <= 106) {
                $zone = 8;
            } elseif ($barangayId >= 107 && $barangayId <= 123) {
                $zone = 9;
            } elseif ($barangayId >= 124 && $barangayId <= 128) {
                $zone = 10;
            } elseif ($barangayId >= 129 && $barangayId <= 134) {
                $zone = 11;
            } elseif ($barangayId >= 135 && $barangayId <= 146) {
                $zone = 12;
            }
            break;
            case 'District II':
            if ($barangayId >= 147 && $barangayId <= 151) {
                $zone = 13;
            } elseif ($barangayId >= 152 && $barangayId <= 165) {
                $zone = 14;
            } elseif ($barangayId >= 166 && $barangayId <= 176) {
                $zone = 15;
            } elseif ($barangayId >= 177 && $barangayId <= 186) {
                $zone = 16;
            } elseif ($barangayId >= 187 && $barangayId <= 197) {
                $zone = 17;
            } elseif ($barangayId >= 198 && $barangayId <= 205) {
                $zone = 18;
            } elseif ($barangayId >= 206 && $barangayId <= 212) {
                $zone = 19;
            } elseif ($barangayId >= 213 && $barangayId <= 220) {
                $zone = 20;
            } elseif ($barangayId >= 221 && $barangayId <= 233) {
                $zone = 21;
            } elseif ($barangayId >= 234 && $barangayId <= 248) {
                $zone = 22;
            } elseif ($barangayId >= 249 && $barangayId <= 259) {
                $zone = 23;
            } elseif ($barangayId >= 260 && $barangayId <= 267) {
                $zone = 24;
            }
            break;
            case 'District III':
                if ($barangayId >= 268 && $barangayId <= 276) {
                    $zone = 25;
                } elseif ($barangayId >= 281 && $barangayId <= 286) {
                    $zone = 26;
                } elseif ($barangayId >= 287 && $barangayId <= 291) {
                    $zone = 27;
                } elseif ($barangayId >= 292 && $barangayId <= 296) {
                    $zone = 28;
                } elseif ($barangayId >= 297 && $barangayId <= 305) {
                    $zone = 29;
                } elseif ($barangayId >= 306 && $barangayId <= 309) {
                    $zone = 30;
                } elseif ($barangayId >= 310 && $barangayId <= 314) {
                    $zone = 31;
                } elseif ($barangayId >= 315 && $barangayId <= 325) {
                    $zone = 32;
                } elseif ($barangayId >= 326 && $barangayId <= 335) {
                    $zone = 33;
                } elseif ($barangayId >= 336 && $barangayId <= 343) {
                    $zone = 34;
                } elseif ($barangayId >= 344 && $barangayId <= 352) {
                    $zone = 35;
                } elseif ($barangayId >= 353 && $barangayId <= 362) {
                    $zone = 36;
                } elseif ($barangayId >= 363 && $barangayId <= 372) {
                    $zone = 37;
                } elseif ($barangayId >= 373 && $barangayId <= 382) {
                    $zone = 38;
                } elseif ($barangayId >= 383 && $barangayId <= 388) {
                    $zone = 39;
                } elseif ($barangayId >= 389 && $barangayId <= 394) {
                    $zone = 40;
                }
            break;
            case 'District IV':
                 if ($barangayId >= 395 && $barangayId <= 404) {
                    $zone = 41;
                } elseif ($barangayId >= 405 && $barangayId <= 416) {
                    $zone = 42;
                } elseif ($barangayId >= 417 && $barangayId <= 428) {
                    $zone = 43;
                } elseif ($barangayId >= 429 && $barangayId <= 449) {
                    $zone = 44;
                } elseif ($barangayId >= 450 && $barangayId <= 461) {
                    $zone = 45;
                } elseif ($barangayId >= 462 && $barangayId <= 471) {
                    $zone = 46;
                } elseif ($barangayId >= 472 && $barangayId <= 481) {
                    $zone = 47;
                } elseif ($barangayId >= 482 && $barangayId <= 491) {
                    $zone = 48;
                } elseif ($barangayId >= 492 && $barangayId <= 501) {
                    $zone = 49;
                } elseif ($barangayId >= 502 && $barangayId <= 511) {
                    $zone = 50;
                } elseif ($barangayId >= 512 && $barangayId <= 520) {
                    $zone = 51;
                } elseif ($barangayId >= 521 && $barangayId <= 531) {
                    $zone = 52;
                } elseif ($barangayId >= 532 && $barangayId <= 541) {
                    $zone = 53;
                } elseif ($barangayId >= 542 && $barangayId <= 554) {
                    $zone = 54;
                } elseif ($barangayId >= 555 && $barangayId <= 568) {
                    $zone = 55;
                } elseif ($barangayId >= 569 && $barangayId <= 580) {
                    $zone = 56;
                } elseif ($barangayId >= 581 && $barangayId <= 586) {
                    $zone = 57;
                }
            break;
            case 'District V':
                if ($barangayId >= 404 && $barangayId <= 649) {
                    $zone = 68;
                } elseif ($barangayId >= 416 && $barangayId <= 654) {
                    $zone = 69;
                } elseif ($barangayId >= 428 && $barangayId <= 657) {
                    $zone = 70;
                } elseif ($barangayId >= 449 && $barangayId <= 659) {
                    $zone = 71;
                } elseif ($barangayId >= 461 && $barangayId <= 666) {
                    $zone = 72;
                } elseif ($barangayId >= 471 && $barangayId <= 671) {
                    $zone = 73;
                } elseif ($barangayId >= 481 && $barangayId <= 677) {
                    $zone = 74;
                } elseif ($barangayId >= 491 && $barangayId <= 686) {
                    $zone = 75;
                } elseif ($barangayId >= 501 && $barangayId <= 696) {
                    $zone = 76;
                } elseif ($barangayId >= 700 && $barangayId <= 706) {
                    $zone = 77;
                } elseif ($barangayId >= 707 && $barangayId <= 721) {
                    $zone = 78;
                } elseif ($barangayId >= 722 && $barangayId <= 730) {
                    $zone = 79;
                } elseif ($barangayId >= 731 && $barangayId <= 744) {
                    $zone = 80;
                } elseif ($barangayId >= 745 && $barangayId <= 754) {
                    $zone = 81;
                } elseif ($barangayId >= 755 && $barangayId <= 762) {
                    $zone = 82;
                } elseif ($barangayId >= 763 && $barangayId <= 769) {
                    $zone = 83;
                } elseif ($barangayId >= 770 && $barangayId <= 776) {
                    $zone = 84;
                } elseif ($barangayId >= 776 && $barangayId <= 783) {
                    $zone = 85;
                } elseif ($barangayId >= 784 && $barangayId <= 793) {
                    $zone = 86;
                } elseif ($barangayId >= 794 && $barangayId <= 807) {
                    $zone = 87;
                } elseif ($barangayId >= 808 && $barangayId <= 820) {
                    $zone = 88;
                } elseif ($barangayId >= 821 && $barangayId <= 828) {
                    $zone = 89;
                }
                break;
                case 'District VI':
                    if ($barangayId >= 587 && $barangayId <= 593) {
                        $zone = 58;
                    } elseif ($barangayId >= 594 && $barangayId <= 601) {
                        $zone = 59;
                    } elseif ($barangayId >= 602 && $barangayId <= 606) {
                        $zone = 60;
                    } elseif ($barangayId >= 607 && $barangayId <= 618) {
                        $zone = 61;
                    } elseif ($barangayId >= 619 && $barangayId <= 625) {
                        $zone = 62;
                    } elseif ($barangayId >= 626 && $barangayId <= 630) {
                        $zone = 63;
                    } elseif ($barangayId >= 631 && $barangayId <= 636) {
                        $zone = 64;
                    } elseif ($barangayId >= 637 && $barangayId <= 640) {
                        $zone = 65;
                    } elseif ($barangayId >= 641 && $barangayId <= 644) {
                        $zone = 66;
                    } elseif ($barangayId >= 645 && $barangayId <= 648) {
                        $zone = 67;
                    } elseif ($barangayId >= 829 && $barangayId <= 832) {
                        $zone = 90;
                    } elseif ($barangayId >= 833 && $barangayId <= 840) {
                        $zone = 91;
                    } elseif ($barangayId >= 841 && $barangayId <= 848) {
                        $zone = 92;
                    } elseif ($barangayId >= 849 && $barangayId <= 859) {
                        $zone = 93;
                    } elseif ($barangayId >= 860 && $barangayId <= 865) {
                        $zone = 94;
                    } elseif ($barangayId >= 866 && $barangayId <= 872) {
                        $zone = 95;
                    } elseif ($barangayId >= 873 && $barangayId <= 880) {
                        $zone = 96;
                    } elseif ($barangayId >= 881 && $barangayId <= 885) {
                        $zone = 97;
                    } elseif ($barangayId >= 886 && $barangayId <= 891) {
                        $zone = 98;
                    } elseif ($barangayId >= 892 && $barangayId <= 897) {
                        $zone = 99;
                    } elseif ($barangayId >= 898 && $barangayId <= 905) {
                        $zone = 100;
                    } else {
                        $zone = ''; 
                    }
                    break;
            }

            echo $district; // Display district in the first column
            echo '</td>';
            echo '<td>';
            echo 'Zone ' . ($zone !== '' ? $zone : 'N/A'); // Display zone in the second column
            echo '</td>';
            echo '<td>';
            echo '<form method="post" class="d-flex justify-content-center">';
            echo '<input type="hidden" name="selectedBarangayId" value="' . $rowBarangays['id'] . '">';
            echo '<button type="submit" name="viewResidents" class="btn btn-success mr-1" style="margin-right: 20px;">View</button>';
            echo '<button type="submit" id="editPasswordBtn" name="editPassword" class="btn btn-warning border" style="height: 42px;">Edit Password</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';



echo'<style>
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 8px;
        text-align: center; /* Center-align text in table cells */
    }
</style>';

echo '<script>
document.getElementById("viewButton").addEventListener("click", function() {
    window.location.href = "table.php"; 
});
</script>';

// PRINT INCLUDES DASHBOARD/DATATABLES


// Handle button clicks
if (isset($_POST['viewResidents'])) {
    $selectedBarangayId = mysqli_real_escape_string($conn, $_POST['selectedBarangayId']);

    
    // Fetch residents for the selected barangay
    $sqlResidents = "SELECT * FROM residents WHERE barangay_id = $selectedBarangayId";
    $resultResidents = mysqli_query($conn, $sqlResidents);

    // Display resident information
    echo "<div class='resident-info-container'>";
    echo "<div class='resident-age-group'>";
    echo "<h2>Resident Information</h2>";
    echo "<label for='ageGroup'>Age Group:</label>";
    echo "<select style='border-radius: 10px 0px 0px 10px;' name='ageGroup' id='ageGroup'>";
    echo "<option value=''>All</option>";
    echo "<option value='Infant'>Infant</option>";
    echo "<option value='Child'>Child</option>";
    echo "<option value='Teen'>Teen</option>";
    echo "<option value='Adult'>Adult</option>";
    echo "<option value='Senior'>Senior</option>";
    echo "</select>";
    echo "<button style='border-radius: 0px 10px 10px 0px;' id='filterBtn'>Search</button>";
    echo "<input type='text' style='border-radius: 10px 0px 0px 10px' id='ageRangeInput' placeholder='Enter Age Range (e.g., 10-20)' style=' width: 230px; margin-left: 40px;' >";
    echo "<button style='border-radius: 0px 10px 10px 0px' id='ageRangeBtn' data-action='filter'>Filter by Age Range</button>";
    echo '<label for="sexuality" style="margin-left: 10px;" >Sexuality:</label>';
echo '<select style="border-radius: 10px 10px 10px 10px;" name="sexuality" id="sexuality" >';
echo '<option value="">All</option>';
echo '<option value="Straight">Straight – heterosexual</option>';
echo '<option value="Bisexual">Bisexual</option>';
echo '<option value="Lesbian">Lesbian</option>';
echo '<option value="Gay">Gay</option>';
echo '<option value="Transgender">Transgender</option>';
echo '<option value="Bisexual">Bisexual</option>';
echo '<option value="Questioning">Questioning</option>';
echo '<option value="Pansexual">Pansexual</option>';
echo '<option value="Polysexual">Polysexual</option>';
echo '<option value="Asexual">Asexual</option>';
echo '<option value="Demisexual">Demisexual</option>';
echo '<option value="Graysexual">Graysexual</option>';
echo '<option value="Queer">Queer</option>';
echo '<option value="Autosexual">Autosexual</option>';
echo '<option value="Androsexual">Androsexual</option>';
echo '<option value="Gynosexual">Gynosexual</option>';
echo '<option value="Homoflexible">Homoflexible</option>';
echo '<option value="Heteroflexible">Heteroflexible</option>';
echo '<option value="Intersex">Intersex</option>';
echo '<option value="Two Spirit">Two Spirit</option>';
echo '<option value="Androgynous">Androgynous</option>';
echo '<option value="Allosexual">Allosexual</option>';
echo '</select>';
    echo "<button onclick='printTable()' id='print' style ='margin-left 50px; border-radius: 10px;'>Print Table</button>";
    echo "</div>";



  
 
    echo '<style>

    @media (max-width: 768px) {
        label, select, button {
            margin: 5px; /* Adjust margins for smaller screens */
        }
        select {
            width: 100%;
        }
        #print {
            width: 100%; /* Full width for print button on smaller screens */
            margin: 5px; /* Adjust margin for smaller screens */
        }
        #ageRangeInput {
            width: 100%; /* Full width for input field on smaller screens */
        }
        #ageRangeBtn {
            width: 100%; /* Full width for age range button on smaller screens */
            margin: 5px; 
        }
    }
    #ageRangeInput{
        margin-left: 5%;
        width: 18%;
        padding: 8px;
        border-radius: 4px;
    }

    #ageGroup{
        height: 36px;
    }
    .resident-age-group {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
    }
    .resident-info-container {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
        margin-top: 20px;
    }
    
    .resident-info-container h2 {
        margin-bottom: 10px;
    }
    
    .resident-info-container label {
        display: inline-block;
        margin-right: 10px;
    }
    
    .resident-info-container select {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    
    .resident-info-container button {
        padding: 8px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
        transition: background-color 0.3s;
    }
    
    .resident-info-container button:hover {
        background-color: #0056b3;
    }
 

    #print{
        margin-left:150px;
        height: 38px;
</style>';


    // Table header
    echo "<div style='overflow-x: auto;'>";
    echo "<table id='residentTable' style='font-size: 14px;'>";
    echo "<thead><tr><th>Resident</th><th>ID</th><th>Last Name</th><th>First Name</th><th>Name Extension</th><th>Middle Name</th><th>Sex</th><th>Gender Sexuality</th><th>Employment Status</th><th>Income</th><th>Age</th><th>Disability Status</th><th>Disability</th><th>Address</th><th>Birthday</th><th>Civil Status</th><th>Nationality</th><th>Religion</th><th>Contact Number</th><th>Email</th></tr></thead>";
    echo "<tbody>";

 

    // Table body
    $residentNumber = 1;
    while ($row = mysqli_fetch_assoc($resultResidents)) {
        echo "<tr>";
        echo "<td>{$residentNumber}</td>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['lastname']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['nameextension']}</td>";
        echo "<td>{$row['middlename']}</td>";
        echo "<td>{$row['gender']}</td>";
        echo "<td>{$row['sexuality']}</td>";
        echo "<td>{$row['employment_status']}</td>";
        echo "<td>{$row['income']}</td>";
        echo "<td>{$row['age']}</td>";
        echo "<td>{$row['disabilityStatus']}</td>";
        echo "<td>{$row['disability']}</td>";
        echo "<td>{$row['address']}</td>";
        echo "<td>{$row['birthday']}</td>";
        echo "<td>{$row['civil_status']}</td>";
        echo "<td>{$row['nationality']}</td>";
        echo "<td>{$row['religion']}</td>";
        echo "<td>{$row['contact_number']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "</tr>";
        $residentNumber++;
    }

    // Table closing tags
    echo "</tbody>";
    echo "</table>";
    echo "</div>";






   // Display Barangay Dashboard
   echo '<h2 class="dashboard-heading">Barangay Dashboard</h2>';

   if ($selectedBarangayId !== null) {
       $sqlEmploymentStatus = "SELECT employment_status, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId GROUP BY employment_status";
       $resultEmploymentStatus = mysqli_query($conn, $sqlEmploymentStatus);

       if (!$resultEmploymentStatus) {
           die("Error in Employment Status query: " . mysqli_error($conn));
       }

       echo '<div class="dashboard-container">';

       // Employment Status Box

       echo '<div class="dashboard-box">';
       echo "<h4>Employment Status</h4>";
       echo "<ul>";
       while ($rowEmploymentStatus = mysqli_fetch_assoc($resultEmploymentStatus)) {
           echo "<li>{$rowEmploymentStatus['employment_status']}: {$rowEmploymentStatus['count']}</li>";
       }
       echo "</ul>";

       $sqlAgeGroups = "SELECT 
               SUM(CASE WHEN age <= 2 THEN 1 ELSE 0 END) AS infants,
               SUM(CASE WHEN age BETWEEN 3 AND 12 THEN 1 ELSE 0 END) AS children,
               SUM(CASE WHEN age BETWEEN 13 AND 17 THEN 1 ELSE 0 END) AS teens,
               SUM(CASE WHEN age BETWEEN 18 AND 59 THEN 1 ELSE 0 END) AS adults,
               SUM(CASE WHEN age >= 60 THEN 1 ELSE 0 END) AS seniors
           FROM residents WHERE barangay_id = $selectedBarangayId";

       $resultAgeGroups = mysqli_query($conn, $sqlAgeGroups);

       if (!$resultAgeGroups) {
          die("Error in Age Groups query: " . mysqli_error($conn));
       }
       echo '</div>';

        // Age Groups Box
        echo '<div class="dashboard-box">'; 
      echo "<h4>Age Groups</h4>";
      echo "<ul>";
      $rowAgeGroups = mysqli_fetch_assoc($resultAgeGroups);
      echo "<li>Infants (0 - 2): {$rowAgeGroups['infants']}</li>";
      echo "<li>Children (3 - 12): {$rowAgeGroups['children']}</li>";
      echo "<li>Teens (13 - 17): {$rowAgeGroups['teens']}</li>";
      echo "<li>Adults (18 - 59): {$rowAgeGroups['adults']}</li>";
      echo "<li>Seniors (60 and above): {$rowAgeGroups['seniors']}</li>";
      echo "</ul>";
      echo "</div>";

       $sqlStraightMaleDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId AND sexuality = 'Straight' AND gender = 'Male'";
$resultStraightMaleDistribution = mysqli_query($conn, $sqlStraightMaleDistribution);

if (!$resultStraightMaleDistribution) {
    die("Error in Gender Distribution query: " . mysqli_error($conn));
}

$sqlStraightFemaleDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId AND sexuality = 'Straight' AND gender = 'Female'";
$resultStraightFemaleDistribution = mysqli_query($conn, $sqlStraightFemaleDistribution);

if (!$resultStraightFemaleDistribution) {
    die("Error in Gender Distribution query: " . mysqli_error($conn));
}

$sqlLGBTMaleDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId AND sexuality != 'Straight' AND gender = 'Male'";
$resultLGBTMaleDistribution = mysqli_query($conn, $sqlLGBTMaleDistribution);

if (!$resultStraightMaleDistribution) {
    die("Error in Gender Distribution query: " . mysqli_error($conn));
}

$sqlLGBTFemaleDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId AND sexuality != 'Straight' AND gender = 'Female'";
$resultLGBTFemaleDistribution = mysqli_query($conn, $sqlLGBTFemaleDistribution);

if (!$resultStraightMaleDistribution) {
    die("Error in Gender Distribution query: " . mysqli_error($conn));
}

echo '<div class="dashboard-box">';
echo "<h4 style='text-align:center;'>Gender Distribution</h4>";
echo "<ul>";
while ($rowStraightMaleDistribution = mysqli_fetch_assoc($resultStraightMaleDistribution)) {
    echo "<li>Straight Males: {$rowStraightMaleDistribution['count']}</li>";
}

while ($rowStraightFemaleDistribution = mysqli_fetch_assoc($resultStraightFemaleDistribution)) {
    echo "<li>Straight Females: {$rowStraightFemaleDistribution['count']}</li>";
}

echo "<hr>";

while ($rowLGBTMaleDistribution = mysqli_fetch_assoc($resultLGBTMaleDistribution)) {
    echo "<li>LGBT Males: {$rowLGBTMaleDistribution['count']}</li>";
}

while ($rowLGBTFemaleDistribution = mysqli_fetch_assoc($resultLGBTFemaleDistribution)) {
    echo "<li>LGBT Females: {$rowLGBTFemaleDistribution['count']}</li>";
}
       echo "</ul>";
       echo '</div>';

       echo '<div class="dashboard-box">';
       $sqlTotalPopulation = "SELECT COUNT(id) as total_population FROM residents WHERE barangay_id = $selectedBarangayId";
       $resultTotalPopulation = mysqli_query($conn, $sqlTotalPopulation);
       $rowTotalPopulation = mysqli_fetch_assoc($resultTotalPopulation);

       if (!$resultTotalPopulation) { 
           die("Error in Total Population query: " . mysqli_error($conn));
       }


       // Total Population Box
       echo "<h4>Total Population</h4>";
       echo "<p>{$rowTotalPopulation['total_population']}</p>";
   } else {
       echo "<p>Please select a barangay or perform a search to view the dashboard.</p>";
   }
}
   echo '</div>';
   echo '</div>';

   echo '<style>
   .dashboard-container {
       display: flex;
       justify-content: center; 
       gap: 10px;
   }
   .dashboard-box {
       flex: 1;
       margin: 15px;
       padding: 20px;
       border: 4px solid #a9a9a9;
       box-shadow: 6px 3px 2px rgba(0, 0, 0, 0.8);
       transition: all 0.3s ease;
       cursor: pointer;
       color: black; 
       border-radius: 20px; 
   }
   .dashboard-heading {
       font-size: 35px;
       font-weight: bold;
       text-align: center;
       color: #333; 
       margin-top: 30px;
   }
   .dashboard-box:hover {
       transform: translateY(-5px);
       box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
   }
   .dashboard-box h4 {
       margin-bottom: 10px;
       font-size: 24px;
       font-weight: bold;
       text-align: center; 
   }
   .dashboard-box ul {
       padding: 0;
       margin-top: 13px;
       list-style-type: none;
       font-size: 20px; 
   }
   .dashboard-box ul li {
       margin-top: 13px;
       font-size: 20px; 
   }
   .dashboard-box p {
       margin: 0; 
       font-size: 50px; 
       text-align: center; 
       line-height: 150px; 
       height: 100px;
       width: 100%; 
       display: flex;
       align-items: center;
       justify-content: center; 
   }
</style>';




if (isset($_POST['editPassword'])) {
    $selectedBarangayId = isset($_POST['selectedBarangayId']) ? $_POST['selectedBarangayId'] : null;

    if ($selectedBarangayId !== null && !empty($selectedBarangayId)) {

        $sqlFetchBarangayInfo = "SELECT b.barangay_name, u.username, u.password
                                FROM barangays b
                                JOIN users u ON b.barangay_name = u.username
                                WHERE b.id = ?";

        $stmt = mysqli_prepare($conn, $sqlFetchBarangayInfo);
        mysqli_stmt_bind_param($stmt, "i", $selectedBarangayId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $barangayName, $username, $password);

        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($barangayName !== null && $username !== null && $password !== null) {
            echo '<!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="border-radius: 20px;">
            <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="margin-left: auto; margin-right: auto;">
            <h5 class="modal-title" id="exampleModalLongTitle" style="margin-left: auto; margin-right: auto; text-align: center; font-size: 35px; font-weight: bold; color: #333;">Edit Password</h5>
             </div>
                <div class="modal-body">
                <div style="text-align: center; font-size: 25px; font-weight: bold; margin-bottom: 10px;">';
            echo "Barangay Name: " . $barangayName . "<br>";
            echo '</div>';
            echo '<form method="post" action="process_edit_password.php" class="password-edit-form" style="margin-top: 20px;">
                        <input type="hidden" name="selectedBarangayId" value="' . htmlspecialchars($selectedBarangayId) . '">
                        <div class="form-group">
                        <label for="oldpassword">Old Password:</label>
                        <input type="text" id="oldpassword" name="oldpassword" value="' . htmlspecialchars($password) . '" readonly style="border: 2px solid #007bff; outline: none;" onmouseover="this.style.borderColor=\' #007bff\'; this.style.borderWidth=\'3px\';" onmouseout="this.style.borderColor=\'#007bff\'; this.style.borderWidth=\'2px\';">
                    </div>
                    <div class="form-group">
                        <label for="newpassword">New Password:</label>
                        <input type="password" id="newpassword" name="newpassword" required style="border: 2px solid #007bff; outline: none;" onmouseover="this.style.borderColor=\' #007bff\'; this.style.borderWidth=\'3px\';" onmouseout="this.style.borderColor=\'#007bff\'; this.style.borderWidth=\'2px\';">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirm Password:</label>
                        <input type="password" id="confirmpassword" name="confirmpassword" required style="border: 2px solid black; outline: none;" onmouseover="this.style.borderColor=\'#007bff\'; this.style.borderWidth=\'3px\';" onmouseout="this.style.borderColor=\'#007bff\'; this.style.borderWidth=\'2px\';">
                    </div>
                        <button type="submit" name="savechanges" class="btn btn-primary" style="position: absolute; bottom: 0; right: 0; margin-bottom: 15px; margin-right: 140px; padding: 15px 18px;">Save Changes</button>';
                        echo '<button type="submit" name="canceledit" class="btn btn-danger"  data-dismiss="modal" style="position: absolute; bottom: 0; right: 0; margin-bottom: 15px; margin-right: 50px; padding: 15px 18px;" onclick="window.location.href=\'admin_homepage.php\'" data-dismiss="modal">Cancel</button>';                
            echo '</form>';
            echo '</div>        
                </div>
              </div>
            </div>';
            echo '<script>
            $(document).ready(function() {
                $("#exampleModalCenter").modal("show");
            });
          </script>';
        } else {
            echo "No barangay info found.";
        }
    } else {
        die("Invalid barangay ID");
    }
}

echo '<style>

.password-edit-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    animation: glow 2s infinite alternate; 
}

@keyframes glow {
    from {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }
    to {
        box-shadow: 0 0 20px rgba(0, 123, 255, 0.8);
    }
}
.password-edit-form {
    max-width: 400px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    margin-right: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
}

button:hover {
    opacity: 0.8;
}
</style>';

echo '</div>';

?>

 <script>
document.getElementById("editPassword").addEventListener("click", function() {
    var formContainer = document.querySelector(".password-edit-container");
    formContainer.style.display = "block"; 
});

function cancelEdit() {
    var formContainer = document.querySelector(".password-edit-container");
    formContainer.style.display = "none"; 
}

</script>


<style>
    .forgot-pass {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }

    </style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style3.css" rel="Stylesheet" type="text/css" /> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"  crossorigin="anonymous"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>  
    <link href="encoding-styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/4b82c45eb7.js" crossorigin="anonymous"></script> 
        <link rel="stylesheet" href ="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css" href="print-styles.css" media="print">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
   

    <script>
    
    $(document).ready(function () {

            // Define a custom search function for DataTable based on sexuality
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var selectedSexuality = $('#sexuality').val(); // Get selected sexuality
            return selectedSexuality === '' || selectedSexuality === data[7]; // Check if selected sexuality matches data
        }
    );
     // Event listener for the sexuality dropdown
     $('#sexuality').change(function () {
        table.draw();
    });

    var table = $('#residentTable').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": [3,4,5,6,7,8,9,11, 12,13,14,15,16,17,18,19] }
        ],
        "initComplete": function () {
            this.api().columns(8).every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                var ageOptions = ['Infant', 'Child', 'Teen', 'Adult', 'Senior'];
                ageOptions.sort();

                ageOptions.forEach(function (option) {
                    select.append('<option value="' + option + '">' + option + '</option>');
                });
            });
        },
        "lengthMenu": [50,100,300, 500, 1000, 3000, 5000]
    });

    $('#filterBtn').on('click', function () {
        table.draw();
    });

    $('#ageRangeBtn').on('click', function () {
    var ageRange = $('#ageRangeInput').val().trim();
    if (ageRange) {
        var ageRangeArray = ageRange.split('-');
        var minAge = parseInt(ageRangeArray[0].trim());
        var maxAge = parseInt(ageRangeArray[1].trim());
        if (!isNaN(minAge) && !isNaN(maxAge)) {
            // Construct the search query to match the age range
            var searchQuery = "^(";
            for (var age = minAge; age <= maxAge; age++) {
                searchQuery += age + "|";
            }
            // Remove the last pipe symbol
            searchQuery = searchQuery.slice(0, -1);
            searchQuery += ")$";
            
            // Apply the age range filter to the table
            table.column(10).search(searchQuery, true, false).draw();
            
            // Calculate total males and females within the age range
            var filteredData = table.rows({ search: 'applied' }).data().toArray();
            var malesCount = 0;
            var femalesCount = 0;
            filteredData.forEach(function(row) {
                if (row[6].toLowerCase() === 'male') {
                    malesCount++;
                } else if (row[6].toLowerCase() === 'female') {
                    femalesCount++;
                }
            });
            
            // Display the totals in the dashboard
            $('#maleCount').text('Total Males: ' + malesCount);
            $('#femaleCount').text('Total Females: ' + femalesCount);


        
        } else {
            console.log("Invalid age range format.");
        }
    } else {
        // If the input is empty, clear the filter
        table.column(10).search('').draw();
        
        // Clear the dashboard
        $('#maleCount').text('');
        $('#femaleCount').text('');
    }
    
    // Clear the content in the input field
    $('#ageRangeInput').val('');
});


    var ageGroupMapping = {
        '0-2': 'Infant',
        '3-12': 'Child',
        '13-17': 'Teen',
        '18-59': 'Adult',
        '60+': 'Senior'
    };

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var selectedAgeGroup = $('#ageGroup').val();
            var age = data[10]; 
            if (selectedAgeGroup === '') {
                return true;
            }
            var ageGroup = '';
            if (age <= 2) {
                ageGroup = 'Infant';
            } else if (age >= 3 && age <= 12) {
                ageGroup = 'Child';
            } else if (age >= 13 && age <= 17) {
                ageGroup = 'Teen';
            } else if (age >= 18 && age <= 59) {
                ageGroup = 'Adult';
            } else {
                ageGroup = 'Senior';
            }
            return selectedAgeGroup === ageGroup;
        }
    );
});

/*function printTable() {
    var el = document.getElementById("residentTable");

    // Apply CSS styling
    el.style.border = '1px solid black';  // Add border styling
    el.style.fontSize = '7pt';

    // Clone the table element to avoid modifying the original
    var clonedTable = el.cloneNode(true);

    

    // Create a new window for printing
    var newPrint = window.open("");

 
    newPrint.document.write(`
  
        <h2>Residents Table</h2>
        ${clonedTable.outerHTML}
    `);

    // Print the new window
    newPrint.print();

    // Close the new window
    newPrint.close();
}*/

    function printTable() {
        var el = document.getElementById("residentTable");

        // Apply basic CSS styling to the cloned table to ensure it retains the original styles
        el.style.border = '1px solid black';
        el.style.fontSize = '10pt'; // Adjusted font size for better readability
        el.style.borderCollapse = 'collapse'; // Ensure the table borders collapse for cleaner output

        // Clone the table element to avoid modifying the original
        var clonedTable = el.cloneNode(true);

        // Create a new window for printing
        var newPrint = window.open("", "_blank", "width=800,height=600");

        // Write the document content with additional styles for printing
        newPrint.document.write(`
            <html>
            <head>
                <title>Print - Residents Table</title>
                <style>
                    body {
                        font-family: Arial, sans-serif; // Ensures consistent font
                        margin: 20px; // Provide some margin for the printed content
                    }
                    h2 {
                        text-align: center; // Center the heading
                    }
                    table {
                        width: 100%; // Use full width
                        border: 1px solid black;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid black; // Uniform border styling
                        padding: 5px; // Padding for better spacing
                        text-align: center; // Center-align text in cells
                    }
                    /* Override hidden display property for printing */
                    * {
                        display: block !important; // Make everything visible during printing
                    }
                </style>
            </head>
            <body>
                <h2>Residents Table</h2>
                ${clonedTable.outerHTML} <!-- Include the cloned table -->
            </body>
            </html>
        `);

        // Ensure the content is fully loaded before printing
        newPrint.document.close();
        newPrint.focus();

        // Print and then close the new window
        newPrint.print();
        setTimeout(() => newPrint.close(), 1000); // Give some time for the printing process
    }

    </script>
    <script>
    // Function to update the date and time
    function updateDateTime() {
      const date = new Date();
      const options = { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' };
      const timeOptions = { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };
      const formattedDate = date.toLocaleDateString(undefined, options);
      const formattedTime = date.toLocaleTimeString(undefined, timeOptions);
      document.getElementById("currentDateTime").textContent = `${formattedDate} - ${formattedTime}`;
    }

    // Initial call to set the date and time
    updateDateTime();

    // Update the date and time every second
    setInterval(updateDateTime, 1000);

    var modal;
            var isChangesMade = false;

            function showModal() {
                $('#navbModal').modal('show');
                $("#navbModal").prependTo("body");
            }

            function enableSaveCancel() {
                document.getElementById('save').disabled = false;
                document.getElementById('cancel').disabled = false;
                document.getElementById('update').disabled = true;
                document.getElementById('delete').disabled = true;

                document.getElementById('last-name-form').disabled = false;
                document.getElementById('first-name-form').disabled = false;
                document.getElementById('middle-name-form').disabled = false;
                document.getElementById('sex-form').disabled = false;
                document.getElementById('age-form').disabled = true;
                document.getElementById('birthday-form').disabled = false;
                document.getElementById('civil-status-form').disabled = false;
                document.getElementById('contact-form').disabled = false;
                document.getElementById('address-form').disabled = false;
                document.getElementById('religion-form').disabled = false;
                document.getElementById('nationality-form').disabled = false;
                document.getElementById('status-form').disabled = false;
                document.getElementById('email-form').disabled = false;

                isChangesMade = true;
            }

            function disableSaveCancel() {
                document.getElementById('save').disabled = true;
                document.getElementById('cancel').disabled = true;
                document.getElementById('update').disabled = false;
                document.getElementById('delete').disabled = false;

                document.getElementById('last-name-form').disabled = true;
                document.getElementById('first-name-form').disabled = true;
                document.getElementById('middle-name-form').disabled = true;
                document.getElementById('sex-form').disabled = true;
                document.getElementById('age-form').disabled = true;
                document.getElementById('birthday-form').disabled = true;
                document.getElementById('civil-status-form').disabled = true;
                document.getElementById('contact-form').disabled = true;
                document.getElementById('address-form').disabled = true;
                document.getElementById('religion-form').disabled = true;
                document.getElementById('nationality-form').disabled = true;
                document.getElementById('status-form').disabled = true;
                document.getElementById('email-form').disabled = true;

                isChangesMade = false;
            }

            document.querySelectorAll('.view-details-btn').forEach(button => {
                button.addEventListener('click', function () {
                    var row = this.closest('tr'); // Get the closest row of the clicked button
                    var cells = row.querySelectorAll('td'); // Get all cells in that row
                    
                    // Extract data from cells and populate the textboxes in the modal
                    document.getElementById('last-name-details').innerText = cells[2].innerText;
                    document.getElementById('first-name-details').innerText = cells[3].innerText;
                    document.getElementById('middle-name-details').innerText = cells[5].innerText;
                    document.getElementById('sex-details').innerText = cells[6].innerText;
                    document.getElementById('age-details').innerText = cells[10].innerText;
                    document.getElementById('civil-status-details').innerText = cells[15].innerText;
                    document.getElementById('birthday-details').innerText = cells[14].innerText;
                    document.getElementById('contact-details').innerText = cells[18].innerText;
                    document.getElementById('religion-details').innerText = cells[17].innerText;
                    document.getElementById('nationality-details').innerText = cells[16].innerText;
                    document.getElementById('status-details').innerText = cells[8].innerText;
                    document.getElementById('email-details').innerText = cells[19].innerText;
                    document.getElementById('address-details').innerText = cells[13].innerText;

                    $('#detailsModal').modal('show'); // Show the modal

                    var lastnameDetails = document.getElementById('last-name-details').innerText;
                    var firstnameDetails = document.getElementById('first-name-details').innerText;
                    var middlenameDetails = document.getElementById('middle-name-details').innerText;
                    var sexDetails = document.getElementById('sex-details').innerText;
                    var ageDetails = document.getElementById('age-details').innerText;
                    var birthdayDetails = document.getElementById('birthday-details').innerText;
                    var civilStatusDetails = document.getElementById('civil-status-details').innerText;
                    var contactDetails = document.getElementById('contact-details').innerText;
                    var addressDetails = document.getElementById('address-details').innerText;
                    var religionDetails = document.getElementById('religion-details').innerText;
                    var nationalityDetails = document.getElementById('nationality-details').innerText;
                    var statusDetails = document.getElementById('status-details').innerText;
                    var emailDetails = document.getElementById('email-details').innerText;

                    document.getElementById('last-name-form').value = lastnameDetails;
                    document.getElementById('first-name-form').value = firstnameDetails;
                    document.getElementById('middle-name-form').value = middlenameDetails;
                    document.getElementById('sex-form').value = sexDetails;
                    document.getElementById('age-form').value = ageDetails;
                    document.getElementById('birthday-form').value = birthdayDetails;
                    document.getElementById('civil-status-form').value = civilStatusDetails;
                    document.getElementById('contact-form').value = contactDetails;
                    document.getElementById('address-form').value = addressDetails;
                    document.getElementById('religion-form').value = religionDetails;
                    document.getElementById('nationality-form').value = nationalityDetails;
                    document.getElementById('status-form').value = statusDetails;
                    document.getElementById('email-form').value = emailDetails;
                    });
                });

                document.getElementById("detailsModal").addEventListener("hidden.bs.modal", function () {
                    // When the modal is hidden, ensure the backdrop is also removed
                    document.querySelector(".modal-backdrop").remove();
                });

  </script>
   <title>RBI Manila</title>
</head>

<body>    
     <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');

        body {
            font-family: 'DM Sans', sans-serif !important;
            background-color: #f4f4f4;
        }

    .box-display {
        width: 100%;
        max-width: 300px; 
        margin: 5px; 
    }

    .container-max-width {
        max-width: 100%; 
        margin: 0 auto; 
        
    }

</style>

<div id="maleCount"></div>
<div id="femaleCount"></div>
<div id="totalResidents"></div>
</body>
</html>



