<?php
//Credentials of the database
$username = "root";
$servername = "localhost";
$password = "barsanjay_1";
$dbName = "Notes";

//Connection to the database

$connection = mysqli_connect($servername, $username, $password, $dbName);
if (!$connection) {
  die("Connection failed");
}?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>PHP CRUD</title>
    <script>
      var content = document.getElementById('simpleModal');
      var close = document.getElementById('close');
      
      function openM() {
        content.style.display = "block";
      }
      function closeM() {
        content.style.display = "none";
      }

      </script>
  </head>
<body>

<!-- Edit Modal -->
<div class="modal" id="simpleModal">
        <div class="modalContent">
            <span onclick="closeM()" class="closeBtn" id="close">&times;</span>
  <form action="/phpt/Projects/CRUD_app.php" method = "POST">
    <input type="hidden" name="snoEdit" id="snoEdit">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Title</label>
      <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text">Edit your note title here</div>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Description</label>
      <input type="text" class="form-control" id="descEdit" name="descEdit">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PHP CRUD</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<div class="container my-5">
  <form action="/phpt/Projects/CRUD_app.php" method = "POST">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Title</label>
      <input type="text" class="form-control" id="tile" name="title" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text">Enter your note title here</div>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Description</label>
      <input type="text" class="form-control" id="desc" name="desc">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<?php
//Inserting notes into database
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `Notes` WHERE `Notes`.`SNO` = $sno";
  $query = mysqli_query($connection, $sql);
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['snoEdit'])) {
    $title = $_POST["titleEdit"];
    $desc = $_POST["descEdit"];
    $sno = $_POST["snoEdit"];

    $insert = "UPDATE `Notes` SET `Title` = '$title', `Description` = '$desc' WHERE `Notes`.`SNO` = $sno";
    $query2 = mysqli_query($connection, $insert);
  }
else {
  $title = $_POST["title"];
  $desc = $_POST["desc"];

  $insert = "INSERT INTO `Notes` (`Title`, `Description`) VALUES ('$title', '$desc')";
  $query2 = mysqli_query($connection, $insert);
}
}





?>
<div class="container">
<table class='table' id="myTable">
  <thead>
    <tr>
      <th scope='col'>Serial Number</th>
      <th scope='col'>Title</th>
      <th scope='col'>Description</th>
      <th scope='col'>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $allNotes = "SELECT * FROM `Notes`";
  $query1 = mysqli_query($connection, $allNotes);
  $sno = 0;
  while ($notes = (mysqli_fetch_assoc($query1))) {
    $sno = $sno + 1;
    echo("
    <tr>
      <th scope='row'> ". $sno . "</th>
      <td>" . $notes['Title'] . "</td>
      <td>" . $notes['Description'] . "</td>
      <td> <button class='edit editBtn' id=" . $notes['SNO'] . " onclick='openM()' style='padding: 1px 2px;'>Edit</button> <button class='delete' id=" . $notes['SNO'] . " style='padding: 1px 2px;'>Delete</button>
      </td>
      </tr>
      ");
    }
    
    ?>
</tbody>
</table>
<hr>
</div>

<!-- Pagination CSS, JQuery & JS -->
<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
  $('#myTable').DataTable();
} );
</script>
<script>
edits = document.getElementsByClassName('edit');
  Array.from(edits).forEach((elements)=>{
    elements.addEventListener("click", (e)=>{
      row = e.target.parentNode.parentNode;
      title = row.getElementsByTagName("td")[0].innerText;
      desc= row.getElementsByTagName("td")[1].innerText;
      // console.log(snoEdit);
      // console.log(titleEdit, descEdit);
      titleEdit.value = title;
      descEdit.value = desc;
      snoEdit.value = e.target.id;

    })
  })
deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((elements)=>{
    elements.addEventListener("click", (e)=>{
      snoEdit = e.target.id;
      console.log(snoEdit);
      if (confirm("Are you sure you want to delete this note?")) {
        console.log("yes");
        window.location = `/phpt/Projects/CRUD_app.php?delete=${snoEdit}`;
      }
      else{
        console.log("no");
      }
    })
  })
</script>
<!-- <script src='./script.js'></script> -->
<script>
      var content = document.getElementById('simpleModal');
      var close = document.getElementById('close');
      
      function openM() {
        content.style.display = "block";
      }
      function closeM() {
        content.style.display = "none";
      }

      //Add event listener for close button
      // close.addEventListener('click', closeM);

</script>
</body>
 
</html>