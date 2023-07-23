<?php

require 'connect.php';
?>

<!doctype html>
<html lang="en">
  <head>
   
    <title>Animal Edit</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: pink
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
  
    <div class="container mt-5">

        <?php  ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $animal_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $query = "SELECT * FROM animal WHERE id='$animal_id' ";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $animal = mysqli_fetch_array($query_run);
                                ?>
                                 <div>
  <h2>Edit Form</h2>
      </div>
                                <form action="index_class.php" method="POST">
                                    <input type="hidden" name="animal_id" value="<?= $animal['id']; ?>">

                                    <div class="mb-3">
                                        <label>Animal Name</label>
                                        <input type="text" name="name" value="<?=$animal['name'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Category</label>
            
                                        <label>Category</label>
                                        <input type="radio" name="category" value="herbivores" <?php if ($animal['category'] === 'herbivores') echo "checked"; ?>> Herbivores
                                        <input type="radio" name="category" value="omnivores" <?php if ($animal['category'] === 'omnivores') echo "checked"; ?>> Omnivores
                                        <input type="radio" name="category" value="carnivores" <?php if ($animal['category'] === 'carnivores') echo "checked"; ?>> Carnivores<br><br>
                                    </div>
                                    <div class="mb-3">
    <label>Image</label>
    <img src="<?php echo "public/" . $animal['image']; ?>" width="200px" height="200px" alt="">
    <input type="hidden" name="prev_image" value="<?= $animal['image']; ?>">
    <input type="file" name="image"><br><br>
</div>
                                        <label>Description</label>
                                        <input type="text" name="description" value="<?=$animal['description'];?>" >
                                    </div>
                                    <p>Life Expectancy:</p>
                                    <select name="life">
                                        <option value="0-1 year" <?php if ($animal['life'] === '0-1 year') echo "selected"; ?>>0-1 year</option>
                                        <option value="1-5 years" <?php if ($animal['life'] === '1-5 years') echo "selected"; ?>>1-5 years</option>
                                        <option value="5-10 years" <?php if ($animal['life'] === '5-10 years') echo "selected"; ?>>5-10 years</option>
                                        <option value="10+ years" <?php if ($animal['life'] === '10+ years') echo "selected"; ?>>10+ years</option>
                                    </select><br><br>
                                    <label>Submission Date:</label><br>
                                    <input type="date" name="submission_date" value="<?= $animal['submission_date']; ?>"><br><br>
                                    <div class="mb-3">
                                    <div class="mb-3">
                                        <button type="submit" name="update_animal" class="btn btn-primary">
                                            Update Animal
                                        </button>
                                    </div>

                                    <h4>
                            <a href="index_class.php" class="btn btn-danger float-end">BACK</a>
                        </h4>

                                </form>
                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>