<?php
session_start(); 
include 'connect.php';

if (!isset($_SESSION['visitor_count'])) {
    $_SESSION['visitor_count'] = 0;
  }
  
  // Increment the visitor count on each page load
  $_SESSION['visitor_count']++;
  if (isset($_POST['search'])) {
    $category = $_POST['category'];
    $lifeExpectancy = $_POST['lifeExpectancy'];
  
    // Create a base SQL query
    $sql = "SELECT * FROM `animal` WHERE 1=1"; // 1=1 always evaluates to true, allowing us to add conditions dynamically
  
    // Check if the category field is filled
    if (!empty($category)) {
        $sql .= " AND `category` LIKE '%$category%'";
    }
  
    // Check if the life_expectancy field is filled with a numeric value
    if (!empty($lifeExpectancy) && is_numeric($lifeExpectancy)) {
        $sql .= " AND `life` = $lifeExpectancy";
    }
  
    $sql .= " ORDER BY `name` ASC, `submission_date` ASC"; 
    $search_result = filterTable($conn, $sql);
  } else {
    $sql = "SELECT * FROM `animal` ORDER BY `name` ASC, `submission_date` ASC"; // Order by name and submission_date
    $search_result = filterTable($conn, $sql);
  }
  
  function filterTable($conn, $sql)
  {
    $filter_result = mysqli_query($conn, $sql);
    return $filter_result;
  }
  
  if (isset($_POST['delete_animal'])) {
   $animal_id = mysqli_real_escape_string($conn, $_POST['delete_animal']);
   $query = "DELETE FROM animal where id='$animal_id' ";
   $query_run = mysqli_query($conn,$query);
   if($query_run)
   {
    header("Location: index_class.php"); // Redirect to the specified page upon successful insertion and correct calculation.
    exit; 
   }
   else{
    echo 'Not deleted';
   }
  }

  if(isset($_POST['update_animal']))
{
    $animal_id = mysqli_real_escape_string($conn, $_POST['animal_id']);

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $life = mysqli_real_escape_string($conn, $_POST['life']);
    $submission_date = mysqli_real_escape_string($conn, $_POST['submission_date']);

    $query = "UPDATE animal SET name='$name', category='$category', image='$image', description='$description', life='$life', submission_date='$submission_date' WHERE id='$animal_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
      //  echo "updated";
      header("Location: index_class.php"); // Redirect to the specified page upon successful insertion and correct calculation.
    exit; 
    }
    else
    {
        echo "not updated";
    }

}
?>

<html>
<head>
    <title>Landing Page</title>
</head>
<body>
<h2>Visitor Count: <?php echo $_SESSION['visitor_count']; ?></h2>
<h4><a href="submission.php" class="btn btn-danger float-end">Create Animal</a></h4>
<form method="POST" enctype="multipart/form-data">
  <input type="text" name="category" placeholder="Category"><br><br>
  <input type="text" name="lifeExpectancy" placeholder="Life Expectancy"><br><br>
  <input type="submit" name="search" value="Filter"><br><br>
    <table style="border: 2px solid black; width: 100%; margin: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid black;">Id</th>
                <th style="border: 1px solid black;">Animal Name</th>
                <th style="border: 1px solid black;">Category</th>
                <th style="border: 1px solid black;">Image</th>  
                <th style="border: 1px solid black;">Description</th>  
                <th style="border: 1px solid black;">Life Expectancy</th>  
                <th style="border: 1px solid black;">Submission Date</th>  
                <th style="border: 1px solid black;">Options</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if ($search_result) {
                while ($row = mysqli_fetch_array($search_result)) {
                    ?>
                    <tr>
                        <td style="border: 1px solid black;"><?php echo $row['id']; ?></td>
                        <td style="border: 1px solid black;"><?php echo $row['name']; ?></td>
                        <td style="border: 1px solid black;"><?php echo $row['category']; ?></td>
                        <td style="border: 1px solid black;">
                            <img src="<?php echo "public/" . $row['image']; ?>" width="200px" height="200px" alt="">
                
                        </td>
                        <td style="border: 1px solid black;"><?php echo $row['description']; ?></td>
                        <td style="border: 1px solid black;"><?php echo $row['life']; ?></td>
                        <td style="border: 1px solid black;"><?php echo $row['submission_date']; ?></td>
                        <td style="border: 1px solid black;"><a href="animal-edit.php?id=<?= $row['id']; ?>">Edit</a></button>
                        <button type="submit" name="delete_animal" value="<?= $row['id']; ?>">Delete</button>
                    </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</form>
</body>
</html>
