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



// ============= Class Management Logic Start Here ===================
$(document).ready(function () {
  function loadClasses() {
    $.get('../apis/c_api.php', function(data) {
      $('#classTable').html(data);
    });
  }

  $('#addClassModal').on('show.bs.modal', function () {
    $.get('../apis/c_api.php?mode=generate_code', function(response) {
      const data = JSON.parse(response);
      $('#class_code').val(data.class_code);
    });
  });

  $('#addClassForm').submit(function(e) {
    e.preventDefault();
    $.post('../apis/c_api.php', $(this).serialize(), function(res) {
      const data = JSON.parse(res);
      if (data.status === 'success') {
        Swal.fire('Class Added!', 'Code: ' + data.class_code, 'success');
        $('#addClassModal').modal('hide');
        $('#addClassForm')[0].reset();
        loadClasses();
      } else {
        Swal.fire('Error', data.message, 'error');
      }
    });
  });

  $(document).on('click', '.btn-delete', function() {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "This action can't be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        $.post('../apis/c_api.php', { delete_id: id }, function(res) {
          if (res.trim() === 'success') {
            Swal.fire('Deleted!', 'Class deleted.', 'success');
            loadClasses();
          } else {
            Swal.fire('Error!', 'Failed to delete: ' + res, 'error');
          }
        });
      }
    });
  });

  $(document).on('click', '.editBtn', function() {
    let btn = $(this);
    $('#edit_id').val(btn.data('id'));
    $('#edit_class_name').val(btn.data('name'));
    $('#edit_class_code').val(btn.data('code'));
    $('#edit_class_type').val(btn.data('type'));
    $('#edit_level').val(btn.data('level'));
    $('#edit_teacher_id').val(btn.data('teacher'));
    $('#edit_max_students').val(btn.data('max'));
    $('#edit_gender').val(btn.data('gender'));
    $('#edit_time_start').val(btn.data('start'));
    $('#edit_time_end').val(btn.data('end'));
    $('#edit_room').val(btn.data('room'));
    $('#edit_status').val(btn.data('status'));

    // Reset checkboxes
    $('.edit-day').prop('checked', false);
    let daysArray = btn.data('days').split(',');
    daysArray.forEach(day => $('#edit_day_' + day.trim()).prop('checked', true));

    $('#editClassModal').modal('show');
  });

  $('#editClassForm').submit(function(e) {
    e.preventDefault();
    $.post('../apis/c_api.php', $(this).serialize(), function(res) {
      const data = JSON.parse(res);
      if (data.status === 'success') {
        $('#editClassModal').modal('hide');
        Swal.fire('Updated!', 'Class has been updated.', 'success');
        loadClasses();
      } else {
        Swal.fire('Error!', data.message || 'Update failed.', 'error');
      }
    });
  });

  $(document).on('click', '.viewClassBtn', function () {
  $('#v_name').text($(this).data('name'));
  $('#v_code').text($(this).data('code'));
  $('#v_type').text($(this).data('type'));
  $('#v_level').text($(this).data('level'));
  $('#v_teacher').text($(this).data('teacher'));
  $('#v_max').text($(this).data('max'));
  $('#v_status').text($(this).data('status'));
  $('#v_gender').text($(this).data('gender'));
  $('#v_days').text($(this).data('days'));
  $('#v_time').text($(this).data('time'));
  $('#v_room').text($(this).data('room'));

  // Show modal (optional, in case it's not shown by button)
  $('#viewClassModal').modal('show');
});


  // Initial load
  loadClasses();
});
// ============= Class Management Logic End Here ===================