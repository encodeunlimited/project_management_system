<?php

include 'db_connect.php';
$project_id = $_GET['id'];

$progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM discussion_list p inner join users u on u.id = p.user_id inner join task_list t on t.id = p.task_id where p.project_id = $project_id order by unix_timestamp(p.date_created) desc");

//$progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM user_productivity p inner join users u on u.id = p.user_id inner join task_list t on t.id = p.task_id where p.project_id = $id order by unix_timestamp(p.date_created) desc ");
while ($row = $progress->fetch_assoc()) :
?>
    <div class="post">

        <div class="user-block">
            
            <img class="img-circle img-bordered-sm" src="assets/uploads/<?php echo $row['avatar'] ?>" alt="user image">
            <span class="username">
                <a href="#"><?php echo ucwords($row['uname']) ?>[ <?php echo ucwords($row['task']) ?> ][ <?php echo ucwords($row['subject']) ?> ]</a>
            </span>
            <span class="description">
                <span class="fa fa-calendar-day"></span>
                <span><b><?php echo date('M d, Y', strtotime($row['date_created'])) ?></b></span>
                <span class="fa fa-user-clock"></span>
                <span><b><?php echo date('h:i A', strtotime($row['date_created'])) ?></b></span>
                
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