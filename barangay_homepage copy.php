<?php
session_start();

if ($_SESSION['role'] !== 'barangay_official') {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "username", "password", "barangay_db");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}




// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $lastname = $_POST['lastname'];
        $name = $_POST['name'];
        $nameextension = $_POST['nameextension'];
        $middlename = $_POST['middlename'];
        $gender = $_POST['gender'];
        $sexuality = $_POST['sexuality'];
        $employment_status = $_POST['employment_status'];
        $age = $_POST['age'];
        $disability = $_POST['disability'];
        $disabilityStatus = $_POST['disabilityStatus'];
        $income = $_POST['income'];
        $block_lot = isset($_POST['block_lot']) ? $_POST['block_lot'] : '';
        $street = isset($_POST['street']) ? $_POST['street'] : '';
        $barangayId = mysqli_real_escape_string($conn, $_POST['barangay_id']); // Sanitize input
        $birthday = $_POST['birthday'];
        $civil_status = $_POST['civil_status'];
        $nationality = $_POST['nationality'];
        $religion = $_POST['religion'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $address = "$block_lot, $street";
        $sqlInsert = "INSERT INTO residents (lastname, name, nameextension, middlename, gender,sexuality, employment_status, income, age, disability,disabilityStatus,address, barangay_id, birthday, civil_status, nationality, religion, contact_number, email) VALUES ('$lastname', '$name', '$nameextension','$middlename', '$gender','$sexuality', '$employment_status', '$income', '$age','$disability', '$disabilityStatus','$address', '$barangayId', '$birthday', '$civil_status', '$nationality', '$religion', '$contact_number', '$email')";

        if (mysqli_query($conn, $sqlInsert)) {
            echo "Resident information saved successfully.";
            header("Location: barangay_homepage.php");
            exit();
            echo '</div>';
        } else {
            echo "Error: " . $sqlInsert . "<br>" . mysqli_error($conn);
        }

      
    } elseif (isset($_POST['edit'])) {
        // Display the form fields with the selected resident's information for editing
        $residentId = $_POST['resident_id'];
        $lastname = $_POST['lastname'];
        $name = $_POST['name'];
        $nameextension = $_POST['nameextension'];
        $middlename = $_POST['middlename'];
        $gender = $_POST['gender'];
        $sexuality = $_POST['sexuality'];
        $employment_status = $_POST['employment_status'];
        $income = $_POST['income'];
        $age = $_POST['age'];
        $disabilityStatus = $_POST['disabilityStatus'];
        $disability = $_POST['disability'];
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $barangayId = mysqli_real_escape_string($conn, $_POST['barangay_id']); // Sanitize input
        $birthday = $_POST['birthday'];
        $civil_status = $_POST['civil_status'];
        $nationality = $_POST['nationality'];
        $religion = $_POST['religion'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $editing = true;
    
        // Extract block_lot and street from the existing address
        list($block_lot, $street) = explode(', ', $address);
        
        // Now you can set these values for the corresponding input fields
        $block_lot_value = htmlspecialchars($block_lot);
        $street_value = htmlspecialchars($street);
    
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("overlay").style.display = "block";
            document.getElementById("formContainer").style.display = "block";
            document.getElementById("exitButton").addEventListener("click", function(event) {
                event.preventDefault(); 
                exitForm(); 
              
            });
        });

      </script>';
      

    } elseif (isset($_POST['update'])) {
        // Retrieve form data
        $residentId = $_POST['resident_id'];
        $lastname = $_POST['lastname'];
        $name = $_POST['name'];
        $nameextension = $_POST['nameextension'];
        $middlename = $_POST['middlename'];
        $gender = $_POST['gender'];
        $sexuality = $_POST['sexuality'];
        $employment_status = $_POST['employment_status'];
        $income = $_POST['income'];
        $disabilityStatus = $_POST['disabilityStatus'];
        $disability = $_POST['disability'];
        $block_lot = isset($_POST['block_lot']) ? $_POST['block_lot'] : '';
        $street = isset($_POST['street']) ? $_POST['street'] : '';
        $barangayId = mysqli_real_escape_string($conn, $_POST['barangay_id']); // Sanitize input
        $birthday = $_POST['birthday'];
        $civil_status = $_POST['civil_status'];
        $nationality = $_POST['nationality'];
        $religion = $_POST['religion'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
    
        // Concatenate block_lot, street, and address
        $address = "$block_lot, $street";
    
        // Calculate age based on the updated birthday
        $birthdate = new DateTime($birthday);
        $today = new DateTime();
        $age = $birthdate->diff($today)->y;
    
        // Update the age value in the form data
        $_POST['age'] = $age;
    
        // Update the database with the new information
        $sqlUpdate = "UPDATE residents SET lastname='$lastname', name='$name', nameextension='$nameextension', middlename='$middlename', gender='$gender', sexuality='$sexuality', employment_status='$employment_status', income='$income', age='$age', disability='$disability',disabilityStatus='$disabilityStatus', address='$address', barangay_id='$barangayId', birthday='$birthday', civil_status='$civil_status', nationality='$nationality', religion='$religion', contact_number='$contact_number', email='$email' WHERE id=$residentId";
    
        if (mysqli_query($conn, $sqlUpdate)) {
            echo "Resident information updated successfully.";
    
            // Redirect to avoid form resubmission on page refresh
            echo "<script>alert('Resident information updated successfully!');</script>";
            header("Location: barangay_homepage.php");
            echo "<script>window.location.href='barangay_homepage.php';</script>";
            
            exit();
        } else {
            echo "Error updating resident information: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete'])) {
        $residentId = $_POST['resident_id'];

        $sqlDelete = "DELETE FROM residents WHERE id=$residentId";

        if (mysqli_query($conn, $sqlDelete)) {
            echo "<script>alert('Resident information deleted successfully!');</script>";
            
            header("Location: barangay_homepage.php");
            exit();
        } else {
            echo "Error deleting resident information: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['cancel'])) {
        // Reset form fields
        unset($residentId, $lastname, $name,$nameextension,$middlename, $gender, $sexuality, $employment_status, $income, $age,$disability, $disabilityStatus, $address, $barangayId, $birthday, $civil_status, $nationality, $religion, $contact_number, $email, $editing);
    }
}

// Calculate population statistics
$sqlStatistics = "SELECT
    COUNT(*) AS total_population,
    SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) AS total_males,
    SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) AS total_females,
    SUM(CASE WHEN age <= 2 THEN 1 ELSE 0 END) AS total_infants,
    SUM(CASE WHEN age BETWEEN 3 AND 12 THEN 1 ELSE 0 END) AS total_children,
    SUM(CASE WHEN age BETWEEN 13 AND 17 THEN 1 ELSE 0 END) AS total_teens,
    SUM(CASE WHEN age BETWEEN 18 AND 59 THEN 1 ELSE 0 END) AS total_adults,
    SUM(CASE WHEN age >= 60 THEN 1 ELSE 0 END) AS total_seniors
