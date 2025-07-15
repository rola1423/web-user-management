<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["Name"], $_POST["Age"])) {
  $name = $_POST["Name"];
  $age = $_POST["Age"];
  $conn->query("INSERT INTO info (Name, Age) VALUES ('$name', $age)");
  header("Location: user_status.php"); 
  exit;
}

if (isset($_POST["toggle_id"])) {
  $id = (int)$_POST["toggle_id"];
  $res = $conn->query("SELECT Status FROM info WHERE ID = $id");
  $current = $res->fetch_assoc()["Status"];
  $new = $current == 1 ? 0 : 1;
  $conn->query("UPDATE info SET Status = $new WHERE ID = $id");
  header("Location: user_status.php"); 
  exit;
}

$result = $conn->query("SELECT * FROM info");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>User Status</title>
  <style>
    body {
      background-color: white;
        display: flex;
      justify-content: center;
       padding: 40px; 
    
    }

    .container {
     background: white;
      padding: 30px;
      border-radius: 10px;
     width: 500px;
    }

    form {
     display: flex;
     gap: 10px;
     margin-bottom: 20px;
    }

    form input {
     padding: 10px;
     font-size: 14px;
     border: 1px solid #ccc;
     box-sizing: border-box;
    }

    input[type="text"] {
     width: 40%;
    }

    input[type="number"] {
     width: 30%;
    }

    form button {
     background-color: #0f3460;
     color: white;
     cursor: pointer;
     padding: 10px 15px;
     border: none;
    }

    table {
     width: 100%;
     border-collapse: collapse;
     margin-top: 15px;
    }

    th, td {
     border: 1px solid black;  
     padding: 10px;
     text-align: center;
    }

    

    h3 {
     text-align: center;
    }


  </style>
</head>
<body>
<div class="container">
  <form method="POST">
  <input type="text" name="Name" placeholder="Enter Name" required>
  <input type="number" name="Age" placeholder="Enter Age" required min="10" max="80">
  <button type="submit">Submit</button>
</form>


  <h3>User List</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Age</th>
      <th>Status</th>
      <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row["ID"] ?></td>
      <td><?= $row["Name"] ?></td>
      <td><?= $row["Age"] ?></td>
      <td><?= $row["Status"] ?></td> 
      <td>
        <form method="POST" style="display:inline;">
          <input type="hidden" name="toggle_id" value="<?= $row["ID"] ?>">
          <button type="submit">Toggle</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
</body>
</html>