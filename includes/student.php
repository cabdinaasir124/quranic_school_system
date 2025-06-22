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
        <div class="card-header d-flex justify-content-between items-center">
          <h5 class="card-title mb-2">Students Table</h5>
         <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            ➕ Add Student
          </button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="datatable table table-striped">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Address</th>
                  <th>Nationality</th>
                  <th>Class</th>
                  <th>View</th>
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody id="ReadStdBody">
              
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
        <img src="../upload/<?= htmlspecialchars($row['profile_photo']) ?>" 
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
    <th scope="row" class="text-muted" style="width: 40%;">Place Of Birth:</th>
    <td><?= htmlspecialchars($row['place_of_birth']) ?></td>
  </tr>
  <tr>
    <th scope="row" class="text-muted">Date Of Birth:</th>
    <td><?= htmlspecialchars($row['date_of_birth']) ?></td>
  </tr>
  <tr>
    <th scope="row" class="text-muted">Responsible Name:</th>
    <td><?= htmlspecialchars($row['Responsible_name']) ?></td>
  </tr>
  <tr>
    <th scope="row" class="text-muted">Responsible Phone:</th>
    <td><?= htmlspecialchars($row['Responsible_phone']) ?></td>
  </tr>
  <tr>
    <th scope="row" class="text-muted">Status:</th>
    <td><?= htmlspecialchars($row['status']) ?></td>
  </tr>
  <tr>
    <th scope="row" class="text-muted">Admission Date:</th>
    <td><?= htmlspecialchars($row['admission_date']) ?></td>
  </tr>
</table>

      </div>
    </div>
  </div>
  <?php } ?>
</div>

<!-- View Modal  Modal -->
<div class="modal fade" id="ViewModal" tabindex="-1" aria-labelledby="ViewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ViewModalLabel">Personal Student Info!</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="ViewStdBody">
   <!-- Will Be Js File -->

      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Student Add Info!</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <form  id="StudentForm" method="POST" enctype="multipart/form-data">
          <div class="row">

            <!-- Left Column -->
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" >
              </div>

              <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select" >
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control" >
              </div>

              <div class="mb-3">
                <label class="form-label">Place of Birth</label>
                <input type="text" name="place_of_birth" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Nationality</label>
                <input type="text" name="nationality" class="form-control">
              </div>

              <!-- <div class="mb-3">
                <label class="form-label">Phone Number</label> -->
                
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                 <option value="">Select Status</option>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address"  class="form-control">
              </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">

              <div class="mb-3">
                <label class="form-label">Responsible Name</label>
                <input type="text" name="guardian_name"  class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Responsible Phone</label>
                <input type="text" name="guardian_phone"  class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Admission Date</label>
                <input type="date" name="admission_date"  class="form-control" >
              </div>

              <div class="mb-3">
                <label class="form-label">Class Level</label>
                <input type="text" name="class_level"  class="form-control img-thumbnail" >
              </div>

              <div class="mb-3">
                <label class="form-label">Qur'an Memorized Portion</label>
                <textarea name="quran_memorized_portion"  rows="3" class="form-control"></textarea>
              </div>

                  <div class="mb-3">
          <label class="form-label">Profile Photo</label>
          <input type="file" name="profile_photo" class="form-control" id="profile_photo">
        </div>
            </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
        </div>  
           </form>
      </div>
    </div>
  </div>
</div>


<!--UPDATE Modal -->
<div class="modal fade" id="UpdateModal" tabindex="-1" aria-labelledby="UpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="UpdateModalLabel">Student Update Info!</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="ReadUpdateBody">
      <!-- will be Here -->
      </div>
    </div>
  </div>
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