FROM residents
WHERE barangay_id IN (SELECT id FROM barangays WHERE barangay_name LIKE '%$username%')";

$resultStatistics = mysqli_query($conn, $sqlStatistics);

// Fetch resident information from the database
$sqlResidents = "SELECT * FROM residents WHERE barangay_id IN (SELECT id FROM barangays WHERE barangay_name LIKE '%$username%')";
$resultResidents = mysqli_query($conn, $sqlResidents);

// Fetch resident information from the database
$sqlResidents = "SELECT * FROM residents WHERE barangay_id IN (SELECT id FROM barangays WHERE barangay_name LIKE '%$username%')";
$resultResidents = mysqli_query($conn, $sqlResidents);


// Fetch population statistics
$sqlStats = "SELECT 
    COUNT(*) AS total_population,
    SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) AS females,
    SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) AS males,
    SUM(CASE WHEN age <= 2 THEN 1 ELSE 0 END) AS infants,
    SUM(CASE WHEN age BETWEEN 3 AND 12 THEN 1 ELSE 0 END) AS children,
    SUM(CASE WHEN age BETWEEN 13 AND 17 THEN 1 ELSE 0 END) AS teens,
    SUM(CASE WHEN age BETWEEN 18 AND 59 THEN 1 ELSE 0 END) AS adults,
    SUM(CASE WHEN age >= 60 THEN 1 ELSE 0 END) AS seniors
FROM residents
WHERE barangay_id IN (SELECT id FROM barangays WHERE barangay_name LIKE '%$username%')";
$resultStats = mysqli_query($conn, $sqlStats);

// Fetch employed residents
$sqlEmployed = "SELECT COUNT(*) AS total_employed FROM residents 
               WHERE employment_status = 'Employed' 
               AND barangay_id IN (SELECT id FROM barangays WHERE barangay_name LIKE '%$username%')";
$resultEmployed = mysqli_query($conn, $sqlEmployed);

// Fetch student residents
$sqlStudents = "SELECT COUNT(*) AS total_students FROM residents 
               WHERE employment_status = 'Student' 
               AND barangay_id IN (SELECT id FROM barangays WHERE barangay_name LIKE '%$username%')";
$resultStudents = mysqli_query($conn, $sqlStudents);

