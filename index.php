<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$server = "localhost";
$username = "root";
$password = "";
$database = "trip";
$port = 3307;

$conn = mysqli_connect($server, $username, $password, $database, $port);

$showSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];       
    $phone = $_POST['phone'];
    $desc = $_POST['desc'];

    $sql = "INSERT INTO `trip` (`name`, `age`, `gender`, `email`, `phone`, `other`, `dt`) VALUES ('$name', '$age', '$gender', '$email', '$phone', '$desc', current_timestamp());";

    if($conn->query($sql) === TRUE){
        $showSuccess = true;
    } else {
        $errorMsg = "ERROR: $sql <br> $conn->error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveling Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h3>Welcome</h3>
        <p>Enter your details and submit this form to confirm your participation in the trip</p>
        <?php if($showSuccess) { ?>
            <div id="successOverlay" style="
                position: fixed;
                top: 0; left: 0; width: 100vw; height: 100vh;
                display: flex; align-items: center; justify-content: center;
                backdrop-filter: blur(6px);
                background: rgba(30,30,40,0.25);
                z-index: 9999;
            ">
                <div id="successMsgBox" style="
                    max-width: 400px;
                    text-align: center;
                    position: relative;
                    z-index: 10;
                    background: #e6fff2;
                    color: #1a7f3c;
                    font-family: 'Montserrat', Arial, sans-serif;
                    font-weight: 700;
                    font-size: 1.2rem;
                    border-radius: 16px 16px 16px 16px;
                    padding: 1.5rem 1.2rem 1.2rem 1.2rem;
                    box-shadow: 0 2px 24px #1a7f3c22;
                ">
                    Success! Your form has been submitted.
                    <div id="successBar" style="
                        height: 7px;
                        width: 100%;
                        margin-top: 1rem;
                        background: linear-gradient(90deg,#43ea6d,#1a7f3c);
                        border-radius: 0 0 12px 12px;
                        transition: width 5s linear;
                    "></div>
                </div>
            </div>
            <script>
                setTimeout(function(){
                    document.getElementById('successBar').style.width = '0%';
                }, 50);
                setTimeout(function(){
                    var overlay = document.getElementById('successOverlay');
                    if(overlay) overlay.style.display = 'none';
                }, 5050);
                document.getElementById('tripForm').reset();
            </script>
        <?php } ?>
        <form action="index.php" method="post" id="tripForm">
            <input type="text" name="name" id="name" placeholder="Enter your name" required value="">
            <input type="text" name="age" id="age" placeholder="Enter your age" required value="">
            <select name="gender" id="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <input type="email" name="email" id="email" placeholder="Enter your email" required value="">
            <input type="text" name="phone" id="phone" placeholder="Enter your phone number" required value="">
            <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Enter any other information here"></textarea>
            <button class="btn" type="submit">Submit</button>
            <button class="btn" type="reset">Reset</button>
        </form>
        <?php if(isset($errorMsg)) { ?>
            <div class="submitMsg" style="color:#ff6e7f;"><?php echo $errorMsg; ?></div>
        <?php } ?>
    </div>
</body>
</html>