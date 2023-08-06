<?php
$servername = "";
$username = "";
$password = "";
$database = "";
$insert = false;
$update=false;
$delete=false;

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  die("Sorry we failed to connect! " . mysqli_connect_error());
}

if(isset($_GET['delete']))
{
  $sno=$_GET['delete'];
  $query="delete from inotes where sno='$sno'";
  $result=mysqli_query($conn, $query);
  $delete=true;
}

if($_SERVER["REQUEST_METHOD"]=="POST") {
  if(isset($_POST['snoEdit']))
  {
    $title = $_POST['titleEdit'];
    $desc = $_POST['descriptionEdit'];
    $sno=$_POST['snoEdit'];
    $query="UPDATE `inotes` SET `title` = '$title', `desc` = '$desc' WHERE `inotes`.`sno` = '$sno'"; 
    $result=mysqli_query($conn, $query);
    if($result)
    {
      $update=true;
    }
    else
    {
      echo "Error";
    }   
  }
  else
  {
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $query = "INSERT INTO `inotes` (`title`, `desc`) VALUES ('$title', '$desc')"; 
  $result = mysqli_query($conn, $query);
  $insert = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>I-Notes</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <!-- Modal -->
  <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="post">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="titleEdit" class="form-label">Note title</label>
              <input type="text" class="form-control" id="titleEdit" aria-describedby="emailHelp" placeholder="Enter your title....." autocomplete="off" name="titleEdit"/>
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Note description</label>
              <input type="text" class="form-control" id="descriptionEdit" placeholder="Enter your description....." autocomplete="off" name="descriptionEdit"/>
            </div>
            <div class="mb-3">
              <input type="submit" class="btn btn-primary" id="save" name="save" value="Update"/>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="img/logo.jpg"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-disabled="true">Contact</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <?php
  if ($insert) {
    echo '<div class="alert alert-success" role="alert">
    <strong>Success! </strong>Your note has been inserted successfully.
  </div>';
  }
  ?>

<?php
  if ($update) {
    echo '<div class="alert alert-primary" role="alert">
    <strong>Success! </strong>Your note has been updated successfully.
  </div>';
  }
  ?>

<?php
  if ($delete) {
    echo '<div class="alert alert-danger" role="alert">
    <strong>Success! </strong>Your note has been deleted successfully.
  </div>';
  }
  ?>

  <div class="container mt-5">
    <form action="index.php" method="post">
      <h2>Add a Note</h2>
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter your title....." autocomplete="off" required name="title" />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" placeholder="Enter your description....." autocomplete="off" required name="description" />
      </div>
      <button type="submit" class="btn btn-primary mt-2" name="submit" value="submit">Add Note</button>
    </form>
  </div>

  <div class="container mt-5">
    <table class="table table-striped" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sno=0;
        $query = "SELECT * FROM `inotes`"; 
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          $sno++;
          echo '<tr>
          <th scope="row">' .$sno. '</th>
          <td>' . $row['title'] . '</td>
          <td>' . $row['desc'] . '</td>
          <td><button type="button" class="btn btn-primary btn1 edit" data-bs-toggle="modal" id='.$row['sno'].' data-bs-target="#editmodal">Edit</button><button type="button" class="btn delete btn-danger" id='.$row['sno'].'>Delete</button>
          </td>
        </tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="container">
    <p align="center" style="margin-bottom:3rem; margin-top:2rem;"><strong>Copyright &copy; <a href="https://ashutosh-uniyal.vercel.app/">Ashutosh Uniyal</a></strong></p>
  </div>

  <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
    let table = new DataTable('#myTable');
  </script>

</body>

</html>