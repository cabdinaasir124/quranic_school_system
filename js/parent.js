$(document).ready(function () {
// Viewe Parents Start Here
$(document).on("click","#ViewParent",function(e){
    e.preventDefault(this);
    // alert("click");
    let Parent_Id=$(this).attr("parentId");
    // console.log(Parent_Id);
    $.ajax({
        type: "POST",
        url: "../apis/p_api.php",
        data:{"action":"ViewParent","parentId":Parent_Id},
        dataType: "html",
        success: function (response) {
            // console.log(response);
            $("#ViewBodyParent").html(response);
        }
    });
})
// Viewe Parents End Here





// Update Logic Start Here
$(document).on("submit","#updateParentForm",function(e){
    e.preventDefault();
    // alert("click");
    let formdata=new FormData(this);
    formdata.append("action","UpdateP");
    // console.log(formdata);
    $.ajax({
        type: "POST",
        url: "../apis/p_api.php",
        data:formdata,
        contentType:false,
        processData:false,
        dataType: "json",
        success: function (response) {
            if(response.status == "success"){
                Swal.fire({
                title: "Good job!",
                text: response.message,
                icon: "success"
                });
            }else if(response.status =="error"){
                Swal.fire({
                    title: "I Am Sorry!",
                    text: response.message,
                    icon: "error"
                    });
            }
        }
    });
})
// Update Logic End Here



// Parent Read Update Start Here
$(document).on("click","#UpdateParent",function(e){
    e.preventDefault();
    // alert("click");
    let Parent_Id=$(this).attr("parentId");
    // console.log(Parent_Id);
    $.ajax({
        type: "POST",
        url: "../apis/p_api.php",
        data:{"action":"ReadUpdate","parentId":Parent_Id},
        dataType: "html",
        success: function (response) {
            // console.log(response.message);
            $("#ReadUpdateBody").html(response);
        }
    });
})
// Parent Read Update End Here



 
    // Delete Logic Start Here
     $(document).on("click","#DeleteParent",function(e){
        e.preventDefault(this);
        // alert("click");
        let Parent_Id=$(this).attr("parentId");
        // console.log(Parent_Id);
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
    url: "../apis/p_api.php",
    data:{"action":"DeleteParent","parentId": Parent_Id},
    dataType: "json",
    success: function (response) {
        if(response.status =="success"){
            Swal.fire({
            title: "Good job!",
            text: response.message,
            icon: "success"
            });
            ParentRead();
        }else if(response.status == "error"){
            Swal.fire({
            title: "I Am Sorry!",
            text:response.message,
            icon: "error"
            });
        }
    }
   });
  }
});
     })
    // Delete Logic End Here



//  Read Logic Start Here
ParentRead();
function ParentRead(){
    $.ajax({
        type: "POST",
        url: "../apis/p_api.php",
        data:{"action":"ReadParent"},
        dataType: "html",
        success: function (response) {
            $("#ReadParents").html(response);
        }
    });
}
//  Read Logic end Here

    // Insert Logic Start Here
    $(document).on("submit","#AddParentForm",function(e){
        e.preventDefault();
        // console.log("click");
        let formdata=new FormData(this);
        formdata.append("action","InertParent");
        formdata.append("InertParent","Quranic!@#");
        // console.log(formdata);
        $.ajax({
            type: "POST",
            url: "../apis/p_api.php",
            data:formdata,
            contentType:false,
            processData:false,
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                if(response.status == "success"){
                    swal.fire({
                        title:"Good Luck",
                        text:response.message,
                        icon:"success",
                    })
                    ParentRead();
                    $("#AddParentForm")[0].reset();
                }else if(response.status == "error"){
                     swal.fire({
                        title:"I Am Sorry",
                        text:response.message,
                        icon:"error",
                    })
                }
            }
        });
    })
     // Insert Logic End Here
});