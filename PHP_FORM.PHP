<?php
// define variables and set to empty values
$nameErr = $nicknameErr = "";
$name = $nickname = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["nickname"])) {
    $nicknameErr = "Nickname is required";
  } else {
    $nickname = test_input($_POST["nickname"]);
    // check if nickname only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$nickname)) {
      $nicknameErr = "Only letters and white space allowed";
    }
  }

  if (empty($nameErr) && empty($nicknameErr)) {
    // Save to file if no errors
    $myfile = fopen("formtest.txt", "a") or die("Unable to open file!");
    $txt = "Name: $name\nNickname: $nickname\n\n";
    fwrite($myfile, $txt);
    fclose($myfile);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Example</title>
    <style>
    .error {color: #FF0000;}
    </style>
</head>
<body>  

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  Nickname: <input type="text" name="nickname">
  <span class="error">* <?php echo $nicknameErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>



<?php
// Check if the file exists before reading it
if (file_exists("formtest.txt")) {
    $myfile = fopen("formtest.txt", "r") or die("Unable to open file!");
    // Output all lines until end-of-file
    while(!feof($myfile)) {
        $line = fgets($myfile);
        if (!empty($line)) {
            echo nl2br($line) . "<br>";
        }
    }
    fclose($myfile);
} else {
    echo "No previous submissions found.";
}
?>

</body>
</html>
