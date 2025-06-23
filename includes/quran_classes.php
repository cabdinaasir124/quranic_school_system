<?php
include("../config/conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Class Management</title>
</head>
<body>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Classes</h3>
  </div>

  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title">Class List</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">Add Class</button>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Class Name</th>
            <th>Class Code</th>
            <th>Type</th>
            <!-- <th>Level</th> -->
            <th>Teacher</th>
            <th>Max Students</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="classTable">
          <!-- thisdatawillcome -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Class Modal -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- wider modal -->
    <form method="POST" class="modal-content" id="addClassForm">
      <div class="modal-header">
        <h5 class="modal-title">Add New Class</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body row g-3">
        <div class="col-12">
          <input type="text" name="class_name" class="form-control" placeholder="Class Name">
        </div>

        <div class="col-6">
          <input type="text" name="class_code" id="class_code" class="form-control" readonly>
        </div>

        <div class="col-6">
          <select name="class_type" class="form-select">
            <option value="">Class Type</option>
            <option>Hifz</option>
            <option>Tajweed</option>
            <option>Reading</option>
            <option>Academic</option>
            <option>Hadith</option>
            <option>Fiqh</option>
          </select>
        </div>

        <div class="col-6">
          <input type="text" name="level" class="form-control" placeholder="Level (e.g. Beginner)">
        </div>

        <div class="col-6">
          <select name="teacher_id" class="form-select">
            <option value="">Assign Teacher</option>
            <?php
              $teachers = $conn->query("SELECT id, full_name FROM teachers");
              while ($teacher = $teachers->fetch_assoc()):
            ?>
            <option value="<?= $teacher['id'] ?>"><?= htmlspecialchars($teacher['full_name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-6">
          <input type="number" name="max_students" class="form-control" placeholder="Max Students">
        </div>

        <div class="col-6">
          <select name="gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Mixed">Mixed</option>
          </select>
        </div>

        <!-- Time Slot: Start & End time -->
        <div class="col-6">
          <label class="form-label">Start Time</label>
          <input type="time" name="time_start" class="form-control">
        </div>

        <div class="col-6">
          <label class="form-label">End Time</label>
          <input type="time" name="time_end" class="form-control">
        </div>

        <!-- Days Active as checkboxes -->
        <div class="col-12">
          <label class="form-label">Days Active</label>
          <div class="d-flex flex-wrap gap-3">
            <div><input type="checkbox" name="days_active[]" value="Saturday" id="daySat"><label for="daySat" class="ms-1">Saturday</label></div>
            <div><input type="checkbox" name="days_active[]" value="Sunday" id="daySun"><label for="daySun" class="ms-1">Sunday</label></div>
            <div><input type="checkbox" name="days_active[]" value="Monday" id="dayMon"><label for="dayMon" class="ms-1">Monday</label></div>
            <div><input type="checkbox" name="days_active[]" value="Tuesday" id="dayTue"><label for="dayTue" class="ms-1">Tuesday</label></div>
            <div><input type="checkbox" name="days_active[]" value="Wednesday" id="dayWed"><label for="dayWed" class="ms-1">Wednesday</label></div>
            <div><input type="checkbox" name="days_active[]" value="Thursday" id="dayThu"><label for="dayThu" class="ms-1">Thursday</label></div>
            <div><input type="checkbox" name="days_active[]" value="Friday" id="dayFri"><label for="dayFri" class="ms-1">Friday</label></div>
          </div>
        </div>

        <div class="col-6">
          <input type="text" name="room" class="form-control" placeholder="Room / Class Location">
        </div>

        <div class="col-6">
          <select name="status" class="form-select">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Class</button>
      </div>
    </form>
  </div>
</div>


<!-- Edit Class Modal -->
<div class="modal fade" id="editClassModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" class="modal-content" id="editClassForm">
      <div class="modal-header">
        <h5 class="modal-title">Edit Class</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body row g-3">
        <input type="hidden" name="edit_id" id="edit_id">

        <div class="col-12">
          <input type="text" name="class_name" id="edit_class_name" class="form-control" placeholder="Class Name">
        </div>

        <div class="col-6">
          <input type="text" name="class_code" id="edit_class_code" class="form-control" readonly>
        </div>

        <div class="col-6">
          <select name="class_type" id="edit_class_type" class="form-select">
            <option value="">Class Type</option>
            <option>Hifz</option>
            <option>Tajweed</option>
            <option>Reading</option>
            <option>Academic</option>
            <option>Hadith</option>
            <option>Fiqh</option>
          </select>
        </div>

        <div class="col-6">
          <input type="text" name="level" id="edit_level" class="form-control" placeholder="Level (e.g. Beginner)">
        </div>

        <div class="col-6">
          <select name="teacher_id" id="edit_teacher_id" class="form-select">
            <option value="">Assign Teacher</option>
            <?php
              $teachers = $conn->query("SELECT id, full_name FROM teachers");
              while ($teacher = $teachers->fetch_assoc()):
            ?>
            <option value="<?= $teacher['id'] ?>"><?= htmlspecialchars($teacher['full_name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="col-6">
          <input type="number" name="max_students" id="edit_max_students" class="form-control" placeholder="Max Students">
        </div>

        <div class="col-6">
          <select name="gender" id="edit_gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Mixed">Mixed</option>
          </select>
        </div>

        <div class="col-6">
          <label class="form-label">Start Time</label>
          <input type="time" name="time_start" id="edit_time_start" class="form-control">
        </div>

        <div class="col-6">
          <label class="form-label">End Time</label>
          <input type="time" name="time_end" id="edit_time_end" class="form-control">
        </div>

        <div class="col-12">
          <label class="form-label">Days Active</label>
          <div class="d-flex flex-wrap gap-3">
            <?php
              $days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
              foreach ($days as $day):
            ?>
            <div>
              <input type="checkbox" name="days_active[]" class="edit-day" value="<?= $day ?>" id="edit_day_<?= $day ?>">
              <label for="edit_day_<?= $day ?>" class="ms-1"><?= $day ?></label>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="col-6">
          <input type="text" name="room" id="edit_room" class="form-control" placeholder="Room / Class Location">
        </div>

        <div class="col-6">
          <select name="status" id="edit_status" class="form-select">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Class</button>
      </div>
    </form>
  </div>
</div>



<!-- View Class Info Modal -->
<div class="modal fade" id="viewClassModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Class Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr><th>Class Name</th><td id="v_name"></td></tr>
            <tr><th>Class Code</th><td id="v_code"></td></tr>
            <tr><th>Type</th><td id="v_type"></td></tr>
            <tr><th>Level</th><td id="v_level"></td></tr>
            <tr><th>Teacher</th><td id="v_teacher"></td></tr>
            <tr><th>Max Students</th><td id="v_max"></td></tr>
            <tr><th>Status</th><td id="v_status"></td></tr>
            <tr><th>Gender</th><td id="v_gender"></td></tr>
            <tr><th>Days Active</th><td id="v_days"></td></tr>
            <tr><th>Time Slot</th><td id="v_time"></td></tr>
            <tr><th>Room</th><td id="v_room"></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>




</body>
</html>
