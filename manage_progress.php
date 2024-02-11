<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM user_productivity where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}

	// $project_id = $_GET['pid'];
	// // Fetch project details from project_list table

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
$login_name = json_encode($_GET['login_name']);
$projectIdName = $project['id'] . ' - ' . $project['name'];
$projectIdNameJSON = json_encode($projectIdName);
//$pro_dat = json_encode($projectIdName);

//echo $projectIdName;


?>
<div class="container-fluid">
	<form action="" id="manage-progress">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-5">
					<?php if (!isset($_GET['tid'])) : ?>
						<div class="form-group">
							<label for="" class="control-label">Project Task</label>
							<select class="form-control form-control-sm select2" name="task_id">
								<option></option>
								<?php
								$tasks = $conn->query("SELECT * FROM task_list where project_id = {$_GET['pid']} order by task asc ");
								while ($row = $tasks->fetch_assoc()) :
								?>
									<option value="<?php echo $row['id'] ?>" <?php echo isset($task_id) && $task_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['task']) ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					<?php else : ?>
						<input type="hidden" name="task_id" value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : '' ?>">
					<?php endif; ?>
					<div class="form-group">
						<label for="">Subject</label>
						<input type="text" class="form-control form-control-sm" name="subject" value="<?php echo isset($subject) ? $subject : date("Y-m-d", strtotime(date('Y-m-d'))) . ' Progress' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Date</label>
						<input type="date" class="form-control form-control-sm" name="date" value="<?php echo isset($date) ? date("Y-m-d", strtotime($date)) : date("Y-m-d", strtotime(date('Y-m-d'))) ?>" required>
					</div>
					<div class="form-group">
						<label for="">Start Time</label>
						<input type="time" class="form-control form-control-sm" name="start_time" value="<?php echo isset($start_time) ? date("H:i", strtotime("2020-01-01 " . $start_time)) : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">End Time</label>
						<input type="time" class="form-control form-control-sm" name="end_time" value="<?php echo isset($end_time) ? date("H:i", strtotime("2020-01-01 " . $end_time)) : '' ?>" required>
					</div>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<label for="">Comment/Progress Description</label>
						<textarea name="comment" id="" cols="30" rows="10" required class="summernote form-control"><?php echo isset($comment) ? $comment : '' ?></textarea>
					</div>
				</div>
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
		$('.select2').select2({
			placeholder: "Please select here",
			width: "100%"
		});
	})

	$('#manage-progress').submit(function(e) {
		e.preventDefault()
		start_load()
		
		var formData = new FormData(this)

		var projectIdName = <?php echo $projectIdNameJSON ?>

		var login_name = <?php echo json_encode($login_name) ?>

		var recipients = <?php echo json_encode($recipients) ?>
		

		// $.ajax({
		// 	url: 'ajax.php?action=save_progress',
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

		$.ajax({
			url: 'ajax.php?action=save_progress',
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
				}, 2000);
				if (resp == 1) {
					// Project saved successfully, now send the email
					$.ajax({
						url: 'send_email.php', // Assuming the email sending function is accessible via this URL
						data: {
							recipients: recipients,
							subject: 'New Productivity Assigned - '+formData.get('subject')+' to '+projectIdName,
							// + formData.get('name')
							body: '<p>A New Productivity Assigned to you:</p>'+
							'<table style="border-collapse:collapse;border-spacing:0" class="tg"><thead><tr><th style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Productivity Subject</th><th style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('subject') + '</th></tr></thead><tbody><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">User</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + login_name + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Date</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('date') + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Start Time</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('start_time') + '</td></tr><tr><td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">End Time</td><td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('end_time') + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Description</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('comment') + '</td></tr></tbody></table>',
						},
						method: 'POST',
						success: function(emailResp) {
							alert_toast('Email sent successfully', "success");
						}
					});
				}
			}
		});
	})
</script>