if ($resultStats && $resultEmployed && $resultStudents) {
    $stats = mysqli_fetch_assoc($resultStats);
    $totalPopulation = $stats['total_population'];
    $females = $stats['females'];
    $males = $stats['males'];
    $infants = $stats['infants'];
    $children = $stats['children'];
    $teens = $stats['teens'];
    $adults = $stats['adults'];
    $seniors = $stats['seniors'];

    $employedData = mysqli_fetch_assoc($resultEmployed);
    $totalEmployed = $employedData['total_employed'];

    $studentsData = mysqli_fetch_assoc($resultStudents);
    $totalStudents = $studentsData['total_students'];


//time an date
date_default_timezone_set('Asia/Manila'); 
           // style for header 
            echo '<header class="navbar navbar-default" style=" height: auto; box-shadow: none;"> 
            <div class="container-fluid">
            
            <div class="navb-logo" style="display: flex; padding-left:">
            <img src="images/logo.png"  draggable="false" alt="logo-needed" class="img-fluid" style="height: 50px; width: auto; max-width: 100%;margin-right:30px; ">
            
            <div class="current-date-time" style="margin-left: 0px; margin-top: 18px;">' . date("l, F jS Y - g:i A") . '</div>
               
        </div>

         
                
                <div class="navb-items d-none d-lg-flex"> <!-- Hide on small screens, show on large screens -->
                    <div class="item">
                    <a href="#" onclick="downloadDocument()" style="color: #0a2472; font-weight: bold; ">RBI&nbsp;Certification</a> 
                    </div>
                    

                    <div class="item">
                        <a href="#" class="active" id="toggleForm" style="color: #0a2472; font-weight: bold; ">Encode&nbsp;Info</a>
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
                                <img src="images/logo.png" alt="logo-needed" class="img-fluid" draggable="false">
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

        echo '<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" data-interval="4000">';
        echo '<div class="carousel-inner">';
        echo '<div class="carousel-item active">';
        echo '<img src="https://lh3.googleusercontent.com/pw/AP1GczO8mu7-B_YBO0MR3_viM40nJNF782j-I1pgZOKIP_zXfajdVcGEWPcA3fsOMpzojsvFG__xh_z_xq66IWNvyi01_FrUZFCcuFrzF7PtEEkAd_BHlSY=w1920-h1080" class="d-block w-100" alt="First slide" draggable="false">';
        echo '</div>';
        echo '<div class="carousel-item">';
        echo '<img src="images/manila-mayora.png" class="d-block w-100" alt="Second slide" draggable="false">';
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

   

echo '<div class="main-container">';
echo '<div class="container-fluid mx-auto">';
echo '<div class="container" style="max-width: 1500px;">'; 
echo '<div class="row justify-content-center my-4">';

            // Barangay Population
            echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display"style="width: 260px; height: 170px;">';
            echo '<div class="box-display-males" style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
            echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Population</h4>';
            echo '<h1 class="text-end me-3" style="color: #002d80;">' . $totalPopulation . '</h1>';
            echo '</div>';
            echo '</div>';

            //Total Employed People
            echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display"style="width: 260px; height: 170px;">';
            echo '<div class="box-display-males"style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
            echo '<h4 class="text-start ms-3 mt-3" style="color:#002d80;">Total Employed</h4>';
            echo '<h1 class="text-end me-3" style="color: #002d80;">' .$totalEmployed. '</h1>';
            echo '</div>';
            echo '</div>';

             //Total Infants 
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display"style="width: 260px; height: 170px;">';
             echo '<div class="box-display-males" style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
             echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Students</h4>';
             echo '<h1 class="text-end me-3" style="color: #002d80;">' .$totalStudents. '</h1>';
             echo '</div>';
             echo '</div>';
             
            //Total Females
            echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display"style="width: 260px; height: 170px;">';
            echo '<div class="box-display-males" style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
            echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Females</h4>';
            echo '<h1 class="text-end me-3" style="color: #002d80;">' .$females. '</h1>';
            echo '</div>';
            echo '</div>';

            //Total Males 
            echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display" style="width: 260px; height: 170px;">';
            echo '<div class="box-display-males" style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
            echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Males</h4>';
            echo '<h1 class="text-end me-3" style="color: #002d80;">' .$males. '</h1>';
            echo '</div>';
            echo '</div>';

            //Total Infants 
            echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display"style="width: 260px; height: 170px;">';
            echo '<div class="box-display-males" style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
            echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Infants</h4>';
            echo '<h1 class="text-end me-3" style="color: #002d80;">' .$infants. '</h1>';
            echo '</div>';
            echo '</div>';
    
            
             //Total Children 
             echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display" style="width: 260px; height: 170px;">';
             echo '<div class="box-display-males"style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
             echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Children</h4>';
             echo '<h1 class="text-end me-3" style="color: #002d80;">' .$children. '</h1>';
             echo '</div>';
             echo '</div>';

            //Total Teens 
            echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display"style="width: 260; height: 170px;">';
            echo '<div class="box-display-males" style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
            echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Teens</h4>';
            echo '<h1 class="text-end me-3" style="color: #002d80;">' .$teens. '</h1>';
            echo '</div>';
            echo '</div>';

            //Total Adults 
            echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display"style="width: 260px; height: 170px;">';
            echo '<div class="box-display-legal" style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
            echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Adults</h4>';
            echo '<h1 class="text-end me-3" style="color: #002d80;">' .$adults. '</h1>';
            echo '</div>';
            echo '</div>';

            // Total Seniors
            echo '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 my-2 d-flex justify-content-center box-display" style="width: 260px; height: 170px;">';
            echo '<div class="box-display-legal" style="width: 350px; height: 160px; border: 4px solid #002d80; box-shadow: 3px 3px 0px #002d80";>';
            echo '<h4 class="text-start ms-3 mt-3" style="color: #002d80;">Total Seniors</h4>';
            echo '<h1 class="text-end me-3" style="color: #002d80;">' . $seniors. '</h1>';
            echo '</div>';
            echo '</div>';

         echo '<div class="row my-4 mx-0">';
         echo '</div>'; 
    echo '</div>';
 echo '</div>';

} else {
    echo "Error fetching statistics: " . mysqli_error($conn);
}
echo '<style>
    .box-display {
        transition: transform 0.3s, box-shadow 0.3s; 
    }
    .box-display:hover {
        transform: translateY(-5px) scale(1.03); 
    }
</style>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style4.css" rel="Stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"  crossorigin="anonymous"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>   
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.print.min.js"></script>
    <link href="encoding-styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/4b82c45eb7.js" crossorigin="anonymous"></script> 
        <link rel="stylesheet" href ="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css" href="print-styles.css" media="print">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

     
     <title>RBI Manila</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');

        body {
            font-family: 'DM Sans', sans-serif !important;
            background-color: #f4f4f4;
        }

          table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f5f5f5;
    }

    #close {
		cursor: pointer;
	}


 
        
    </style>
 
</head>
<body>

    <!-- Display the username in an H1 heading -->

<div class="overlay" id="overlay" style="display: none;"></div>
 <div class="box-container2" id="formContainer" style="display: none;">
    <div class="box-container">


    <div class="close-button" style="position: absolute; margin-left: 750px;">
    <button onclick="exitForm()" style="background-color: transparent; border: none; color: black; font-size: 20px;"> 
        <i id="close" class="fas fa-times" ></i>   
    </button>
</div>

 
 
    <h1><?php echo $_SESSION['username']; ?></h1>

    <form action="barangay_homepage.php" method="post">

    <div class="form-container">
    <div class="row ms-4 me-4 mt-1 d-flex justify-content-center">
  <hr class="my-3 mx-2">
    <div class="d-flex justify-content-center">
    <h2>Personal Information</h2>
            </div>
