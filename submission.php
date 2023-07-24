<?php

include 'connect.php';
$min  = 1;
$max  = 300;
$num1 = rand($min, $max);
$num2 = rand($min, $max);
$sum  = $num1 + $num2;
$user_answer = isset($_POST['user_answer']) ? $_POST['user_answer'] : '';
  
if(isset($_POST['submit']))
{
 
  
    $name = $_POST['name'];
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $upload_dir = "C:/xampp/htdocs/php-Animal-Assessment/public/";
    $image_path = $upload_dir . basename($image); 
    move_uploaded_file($image_temp, $image_path);
    $description = $_POST['description'];
    $life = isset($_POST['life']) ? $_POST['life'] : '';
    $submission_date = isset($_POST['submission_date']) ? $_POST['submission_date'] : '';

   $sql = "insert into animal (name,category,image,image_path,description,life,submission_date) value('$name','$category','$image','$image_path','$description','$life','$submission_date')";
   if (mysqli_query($conn, $sql)) {
    header("Location: index_class.php"); // Redirect to the specified page upon successful insertion and correct calculation.
    exit; // Make sure to stop the script execution after the redirect.
} else {
    echo "Failed to insert data into the database.";
}

//    if ($user_answer != $sum) {
//     echo "incorrect calculation";
   
// } else{
 
//    $sql = "insert into test (name,category,image,image_path,description,life) value('$name','$category','$image','$image_path','$category','$description','$life')";
//    if (mysqli_query($conn, $sql)) {
//        header("Location: index.php");
//         echo "success";
//        } else {
//        echo "fail";
//        }
     
// }
  
       
} 


?>

  <html>
<head>
<title>Form Submission</title>
<style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #ffdab9
        }

        .container {
            width: 80%;
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
    </style>
</head>
<body>
   <div class="container">
   <div>
  <h2>Animal Submission Form</h2>
      </div>
   <form method="POST" enctype="multipart/form-data">
  <label>Animal Name:</label><br>
  <input type="text" name="name"><br>
  <p>Category:</p>
  <input type="radio" name="category" value="herbivores" id="category"> herbivores
  <input type="radio" name="category" value="omnivores" id="category"> omnivores
  <input type="radio" name="category" value="carnivores" id="category"> carnivores<br><br>
  <label>Image:</label><br>
  <input type="file" name="image"><br><br>
  <label>Description:</label><br>
  <textarea name="description"></textarea><br><br>
        <p>Life Expectancy:</p>
        <select name="life">
            <option value="0-1 year" id="life">0-1 year</option>
            <option value="1-5 year" id="life">1-5 year</option>
            <option value="5-10 year" id="life">5-10 year</option>
            <option value="10+ year" id="life">10+ year</option>
        </select><br><br>
 <label>Submission Date:</label><br>
<input type="date" name="submission_date"><br><br>
        <label><?php echo $num1 . '+' . $num2; ?></label>
        <input type="text" name="user_answer"><br><br>

  <button type="submit" name="submit">Submit</button>
</form>
</div>
</html>