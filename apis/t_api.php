<?php 
include("../config/conn.php");

header('Content-Type: application/json');

if(isset($_POST['action'])){
    $action=$_POST['action'];
    if(function_exists($action)){
        $action($conn);
    }else{
        echo json_encode(["status"=>"error","message"=>"Invalid Action!"]);
    }
}else{
            echo json_encode(["status"=>"error","message"=>"Action Is Required!"]);
}

// ============= CALI IBRAAHIM OMAR =====================

// Insert Teacher Start Here 
function InsertTeacher($conn){
    if(isset($_POST['InsertTeacher']) && $_POST['InsertTeacher'] == "Idman123"){
        extract($_POST);

        if(empty($full_name) || empty($gender) || empty($phone_number) ||
            empty($qualification) || empty($experience) || empty($subjects) || empty($status)){
            echo json_encode(["status"=>"error","message"=>"All Fields Are Required!"]);
        } else {
            $read_old = mysqli_query($conn, "SELECT * FROM teachers WHERE full_name='$full_name' OR phone_number='$phone_number'");
              if($read_old && mysqli_num_rows($read_old) > 0){
                echo json_encode(["status"=>"error","message"=>"This Name Or Phone Number Is Already Exists!"]);
            } else {
                if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0){
                    $file_name = $_FILES['profile_photo']['name'];
                    $file_temp = $_FILES['profile_photo']['tmp_name'];
                    $folder = "../upload/teachers/" . $file_name;



                    if(move_uploaded_file($file_temp, $folder)){
                            
                        $passwordGenerator = rand(100000, 999999);


                        $insertTeacher = mysqli_query($conn,"INSERT INTO teachers(`login_pass`,`full_name`, `gender`, `phone_number`, `qualification`, `experience`, `subjects`, `profile_photo`, `status`) VALUES
                         ('$passwordGenerator','$full_name','$gender','$phone_number','$qualification','$experience','$subjects','$folder','$status')");

                        if($insertTeacher){
                            echo json_encode(["status"=>"success","message"=>"Successfully Teacher Inserted!"]);
                        } else {
                            echo json_encode(["status"=>"error","message"=>"Failed To Insert Teacher!"]);
                        }
                    } else {
                        echo json_encode(["status"=>"error","message"=>"Failed to move uploaded file"]);
                    }
                } else {
                    echo json_encode(["status"=>"error","message"=>"File upload failed or no file selected!"]);
                }
            }
        }

    } else {
        echo json_encode(["status"=>"error","message"=>"Invalid Insert And Password Is Required!"]);
    }
}


