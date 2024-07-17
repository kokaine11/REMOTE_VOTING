<!-- Reset -->
<div class="modal fade" id="reset">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="resetForm" method="POST" action="verify_password.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Reseting...</b></h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <p>RESET VOTES</p>
                        <h4>This will delete all votes</h4>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="curr_password" class="col-sm-3 control-label">Current Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="curr_password" name="curr_password" placeholder="input current password to reset" required>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#resetForm').submit(function(e){
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: 'verify_password.php',
            data: $(this).serialize(),
            success: function(response){
                var result = JSON.parse(response);
                if(result.success) {
                    alert('Votes have been reset successfully.');
                    location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
    });
});
</script>