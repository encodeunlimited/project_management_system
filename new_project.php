<?php if (!isset($conn)) {
	include 'db_connect.php';
} ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-project">

				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Name</label>
							<input type="text" class="form-control form-control-sm" name="name" required value="<?php echo isset($name) ? $name : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Status</label>
							<select name="status" id="status" class="custom-select custom-select-sm">
								<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Pending</option>
								<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>On-Hold</option>
								<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Done</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Start Date</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" required value="<?php echo isset($start_date) ? date("Y-m-d", strtotime($start_date)) : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Review Brief Date</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="review_brief_date" required value="<?php echo isset($review_brief_date) ? date("Y-m-d", strtotime($review_brief_date)) : '' ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Design Date</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="design_date" required value="<?php echo isset($design_date) ? date("Y-m-d", strtotime($design_date)) : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Development Date</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="development_date" required value="<?php echo isset($development_date) ? date("Y-m-d", strtotime($development_date)) : '' ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Site Test Date</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="site_test_date" required value="<?php echo isset($site_test_date) ? date("Y-m-d", strtotime($site_test_date)) : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">UAT Date</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="uat_date" required value="<?php echo isset($uat_date) ? date("Y-m-d", strtotime($uat_date)) : '' ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Go Live Date</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="go_live_date" value="<?php echo isset($go_live_date) ? date("Y-m-d", strtotime($go_live_date)) : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">End Date</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" required value="<?php echo isset($end_date) ? date("Y-m-d", strtotime($end_date)) : '' ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<?php if ($_SESSION['login_type'] == 1) : ?>
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="control-label">Project Manager</label>
								<select required class="form-control form-control-sm select2" name="manager_id" id="manager_id">
									<option></option>
									<?php
									$managers = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 2 order by concat(firstname,' ',lastname) asc ");
									while ($row = $managers->fetch_assoc()) :
									?>
										<option required value="<?php echo $row['id'] ?>" data-email="<?php echo $row['email'] ?>" <?php echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>
					<?php else : ?>
						<input type="hidden" name="manager_id" value="<?php echo $_SESSION['login_id'] ?>">
					<?php endif; ?>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Project Team Members</label>
							<select required class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]" id="user_ids">
								<option></option>
								<?php
								$employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
								while ($row = $employees->fetch_assoc()) :
								?>
									<option required value="<?php echo $row['id'] ?>" data-email="<?php echo $row['email'] ?>" <?php echo isset($user_ids) && in_array($row['id'], explode(',', $user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
								<?php endwhile; ?>
							</select>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Project Clients</label>
							<select required class="form-control form-control-sm select2" multiple="multiple" name="client_ids[]" id="client_ids">
								<option></option>
								<?php
								$clients = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 4 order by concat(firstname,' ',lastname) asc ");
								while ($row = $clients->fetch_assoc()) :
								?>
									<option required value="<?php echo $row['id'] ?>" data-email="<?php echo $row['email'] ?>" <?php echo isset($client_ids) && in_array($row['id'], explode(',', $client_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10">
						<div class="form-group">
							<label for="" class="control-label">Description</label>
							<textarea name="description" id="" cols="30" rows="10" required class="summernote form-control">
						<?php echo isset($description) ? $description : '' ?>
					</textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="card-footer border-top border-info">
			<div class="d-flex w-100 justify-content-center align-items-center">
				<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project">Save</button>
				<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script>
	// $('#manage-project').submit(function(e){
	// 	e.preventDefault()
	// 	start_load()
	// 	$.ajax({
	// 		url:'ajax.php?action=save_project',
	// 		data: new FormData($(this)[0]),
	// 	    cache: false,
	// 	    contentType: false,
	// 	    processData: false,
	// 	    method: 'POST',
	// 	    type: 'POST',
	// 		success:function(resp){
	// 			if(resp == 1){
	// 				alert_toast('Data successfully saved',"success");
	// 				setTimeout(function(){
	// 					location.href = 'index.php?page=project_list'
	// 				},2000)
	// 			}
	// 		}
	// 	})
	// })
	

	$('#manage-project').submit(function(e) {
		e.preventDefault();
		start_load();
		var form = $(this)[0];
		var formData = new FormData(form);
		var recipients = [];

		// Extract email addresses from user_ids dropdown
		$('#manager_id option:selected, #user_ids option:selected, #client_ids option:selected').each(function() {
			var email = $(this).data('email');
			if (email) {
				recipients.push(email);
			}
		});

		formData.append('name', $('input[name="name"]').val());
		formData.append('description', $('textarea[name="description"]').val());

		if (formData.get('name') === '') {
			alert_toast('Name is required', "error");
			//$('input[name="name"]').focus(); // Set focus on the "Name" text field
			return;
		}

		$.ajax({
			url: 'ajax.php?action=save_project',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				alert_toast('Data successfully saved and email sent', "success");

				setTimeout(function() {
					location.href = 'index.php?page=project_list';
				}, 2000);
				if (resp == 1) {
					// Project saved successfully, now send the email
					$.ajax({
						url: 'send_email.php', // Assuming the email sending function is accessible via this URL
						data: {
							recipients: recipients,
							subject: 'New Project Assigned - ' + formData.get('name'),
							body: 'A new project has been assigned to You - Name: ' + formData.get('name') + ' - Description: ' + formData.get('description'),
						},
						method: 'POST',
						success: function(emailResp) {
							alert_toast('Email sent successfully', "success");
						}
					});
				}
			}
		});
	});
</script>