<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM task_list where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}

$project_query = $conn->query("SELECT * FROM project_list where id = {$_GET['pid']}");
$project = $project_query->fetch_assoc();

// // Fetch user details from users table
$users_query = $conn->query("SELECT * FROM users");
$users = array();
while ($row = $users_query->fetch_assoc()) {
	$users[$row['id']] = $row;
}

$recipients = array();
$recipients[] = $users[$project['manager_id']]['email']; // Add manager's email
$userIds = explode(',', $project['user_ids']); // Assuming user_ids is a comma-separated list of user IDs
foreach ($userIds as $userId) {
	$recipients[] = $users[$userId]['email']; // Add user's email
}
$clientIds = explode(',', $project['client_ids']); // Assuming user_ids is a comma-separated list of user IDs
foreach ($clientIds as $clientId) {
	$recipients[] = $users[$clientId]['email']; // Add user's email
}


// Encode the recipients array to JSON
$recipients_json = json_encode($recipients);
$projectIdName = $project['id'] . ' - ' . $project['name'];
$projectIdNameJSON = json_encode($projectIdName);

?>

<div class="container-fluid">
	<form action="" id="manage-task">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="form-group">
			<label for="">Task</label>
			<input type="text" class="form-control form-control-sm" name="task" required value="<?php echo isset($task) ? $task : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="">Description</label>
			<textarea required name="description" id="" cols="30" rows="10" class="summernote form-control">
				<?php echo isset($description) ? $description : '' ?>
			</textarea>
		</div>
		<div class="form-group">
			<label for="">Type</label>
			<select required name="type" id="type" class="custom-select custom-select-sm">
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
			<select required name="priority" id="priority" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($priority) && $priority == 1 ? 'selected' : '' ?>>Unknown</option>
				<option value="2" <?php echo isset($priority) && $priority == 2 ? 'selected' : '' ?>>Low</option>
				<option value="3" <?php echo isset($priority) && $priority == 3 ? 'selected' : '' ?>>Medium</option>
				<option value="4" <?php echo isset($priority) && $priority == 4 ? 'selected' : '' ?>>High</option>
				<option value="5" <?php echo isset($priority) && $priority == 5 ? 'selected' : '' ?>>Urgent</option>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Start Date</label>
			<input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" required value="<?php echo isset($start_date) ? date("Y-m-d", strtotime($start_date)) : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Due Date</label>
			<input type="date" class="form-control form-control-sm" autocomplete="off" name="due_date" required value="<?php echo isset($due_date) ? date("Y-m-d", strtotime($due_date)) : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Progress</label>
			<input type="range" class="form-control-range" ... ... name="progress" min="0" max="100" required value="<?php echo isset($progress) ? $progress : '0' ?>" oninput="updateProgressValue(this.value)">
			<output for="progress"><?php echo isset($progress) ? $progress : '0' ?>%</output>
		</div>

		<script>
			function updateProgressValue(value) {
				document.querySelector('output[for="progress"]').value = value + '%';
			}
		</script>


		<div class="form-group">
			<label for="">Status</label>
			<select required name="status" id="status" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Pending</option>
				<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>On-Progress</option>
				<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Done</option>
			</select>
		</div>

		<div class="col-lg-12 text-right justify-content-center d-flex">
			<button class="btn btn-primary mr-2">Save</button>
			<button class="btn btn-secondary" type="button" onclick="closeModalAndRefresh()">Cancel</button>

			<script>
				function closeModalAndRefresh() {
					$('#uni_modal').modal('hide');
					location.reload(); // This will refresh the view_project.php file
				}
			</script>

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


		var formData = new FormData(this)

		var projectIdName = <?php echo $projectIdNameJSON ?>
		//var recipients = []
		var recipients = <?php echo json_encode($recipients) ?>

		var status = document.getElementById('status')
        var selectedstatus = status.options[status.selectedIndex].text

		var type = document.getElementById('type')
        var selectedtype = type.options[type.selectedIndex].text

		var priority = document.getElementById('priority')
        var selectedpriority = priority.options[type.selectedIndex].text


		$.ajax({
			url: 'ajax.php?action=save_task',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				alert_toast('Data successfully saved and email sent', "success");

				setTimeout(function() {
					location.reload()
				}, 1500);
				if (resp == 1) {
					// Project saved successfully, now send the email
					$.ajax({
						url: 'send_email.php', // Assuming the email sending function is accessible via this URL
						data: {
							recipients: recipients,
							subject: 'New Task Assigned - '+' to '+projectIdName,//+ formData.get('task')
							body: '<p>A new Task has been assigned to you:</p>'+
							'<table style="border-collapse:collapse;border-spacing:0" class="tg"><thead><tr><th style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Task Name</th><th style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('task') + '</th></tr></thead><tbody><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Start date</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('start_date') + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">End date</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('due_date') + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Type</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + selectedtype + '</td></tr><tr><td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Priority</td><td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + selectedpriority + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Status</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + selectedstatus + '</td></tr><tr><td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Progress</td><td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('progress') + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Description</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('description') + '</td></tr></tbody></table>',
						},
						method: 'POST',
						success: function(emailResp) {
							alert_toast('Email sent successfully', "success");
						}
					});
				}
			}
		});

		// $.ajax({
		// 	url: 'ajax.php?action=save_task',
		// 	data: new FormData($(this)[0]),
		// 	cache: false,
		// 	contentType: false,
		// 	processData: false,
		// 	method: 'POST',
		// 	type: 'POST',
		// 	success: function(resp) {
		// 		if (resp == 1) {
		// 			alert_toast('Data successfully saved', "success");
		// 			setTimeout(function() {
		// 				location.reload()
		// 			}, 1500)
		// 		}
		// 	}
		// })
	})
</script>