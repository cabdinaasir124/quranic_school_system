<?php
include("../config/conn.php");

// Fetch all teachers
$teachers = $conn->query("SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Teachers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

<div class="content container-fluid mt-4">

  <!-- Page Header -->
  <div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="page-title">Parents</h3>
    </div>

    <!-- Add Teacher Button -->
    <div>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">➕ Add Parent</button>
    </div>
  </div>

  <!-- TABLE VIEW -->
  <div class="row" id="tableView">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Parents Table</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="datatable table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Relationship</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>View</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
                </thead>
              <tbody>
               <tr>
                <td>P001</td>
                <td>cali ibraahim Sheekh</td>
                <td>Father</td>
                <td>615887025</td>
                <td>xaji@gmail.com</td>
                <td><button class="btn btn-sm btn-warning"><i class="fas fa-eye"></i>&nbsp;View</button></td>
                <td><button class="btn btn-sm btn-success"><i class="fas fa-edit"></i>&nbsp;edit</button></td>
                <td><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp;Delete</button></td>
               </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ADD TEACHER MODAL -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="save_parent.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Parent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="parent_id" value="P001">

        <div class="row">
          <!-- Left Column -->
          <div class="col-md-6">
            <div class="mb-3">
              <label>Name:</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Relationship:</label>
              <input type="text" name="relationship" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>National ID:</label>
              <input type="text" name="national_id" class="form-control">
            </div>

            <div class="mb-3">
              <label>Phone:</label>
              <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Email:</label>
              <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
              <label>Address:</label>
              <textarea name="address" class="form-control" rows="2"></textarea>
            </div>

            <div class="mb-3">
              <label>Occupation:</label>
              <input type="text" name="occupation" class="form-control">
            </div>
          </div>

          <!-- Right Column -->
          <div class="col-md-6">
            <label class="fw-bold mb-3 mt-2">Emergency Contact</label>

            <div class="mb-3">
              <label>Emergency Name:</label>
              <input type="text" name="emergency_name" class="form-control">
            </div>

            <div class="mb-3">
              <label>Emergency Phone:</label>
              <input type="text" name="emergency_phone" class="form-control">
            </div>

            <div class="mb-3">
              <label>Children (IDs comma-separated):</label>
              <input type="text" name="children" class="form-control">
            </div>

            <div class="mb-3">
              <label>Payment Method:</label>
              <select name="payment_method" class="form-control">
                <option value="Mobile Money">Mobile Money</option>
                <option value="Bank">Bank</option>
                <option value="Cash">Cash</option>
              </select>
            </div>

            <div class="mb-3">
              <label>Payment History (JSON):</label>
              <textarea name="payment_history" class="form-control" rows="3">{ "month": "January 2025", "amount": 20, "status": "Paid" }</textarea>
            </div>

            <div class="mb-3">
              <label>Discount (%):</label>
              <input type="number" name="discount" step="0.01" class="form-control" value="0">
            </div>

            <div class="form-check mb-2">
              <input type="checkbox" name="installment_plan" class="form-check-input" value="1">
              <label class="form-check-label">Installment Plan</label>
            </div>

            <div class="form-check mb-3">
              <input type="checkbox" name="consent_sms_alerts" class="form-check-input" value="1" checked>
              <label class="form-check-label">Consent to SMS Alerts</label>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>



</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
