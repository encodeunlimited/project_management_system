<?php

include 'db_connect.php';
$stat = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done");
$qry = $conn->query("SELECT * FROM project_list where id = " . $_GET['id'])->fetch_array();


foreach ($qry as $k => $v) {
	$$k = $v;
}
$tprog = $conn->query("SELECT * FROM task_list where project_id = {$id}")->num_rows;
$cprog = $conn->query("SELECT * FROM task_list where project_id = {$id} and status = 3")->num_rows;
$prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
$prog = $prog > 0 ?  number_format($prog, 2) : $prog;
$prod = $conn->query("SELECT * FROM user_productivity where project_id = {$id}")->num_rows;
if ($status == 0 && strtotime(date('Y-m-d')) >= strtotime($start_date)) :
	if ($prod  > 0  || $cprog > 0)
		$status = 2;
	else
		$status = 1;
elseif ($status == 0 && strtotime(date('Y-m-d')) > strtotime($end_date)) :
	$status = 4;
endif;
$manager = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id = $manager_id");
$manager = $manager->num_rows > 0 ? $manager->fetch_array() : array();

?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-8" style="max-height: 450px; overflow-y: auto;">
			<div class="callout callout-info">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-4">
							<dl>
								<dt><b class="border-bottom border-primary">Project Name</b></dt>
								<dd><?php echo ucwords($name) ?></dd>
								<dt><b class="border-bottom border-primary">Project Manager</b></dt>
								<dd>
									<?php if (isset($manager['id'])) : ?>
										<div class="d-flex align-items-center mt-1">
											<img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="assets/uploads/<?php echo $manager['avatar'] ?>" alt="Avatar">
											<b><?php echo ucwords($manager['name']) ?></b>
										</div>
									<?php else : ?>
										<small><i>Manager Deleted from Database</i></small>
									<?php endif; ?>
								</dd>

								<dt><b class="border-bottom border-primary">Description</b></dt>
								<dd><?php echo html_entity_decode($description) ?></dd>
							</dl>

						</div>
						<div class="col-md-4">
							<dl>
								<dt><b class="border-bottom border-primary">Start Date</b></dt>
								<dd><?php echo date("F d, Y", strtotime($start_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Review Brief Date</b></dt>
								<dd><?php echo date("F d, Y", strtotime($review_brief_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Design Date</b></dt>
								<dd><?php echo date("F d, Y", strtotime($design_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Development Date</b></dt>
								<dd><?php echo date("F d, Y", strtotime($development_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Status</b></dt>
								<dd>
									<?php
									if ($stat[$status] == 'Pending') {
										echo "<span class='badge badge-secondary'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'Started') {
										echo "<span class='badge badge-primary'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'On-Progress') {
										echo "<span class='badge badge-info'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'On-Hold') {
										echo "<span class='badge badge-warning'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'Over Due') {
										echo "<span class='badge badge-danger'>{$stat[$status]}</span>";
									} elseif ($stat[$status] == 'Done') {
										echo "<span class='badge badge-success'>{$stat[$status]}</span>";
									}
									?>
								</dd>
							</dl>

						</div>
						<div class="col-md-4">
							<dl>
								<dt><b class="border-bottom border-primary">Site Test Date</b></dt>
								<dd><?php echo date("F d, Y", strtotime($site_test_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">UAT Date</b></dt>
								<dd><?php echo date("F d, Y", strtotime($uat_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">Go Live Date</b></dt>
								<dd><?php echo date("F d, Y", strtotime($go_live_date)) ?></dd>
							</dl>
							<dl>
								<dt><b class="border-bottom border-primary">End Date</b></dt>
								<dd><?php echo date("F d, Y", strtotime($end_date)) ?></dd>
							</dl>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="col-md-4">
			<div class="callout callout-warning">
				<div class="card-header">
					<span><b>Client/s:</b></span>
					<div class="card-tools">
						<!-- <button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="manage_team">Manage</button> -->
					</div>
				</div>
				<div class="card-body" style="max-height: 300px; overflow-y: auto;">
					<ul class="users-list clearfix">
						<?php
						if (!empty($client_ids)) :
							$clients = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id in ($client_ids) order by concat(firstname,' ',lastname) asc");
							while ($row = $clients->fetch_assoc()) :
						?>
								<li>
									<img src="assets/uploads/<?php echo $row['avatar'] ?>" alt="User Image">
									<a class="users-list-name" href="javascript:void(0)"><?php echo ucwords($row['name']) ?></a>
									<!-- <span class="users-list-date">Today</span> -->
								</li>
						<?php
							endwhile;
						endif;
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="card card-outline card-secondary">
				<div class="card-header">
					<span><b>Team Member/s:</b></span>
					<div class="card-tools">
						<!-- <button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="manage_team">Manage</button> -->
					</div>
				</div>
				<div class="card-body" style="max-height: 300px; overflow-y: auto;">
					<ul class="users-list clearfix">
						<?php
						if (!empty($user_ids)) :
							$members = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id in ($user_ids) order by concat(firstname,' ',lastname) asc");
							while ($row = $members->fetch_assoc()) :
						?>
								<li>
									<img src="assets/uploads/<?php echo $row['avatar'] ?>" alt="User Image">
									<a class="users-list-name" href="javascript:void(0)"><?php echo ucwords($row['name']) ?></a>
									<!-- <span class="users-list-date">Today</span> -->
								</li>
						<?php
							endwhile;
						endif;
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-outline card-danger">
				<div class="card-header">
					<span><b>Ticket List:</b></span>
					<?php if ($_SESSION['login_type'] != 3) : ?>
						<div class="card-tools">
							<button class="btn btn-danger bg-gradient-danger btn-sm" type="button" id="new_ticket"><i class="fa fa-plus"></i> New Ticket</button>
						</div>
					<?php endif; ?>
				</div>
				<div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
					<div class="table-responsive">
						<table class="table table-condensed m-0 table-hover">
							<colgroup>
								<col width="5%">
								<col width="20%">
								<col width="40%">
								<col width="10%">
								<col width="10%">
								<col width="15%">
							</colgroup>
							<thead>
								<th>#</th>
								<th>Subject</th>
								<th>Description</th>
								<th>Type</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$tickets = $conn->query("SELECT * FROM ticket_list where project_id = {$id} order by subject asc");
								while ($row = $tickets->fetch_assoc()) :
									$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
									unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
									$desc = strtr(html_entity_decode($row['description']), $trans);
									$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class=""><b><?php echo ucwords($row['subject']) ?></b></td>
										<td class="">
											<p class="truncate"><?php echo strip_tags($desc) ?></p>
										</td>
										<td>
											<?php
											if ($row['type'] == 1) {
												echo "<span class='badge badge-secondary'>Request a Change</span>";
											} elseif ($row['type'] == 2) {
												echo "<span class='badge badge-primary'>Report a Bug</span>";
											} elseif ($row['type'] == 3) {
												echo "<span class='badge badge-success'>Ask a Question</span>";
											} elseif ($row['type'] == 4) {
												echo "<span class='badge badge-danger'>Risk on Issue</span>";
											}
											?>
										</td>
										<td>
											<?php
											if ($row['status'] == 1) {
												echo "<span class='badge badge-success'>New</span>";
											} elseif ($row['status'] == 2) {
												echo "<span class='badge badge-warning'>Open</span>";
											} elseif ($row['status'] == 3) {
												echo "<span class='badge badge-danger'>Re-Open</span>";
											} elseif ($row['status'] == 4) {
												echo "<span class='badge badge-primary'>Waiting Assesment</span>";
											} elseif ($row['status'] == 5) {
												echo "<span class='badge badge-success'>Resolved</span>";
											} elseif ($row['status'] == 6) {
												echo "<span class='badge badge-secondary'>Closed</span>";
											} elseif ($row['status'] == 7) {
												echo "<span class='badge badge-secondary'>Fixed</span>";
											} elseif ($row['status'] == 8) {
												echo "<span class='badge badge-secondary'>Canceled</span>";
											}
											?>
										</td>
										<td class="text-center">
											<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
												Action
											</button>
											<div class="dropdown-menu" style="">
												<a class="dropdown-item view_ticket" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['subject'] ?>">View</a>
												<div class="dropdown-divider"></div>
												<?php if ($_SESSION['login_type'] != 3) : ?>
													<a class="dropdown-item edit_ticket" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['subject'] ?>">Edit</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item delete_ticket" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
												<?php endif; ?>
											</div>
										</td>
									</tr>
								<?php
								endwhile;
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<span><b>Task List:</b></span>
					<?php if ($_SESSION['login_type'] != 3) : ?>
						<div class="card-tools">
							<button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_task"><i class="fa fa-plus"></i> New Task</button>
						</div>
					<?php endif; ?>
				</div>
				<div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
					<div class="table-responsive">
						<table class="table table-condensed m-0 table-hover">
							<colgroup>
								<col width="5%">
								<col width="20%">
								<col width="25%">
								<col width="5%">
								<col width="5%">
								<col width="10%">
								<col width="10%">
								<col width="10%">
								<col width="5%">
								<col width="5%">
							</colgroup>
							<thead>
								<th>#</th>
								<th>Task</th>
								<th>Description</th>
								<th>Type</th>
								<th>Priority</th>
								<th>Start Date</th>
								<th>Due Date</th>
								<th>Progress</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$tasks = $conn->query("SELECT * FROM task_list where project_id = {$id} order by task asc");
								while ($row = $tasks->fetch_assoc()) :
									$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
									unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
									$desc = strtr(html_entity_decode($row['description']), $trans);
									$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class=""><b><?php echo ucwords($row['task']) ?></b></td>
										<td class="">
											<p class="truncate"><?php echo strip_tags($desc) ?></p>
										</td>
										<td>
											<?php
											if ($row['type'] == 1) {
												echo "<span class='badge badge-secondary'>Change</span>";
											} elseif ($row['type'] == 2) {
												echo "<span class='badge badge-dark'>Plugin</span>";
											} elseif ($row['type'] == 3) {
												echo "<span class='badge badge-success'>Task</span>";
											} elseif ($row['type'] == 4) {
												echo "<span class='badge badge-danger'>Bug</span>";
											} elseif ($row['type'] == 5) {
												echo "<span class='badge badge-primary'>Idea</span>";
											} elseif ($row['type'] == 6) {
												echo "<span class='badge badge-info'>Quote</span>";
											} elseif ($row['type'] == 7) {
												echo "<span class='badge badge-warning'>Issue</span>";
											}

											?>
										</td>
										<td>
											<?php
											if ($row['priority'] == 1) {
												echo "<span class='badge badge-info'>Unknown</span>";
											} elseif ($row['priority'] == 2) {
												echo "<span class='badge badge-primary'>Low</span>";
											} elseif ($row['priority'] == 3) {
												echo "<span class='badge badge-success'>Medium</span>";
											} elseif ($row['priority'] == 4) {
												echo "<span class='badge badge-warning'>High</span>";
											} elseif ($row['priority'] == 5) {
												echo "<span class='badge badge-danger'>Urgent</span>";
											}

											?>
										</td>
										<td><span><?php echo date('M d, Y', strtotime($row['start_date'])) ?></span></td>
										<td><span><?php echo date('M d, Y', strtotime($row['due_date'])) ?></span></td>
										<td>
											<div class="progress">
												<div class="progress-bar rounded-pill
            <?php
									if ($row['progress'] >= 0 && $row['progress'] <= 10) {
										echo 'bg-danger';
									} elseif ($row['progress'] > 10 && $row['progress'] <= 30) {
										echo 'bg-warning';
									} elseif ($row['progress'] > 30 && $row['progress'] <= 50) {
										echo 'bg-info';
									} elseif ($row['progress'] > 50 && $row['progress'] <= 70) {
										echo 'bg-primary';
									} elseif ($row['progress'] > 70 && $row['progress'] <= 100) {
										echo 'bg-success';
									}
			?>" role="progressbar" style="width: <?php echo $row['progress'] ?>%;" aria-valuenow="<?php echo $row['progress'] ?>" aria-valuemin="0" aria-valuemax="100">
													<span class="sr-only"><?php echo $row['progress'] ?>% Complete</span>
												</div>
											</div>
											<span><?php echo $row['progress'] ?>%</span>
										</td>


										<td>
											<?php
											if ($row['status'] == 1) {
												echo "<span class='badge badge-warning'>Pending</span>";
											} elseif ($row['status'] == 2) {
												echo "<span class='badge badge-primary'>On-Progress</span>";
											} elseif ($row['status'] == 3) {
												echo "<span class='badge badge-success'>Done</span>";
											}
											?>
										</td>
										<td class="text-center">
											<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
												Action
											</button>
											<div class="dropdown-menu" style="">
												<a class="dropdown-item view_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">View</a>
												<div class="dropdown-divider"></div>
												<?php if ($_SESSION['login_type'] != 3) : ?>
													<a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Edit</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
												<?php endif; ?>
											</div>
										</td>
									</tr>
								<?php
								endwhile;
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card card-outline card-warning">
				<div class="card-header">
					<b>Members Progress/Activity</b>
					<div class="card-tools">
						<button class="btn btn-warning bg-gradient-warning btn-sm" type="button" id="new_productivity"><i class="fa fa-plus"></i> New Productivity</button>
					</div>
				</div>
				<div class="card-body">
					<?php
					$progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM user_productivity p inner join users u on u.id = p.user_id inner join task_list t on t.id = p.task_id where p.project_id = $id order by unix_timestamp(p.date_created) desc ");
					while ($row = $progress->fetch_assoc()) :
					?>
						<div class="post">

							<div class="user-block">
								<?php if ($_SESSION['login_id'] == $row['user_id']) : ?>
									<span class="btn-group dropleft float-right">
										<span class="btndropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<div class="dropdown-menu">
											<a class="dropdown-item manage_progress" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Edit</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete_progress" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
										</div>
									</span>
								<?php endif; ?>
								<img class="img-circle img-bordered-sm" src="assets/uploads/<?php echo $row['avatar'] ?>" alt="user image">
								<span class="username">
									<a href="#"><?php echo ucwords($row['uname']) ?>[ <?php echo ucwords($row['task']) ?> ]</a>
								</span>
								<span class="description">
									<span class="fa fa-calendar"></span>
									<span><b><?php echo date('M d, Y', strtotime($row['date'])) ?></b></span>
									<span class="fa fa-clock-o"></span>
									<span>Start: <b><?php echo date('h:i A', strtotime($row['date'] . ' ' . $row['start_time'])) ?></b></span>
									<span> | </span>
									<span>End: <b><?php echo date('h:i A', strtotime($row['date'] . ' ' . $row['end_time'])) ?></b></span>
								</span>
							</div>
							<!-- /.user-block -->
							<div>
								<?php echo html_entity_decode($row['comment']) ?>
							</div>

							<p>
								<!-- <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a> -->
							</p>
						</div>
						<!-- <div class="post clearfix"></div> -->
					<?php endwhile; ?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card card-outline card-success">
				<div class="card-header">
					<b>Discussion</b>
					<div class="card-tools">
						<button class="btn btn-success bg-gradient-success btn-sm" type="button" id="new_discussion"><i class="fa fa-plus"></i> New Discussion</button>
					</div>
				</div>
				<div class="card-body" id="table">

				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.users-list>li img {
		border-radius: 50%;
		height: 67px;
		width: 67px;
		object-fit: cover;
	}

	.users-list>li {
		width: 33.33% !important
	}

	.truncate {
		-webkit-line-clamp: 1 !important;
	}

	#uni_modal .modal-footer {
		display: none;
	}

	#uni_modal .modal-footer.display {
		display: flex
	}
</style>
<script>
	$('#new_ticket').click(function() {
		uni_modal("New Ticket For <?php echo ucwords($name) ?>", "manage_ticket.php?pid=<?php echo $id ?>", "mid-large", false, false, false)
	})
	$('.edit_ticket').click(function() {
		uni_modal("Edit Ticket: " + $(this).attr('data-task'), "manage_ticket.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), "mid-large", false, false, false)
	})
	$('.view_ticket').click(function() {
		uni_modal("Ticket Details", "view_ticket.php?id=" + $(this).attr('data-id'), "mid-large", false, false, false)
	})
	$('#new_task').click(function() {
		uni_modal("New Task For <?php echo ucwords($name) ?>", "manage_task.php?pid=<?php echo $id ?>", "mid-large", false, false, false)
	})
	$('.edit_task').click(function() {
		uni_modal("Edit Task: " + $(this).attr('data-task'), "manage_task.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), "mid-large", false, false, false)
	})
	$('.view_task').click(function() {
		uni_modal("Task Details", "view_task.php?id=" + $(this).attr('data-id'), "mid-large", false, false, false)
	})
	$('#new_productivity').click(function() {
		uni_modal("<i class='fa fa-plus'></i> New Progress", "manage_progress.php?pid=<?php echo $id ?>", "mid-large", false, false, false)
	})
	$('.manage_progress').click(function() {
		uni_modal("<i class='fa fa-edit'></i> Edit Progress", "manage_progress.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), 'mid-large', false, false, false)
	})
	$('.delete_progress').click(function() {
		_conf("Are you sure to delete this progress?", "delete_progress", [$(this).attr('data-id')])
	})
	
	$('#new_discussion').click(function() {
		uni_modal("<i class='fa fa-plus'></i> New Discussion", "manage_discussion.php?pid=<?php echo $id ?>", 'mid-large', false, false, false)
	})

	$('.delete_task').click(function() {
		_conf("Are you sure to delete this task?", "delete_task", [$(this).attr('data-id')])
	})

	$('.delete_ticket').click(function() {
		_conf("Are you sure to delete this ticket?", "delete_ticket", [$(this).attr('data-id')])
	})

	function delete_progress($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_progress',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}

	

	const id = <?php echo isset($_GET['id']) ? json_encode($_GET['id']) : 'null'; ?>;
	const uid = <?php echo isset($_SESSION['login_id']) ? json_encode($_SESSION['login_id']) : 'null'; ?>;

	function table() {
		const xhttp = new XMLHttpRequest();
		xhttp.onload = function() {
			document.getElementById("table").innerHTML = this.responseText;
		}
		xhttp.open("GET", "system.php?id=" + id + "&uid="+uid);
		xhttp.send();
	}

	setInterval(function() {
		table();
	}, 10000);


	$('.delete_discussion').click(function() {
        _conf("Are you sure to delete this Chat?", "delete_discussion", [$(this).attr('data-id')])
    })

	$('.delete_task').click(function() {
        _conf("Are you sure to delete this Task?", "delete_task", [$(this).attr('data-id')])
    })

    function delete_ticket($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_ticket',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}

	function delete_task($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_task',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}

	function delete_discussion($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_discussion',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>