<div class="form-row">
   
        <label>Last Name<span class="required-asterisk">*</span></label>
        <input type="text" name="lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>" required><br>
</div>

<div class="form-row">
        <label>First Name<span class="required-asterisk">*</span></label>
        <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required><br>
</div>


<div class="form-row">
        <label>Middle Name<span class="required-asterisk">*</span></label>
        <input type="text" name="middlename" value="<?php echo isset($middlename) ? $middlename : ''; ?>" required><br>
</div>


<div class="form-row">
        <label>Name Extension</label>
        <input type="text" name="nameextension" value="<?php echo isset($nameextension) ? $nameextension : ''; ?>"><br>
</div>
        
<div class="form-row">
        <label>Sex<span class="required-asterisk">*</span></label>
        <select name="gender" required>
            <option value="Male" <?php echo (isset($gender) && $gender === 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo (isset($gender) && $gender === 'Female') ? 'selected' : ''; ?>>Female</option>
        </select><br>
</div>

<div class="form-row">
    <label>Gender Sexuality:</label>
    <select name="sexuality" required>
        <option value="Straight" <?php echo (isset($sexuality) && $sexuality === 'Straight') ? 'selected' : ''; ?>>Straight – heterosexual</option>
        <option value="Bisexual" <?php echo (isset($sexuality) && $sexuality === 'Bisexual') ? 'selected' : ''; ?>>Bisexual</option>
        <option value="Lesbian" <?php echo (isset($sexuality) && $sexuality === 'Lesbian') ? 'selected' : ''; ?>>Lesbian</option>
        <option value="Gay" <?php echo (isset($sexuality) && $sexuality === 'Gay') ? 'selected' : ''; ?>>Gay</option>
        <option value="Transgender" <?php echo (isset($sexuality) && $sexuality === 'Transgender') ? 'selected' : ''; ?>>Transgender</option>
        <option value="Bisexual" <?php echo (isset($sexuality) && $sexuality === 'Bisexual') ? 'selected' : ''; ?>>Bisexual</option>
        <option value="Questioning" <?php echo (isset($sexuality) && $sexuality === 'Questioning') ? 'selected' : ''; ?>>Questioning</option>
        <option value="Pansexual" <?php echo (isset($sexuality) && $sexuality === 'Pansexual') ? 'selected' : ''; ?>>Pansexual</option>
        <option value="Polysexual" <?php echo (isset($sexuality) && $sexuality === 'Polysexual') ? 'selected' : ''; ?>>Polysexual</option>
        <option value="Asexual" <?php echo (isset($sexuality) && $sexuality === 'Asexual') ? 'selected' : ''; ?>>Asexual</option>
        <option value="Demisexual" <?php echo (isset($sexuality) && $sexuality === 'Demisexual') ? 'selected' : ''; ?>>Demisexual</option>
        <option value="Graysexual" <?php echo (isset($sexuality) && $sexuality === 'Graysexual') ? 'selected' : ''; ?>>Graysexual</option>
        <option value="Queer" <?php echo (isset($sexuality) && $sexuality === 'Queer') ? 'selected' : ''; ?>>Queer</option>
        <option value="Autosexual" <?php echo (isset($sexuality) && $sexuality === 'Autosexual') ? 'selected' : ''; ?>>Autosexual</option>
        <option value="Androsexual" <?php echo (isset($sexuality) && $sexuality === 'Androsexual') ? 'selected' : ''; ?>>Androsexual</option>
        <option value="Gynosexual" <?php echo (isset($sexuality) && $sexuality === 'Gynosexual') ? 'selected' : ''; ?>>Gynosexual</option>
        <option value="Homoflexible" <?php echo (isset($sexuality) && $sexuality === 'Homoflexible') ? 'selected' : ''; ?>>Homoflexible</option>
        <option value="Heteroflexible" <?php echo (isset($sexuality) && $sexuality === 'Heteroflexible') ? 'selected' : ''; ?>>Heteroflexible</option>
        <option value="Intersex" <?php echo (isset($sexuality) && $sexuality === 'Intersex') ? 'selected' : ''; ?>>Intersex</option>
        <option value="Two Spirit" <?php echo (isset($sexuality) && $sexuality === 'Two Spirit') ? 'selected' : ''; ?>>Two Spirit</option>
        <option value="Androgynous" <?php echo (isset($sexuality) && $sexuality === 'Androgynous') ? 'selected' : ''; ?>>Androgynous</option>
        <option value="Allosexual" <?php echo (isset($sexuality) && $sexuality === 'Allosexual') ? 'selected' : ''; ?>>Allosexual</option>
    </select><br>
</div>

<div class="form-row">
        <label>Birthday<span class="required-asterisk">*</span></label>
        <input type="date" id="birthday" name="birthday" value="<?php echo isset($birthday) ? $birthday : ''; ?>" required><br>
</div>

<div class="form-row">
        <label>Age<span class="required-asterisk">*</span></label>
        <input type="number" id="age" name="age" value="<?php echo isset($age) ? $age : ''; ?>" required readonly><br>
</div>

<div class="form-row">
    <label for="disabilityStatus">Person With Disability:</label>
    <select name="disabilityStatus" id="disabilityStatus" required>
    <option value="" disabled>Select an option</option>
        <option value="none" <?php echo isset($disabilityStatus) && $disabilityStatus == 'none' ? 'selected' : ''; ?>>No</option>
        <option value="pwd" <?php echo isset($disabilityStatus) && $disabilityStatus == 'pwd' ? 'selected' : ''; ?>>Yes</option>

    </select>
</div>

<div class="form-row">
    <label for="disability">Disability:</label>
    <input type="text" name="disability" id="disability" value="<?php echo isset($disability) ? $disability : ''; ?>" readonly><br>
</div>

<div class="form-row">
        <label>Civil Status:</label>
        <select name="civil_status" required>
            <option value="Single" <?php echo (isset($civil_status) && $civil_status === 'Single') ? 'selected' : ''; ?>>Single</option>
            <option value="Married" <?php echo (isset($civil_status) && $civil_status === 'Married') ? 'selected' : ''; ?>>Married</option>
            <option value="Divorced" <?php echo (isset($civil_status) && $civil_status === 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
            <option value="Widowed" <?php echo (isset($civil_status) && $civil_status === 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
        </select><br>
</div>

<div class="form-row">
        <label>Nationality<span class="required-asterisk">*</span></label>
        <input type="text" name="nationality" value="<?php echo isset($nationality) ? $nationality : ''; ?>" required><br>
</div>

<div class="form-row">
        <label>Religion<span class="required-asterisk">*</span></label>
        <input type="text" name="religion" value="<?php echo isset($religion) ? $religion : ''; ?>" required><br>
</div>


<div class="form-row">
<label>Contact Number<span class="required-asterisk">*</span></label>
<input type="number" name="contact_number" value="<?php echo isset($contact_number) ? $contact_number : ''; ?>"  maxlength="11"><br>
</div>

<div class="form-row">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>"><br>
</div>

</div>


<script>
    $(document).ready(function () {
        $('#disabilityStatus').change(function () {
            var selectedOption = $(this).val();
            if (selectedOption === 'pwd') {
                $('#disability').prop('readonly', false).removeAttr('required');
            } else {
                $('#disability').prop('readonly', true).removeAttr('required').val('');
            }
        });

        if ($('#disabilityStatus').val() === 'none') {
            $('#disability').prop('readonly', true).removeAttr('required').val('');
        }
    });
</script>


<div class="row ms-4 me-4 mt-3 d-flex justify-content-center">
  <hr class="my-3 mx-5">
    <div class="d-flex justify-content-center">
     <h2>Home Address</h2>
            </div>
<div class="form-row">
        <label>Block & Lot / House No.<span class="required-asterisk">*</span></label>
        <input type="text" name="block_lot" value="<?php echo isset($block_lot) ? $block_lot : ''; ?>" required><br>
</div>


<div class="form-row">
        <label>Street/Subdivision/Village<span class="required-asterisk">*</span></label>
        <input type="text" name="street" value="<?php echo isset($street) ? $street : ''; ?>" required><br>
</div>

<div class="form-row">
        <label>Barangay<span class="required-asterisk">*</span></label>
        <input type="text" name="barangay_id" value="<?php echo isset($_SESSION['username']) ? preg_replace('/\D/', '', $_SESSION['username']) : ''; ?>" required readonly><br>
</div>
</div>


<div class="row ms-4 me-4 mt-3 d-flex justify-content-center">
    <hr class="my-3 mx-5">
    <div class="d-flex justify-content-center">
        <h2>Current Status</h2>
     </div>

<div class="form-row">
        <label>Employment Status<span class="required-asterisk">*</span></label>
        <select name="employment_status" required>
            <option value="Employed" <?php echo (isset($employment_status) && $employment_status === 'Employed') ? 'selected' : ''; ?>>Employed</option>
            <option value="Unemployed" <?php echo (isset($employment_status) && $employment_status === 'Unemployed') ? 'selected' : ''; ?>>Unemployed</option>
            <option value="Student" <?php echo (isset($employment_status) && $employment_status === 'Student') ? 'selected' : ''; ?>>Student</option>
        </select><br>
</div>


<div class="form-row">
        <label>Income<span class="required-asterisk">*</span></label>
        <input type="number" name="income" value="<?php echo isset($income) ? $income : ''; ?>" required><br>
</div>
</div>



<script>
    document.querySelector('input[name="contact_number"]').addEventListener('input', function(event) {
        var input = event.target.value;
        if (input.length > 11) {
            event.target.value = input.slice(0, 11);
        }
    });


</script>

<div class="form-row">
</div>
<script>
    var birthdayInput = document.getElementById('birthday');
    var ageInput = document.getElementById('age');

    
    birthdayInput.addEventListener('input', function() {
        var birthday = new Date(birthdayInput.value);
        
        var age = calculateAge(birthday);

        ageInput.value = age;
    });

    function calculateAge(birthday) {
        var today = new Date();
        var age = today.getFullYear() - birthday.getFullYear();
        var monthDiff = today.getMonth() - birthday.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
            age--;
        }
        
        return age;
    }
</script>
<script>
    
    document.getElementById('toggleForm').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        document.getElementById('modalOverlay').style.display = 'block'; // Show the modal overlay
    });

    document.getElementById('closeModal').addEventListener('click', function(event) {
        document.getElementById('modalOverlay').style.display = 'none'; // Hide the modal overlay when close button is clicked
    });
