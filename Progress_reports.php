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
        <table class="table m-0 table-bordered">
          <!--  <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup> -->
          <thead>
            <th>#</th>
            <th>User</th>
            <th>Productivity Count</th>
            <th>Discussion Count</th>
          </thead>
          <tbody>
            <?php
            $i = 1;
            $stat = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done");
            $where = "where type in(1,2,3)";
            if ($_SESSION['login_type'] == 2) {
              $where = " where manager_id = '{$_SESSION['login_id']}' and type in(2,3) ";
            } elseif ($_SESSION['login_type'] == 3) {
              $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' and type in(2,3) ";
            }
            $qry = $conn->query("SELECT * FROM users $where  order by id asc");
            while ($row = $qry->fetch_assoc()) :
              $tprog = $conn->query("SELECT * FROM user_productivity where user_id = {$row['id']}")->num_rows;
              $cprog = $conn->query("SELECT * FROM discussion_list where user_id = {$row['id']}")->num_rows;
              
            ?>
              <tr>
                <td>
                  <?php echo $i++ ?>
                </td>
                <td>
                  <a>
                    <?php echo ucwords($row['firstname'] . ' ' . $row['lastname']) ?>

                  </a>
                  <br>
                  <small>
                    <?php echo $row['email'] ?>
                  </small>
                </td>
                <td class="text-center">
                  <?php echo number_format($tprog) ?>
                </td>
                <td class="text-center">
                  <?php echo number_format($cprog) ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
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