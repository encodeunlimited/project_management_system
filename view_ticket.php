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
	<dl>
		<dt><b class="border-bottom border-primary">Task</b></dt>
		<dd><?php echo ucwords($subject) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Status</b></dt>
		<dd>
			<?php
			if ($status == 1) {
				echo "<span class='badge badge-success'>New</span>";
			} elseif ($status == 2) {
				echo "<span class='badge badge-warning'>Open</span>";
			} elseif ($status == 3) {
				echo "<span class='badge badge-danger'>Re-Open</span>";
			} elseif ($status == 4) {
				echo "<span class='badge badge-primary'>Waiting Assesment</span>";
			} elseif ($status == 5) {
				echo "<span class='badge badge-success'>Resolved</span>";
			} elseif ($status == 6) {
				echo "<span class='badge badge-secondary'>Closed</span>";
			} elseif ($status == 7) {
				echo "<span class='badge badge-secondary'>Fixed</span>";
			} elseif ($status == 8) {
				echo "<span class='badge badge-secondary'>Canceled</span>";
			}
			?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Type</b></dt>
		<dd>
			<?php
			if ($type == 1) {
				echo "<span class='badge badge-secondary'>Request a Change</span>";
			} elseif ($type == 2) {
				echo "<span class='badge badge-primary'>Report a Bug</span>";
			} elseif ($type == 3) {
				echo "<span class='badge badge-success'>Ask a Question</span>";
			} elseif ($type == 4) {
				echo "<span class='badge badge-danger'>Risk on Issue</span>";
			}
			?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Description</b></dt>
		<dd><?php echo html_entity_decode($description) ?></dd>
	</dl>
</div>
<div class="col-lg-12 text-right justify-content-center d-flex">
	<button class="btn btn-secondary" type="button" onclick="$('#uni_modal').modal('hide')">Cancel</button>
</div>