</script>



<div class="buttons-container">
        <?php if (isset($editing)) : ?>
            <input type="hidden" name="resident_id" value="<?php echo $residentId; ?>">
            <button type="submit" name="update" class="action-button update-button">Update</button>
            <button type="submit" name="delete" class="action-button delete-button" onclick="return confirmDelete()">Delete</button>
            <button type="submit" name="cancel" class="action-button cancel-button" onclick="return confirmCancel()">Cancel</button>
        </div>
    
        <?php else : ?>
            <button type="submit" name="create" class="action-button create-button">Create</button>
        <?php endif; ?>
        </div>   
 </div>      
     <style>
    
.required-asterisk {
        color: red;
}

h1 {
    margin-top: 20px;
    text-align: center; /* Center the heading */
    margin-bottom: 0px;
}

#exitButton {
    position: absolute;
    top: 0;
    right: 0;
    width: 20px;
    height: 20px;
    border: none;
    background-color: transparent;
    color: #000;
    font-size: 16px;
    line-height: 1;
    cursor: pointer;
        position: absolute;
        width: 38px;
        height: 45px;   
        
    }

    #exitButton:hover {
    background-color: lightgray; 
}

.blue-background {
    background-color: blue !important; /* Background color when button clicked */
}

.form-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: flex-start;
    width: calc(100% - 40px); /* Adjust the width to fit within the available space */
    width: 800px;
    margin: 0 auto;
}

