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
	<dl>
		<dt><b class="border-bottom border-primary">Task</b></dt>
		<dd><?php echo ucwords($task) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Status</b></dt>
		<dd>
			<?php
			if ($status == 1) {
				echo "<span class='badge badge-secondary'>Pending</span>";
			} elseif ($status == 2) {
				echo "<span class='badge badge-primary'>On-Progress</span>";
			} elseif ($status == 3) {
				echo "<span class='badge badge-success'>Done</span>";
			}
			?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Description</b></dt>
		<dd><?php echo html_entity_decode($description) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Type</b></dt>
		<dd>
			<?php
			if ($type == 1) {
				echo "<span class='badge badge-secondary'>Change</span>";
			} elseif ($type == 2) {
				echo "<span class='badge badge-dark'>Plugin</span>";
			} elseif ($type == 3) {
				echo "<span class='badge badge-success'>Task</span>";
			} elseif ($type == 4) {
				echo "<span class='badge badge-danger'>Bug</span>";
			} elseif ($type == 5) {
				echo "<span class='badge badge-primary'>Idea</span>";
			} elseif ($type == 6) {
				echo "<span class='badge badge-info'>Quote</span>";
			} elseif ($type == 7) {
				echo "<span class='badge badge-warning'>Issue</span>";
			}

			?>
		</dd>
	</dl>
	<dl>
		<dd>
		<dt><b class="border-bottom border-primary">Priority</b></dt>
		<?php
		if ($priority == 1) {
			echo "<span class='badge badge-info'>Unknown</span>";
		} elseif ($priority == 2) {
			echo "<span class='badge badge-primary'>Low</span>";
		} elseif ($priority == 3) {
			echo "<span class='badge badge-success'>Medium</span>";
		} elseif ($priority == 4) {
			echo "<span class='badge badge-warning'>High</span>";
		} elseif ($priority == 5) {
			echo "<span class='badge badge-danger'>Urgent</span>";
		}

		?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Start Date</b></dt>
		<dd><span><?php echo date('M d, Y', strtotime($start_date)) ?></span></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Due Date</b></dt>
		<dd><span><?php echo date('M d, Y', strtotime($due_date)) ?></span></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Progress</b></dt>
		<dd>
			<div class="progress">
				<div class="progress-bar rounded-pill
            <?php
			if ($progress >= 0 && $row['progress'] <= 10) {
				echo 'bg-danger';
			} elseif ($progress > 10 && $progress <= 30) {
				echo 'bg-warning';
			} elseif ($progress > 30 && $progress <= 50) {
				echo 'bg-info';
			} elseif ($progress > 50 && $progress <= 70) {
				echo 'bg-primary';
			} elseif ($progress > 70 && $progress <= 100) {
				echo 'bg-success';
			}
			?>" role="progressbar" style="width: <?php echo $progress ?>%;" aria-valuenow="<?php echo $progress ?>" aria-valuemin="0" aria-valuemax="100">
					<span class="sr-only"><?php echo $progress ?>% Complete</span>
				</div>
			</div>
			<span><?php echo $progress ?>%</span>
		</dd>
		<dd>
			<?php
			if ($progress == 1) {
				echo "<span class='badge badge-warning'>Pending</span>";
			} elseif ($progress == 2) {
				echo "<span class='badge badge-primary'>On-Progress</span>";
			} elseif ($progress == 3) {
				echo "<span class='badge badge-success'>Done</span>";
			}
			?>
		</dd>
	</dl>
</div>
<div class="col-lg-12 text-right justify-content-center d-flex">
	<button class="btn btn-secondary" type="button" onclick="$('#uni_modal').modal('hide')">Cancel</button>
</div>