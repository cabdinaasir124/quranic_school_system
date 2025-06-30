<?php 
include("../config/conn.php");
header('Content-Type: application/json');

// Started Action
if(isset($_POST['action'])){
    $action = $_POST['action'];
    if(function_exists($action)){
        $action($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Action Is Required"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Action And Action Is Required"]);
} 

// Ended  Action


// Insert Parent Function Start Here
function InertParent($conn){
    if(isset($_POST['InertParent']) && $_POST['InertParent']== "Quranic!@#"){
         // Clean input
        $name = trim($_POST['name']);
        $relationship = trim($_POST['relationship']);
        $national_id = trim($_POST['national_id']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $occupation = trim($_POST['occupation']);
        $emergency_name = trim($_POST['emergency_name']);
        $emergency_phone = trim($_POST['emergency_phone']);
        $children = trim($_POST['children']);
        $payment_method = trim($_POST['payment_method']);
        $payment_history = trim($_POST['payment_history']);
        $discount = floatval($_POST['discount']);
        $installment_plan = isset($_POST['installment_plan']) ? 1 : 0;
        $consent_sms_alerts = isset($_POST['consent_sms_alerts']) ? 1 : 0;

               // Validation
        if (
            empty($name) || empty($relationship) || empty($national_id) || empty($phone) ||
            empty($address) || empty($occupation) || empty($emergency_name) || empty($emergency_phone) ||
            empty($children) || empty($payment_method) || empty($payment_history)
        ) 
        {
            echo json_encode(["status" => "error", "message" => "All required fields must be filled"]);
           
        }
        else

        // Email optional: validate if filled
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Invalid email format"]);
        }
        else{
            $read_old=mysqli_query($conn,"SELECT * FROM parents WHERE email='$email'");
            if($read_old && mysqli_num_rows($read_old)>0){
              echo json_encode(["status"=>"error","message"=>"This Email: $email is Already Exists"]);
            }else{
                $insert_query=mysqli_query($conn, 
        "INSERT INTO `parents`(`name`, `relationship`, `national_id`, `phone`, `email`, `address`, `occupation`, `emergency_name`, `emergency_phone`, `children`, `payment_method`, `payment_history`, `discount`, `installment_plan`, `consent_sms_alerts`) VALUES 
                ('$name','$relationship','$national_id','$phone','$email','$address','$occupation','$emergency_name','$emergency_phone','$children','$payment_method','$payment_history','$discount','$installment_plan','$consent_sms_alerts')");
                if($insert_query){
                    echo json_encode(["status"=>"success","message"=>"SuccessFully Parent Inserted"]);
                }
                else{
                    echo json_encode(["status"=>"error","message"=>"Parent Insert Failed!"]);
                }
            }
        }



    }else{
        echo json_encode(["status"=>"error","message"=>"Invalid Insert And Password Is Required"]);
    }
}
// Insert Parent Function End Here

// Read  Parent Function start Here
function ReadParent($conn){
    $read_query=mysqli_query($conn,"SELECT * FROM parents");
    if($read_query && mysqli_num_rows($read_query)>0){
        foreach($read_query as $row){
            ?>
              <tr>
                <td><?php echo $row['parent_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['relationship']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><button data-bs-toggle="modal" data-bs-target="#ViewTeacherModal" id="ViewParent" parentId="<?php echo $row['parent_id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i>&nbsp;View</button></td>
                <td><button data-bs-toggle="modal" data-bs-target="#UpdateTeacherModal" id="UpdateParent" parentId="<?php echo $row['parent_id']; ?>" class="btn btn-sm btn-success"><i class="fas fa-edit"></i>&nbsp;edit</button></td>
                <td><button id="DeleteParent" parentId="<?php echo $row['parent_id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>&nbsp;Delete</button></td>
               </tr>
            <?php
        }
    }else{
        echo "<h3>No Parent Found It!</h3>";
    }
}
// Read  Parent Function End Here

// Delete  Parent Function Start Here
function DeleteParent($conn){
    if(isset($_POST['parentId'])){
        $Id=$_POST['parentId'];
        $delete_Query=mysqli_query($conn, "DELETE FROM parents WHERE parent_id='$Id'");
        if($delete_Query){
            echo json_encode(["status"=>"success","message"=>"SuccessFully Parent Deleted!"]);
        }else{
              echo json_encode(["status"=>"error","message"=>"Failed To Delete Parent!"]);
        }
    }else{
      echo json_encode(["status"=>"error","message"=>"Parent Id Is Required!"]);
    }
}
// Delete  Parent Function End Here

// Read Update  Parent Function Start Here
function ReadUpdate($conn){
    if(isset($_POST['parentId'])){
        $parent_Id=$_POST['parentId'];
        $read_upadete=mysqli_query($conn,"SELECT * FROM parents WHERE parent_id='$parent_Id'");
        if($read_upadete && mysqli_num_rows($read_upadete)>0){
            $row=mysqli_fetch_assoc($read_upadete);
            ?>
            <form id="updateParentForm" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Parent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" value="<?php echo $row['parent_id']; ?>" name="parent_id" value="P001">

        <div class="row">
          <!-- Left Column -->
          <div class="col-md-6">
            <div class="mb-3">
              <label>Name:</label>
              <input type="text" value="<?php echo $row['name']; ?>" name="name" class="form-control" >
            </div>

            <div class="mb-3">
              <label>Relationship:</label>
              <input type="text" value="<?php echo $row['relationship']; ?>" name="relationship" class="form-control" >
            </div>

            <div class="mb-3">
              <label>National ID:</label>
              <input type="text" value="<?php echo $row['national_id']; ?>" name="national_id" class="form-control">
            </div>

            <div class="mb-3">
              <label>Phone:</label>
              <input type="text" value="<?php echo $row['phone']; ?>" name="phone" class="form-control" >
            </div>

            <div class="mb-3">
              <label>Email:</label>
              <input type="email" value="<?php echo $row['email']; ?>" name="email" class="form-control">
            </div>

            <div class="mb-3">
              <label>Address:</label>
              <textarea name="address"  class="form-control" rows="2"><?php echo $row['address']; ?></textarea>
            </div>

            <div class="mb-3">
              <label>Occupation:</label>
              <input type="text" value="<?php echo $row['occupation']; ?>" name="occupation" class="form-control">
            </div>
          </div>

          <!-- Right Column -->
          <div class="col-md-6">
            <label class="fw-bold mb-3 mt-2">Emergency Contact</label>

            <div class="mb-3">
              <label>Emergency Name:</label>
              <input type="text" value="<?php echo $row['emergency_name']; ?>" name="emergency_name" class="form-control">
            </div>

            <div class="mb-3">
              <label>Emergency Phone:</label>
              <input type="text" value="<?php echo $row['emergency_phone']; ?>" name="emergency_phone" class="form-control">
            </div>

            <div class="mb-3">
              <label>Children (IDs comma-separated):</label>
              <input type="text" value="<?php echo $row['children']; ?>" name="children" class="form-control">
            </div>

            <div class="mb-3">
              <label>Payment Method:</label>
              <select name="payment_method" class="form-control">
                <option value="<?php echo $row['payment_method']; ?>"><?php echo $row['payment_method']; ?></option>
                <option value="Mobile Money">Mobile Money</option>
                <option value="Bank">Bank</option>
                <option value="Cash">Cash</option>
              </select>
            </div>

            <div class="mb-3">
              <label>Payment History (JSON):</label>
              <textarea name="payment_history" class="form-control" rows="3"><?php echo $row['payment_history']; ?></textarea>
            </div>

            <div class="mb-3">
              <label>Discount (%):</label>
              <input type="number" name="discount" value="<?php echo $row['discount']; ?>" step="0.01" class="form-control" value="0">
            </div>

            <div class="form-check mb-2">
              <input type="checkbox" value="<?php echo $row['installment_plan']; ?>" name="installment_plan" class="form-check-input" value="1">
              <label class="form-check-label">Installment Plan</label>
            </div>

            <div class="form-check mb-3">
              <input type="checkbox" value="<?php echo $row['consent_sms_alerts']; ?>" name="consent_sms_alerts" class="form-check-input" value="1" checked>
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
            <?php
        }
    }else{
        echo json_encode(["status"=>"error","message"=>"Parent Id Is Required"]);
    }
}

// Read Update  Parent Function End Here
//  Update  Parent Function Start Here
function UpdateP($conn){
    if(isset($_POST['parent_id'])){
        $parent_id=$_POST['parent_id'];
          // Clean input
        $name = trim($_POST['name']);
        $relationship = trim($_POST['relationship']);
        $national_id = trim($_POST['national_id']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $occupation = trim($_POST['occupation']);
        $emergency_name = trim($_POST['emergency_name']);
        $emergency_phone = trim($_POST['emergency_phone']);
        $children = trim($_POST['children']);
        $payment_method = trim($_POST['payment_method']);
        $payment_history = trim($_POST['payment_history']);
        $discount = floatval($_POST['discount']);
        $installment_plan = isset($_POST['installment_plan']) ? 1 : 0;
        $consent_sms_alerts = isset($_POST['consent_sms_alerts']) ? 1 : 0;

        // Email optional: validate if filled
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Invalid email format"]);
        }else{
          $read_old=mysqli_query($conn,"SELECT * FROM parents WHERE email='$email'");
            if($read_old && mysqli_num_rows($read_old)>0){
              echo json_encode(["status"=>"error","message"=>"This Email: $email is Already Exists"]);
            }else{
              $update_query=mysqli_query($conn,"UPDATE parents SET `name`='$name',`relationship`='$relationship',`national_id`='$national_id',`phone`='$phone',`email`='$email',`address`='$address',`occupation`='$occupation',`emergency_name`='$emergency_name',`emergency_phone`='$emergency_phone',`children`='$children',`payment_method`='$payment_method',`payment_history`='$payment_history',`discount`='$discount',`installment_plan`='$installment_plan',`consent_sms_alerts`='$consent_sms_alerts' WHERE  parent_id='$parent_id'");
              if($update_query){
                    echo json_encode(["status" => "success", "message" => "SuccessFully Parent Updated"]);
              }else{
                    echo json_encode(["status" => "error", "message" => "Failed To Update Parent"]);
              }
           }
         
        }
    }else{
            echo json_encode(["status" => "error", "message" => "Parent ID is Required"]);
    }
}
//  Update  Parent Function End Here
//  View  Parent Function End Here
function ViewParent($conn){
  if(isset($_POST['parentId'])){
    $parent_id=$_POST['parentId'];
    $query=mysqli_query($conn,"SELECT * FROM parents WHERE parent_id='$parent_id'");
    if($query && mysqli_num_rows($query)>0){
      $row=mysqli_fetch_assoc($query);
      ?>
      <div class="row" id="gridView" style="display: flex;">
          <div class="col-md-12 mb-12">
            <div class="card shadow border-0 h-100">
              <div class="d-flex justify-content-center mt-4">
                <!-- Profile photo removed -->
              </div>

              <div class="card-body text-left">
                <h5 class="card-title mb-1 text-left"><span style="color: red;">Welcome:</span><?php echo $row['name'] ;?></h5>

                <table class="table table-sm table-borderless text-start mb-0 mt-3">
                  <tr><th class="text-muted" style="width: 40%;">ID:</th><td><?php echo htmlspecialchars($row['parent_id']); ?></td></tr>
                  <tr><th class="text-muted">Full Name:</th><td><?php echo htmlspecialchars($row['name']); ?></td></tr>
                  <tr><th class="text-muted">Relationship:</th><td><?php echo htmlspecialchars($row['relationship']); ?></td></tr>
                  <tr><th class="text-muted">national_id:</th><td><?php echo htmlspecialchars($row['national_id']); ?></td></tr>
                  <tr><th class="text-muted">phone:</th><td><?php echo htmlspecialchars($row['phone']); ?></td></tr>
                  <tr><th class="text-muted">email:</th><td><?php echo htmlspecialchars($row['email']); ?></td></tr>
                  <tr><th class="text-muted">address:</th><td><?php echo htmlspecialchars($row['address']); ?></td></tr>
                  <tr><th class="text-muted">occupation:</th><td><?php echo htmlspecialchars($row['occupation']); ?></td></tr>
                  <tr><th class="text-muted">emergency_name:</th><td><?php echo htmlspecialchars($row['emergency_name']); ?></td></tr>
                  <tr><th class="text-muted">emergency_phone:</th><td><?php echo htmlspecialchars($row['emergency_phone']); ?></td></tr>
                  <tr><th class="text-muted">children:</th><td><?php echo htmlspecialchars($row['children']); ?></td></tr>
                  <tr><th class="text-muted">payment_method:</th><td><?php echo htmlspecialchars($row['payment_method']); ?></td></tr>
                  <tr><th class="text-muted">payment_history:</th><td><?php echo htmlspecialchars($row['payment_history']); ?></td></tr>
                  <tr><th class="text-muted">discount:</th><td><?php echo htmlspecialchars($row['discount']); ?></td></tr>
                  <tr><th class="text-muted">installment_plan:</th><td><?php echo htmlspecialchars($row['installment_plan']); ?></td></tr>
                  <tr><th class="text-muted">consent_sms_alerts:</th><td><?php echo htmlspecialchars($row['consent_sms_alerts']); ?></td></tr>
                  <tr><th class="text-muted">joining_date:</th><td><?php echo htmlspecialchars($row['joining_date']); ?></td></tr>
                </table>

              </div>
            </div>
          </div>
        </div>
      <?php
    }
  }
}

//  View  Parent Function End Here
 ?>