.form-row {
    flex: 0 0 calc(33.33% - 10px); /* Adjust width and margin as needed */
    margin-bottom: 10px;
}

.form-row label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-row input,
.form-row select {
    width: calc(100% - 16px); /* Adjust width to fit within the form container */
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.form-row select {
    margin-top: 5px;
}

.buttons-container {
    width: 100%; /* Make the container full width */
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-row button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-right: 10px;
    transition: background-color 0.3s;
    margin: 0 9px;
}

.action-button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
    margin-top: 5px;
    width: auto; /* Reset width */
}

.create-button {
    background-color: #28a745;
    color: #fff;
    max-width: 300px; /* Adjust max-width to fit within the available space */
    width: 100%; /* Make the button full width */
    margin: 20px auto;
}

.cancel-button:hover {
    background-color: #ffc107; 
    opacity: 0.8; 
}

.cancel-button {
    background-color: #ffc107;
    
}
.action-button:hover {
    opacity: 0.8;
}



.action-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
    </form>
</div>
</div>
</div>
<script>
    document.getElementById('toggleForm').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior

        var overlay = document.getElementById('overlay');
        var formContainer = document.getElementById('formContainer');

        overlay.style.display = 'block'; // Show the overlay
        formContainer.style.display = 'block'; // Show the form container
        document.body.classList.add('overlay-open'); // Add class to body to disable scrolling

        document.getElementById("exitButton").addEventListener("click", function() { // for exit button hover
    document.getElementById("container").classList.toggle("blue-background"); // for exit button hover
});

    });

    // Function to close the overlay and form container
    function exitForm() {
        var overlay = document.getElementById('overlay');
        var formContainer = document.getElementById('formContainer');
    

        overlay.style.display = 'none'; // Hide the overlay
        formContainer.style.display = 'none'; // Hide the form container
        document.body.classList.remove('overlay-open'); // Remove class to enable scrolling
    }
</script>

<style>


.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
    z-index: 999; /* Ensure the overlay is on top of other content */
}
.box-container2 {
    display: none; 
    position: fixed; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%); 
    width: 855px; 
    max-height: 90%; 
    overflow-y: auto; 
    border: 1px solid ; 
    border-radius: 10px; 
    padding: 10x; 
    background-color: #fff; 
    z-index: 1000; 
}

/* Additional styles for buttons */

body.overlay-open {
    overflow: hidden; /* Disable scrolling on the body */
}

    </style>

    <br>

    <h2 style="margin-left: 30px;">Resident Information</h2>
    <label for="ageGroup" style="margin-left: 30px;">Age Group:</label>
<select name="ageGroup" id="ageGroup">
    <option value="">All</option>
    <option value="Infant">Infant</option>
    <option value="Child">Child</option>
    <option value="Teen">Teen</option>
    <option value="Adult">Adult</option>
    <option value="Senior">Senior</option>
</select>

<button id="filterBtn">Search</button>



<input type='text' id='ageRangeInput' placeholder='Enter Age Range (e.g., 10-20)'>
<button id='ageRangeBtn' data-action='filter'>Filter by Age Range</button>
<label for="sexuality" style="margin-left: 50px;">Sexuality:</label>
    <select name="sexuality" id="sexuality">
        <option value="">All</option>
        <option value="Straight">Straight – heterosexual</option>
        <option value="Bisexual">Bisexual</option>
        <option value="Lesbian">Lesbian</option>
        <option value="Gay">Gay</option>
        <option value="Transgender">Transgender</option>
        <option value="Bisexual">Bisexual</option>
        <option value="Questioning">Questioning</option>
        <option value="Pansexual">Pansexual</option>
        <option value="Polysexual">Polysexual</option>
        <option value="Asexual">Asexual</option>
        <option value="Demisexual">Demisexual</option>
        <option value="Graysexual">Graysexual</option>
        <option value="Queer">Queer</option>
        <option value="Autosexual">Autosexual</option>
        <option value="Androsexual">Androsexual</option>
        <option value="Gynosexual">Gynosexual</option>
        <option value="Homoflexible">Homoflexible</option>
        <option value="Heteroflexible">Heteroflexible</option>
        <option value="Intersex">Intersex</option>
        <option value="Two Spirit">Two Spirit</option>
        <option value="Androgynous">Androgynous</option>
        <option value="Allosexual">Allosexual</option>
    </select>
<button onclick="printTable()" id="print">Print Table</button>


    <div id="genderCounts">
        <p> Males: <span id="malesCount">0</span></p>
        <p>Females: <span id="femalesCount">0</span></p>
    </div>


