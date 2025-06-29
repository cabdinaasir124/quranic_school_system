$(document).ready(function () {
    Allstudents();
    function Allstudents(){
        $.ajax({
            type: "POST",
            url: "../apis/dashboard_api.php",
            data:{"action":"AllStudents"},
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                $("#Snumber").html(response.message);
            }
        });
    }
    Allteachers();
    function Allteachers(){
        $.ajax({
            type: "POST",
            url: "../apis/dashboard_api.php",
            data:{"action":"Allteachers"},
            dataType: "json",
            success: function (response) {
                // console.log(response.message);
                $("#Tnumber").html(response.message);
            }
        });
    }
});