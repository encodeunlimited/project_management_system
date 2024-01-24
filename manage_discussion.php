<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM discussion_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid narrow-container">
	<form action="" id="manage-discussion">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
					<?php if(!isset($_GET['tid'])): ?>
					 <div class="form-group">
		              <label for="" class="control-label">Discussion</label>
		              <select required class="form-control form-control-sm select2" name="task_id">
		              	<option></option>
		              	<?php 
		              	$tasks = $conn->query("SELECT * FROM task_list where project_id = {$_GET['pid']} order by task asc ");
		              	while($row= $tasks->fetch_assoc()):
		              	?>
		              	<option required value="<?php echo $row['id'] ?>" <?php echo isset($task_id) && $task_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['task']) ?></option>
		              	<?php endwhile; ?>
		              </select>
		            </div>
		            <?php else: ?>
					<input  type="hidden" name="task_id"  value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : '' ?>">
		            <?php endif; ?>
					<div class="form-group">
						<label for="">Subject</label>
						<input type="text" class="form-control form-control-sm" name="subject" required value="<?php echo isset($subject) ? $subject : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Comment/Progress Description</label>
						<textarea required name="comment" id="" cols="30" rows="10" class="summernote form-control" required="">
							<?php echo isset($comment) ? $comment : '' ?>
						</textarea>
					</div>
					<div class="col-lg-12 text-right justify-content-center d-flex">
			<button class="btn btn-primary mr-2">Save</button>
			<button class="btn btn-secondary" type="button" onclick="$('#uni_modal').modal('hide')">Cancel</button>
			
		</div>
	</form>
</div>

<script>
	$(document).ready(function(){
	$('.summernote').summernote({
        height: 200,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    })
     $('.select2').select2({
	    placeholder:"Please select here",
	    width: "100%"
	  });
     })


    $('#manage-discussion').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'ajax.php?action=save_discussion',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
    	})
    })
</script>