// Insert Teacher End Here Here 
// Read Teacher Start Here Here 
function ReadTeacher($conn){
    if(isset($_POST['ReadTeacher']) && $_POST['ReadTeacher']== "Idman123"){
        $readTeacher=mysqli_query($conn,"SELECT * FROM teachers");
        if($readTeacher && mysqli_num_rows($readTeacher)>0){
          foreach($readTeacher as $row){
              ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['phone_number']; ?></td>
                <td><?php echo $row['qualification']; ?></td>
                <td><?php echo $row['subjects']; ?></td>
                <td><?php echo $row['experience']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><button data-bs-toggle="modal" data-bs-target="#UpdateTeacherModal" id="UpdateTchr" TeacherId="<?php echo $row['id']; ?>" class="btn btn-dark"><i class="fas fa-edit"></i></button></td>
                <td><button id="DeleteTchr" TeacherId="<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
            </tr>
            <?php 
          }
        }else{
            echo "No Student Found it";
        }
    }else{
        echo json_encode(["status"=>"error","message"=>"Invalid Read And Password Is Required"]);
    }
}
// Read Teacher End Here Here 
// Delete Teacher Start Here Here 
function DeleteTchr($conn){
    if(isset($_POST['TeacherId'])){
        $id=$_POST['TeacherId'];
        $delete_query=mysqli_query($conn,"DELETE FROM teachers WHERE id='$id'");
        if($delete_query){
        echo json_encode(["status"=>"success","message"=>"SuccessFully Teacher Deleted!"]);
        }else{
               echo json_encode(["status"=>"error","message"=>"No Teacher Deleted!"]);
        }
    }else{
           echo json_encode(["status"=>"error","message"=>"Teacher Id Is Required"]);
    }
}
// Delete Teacher End Here Here 
// Update Read Teacher Start  Here 
function UpdateRead($conn){
    if(isset($_POST['TeacherId'])){
        $teacherId=$_POST['TeacherId'];
        $updateRead=mysqli_query($conn, "SELECT * FROM teachers WHERE id='$teacherId'");
        if($updateRead && mysqli_num_rows($updateRead)>0){
            $row=mysqli_fetch_assoc($updateRead);
            ?>
                <form method="POST" enctype="multipart/form-data" class="modal-content" id="TeacherUpdateForm"> <!-- ✅ Only One FORM -->
      <div class="modal-header">
        <h5 class="modal-title">Add New Teacher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
             <input type="text" name="id" hidden class="form-control" value="<?php echo $row['id'] ?>">
        <div class="col-12">
          <input type="text" name="full_name" class="form-control" value="<?php echo $row['full_name'] ?>">
        </div>
        <div class="col-6">
          <select name="gender" class="form-select">
            <option value="<?php echo $row['gender'] ?>"><?php echo $row['gender'] ?></option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="col-6">
          <input type="text" name="phone_number" class="form-control" value="<?php echo $row['phone_number'] ?>" >
        </div>
        <div class="col-6">
          <input type="text" name="qualification" class="form-control" value="<?php echo $row['qualification'] ?>">
        </div>
        <div class="col-6">
          <input type="number" name="experience" class="form-control" value="<?php echo $row['experience'] ?>">
        </div>
        <div class="col-12">
          <input type="text" name="subjects" class="form-control" value="<?php echo $row['subjects'] ?>">
        </div>
        <div class="col-12">
          <input type="file" name="profile_photo" class="form-control">
          <img src="<?php echo $row['profile_photo'] ?>" style="width: 150px;" class="img-thumbnail" alt="">
        </div>
        <div class="col-12">
          <select name="status" class="form-select">
            <option value="<?php echo $row['status'] ?>"><?php echo $row['status'] ?></option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Teacher</button>
      </div>
    </form>
            <?php
        }else{
            echo json_encode(["status"=>"error","message"=>"No Teacher Found it"]);
        }
    }else{
                    echo json_encode(["status"=>"error","message"=>"Student Id Is Required"]);
    }
}
// Update Read Teacher End  Here 
// Update  Teacher Start  Here 
function UpdateTeacher($conn){
    if(isset($_POST['id'])){
        $teacher_id = $_POST['id'];
        extract($_POST);

        if(empty($full_name) || empty($gender) || empty($phone_number) ||
           empty($qualification) || empty($experience) || empty($subjects) || empty($status)){
            echo json_encode(["status"=>"error","message"=>"All Fields Are Required!"]);
        } else {

            // Haddii sawir cusub la doortay
            if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0){
                $file_name = $_FILES['profile_photo']['name'];
                $file_temp = $_FILES['profile_photo']['tmp_name'];
                $folder = "../upload/teachers/" . $file_name;

                if(move_uploaded_file($file_temp, $folder)){
                    // ✅ Update with image
                    $update = mysqli_query($conn, "UPDATE teachers SET 
                        full_name='$full_name',
                        gender='$gender',
                        phone_number='$phone_number',
                        qualification='$qualification',
                        experience='$experience',
                        subjects='$subjects',
                        profile_photo='$folder',
                        status='$status'
                        WHERE id='$teacher_id'");

                    if($update){
                        echo json_encode(["status"=>"success","message"=>"Teacher Updated Successfully With New Photo!"]);
                    } else {
                        echo json_encode(["status"=>"error","message"=>"Failed To Update Teacher!"]);
                    }

                } else {
                    echo json_encode(["status"=>"error","message"=>"Failed to move uploaded file"]);
                }
            } else {
                // ✅ Update without image
                $update = mysqli_query($conn, "UPDATE teachers SET 
                    full_name='$full_name',
                    gender='$gender',
                    phone_number='$phone_number',
                    qualification='$qualification',
                    experience='$experience',
                    subjects='$subjects',
                    status='$status'
                    WHERE id='$teacher_id'");

                if($update){
                    echo json_encode(["status"=>"success","message"=>"Teacher Updated Successfully!"]);
                } else {
                    echo json_encode(["status"=>"error","message"=>"Failed To Update Teacher!"]);
                }
            }
        }
    }
}

// Update  Teacher End  Here 

?>