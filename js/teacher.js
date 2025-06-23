$(document).ready(function () {
          // ============ Teacher Crud Logic Start Here ===================


        //   Update Logic Start Here
        $(document).on("submit","#TeacherUpdateForm",function (e) { 
            e.preventDefault();
            // alert("click");
            let formdata=new FormData(this);
            formdata.append("action","UpdateTeacher");
            // console.log(formdata);
            $.ajax({
                type: "POST",
                url: "../apis/t_api.php",
                data:formdata,
                contentType:false,
                processData:false,
                dataType: "json",
                success: function (response) {
                    if(response.status == "success"){
                       Swal.fire({
                title: "Good job!",
                text:response.message,
                icon: "success"
                });
                ReadRequest();
            }else if(response.status== "error"){
                Swal.fire({
                title: "Good job!",
                text:response.message,
                icon: "error"
                });
            }
                }
            });
         })
        //   Update Logic End Here



        // Update  Read Teacher  Start Here
          $(document).on("click","#UpdateTchr",function(e){
            e.preventDefault();
            // alert("click");
            let Teacher_id=$(this).attr("TeacherId");
            // alert(Teacher_id);
            $.ajax({
                type: "POST",
                url: "../apis/t_api.php",
                data:{"action":"UpdateRead","TeacherId":Teacher_id},
                dataType: "html",
                success: function (response) {
                    $("#UpdateTeacherBody").html(response);
                }
            });
          })
        // Update  Read Teacher  End Here

    // Insert Logic
  $(document).on("submit", "#TeacherForm", function(e){
    e.preventDefault();

    let submitBtn = $(this).find("button[type='submit']");
    submitBtn.prop("disabled", true); // ✅ Disable button

    let formdata = new FormData(this);
    formdata.append("action", "InsertTeacher");
    formdata.append("InsertTeacher", "Idman123");

    $.ajax({
        type: "POST",
        url: "../apis/t_api.php",
        data: formdata,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
            if(response.status == "success"){
                Swal.fire({
                    title: "Good job!",
                    text: response.message,
                    icon: "success"
                });
                ReadRequest();
            } else if(response.status == "error"){
                Swal.fire({
                    title: "I am Sorry!",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        complete: function() {
            submitBtn.prop("disabled", false); // ✅ Enable button after done
        }
    });
});

// Insert Logic
// Read Start Herre Logic
ReadRequest();
function ReadRequest(){
    $.ajax({
        type: "POST",
        url: "../apis/t_api.php",
        data:{"action":"ReadTeacher","ReadTeacher":"Idman123"},
        dataType: "html",
        success: function (response) {
            // console.log(response);
            $("#readTeacher").html(response);
        }
    });
}
// Read end Logic
// Delete  Start Logic
$(document).on("click","#DeleteTchr",function(e){
    e.preventDefault();
    // alert("clicked");
    let Teacher_id=$(this).attr("TeacherId");
    // alert(Teacher_id);
    Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        type: "POST",
        url: "../apis/t_api.php",
        data:{"action":"DeleteTchr","TeacherId":Teacher_id},
        dataType: "json",
        success: function (response) {
            if(response.status== "success"){
                Swal.fire({
                title: "Good job!",
                text:response.message,
                icon: "success"
                });
                ReadRequest();
            }else if(response.status== "error"){
                Swal.fire({
                title: "Good job!",
                text:response.message,
                icon: "error"
                });
            }
        }
    });
  }
});
})
// Delete  end Logic


    // ============ Teacher Crud Logic End Here ===================
});