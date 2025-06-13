<?php
// Connect to the database
include("../config/conn.php");

// Fetch all students
$students = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student List</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/> -->
  <style>
    #gridView .card {
      height: 100%;
    }
  </style>
</head>
<body>

<div class="content container-fluid mt-4">

  <!-- Page Header -->
  <div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="page-title">Students</h3>
      <!-- <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Student List</li>
      </ul> -->
    </div>

    <!-- Toggle Buttons -->
    <div>
      <button class="btn btn-outline-primary me-2" onclick="showTable()">Table View</button>
      <button class="btn btn-outline-secondary" onclick="showGrid()">Grid View</button>
    </div>
  </div>

  <!-- TABLE VIEW -->
  <div class="row" id="tableView">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-2">Students Table</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="datatable table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Class</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $students->fetch_assoc()) { ?>
                <tr>
                  <td><?= htmlspecialchars($row['full_name']) ?></td>
                  <td><?= htmlspecialchars($row['gender']) ?></td>
                  <td><?= htmlspecialchars($row['phone_number']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td><?= htmlspecialchars($row['class_level']) ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- GRID VIEW -->
<div class="row" id="gridView" style="display: none;">
  <?php
  $students->data_seek(0); // reset pointer for re-loop
  while ($row = $students->fetch_assoc()) {
  ?>
  <div class="col-md-4 mb-4">
    <div class="card shadow border-0 h-100">
      <div class="d-flex justify-content-center mt-4">
        <?php if (!empty($row['profile_photo'])): ?>
        <img src="../assets/img/<?= htmlspecialchars($row['profile_photo']) ?>" 
             class="rounded-circle shadow-sm" 
             style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;" 
             alt="Student Photo">
        <?php else: ?>
        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" 
             style="width: 120px; height: 120px; font-size: 32px;">
          <?= strtoupper($row['full_name'][0]) ?>
        </div>
        <?php endif; ?>
      </div>
      <div class="card-body text-left">
        <h5 class="card-title mb-1 text-center"><?= htmlspecialchars($row['full_name']) ?></h5>
        <table class="table table-sm table-borderless text-start mb-0 mt-3">
  <tr>
    <th scope="row" class="text-muted" style="width: 40%;">Gender:</th>
    <td><?= htmlspecialchars($row['gender']) ?></td>
  </tr>
  <tr>
    <th scope="row" class="text-muted">Class:</th>
    <td><?= htmlspecialchars($row['class_level']) ?></td>
  </tr>
  <tr>
    <th scope="row" class="text-muted">Phone:</th>
    <td><?= htmlspecialchars($row['phone_number']) ?></td>
  </tr>
  <tr>
    <th scope="row" class="text-muted">Email:</th>
    <td><?= htmlspecialchars($row['email']) ?></td>
  </tr>
</table>

      </div>
    </div>
  </div>
  <?php } ?>
</div>


</div>

<!-- Scripts -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script>
  function showTable() {
    document.getElementById("tableView").style.display = "block";
    document.getElementById("gridView").style.display = "none";
  }

  function showGrid() {
    document.getElementById("tableView").style.display = "none";
    document.getElementById("gridView").style.display = "flex";
    document.getElementById("gridView").style.flexWrap = "wrap";
  }
</script>

</body>
</html>
