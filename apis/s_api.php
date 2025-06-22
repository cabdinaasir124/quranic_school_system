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

// Start Insert Function
function StudentInsert($conn){
    if(isset($_POST['StudentInsert']) && $_POST['StudentInsert'] == "Caaqil123"){
        // Extract & Sanitize Fields
        $full_name = $_POST['full_name'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $date_of_birth = $_POST['date_of_birth'] ?? '';
        $place_of_birth = $_POST['place_of_birth'] ?? '';
        $nationality = $_POST['nationality'] ?? '';
        $status = $_POST['status'] ?? '';
        $address = $_POST['address'] ?? '';
       $Responsible_name = $_POST['guardian_name'] ?? '';
       $Responsible_phone = $_POST['guardian_phone'] ?? '';
        $admission_date = $_POST['admission_date'] ?? '';
        $class_level = $_POST['class_level'] ?? '';
        $quran_memorized_portion = $_POST['quran_memorized_portion'] ?? '';

        // ifka saxan:
            if (empty($full_name) || empty($gender) || empty($date_of_birth) || empty($place_of_birth) || empty($nationality) ||
                empty($status) || empty($address) || empty($Responsible_name) || empty($Responsible_phone) || 
                empty($admission_date) || empty($class_level) || empty($quran_memorized_portion)) {
                echo json_encode(["status" => "error", "message" => "All Fields Are Required"]);
                return;
            }

        // Check If Student Already Exists
        $read_old = mysqli_query($conn, "SELECT * FROM students WHERE full_name = '$full_name'");
        if($read_old && mysqli_num_rows($read_old) > 0){
            echo json_encode(["status" => "error", "message" => "This Student Already Exists"]);
            return;
        }


        

        // Handle File Upload
        if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0){
            $file_name = $_FILES['profile_photo']['name'];
            $file_tmp = $_FILES['profile_photo']['tmp_name']; // FIXED HERE
            $folder = "../uploads" . $file_name;

            $read_studentId=mysqli_query($conn, "SELECT student_id FROM students ORDER BY student_id DESC LIMIT 1 ");
            if($read_studentId && mysqli_num_rows($read_studentId)> 0)
            {
                foreach($read_studentId as $row_user)
                {
                    
                }
                $row_user['student_id'];
                $CurrentUserId=++$row_user['student_id'];
                }  
                else
                {
                echo json_encode(['status'=> 'error','message'=> 'User Id Is NOt Generated']);
                }




            if(move_uploaded_file($file_tmp, $folder)){
               $insert = mysqli_query($conn, "INSERT INTO students (
                student_id, full_name, gender, date_of_birth, place_of_birth, nationality, address, Responsible_name, Responsible_phone, admission_date, class_level, quran_memorized_portion, profile_photo, status
            ) VALUES (
                '$CurrentUserId', '$full_name', '$gender', '$date_of_birth', '$place_of_birth', '$nationality', '$address', '$Responsible_name', '$Responsible_phone', '$admission_date', '$class_level', '$quran_memorized_portion', '$folder', '$status'
            )");
                if($insert){
                    echo json_encode(["status" => "success", "message" => "Student Inserted Successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Student Insert Failed"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to move uploaded file"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "File upload failed or no file selected"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Insert. Insert Password Is Required"]);
    }


}

// End Insert Function
// Start Delete Function
function DeleteF($conn){
    if(isset($_POST['studentId'])){
        $student_id=$_POST['studentId'];
        $queryDelete=mysqli_query($conn,"DELETE FROM students WHERE id='$student_id'");
        if($queryDelete){
            echo json_encode(["status"=>"success","message"=>"SuccessFully Student Deleted"]);
        }else{
           echo json_encode(["status"=>"error","message"=>"Failed To Delete Student"]);
        }
    }else{
       echo json_encode(["status"=>"error","message"=>"Delete Id Is Required"]);
    }
}
// End Delete Function

// Staert Update Read Function
function UpdateR($conn){
    if(isset($_POST['studentId'])){
        $student_id=$_POST['studentId'];
        $queryReadUpdate=mysqli_query($conn,"SELECT * FROM students WHERE id='$student_id'");
        if($queryReadUpdate && mysqli_num_rows($queryReadUpdate)>0){
            $rowUpdate=mysqli_fetch_assoc($queryReadUpdate);
            ?>
                   <form  id="StudentUpdateForm" method="POST" enctype="multipart/form-data">
          <div class="row">

            <!-- Left Column -->

           
                     <input type="text" hidden name="idUpdate" value="<?php echo $rowUpdate['id'];?>" class="form-control" >
          
            <div class="col-md-6">
              <div class="mb-3">

                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" value="<?php echo $rowUpdate['full_name'];?>" class="form-control" >
              </div>

              <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender"  class="form-select" >
                  <option value="<?php echo $rowUpdate['gender'];?>"><?php echo $rowUpdate['gender'];?></option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" value="<?php echo $rowUpdate['date_of_birth'];?>" class="form-control" >
              </div>

              <div class="mb-3">
                <label class="form-label">Place of Birth</label>
                <input type="text" name="place_of_birth" value="<?php echo $rowUpdate['place_of_birth'];?>" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Nationality</label>
                <input type="text" name="nationality" value="<?php echo $rowUpdate['nationality'];?>" class="form-control">
              </div>

              <!-- <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control">
              </div> -->

              <!-- <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
              </div> -->

              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="<?php echo $rowUpdate['status'];?>"><?php echo $rowUpdate['status'];?></option>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" value="<?php echo $rowUpdate['address'];?>" class="form-control">
              </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">

              <div class="mb-3">
                <label class="form-label">Responsible Name</label>
                <input type="text" name="guardian_name" value="<?php echo $rowUpdate['Responsible_name'];?>" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Responsible Phone</label>
                <input type="text" name="guardian_phone" value="<?php echo $rowUpdate['Responsible_phone'];?>" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Admission Date</label>
                <input type="date" name="admission_date" value="<?php echo $rowUpdate['admission_date'];?>" class="form-control" >
              </div>

              <div class="mb-3">
                <label class="form-label">Class Level</label>
                <input type="text" name="class_level" value="<?php echo $rowUpdate['class_level'];?>" class="form-control img-thumbnail" >
              </div>

              <div class="mb-3">
                <label class="form-label">Qur'an Memorized Portion</label>
                <textarea name="quran_memorized_portion" value="<?php echo $rowUpdate['quran_memorized_portion'];?>" rows="3" class="form-control"></textarea>
              </div>

                  <div class="mb-3">
          <label class="form-label">Profile Photo</label>
          <input type="file" name="profile_photo" class="form-control" id="profile_photo">
          <img src="<?php echo $rowUpdate['profile_photo'];?>" style="max-width: 150px;" class="img-tumbnail">
        </div>
        <div class="mb-3">
          <img id="previewImage" src="" alt="Preview" style="max-width: 150px; display: none;" class="img-thumbnail">
        </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
        </div> 
          </div>
           </form>

            <?php
        } else{
            echo "<h3>No Student Found In Database</h3>";
        }
    }else{
        echo json_encode(["status"=>"error","message"=>"Id Is Required"]);
    }
}
// End Update Read Function
// Start  Update  Function
function UpdateStudent($conn) {
    if (isset($_POST['idUpdate'])) {
        $id = $_POST['idUpdate'];

        // Sanitize input fields
        $full_name = $_POST['full_name'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $date_of_birth = $_POST['date_of_birth'] ?? '';
        $place_of_birth = $_POST['place_of_birth'] ?? '';
        $nationality = $_POST['nationality'] ?? '';
        $status = $_POST['status'] ?? '';
        $address = $_POST['address'] ?? '';
        $Responsible_name = $_POST['guardian_name'] ?? '';
        $Responsible_phone = $_POST['guardian_phone'] ?? '';
        $admission_date = $_POST['admission_date'] ?? '';
        $class_level = $_POST['class_level'] ?? '';
        $quran_memorized_portion = $_POST['quran_memorized_portion'] ?? '';

        // Optional: handle profile photo if updated
        $update_photo = "";
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === 0) {
            $file_name = $_FILES['profile_photo']['name'];
            $file_tmp = $_FILES['profile_photo']['tmp_name'];
            $folder = "../upload/" . $file_name;

            if (move_uploaded_file($file_tmp, $folder)) {
                $update_photo = ", profile_photo = '$folder'";
            } else {
                echo json_encode(["status" => "error", "message" => "Profile photo upload failed"]);
                return;
            }
        }

        // Final update query
        $query = "UPDATE students SET 
            full_name = '$full_name',
            gender = '$gender',
            date_of_birth = '$date_of_birth',
            place_of_birth = '$place_of_birth',
            nationality = '$nationality',
            `status` = '$status',
            `address` = '$address',
            Responsible_name = '$Responsible_name',
            Responsible_phone = '$Responsible_phone',
            admission_date = '$admission_date',
            class_level = '$class_level',
            quran_memorized_portion = '$quran_memorized_portion'
            $update_photo
        WHERE id = '$id'";

        $update = mysqli_query($conn, $query);

        if ($update) {
            echo json_encode(["status" => "success", "message" => "Student updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update student"]);
        }

    } else {
        echo json_encode(["status" => "error", "message" => "Student ID is required"]);
    }
}

// End Update  Function
// Start Read Student  Function
function ReadStd($conn){
    if(isset($_POST['ReadStd']) && $_POST['ReadStd']=="Idman123"){
        $read_query=mysqli_query($conn, "SELECT * FROM students");
        if($read_query && mysqli_num_rows($read_query)>0){
            foreach($read_query as $row){
                ?>
                <tr>
                   <td><?php echo $row['id'];?></td>
                  <td><?php echo $row['full_name'];?></td>
                   <td><?php echo $row['gender'];?></td>
                  <td><?php echo $row['address'];?></td>
                   <td><?php echo $row['nationality'];?></td>
                   <td><?php echo $row['class_level'];?></td>
                  <td><button data-bs-toggle="modal" data-bs-target="#ViewModal" id="ViewStd" studentId="<?= $row['id'];?>" class="btn btn-success"><i class="fas fa-eye"></i></button></td>
                  <td><button data-bs-toggle="modal" data-bs-target="#UpdateModal" id="UpdateStd" studentId="<?= $row['id'];?>" class="btn btn-dark"><i class="fas fa-edit"></i></button></td>
                  <td><button id="DeleteStd" studentId="<?= $row['id'];?>" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
                </tr>
                <?php
            }
        }
    }else{
     echo json_encode(["status"=>"error","message"=>"Read Password Is Required"]);
    }
}
// End Read Student  Function
// Start View Student  Function
function ViewStudent($conn){
    if(isset($_POST['studentId'])){
        $stdId=$_POST['studentId'];
        $viewStd=mysqli_query($conn,"SELECT * FROM students WHERE id='$stdId'");
        if($viewStd && mysqli_num_rows($viewStd)>0){
            $row=mysqli_fetch_assoc($viewStd);
            ?>
                 <div class="row" id="gridView" style="display: flex;">
  <!-- Start of Student Card Template -->
  <div class="col-md-12 mb-12">
    <div class="card shadow border-0 h-100">
      <div class="d-flex justify-content-center mt-4">
        <!-- If Profile Photo Exists -->
        <img src="<?php echo $row['profile_photo'] ?>" 
             class="rounded-circle shadow-sm" 
             style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;" 
             alt="Student Photo">
        
        <!-- If No Profile Photo (Initial Placeholder) -->
        <!-- <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" 
             style="width: 120px; height: 120px; font-size: 32px;">
          {{initial}}
        </div> -->
      </div>

      <div class="card-body text-left">
        <h5 class="card-title mb-1 text-center"><?php echo $row['full_name'] ?></h5>

        <table class="table table-sm table-borderless text-start mb-0 mt-3">
         <tr>
  <th scope="row" class="text-muted" style="width: 40%;">ID:</th>
  <td><?php echo htmlspecialchars($row['id']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Full Name:</th>
  <td><?php echo htmlspecialchars($row['full_name']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Gender:</th>
  <td><?php echo htmlspecialchars($row['gender']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Date of Birth:</th>
  <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Place of Birth:</th>
  <td><?php echo htmlspecialchars($row['place_of_birth']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Nationality:</th>
  <td><?php echo htmlspecialchars($row['nationality']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Status:</th>
  <td><?php echo htmlspecialchars($row['status']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Address:</th>
  <td><?php echo htmlspecialchars($row['address']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Responsible Name:</th>
  <td><?php echo htmlspecialchars($row['Responsible_name']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Responsible Phone:</th>
  <td><?php echo htmlspecialchars($row['Responsible_phone']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Admission Date:</th>
  <td><?php echo htmlspecialchars($row['admission_date']); ?></td>
</tr>
<tr>
  <th scope="row" class="text-muted">Class Level:</th>
  <td><?php echo htmlspecialchars($row['class_level']); ?></td>
</tr>

        </table>

      </div>
    </div>
  </div>
  <!-- End of Student Card Template -->
</div>
            <?php
        }else{
            echo json_encode(["status"=>"error","message"=>"<h2>No Student Found It!</h2>"]);
        }
    }else{
        echo json_encode(["status"=>"error","message"=>"Student ID is Required"]);
    }
}
// End View Student  Function


?>
