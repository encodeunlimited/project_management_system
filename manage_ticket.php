<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM ticket_list where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-ticket">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="form-group">
			<label for="">Subject</label>
			<input type="text" class="form-control form-control-sm" name="subject" required value="<?php echo isset($subject) ? $subject : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="">Description</label>
			<textarea name="description" id="" cols="30" rows="10" required class="summernote form-control">
				<?php echo isset($description) ? $description : '' ?>
			</textarea>
		</div>
		<div class="form-group">
			<label for="">Type</label>
			<select required name="type" id="type" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Request a Change</option>
				<option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Report a Bug</option>
				<option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>Ask a Question</option>
				<option value="4" <?php echo isset($type) && $type == 4 ? 'selected' : '' ?>>Risk on Issue</option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Status</label>
			<select required name="status" id="status" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>New</option>
				<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>Open</option>
				<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Re-Open</option>
				<option value="4" <?php echo isset($status) && $status == 4 ? 'selected' : '' ?>>Waiting Assesment</option>
				<option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Resolved</option>
				<option value="6" <?php echo isset($status) && $status == 6 ? 'selected' : '' ?>>Closed</option>
				<option value="7" <?php echo isset($status) && $status == 7 ? 'selected' : '' ?>>Fixed</option>
				<option value="8" <?php echo isset($status) && $status == 8 ? 'selected' : '' ?>>Canceled</option>
			</select>
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {


		$('.summernote').summernote({
			height: 200,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ol', 'ul', 'paragraph', 'height']],
				['table', ['table']],
				['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
			]
		})
	})

	$('#manage-ticket').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_ticket',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Data successfully saved', "success");
					setTimeout(function() {
						location.reload()
					}, 1500)
				}
			}
		})
	})
</script>