<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM ticket_list where id = " . $_GET['id'])->fetch_array();
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
$login_name = json_encode($_GET['login_name']);

$projectIdName = $project['id'] . ' - ' . $project['name'];
$projectIdNameJSON = json_encode($projectIdName);


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

	$('#manage-ticket').submit(function(e) {
		e.preventDefault()
		start_load()
		var login_name = <?php echo json_encode($login_name) ?>
		


		var formData = new FormData(this)
		//var recipients = []
		var projectIdName = <?php echo $projectIdNameJSON ?>

		var recipients = <?php echo json_encode($recipients) ?>

		var status = document.getElementById('status')
        var selectedstatus = status.options[status.selectedIndex].text

		var type = document.getElementById('type')
        var selectedtype = type.options[type.selectedIndex].text
		

		$.ajax({
			url: 'ajax.php?action=save_ticket',
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
							subject: 'New Ticket Assigned - ' + formData.get('subject')+' to '+projectIdName,
							// + formData.get('name')
							body: '<p>A new Ticket has been assigned to you:</p>' + '<table style="border-collapse:collapse;border-spacing:0" class="tg"><thead><tr><th style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Ticket Subject</th><th style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('subject') + '</th></tr></thead><tbody><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Ticket open by</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + login_name + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Ticket open date and time</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + new Date().toLocaleString() + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Type</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + selectedtype + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Status</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + selectedstatus + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Description</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('description') + '</td></tr></tbody></table>',
							//'<table style="border-collapse:collapse;border-spacing:0" class="tg"><thead><tr><th style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Project Name</th><th style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal" colspan="3">' + formData.get('name') + '</th></tr></thead><tbody><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Start Date</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('start_date') + '</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal" colspan="2" rowspan="2"></td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">End Date</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">' + formData.get('end_date') + '</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal" rowspan="2">Members</td><td style="background-color:#fffc9e;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Manager</td><td style="background-color:#9aff99;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Client/s</td><td style="background-color:#96fffb;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Developer/s</td></tr><tr><td style="background-color:#fffc9e;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">'+ managerNames +'</td><td style="background-color:#9aff99;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">'+ clientNames+'</td><td style="background-color:#96fffb;border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">'+ userNames+'</td></tr><tr><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal">Discription</td><td style="border-color:inherit;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;text-align:left;vertical-align:top;word-break:normal" colspan="3">' + formData.get('description') + '</td></tr></tbody></table>',
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
		// 	url: 'ajax.php?action=save_ticket',
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