<style>

   

 
    /* Style for form and label */

    #ageRangeInput{
        margin-left: 100px;
        width: 300px;

    }

    @media (max-width: 768px) {
            #ageRangeInput {
                width: 100%; /* Full width for input field on smaller screens */
                margin: 5px 0; /* Adjust margin for smaller screens */
            }
            #ageRangeBtn, #sexuality {
                width: calc(50% - 5px); /* Half width for button and select on smaller screens */
                margin-top: 5px; /* Adjust margin for smaller screens */
            }
            label[for="sexuality"] {
                margin-left: 0; /* Reset margin for smaller screens */
            }
        }

    form {
        margin-bottom: 20px;
    }
    label {
        margin-right: 10px;
    }
    
    #print{
        height: 45px;
    }

    #ageRangeInput{
        height: 42px;
    }

    #ageRangeBtn{
        width: 200px;
        height: 45px;
    }

    /* Style for select element */
    select {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }

    /* Style for buttons */
    button {
        padding: 8px 16px;
        border-radius: 5px;
        border: none;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        margin-right: 10px;
    }

    button:hover {
        background-color: #0056b3;
    }

    #print {
        width: 120px; 
        margin-left: 210px;
    }
    
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
     -webkit-appearance: none;
     margin: 0;
    }
    input[type="number"] {
      -moz-appearance: textfield;
}

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
                margin: 5px; /* Adjust margin for smaller screens */
            }
        }

</style>

    
    </form>


    <?php
if (mysqli_num_rows($resultResidents) > 0) {
    echo '<div class="table-container" style ="margin-top: 20px;">';
    echo "<table id='residentTable'  style='font-size: 14px;'>";
    echo "<thead><tr><th>Resident</th><th>Last Name</th><th>First Name</th><th>Name Extension</th><th>Middle Name</th><th>Gender</th><th>Gender Sexuality</th><th>Employment Status</th><th>Income</th><th>Age</th><th>Disability Status</th><th>Disability</th><th>Address</th><th>Barangay</th><th>Birthday</th><th>Civil Status</th><th>Nationality</th><th>Religion</th><th>Contact Number</th><th>Email</th><th>Action</th></tr></thead>";
    echo "<tbody>";
    $residentNumber = 1;
    while ($row = mysqli_fetch_assoc($resultResidents)) {
        // Calculate age based on birthday
        $birthdate = new DateTime($row['birthday']);
        $today = new DateTime('today');
        $age = $birthdate->diff($today)->y;

        echo "<tr>";
        echo "<td>" . $residentNumber . "</td>";
        echo "<td>" . $row['lastname'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['nameextension'] . "</td>";
        echo "<td>" . $row['middlename'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['sexuality'] . "</td>";
        echo "<td>" . $row['employment_status'] . "</td>";
        echo "<td>" . $row['income'] . "</td>";
        echo "<td>" . $age . "</td>"; 
        echo "<td>" . $row['disabilityStatus'] . "</td>";
        echo "<td>" . $row['disability'] . "</td>";
        echo "<td>" . $row['address'] . "</td>";
        echo "<td>" . $row['barangay_id'] . "</td>";
        echo "<td>" . $row['birthday'] . "</td>";
        echo "<td>" . $row['civil_status'] . "</td>";
        echo "<td>" . $row['nationality'] . "</td>";
        echo "<td>" . $row['religion'] . "</td>";
        echo "<td>" . $row['contact_number'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>
            <form action='barangay_homepage.php' method='post' style='display:inline;'>
            <input type='hidden' name='resident_id' value='" . $row['id'] . "'>
            <input type='hidden' name='lastname' value='" . $row['lastname'] . "'>
            <input type='hidden' name='name' value='" . $row['name'] . "'>
            <input type='hidden' name='nameextension' value='" . $row['nameextension'] . "'>
            <input type='hidden' name='middlename' value='" . $row['middlename'] . "'>
            <input type='hidden' name='gender' value='" . $row['gender'] . "'>
            <input type='hidden' name='sexuality' value='" . $row['sexuality'] . "'>
            <input type='hidden' name='employment_status' value='" . $row['employment_status'] . "'>
            <input type='hidden' name='income' value='" . $row['income'] . "'>
            <input type='hidden' name='age' value='" . $age . "'>
            <input type='hidden' name='disabilityStatus' value='" . $row['disabilityStatus'] . "'>
            <input type='hidden' name='disability' value='" . $row['disability'] . "'>
            <input type='hidden' name='address' value='" . $row['address'] . "'>
            <input type='hidden' name='barangay_id' value='" . $row['barangay_id'] . "'>
            <input type='hidden' name='birthday' value='" . $row['birthday'] . "'>
            <input type='hidden' name='civil_status' value='" . $row['civil_status'] . "'>
            <input type='hidden' name='nationality' value='" . $row['nationality'] . "'>
            <input type='hidden' name='religion' value='" . $row['religion'] . "'>
            <input type='hidden' name='contact_number' value='" . $row['contact_number'] . "'>
            <input type='hidden' name='email' value='" . $row['email'] . "'>

            <button type='submit' onclick='showEditForm()' name='edit' style='margin-left:10px; margin-top: 3px; width: 80px;  font-size: 14px;'>Edit</button>
            
            <button type='submit' name='delete' onclick='return confirmDelete()' style='margin-left:10px; margin-top: 3px; font-size: 14px;'>Delete</button>
        </form>
                  </td>";
            echo "</tr>";

            echo "<script>
            function showEditForm() {
                var overlay = document.getElementById('overlay');
                var formContainer = document.getElementById('formContainer');
            
                if (overlay.style.display !== 'block') {
                    overlay.style.display = 'block';
                    formContainer.style.display = 'block';
                    document.getElementById('toggleForm').click();
                }
            }
            </script>";
            $residentNumber++; 
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No resident information available.";
    }

    echo '<style>   
    
    button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
        
.table-container {
    width: 97%; 
    margin: 0 auto; 
    border: 2px solid #ccc; 
    border-radius: 10px; 
    padding: 10px; 
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1);
    background-color: white;
    overflow-x: auto;
}
        font-size: 13px;
        margin-right: 10px;
        transition: background-color 0.3s;
        width: 80px;
        margin-bottom: 10px;
    }

    /* Edit button style */
    button[name=\'edit\'] {
        background-color: #007bff;
        color: #fff;
        margin-top: 10px
        margin-left: 30px;
        font-size: 7px;
    }

    /* Delete button style */
    button[name=\'delete\'] {
        background-color: #dc3545;
        color: #fff;
        margin-top:8px;
        margin-right: 10px; 
    }

    /* Hover effect */
    button:hover {
        opacity: 0.8;
    }

    /* Disabled state */
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    #residentTable {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    #residentTable th, #residentTable td {
        padding: 2px;
        border: 1px solid #ccc;
        text-align: left;
        word-wrap: break-word;
        white-space: normal; 
     

    }

    #residentTable th {
        background-color: #d3d3d3;
        text-align: center;
        border: 1px solid #ccc;
    }

    #residentTable tr:hover td {
        background-color: #bebebe;
        border: 1px solid #ccc;
    }

