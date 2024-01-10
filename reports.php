<?php include 'db_connect.php' ?>
<div class="col-md-12">
  <div class="card card-outline card-success">
    <div class="card-header">
      <b>Project Progress</b>
      <div class="card-tools">
        <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print</button>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive" id="printable">
        <?php
        // Assuming you have fetched the project and task data from the database

        // Sample project and task data
        $projects = [
          ['id' => 1, 'name' => 'Project A', 'start_date' => '2023-01-01', 'end_date' => '2023-02-01'],
          ['id' => 2, 'name' => 'Project B', 'start_date' => '2023-02-15', 'end_date' => '2023-03-15']
        ];

        $tasks = [
          ['id' => 1, 'project_id' => 1, 'task' => 'Task 1', 'start_date' => '2023-01-05', 'due_date' => '2023-01-15'],
          ['id' => 2, 'project_id' => 1, 'task' => 'Task 2', 'start_date' => '2023-01-10', 'due_date' => '2023-01-25'],
          ['id' => 3, 'project_id' => 2, 'task' => 'Task 1', 'start_date' => '2023-02-20', 'due_date' => '2023-03-05']
        ];

        // Generate Gantt chart
        echo '<html><head><script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.js"></script></head><body>';
        echo '<div id="gantt"></div>';
        echo '<script>';
        echo 'var tasks = [';
        foreach ($tasks as $task) {
          echo '{id: ' . $task['id'] . ', name: "' . $task['task'] . '", start: "' . $task['start_date'] . '", end: "' . $task['due_date'] . '", progress: 100},';
        }
        echo '];';
        echo 'var gantt = new Gantt("#gantt", tasks);';
        echo '</script>';
        echo '</body></html>';
        ?>

      </div>
    </div>
  </div>
</div>
<script>
  $('#print').click(function() {
    start_load()
    var _h = $('head').clone()
    var _p = $('#printable').clone()
    var _d = "<p class='text-center'><b>Project Progress Report as of (<?php echo date("F d, Y") ?>)</b></p>"
    _p.prepend(_d)
    _p.prepend(_h)
    var nw = window.open("", "", "width=900,height=600")
    nw.document.write(_p.html())
    nw.document.close()
    nw.print()
    setTimeout(function() {
      nw.close()
      end_load()
    }, 750)
  })
</script>