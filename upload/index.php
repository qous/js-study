<script src="jquery-1.11.3.min.js"></script>
<script src="ajaxFileUpload.js"></script>

<form enctype="multipart/form-data" action="upload.php" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="myfile" type="file" id="myfile" onchange="myfun(this.files[0])"/>
    <!-- <input type="submit" value="Send File" /> -->
</form>

<script>
$(document).ready(function(){
    
});
function myfun(obj) {
    var fd = new FormData();
    fd.append("myfile", obj);
    $.ajax({
        url : 'upload.php',
        type: "POST",
        // dataType: 'json',
        processData: false,
        contentType: false,
        data: fd,
        success: function (data) {
            console.log(data);
        },
        complete: function(xhr, status){
            console.log(xhr);
            console.log(status)
        }
    })
}
</script>