</style>';
echo '</div>';
    ?>





<style>

     /* Style for the dashboard container */
  #dashboard {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 1px solid #ccc; 
    width: 400px;
    margin-left: 20px;
    margin-top: 10px;
    

    
  }

  /* Style for the heading */
  #dashboard h2 {
    color: #333;
    font-size: 35px;
    margin-bottom: 10px;
  }

  /* Style for the gender counts container */
  #genderCounts {
    margin-left: 20px;
    margin-top: 10px;
  }

  /* Style for the paragraphs inside gender counts */
  #genderCounts p {
    margin: 0;
    font-size: 20px;
    color: #555;
  }

  /* Style for the spans inside gender counts */
  #genderCounts span {
    font-weight: bold;
    color: #555;
  }
    </style>
    <script>

function printTable() {
            window.print(); // Trigger print dialog
        }

        $(document).ready(function () {
    // Define a custom search function for DataTable based on sexuality
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var selectedSexuality = $('#sexuality').val(); // Get selected sexuality
            return selectedSexuality === '' || selectedSexuality === data[6]; // Check if selected sexuality matches data
        }
    );

    var table;

    // Check if DataTable is not already initialized
    if (!$.fn.DataTable.isDataTable('#residentTable')) {
        table = $('#residentTable').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": [2, 3, 4, 5, 6,7, 8, 10, 11, 12, 13, 14, 15, 16,17,18,19,20] }
            ],
            "lengthMenu": [50, 100, 300, 500, 1000, 3000, 5000]
        });
    } else {
        // If DataTable is already initialized, retrieve the existing instance
        table = $('#residentTable').DataTable();
    }

    // Event listener to redraw the table when the sexuality dropdown changes
    $('#sexuality').change(function () {
        table.draw();
        
    });



    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var selectedAgeGroup = $('#ageGroup').val();
            var age = parseInt(data[9]); 

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

    $('#filterBtn').on('click', function () {
        table.draw();
    });

    $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        var selectedAgeRange = $('#ageRangeInput').val();
        var age = parseInt(data[9]); // Age column is at index 9 (0-based index)

        if (!selectedAgeRange) {
            return true;
        }

        var ageRange = selectedAgeRange.split('-');
        var minAge = parseInt(ageRange[0]);
        var maxAge = parseInt(ageRange[1]);

        return age >= minAge && age <= maxAge;

        
    }
);

$('#ageRangeBtn').on('click', function () {
    // Redraw the table
    table.draw();

    // Count males and females within the selected age range
    var selectedAgeRange = $('#ageRangeInput').val();
    var ageRange = selectedAgeRange.split('-');
    var minAge = parseInt(ageRange[0]);
    var maxAge = parseInt(ageRange[1]);
    var malesCount = 0;
    var femalesCount = 0;

    table.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        var age = parseInt(data[9]); // Age column is at index 9 (0-based index)
        var gender = data[5]; // Gender column is at index 5 (0-based index)

        if (age >= minAge && age <= maxAge) {
            if (gender.toLowerCase() === 'male') {
                malesCount++;
            } else if (gender.toLowerCase() === 'female') {
                femalesCount++;
            }
        }
    });

    // Display the counts in the dashboard
    $('#malesCount').text(malesCount);
    $('#femalesCount').text(femalesCount);

    // Clear the age range input
    $('#ageRangeInput').val('');
});
});




    
    function confirmDelete() {
        return confirm("Are you sure you want to delete this resident?");
    }

    function printTable() {
    var el = document.getElementById("residentTable");

    el.style.border = '1px solid black';  // Add border styling
    el.style.fontSize = '7pt';

    var clonedTable = el.cloneNode(true);

    var lastColumnCells = clonedTable.querySelectorAll('th:last-child, td:last-child');
    lastColumnCells.forEach(function (cell) {
        cell.parentNode.removeChild(cell);
    });

    var newPrint = window.open("");

    newPrint.document.write(`
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 10px;
            }
            th, td {
                text-align: center;
                padding: 6px;
                border: 1px solid black;  
            }
            th {
                background-color: #f2f2f2;  
            }
            h2 {
                text-align: center;
            }
        </style>
        <h2>Residents Table</h2>
        ${clonedTable.outerHTML}
    `);

    newPrint.print();
    newPrint.close();
}

</script>
</body>
</html>

