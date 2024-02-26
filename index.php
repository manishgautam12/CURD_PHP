<?php

$conn=mysqli_connect("localhost:3306","root","","curdphp") or die ("connection failed");

// $insert=false;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete'])) {
  $deleteSno = $_GET['delete'];
  $deleteSql = "DELETE FROM notes WHERE id = $deleteSno";
  $deleteResult = mysqli_query($conn, $deleteSql);

  // if ($deleteResult) {
  //     echo "Record deleted successfully";
  // } else {
  //     echo "Record deletion failed";
  // }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
      $sno = $_POST['snoEdit'];
      $title = $_POST['titleEdit'];
      $description = $_POST['descriptionEdit'];

      $sql = "UPDATE notes SET title='{$title}', description='{$description}' WHERE id={$sno}";
  } else {
      $title = $_POST['title'];
      $description = $_POST['description'];

      $sql = "INSERT INTO notes (title, description) VALUES ('{$title}','{$description}')";
  }

  $result = mysqli_query($conn, $sql);

  if ($result) {
      // $insert = true;
  } else {
      echo "Record insertion failed";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

</head>

<body>
  <!-- Button edit modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModel">
  Edit Model
</button> -->

  <!-- Modal -->
  <div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="editModelLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModelLabel">Edit Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/curds/index.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" placeholder="Enter title">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>
            <div>
              <button type="submit" class="btn btn-primary mb-3">Update Note</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">CURD Project</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <!-- <?php
     if($result){
        echo "<div class='alert alert-success' role='alert'>
        <strong>Success</strong> Your record has been inserted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
     }
    ?> -->
  <div class="container">
    <form action="/curds/index.php" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <div>
        <button type="submit" class="btn btn-primary mb-3">Add Note</button>
      </div>
    </form>
  </div>
  <div class="container">
    <table class="table">
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
        $sql="SELECT * FROM notes";
        $result=mysqli_query($conn,$sql) or die("No record found");
        $sno=0;
        while($row = mysqli_fetch_assoc($result)){
            $sno=$sno+1;
           echo " <tr>
           <th scope='row'>".$sno."</th>
           <td>". $row['title']."</td>
           <td>". $row['description']."</td>
           <td><button class='edit btn btn-sm btn-primary' id=". $row['id'].">edit</button> <button class='delete btn btn-sm btn-primary' id=d". $row['id'].">delete</button></td>
         </tr>";
        }
        ?>

      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener('click', (e) => {
        console.log('edit', e.target);
        tr = e.target.parentNode.parentNode
        title = tr.getElementsByTagName('td')[0].innerText;
        description = tr.getElementsByTagName('td')[1].innerText;
        console.log(title, description)
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id
        console.log(e.target.id)
        $('#editModel').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
          element.addEventListener('click', (e) => {
              console.log('delete', e.target);
              sno = e.target.id.substr(1);
              if (confirm("Press a button!")) {
                  console.log("yes");
                  window.location = `/curds/index.php?delete=${sno}`;
              } else {
                  console.log("No");  
              }
          })
      })

  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>