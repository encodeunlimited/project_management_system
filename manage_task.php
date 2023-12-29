<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM task_list where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-task">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="form-group">
			<label for="">Task</label>
			<input type="text" class="form-control form-control-sm" name="task" value="<?php echo isset($task) ? $task : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="">Description</label>
			<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
				<?php echo isset($description) ? $description : '' ?>
			</textarea>
		</div>
		<div class="form-group">
			<label for="">Type</label>
			<select name="type" id="type" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Change</option>
				<option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Plugin</option>
				<option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>Task</option>
				<option value="4" <?php echo isset($type) && $type == 4 ? 'selected' : '' ?>>Bug</option>
				<option value="5" <?php echo isset($type) && $type == 5 ? 'selected' : '' ?>>Idea</option>
				<option value="6" <?php echo isset($type) && $type == 6 ? 'selected' : '' ?>>Quote</option>
				<option value="7" <?php echo isset($type) && $type == 7 ? 'selected' : '' ?>>Issue</option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Priority</label>
			<select name="priority" id="priority" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($priority) && $priority == 1 ? 'selected' : '' ?>>Unknown</option>
				<option value="2" <?php echo isset($priority) && $priority == 2 ? 'selected' : '' ?>>Low</option>
				<option value="3" <?php echo isset($priority) && $priority == 3 ? 'selected' : '' ?>>Medium</option>
				<option value="4" <?php echo isset($priority) && $priority == 4 ? 'selected' : '' ?>>High</option>
				<option value="5" <?php echo isset($priority) && $priority == 5 ? 'selected' : '' ?>>Urgent</option>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Start Date</label>
			<input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d", strtotime($start_date)) : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Due Date</label>
			<input type="date" class="form-control form-control-sm" autocomplete="off" name="due_date" value="<?php echo isset($due_date) ? date("Y-m-d", strtotime($due_date)) : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Progress</label>
			<input type="range" class="form-control-range" ... ... name="progress" min="0" max="100" value="<?php echo isset($progress) ? $progress : '0' ?>" oninput="updateProgressValue(this.value)">
			<output for="progress"><?php echo isset($progress) ? $progress : '0' ?>%</output>
		</div>

		<script>
			function updateProgressValue(value) {
				document.querySelector('output[for="progress"]').value = value + '%';
			}
		</script>


		<div class="form-group">
			<label for="">Status</label>
			<select name="status" id="status" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Pending</option>
				<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>On-Progress</option>
				<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Done</option>
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

	$('#manage-task').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_task',
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