$(document).ready(function () {



   
   
   
    // ============ Student Crud Logic Start Here ===================

    // View Student Start Here
    $(document).on("click","#ViewStd",function (e) { 
        e.preventDefault();
        // alert("click");
        let Student_id=$(this).attr("studentId");
        // console.log(Student_id);
        $.ajax({
            type: "POST",
            url: "../apis/s_api.php",
            data:{"action":"ViewStudent","studentId":Student_id},
            dataType: "html",
            success: function (response) {
                $("#ViewStdBody").html(response);
            }
        });
     })
    // View Student End Here

// Update Logic Is Here
$(document).on("submit", "#StudentUpdateForm", function(e) {
    e.preventDefault();

    let formdata = new FormData(this); // ← Tani waxay ku daraysaa dhammaan input-ka foomka

    formdata.append("action", "UpdateStudent");

    $.ajax({
        type: "POST",
        url: "../apis/s_api.php",
        data: formdata,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(response) {
            console.log(response.message);

            if (response.status == "success") {
                Swal.fire("Updated!", response.message, "success");
                $("#StudentUpdateForm")[0].reset();
            } else {
                Swal.fire("Error", response.message, "error");
            }
        }
    });
});

// Update Logic Is End Here


// Update Read Students Logic
$(document).on("click","#UpdateStd",function(e){
    e.preventDefault();
    // alert("✔Clicked");
    let Student_id = $(this).attr('studentId');  
    // alert(Student_id);
    $.ajax({
        type: "POST",
        url: "../apis/s_api.php",
        data:{"action":"UpdateR","studentId":Student_id},
        dataType: "html",
        success: function (response) {
            // console.log(response);
            $("#ReadUpdateBody").html(response);
        }
    });
})
// Update Read Students Logic End Here

     readyRquest();
    function readyRquest(){
     $.ajax({
        type: "POST",
        url: "../apis/s_api.php",
        data:{"action":"ReadStd","ReadStd":"Idman123"},
        dataType: "html",
        success: function (response) {
            $("#ReadStdBody").html(response);
        }
     });
    }
  

  $(document).on("click","#DeleteStd",function(e){
    e.preventDefault();
    // alert("clicked");
    let Student_id = $(this).attr('studentId');  
    //   console.log(Student_id);
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
    url: "../apis/s_api.php",
    data:{"action":"DeleteF","studentId":Student_id},
    dataType: "json",
    success: function (response) {
        if(response.status == "success"){
           Swal.fire({
                    title: "Good job!",
                    text: response.message,
                    icon: "success"
                    });
                  readyRquest();

        }else  if(response.status == "error"){
           Swal.fire({
                    title: "I am Sorry!",
                    text: response.message,
                    icon: "error"
                    }); 
        }
    }
   });
  }
});
  })




    //  Insert Logic
    $(document).on("submit", "#StudentForm", function(e){
        e.preventDefault();

        let form = document.getElementById("StudentForm");
        let formdata = new FormData(form); // ✅ Create FormData from form
        formdata.append("action", "StudentInsert");
        formdata.append("StudentInsert", "Caaqil123");

        $.ajax({
            type: "POST",
            url: "../apis/s_api.php",
            data: formdata,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                if(response.status === "success"){
                    Swal.fire({
                    title: "Good job!",
                    text: response.message,
                    icon: "success"
                    });
                  readyRquest();
                    $('#StudentForm')[0].reset();
                } else {
                     Swal.fire({
                    title: "I am Sorry!",
                    text: response.message,
                    icon: "error"
                    });
                }
            }
        });
    });
 // ============ Student Crud Logic End Here ===================
});
