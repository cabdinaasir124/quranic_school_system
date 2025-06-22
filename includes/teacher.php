<?php
include("../config/conn.php");
$teachers = $conn->query("SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Teacher List</title>
  <style>
    #gridView .card {
      height: 100%;
    }
    .teacher-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #0d6efd;
    }
    .card-title {
  font-weight: 600;
}
.badge {
  font-size: 0.8rem;
  padding: 0.4em 0.7em;
}

  </style>
</head>
<body>

<div class="container mt-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Teachers</h3>
    <div>
      <button class="btn btn-outline-primary" onclick="showTable()">Table View</button>
      <button class="btn btn-outline-secondary" onclick="showGrid()">Grid View</button>
    </div>
  </div>

  <!-- Table View -->
  <div class="row" id="tableView">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Teacher List</h5>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">Add Teacher</button>
        </div>
        <div class="card-body table-responsive">
             <div class="table-responsive">
            <table class="datatable table table-striped">
               <thead>
              <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Qualification</th>
                <th>Subjects</th>
                <th>Experience</th>
                <th>Status</th>
              </tr>
            </thead>
              <tbody id="readTeacher">
              
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- TEACHER GRID VIEW -->
<div class="row" id="gridView" style="display: none;">
  <?php
  $teachers->data_seek(0); // reset pointer
  while ($row = $teachers->fetch_assoc()):
  ?>
  <div class="col-md-4 mb-4">
    <div class="card shadow border-0 h-100">
      <div class="d-flex justify-content-center mt-4">
        <?php if (!empty($row['profile_photo'])): ?>
        <img src="../upload/<?= htmlspecialchars($row['profile_photo']) ?>" 
             class="rounded-circle shadow-sm" 
             style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;" 
             alt="Teacher Photo">
        <?php else: ?>
        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
             style="width: 120px; height: 120px; font-size: 32px;">
          <?= strtoupper($row['full_name'][0]) ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="card-body text-left">
        <h5 class="card-title mb-1 text-center"><?= htmlspecialchars($row['full_name']) ?></h5>
        <table class="table table-sm table-borderless text-start mb-0 mt-3">
          <tr>
            <th class="text-muted" style="width: 40%;">Gender:</th>
            <td><?= htmlspecialchars($row['gender']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Phone:</th>
            <td><?= htmlspecialchars($row['phone_number']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Qualification:</th>
            <td><?= htmlspecialchars($row['qualification']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Experience:</th>
            <td><?= htmlspecialchars($row['experience']) ?> years</td>
          </tr>
          <tr>
            <th class="text-muted">Subjects:</th>
            <td><?= htmlspecialchars($row['subjects']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Status:</th>
            <td>
              <span class="badge <?= strtolower($row['status']) === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                <?= htmlspecialchars($row['status']) ?>
              </span>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>


  <!-- Add Teacher Modal -->
  <div class="modal fade" id="addTeacherModal" tabindex="-1">
    <div class="modal-dialog">
      <form method="POST" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-12">
            <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
          </div>
          <div class="col-6">
            <select name="gender" class="form-select" required>
              <option value="">Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="col-6">
            <input type="text" name="phone_number" class="form-control" placeholder="Phone Number">
          </div>
          <div class="col-6">
            <input type="text" name="qualification" class="form-control" placeholder="Qualification">
          </div>
          <div class="col-6">
            <input type="number" name="experience" class="form-control" placeholder="Years of Experience">
          </div>
          <div class="col-12">
            <input type="text" name="subjects" class="form-control" placeholder="Subjects (e.g. Qur'an, Fiqh)">
          </div>
          <div class="col-12">
            <input type="file" name="profile_photo" class="form-control">
          </div>
          <div class="col-12">
            <select name="status" class="form-select">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="add_teacher" class="btn btn-primary">Save Teacher</button>
        </div>
      </form>
    </div>
  </div>

</div>

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
