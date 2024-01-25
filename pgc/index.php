<?php $conn = new PDO('mysql:host=localhost; dbname=tms_db', 'root', ''); ?>
<?php include('head.php'); ?>

<style>
    body>div>div>div>div>div>div:nth-child(2)>div.row.top-buffer>div>div>div>div>div.mtablescrolls>div>div>div.gantt-side>div.gantt-side-content>div:nth-child(1)>div>div.gantt-tree-body>div>div.angular-ui-tree>ol>li>div>div>div {
        color: #fff;
    }
</style>
<link rel="stylesheet" href="gantt/vendor.css">

<script src="gantt/vendor.js"></script>

<script src="gantt/scripts.js"></script>

<body class="nav-md" ng-app="angularGanttDemoApp" ng-strict-di>

    <div class="container body">


        <div class="main_container">
            <!-- /top navigation -->


            <!-- page content -->
            <div role="main">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="page-title">
                            <div class="title_left">
                                <?php
                                $query = $conn->query("select * from project_list") or die(mysql_error());
                                $count = $query->rowcount();
                                ?>
                                <h3><i class="fa fa-line-chart"></i> Project Gantt Chart</h3>
                            </div>

                        </div>
                        <div ng-controller="MainCtrl">

                            <div class="container-content" ng-show="false">
                                <div class="container-fluid">
                                    <div class="row top-buffer">
                                        <div class="col-md-12">
                                            <i class="fa fa-cog"></i> Loading Gantt Chart...
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row top-buffer">
                                <div class="col-md-12">
                                    <div class="panel-group" bs-collapse>
                                        <div class="x_panel">
                                            <div class="panel-body">


                                                <div class="panel-group" bs-collapse>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a href="" bs-collapse-toggle>Options</a>
                                                            </h4>
                                                        </div>
                                                        <div class="panel-collapse" bs-collapse-target>
                                                            <div class="panel-body">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="form-inline">
                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-search"></i> Scale</label><br>
                                                                                <button type="button" style="width: 6em; text-align: left" class="col-md-12 col-sm-12 col-xs-12 btn btn-default" ng-model="options.scale" bs-options="s for s in ['day', 'week', '2 weeks', 'month', 'quarter', '6 months', 'year']" bs-select></button>
                                                                            </div>
                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-sort"></i> Sort</label><br>
                                                                                <button type="button" style="width: 7em; text-align: left" class="btn btn-default" ng-model="options.sortMode" bs-options="m.value as m.label for m in [{label: 'disabled', value: undefined}, {label: 'name', value: 'model.name'}, {label: 'from', value: 'from'}, {label: 'to', value: 'to'}]" bs-select></button>
                                                                            </div>
                                                                            <div class="form-group input-append text-center">
                                                                                <label class="control-label"><i class="fa fa-filter"></i> Filter Tasks</label><br>
                                                                                <input type="text" class="form-control" style="width: 20em; text-align: left" ng-model="options.filterTask">
                                                                            </div>
                                                                            <div class="form-group input-append text-center">
                                                                                <label class="control-label"><i class="fa fa-filter"></i> Filter Rows</label><br>
                                                                                <input type="text" class="form-control" style="width: 20em; text-align: left" ng-model="options.filterRow">
                                                                            </div>
                                                                            <br>
                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-clock-o"></i> Today</label><br>
                                                                                <button type="button" style="width: 6em; text-align: left" class="btn btn-default" ng-model="options.currentDate" bs-options="d for d in ['none', 'line', 'column']" bs-select></button>
                                                                            </div>

                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-bars"></i> Side</label><br>
                                                                                <div class="btn-group" bs-checkbox-group>
                                                                                    <button type="button" style="width: 8em; text-align: left" class="btn btn-default" ng-model="options.sideMode" bs-options="s for s in ['Tree', 'Table', 'TreeTable']" bs-select></button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-gear"></i> Groups</label><br>
                                                                                <div class="btn-group" bs-checkbox-group>
                                                                                    <button type="button" style="width: 8em; text-align: left" class="btn btn-default" ng-model="options.groupDisplayMode" bs-options="s for s in ['group', 'overview', 'Disabled']" bs-select></button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-crop"></i> Layout</label><br>
                                                                                <div class="btn-group" bs-checkbox-group>
                                                                                    <button type="button" class="btn btn-default" ng-model="options.maxHeight" bs-checkbox>Height</button>
                                                                                    <button ng-disabled="!canAutoWidth(options.scale)" type="button" class="btn btn-default" ng-model="options.width" bs-checkbox>Width</button>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-search"></i> Zoom</label><br>
                                                                                <input ng-disabled="!options.width" type="number" ng-model="options.zoom" step="0.1" min="0.1" max="5" class="form-control" />
                                                                            </div>


                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-text-width"></i> Labels</label><br>
                                                                                <div class="btn-group" bs-checkbox-group>
                                                                                    <button type="button" class="btn btn-default" ng-model="options.labelsEnabled" bs-checkbox>Show</button>
                                                                                    <button type="button" class="btn btn-default" ng-model="options.allowSideResizing" bs-checkbox>Resizable</button>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-code"></i> Content</label><br>
                                                                                <div class="btn-group" bs-checkbox-group>
                                                                                    <button type="button" class="btn btn-default" ng-model="options.rowContentEnabled" bs-checkbox>Rows</button>
                                                                                    <button type="button" class="btn btn-default" ng-model="options.taskContentEnabled" bs-checkbox>Tasks</button>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-calendar"></i> <i class="fa fa-arrows-h"></i> <i class="fa fa-calendar"></i> Date range</label><br>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" ng-model="options.fromDate" max-date="{{options.toDate}}" start-date="{{options.currentDateValue.toString()}}" start-week="1" placeholder="From" bs-datepicker>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" ng-model="options.toDate" min-date="{{options.fromDate}}" start-date="{{options.currentDateValue.toString()}}" start-week="1" placeholder="To" bs-datepicker>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa-database"></i> Data actions</label><br>
                                                                                <div class="btn-group">
                                                                                    <button class="btn btn-default" ng-click="reload()">Reload</button>
                                                                                    <button class="btn btn-default" ng-click="clear()">Clear</button>
                                                                                </div>
                                                                            </div>

                                                                            <div ng-if="options.sideMode === 'Tree' || options.sideMode === 'TreeTable'" class="form-group text-center">
                                                                                <label class="control-label"><i class="fa fa fa-chevron-circle-right"></i> Tree actions</label><br>
                                                                                <div class="btn-group">
                                                                                    <button class="btn btn-default" ng-click="expandAll()">Expand all</button>
                                                                                    <button class="btn btn-default" ng-click="collapseAll()">Collapse all</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mtablescrolls" style="height:800px;">
                                                    <div gantt data="data" show-side="options.labelsEnabled" daily="options.daily" filter-task="{'name': options.filterTask}" filter-row="{'name': options.filterRow}" sort-mode="options.sortMode" view-scale="options.scale" column-width="getColumnWidth(options.width, options.scale, options.zoom)" auto-expand="options.autoExpand" task-out-of-range="options.taskOutOfRange" from-date="options.fromDate" to-date="options.toDate" allow-side-resizing="options.allowSideResizing" task-content="options.taskContentEnabled ? options.taskContent : undefined" row-content="options.rowContentEnabled ? options.rowContent : undefined" current-date="options.currentDate" current-date-value="options.currentDateValue" headers="options.width && options.shortHeaders || options.longHeaders" max-height="options.maxHeight && 300 || 0" date-frames="options.dateFrames" api="options.api" column-magnet="options.columnMagnet">



                                                        <script>
                                                            angular.module('angularGanttDemoApp')
                                                                .service('Sample', function Sample() {
                                                                    return {
                                                                        getSampleData: function() {
                                                                            return [
                                                                                <?php
                                                                                $query = $conn->query("select * from project_list");
                                                                                while ($row = $query->fetch()) {
                                                                                    $projectid = $row['id'];
                                                                                    $project_name = $row['name'];

                                                                                ?>

                                                                                    {
                                                                                        name: "<?php echo $project_name; ?>",
                                                                                        height: '3em',
                                                                                        color: '#00006B',
                                                                                        children: [
                                                                                            <?php
                                                                                            $query12 = $conn->query("select *,task_list.start_date as st_date from task_list LEFT JOIN project_list ON task_list.project_id = project_list.id where task_list.project_id='$projectid' ORDER BY project_id ASC");
                                                                                            while ($row12 = $query12->fetch()) {
                                                                                                $checklist = $row12['task'];
                                                                                            ?>
                                                                                                <?php echo '"' . $checklist . '"' . ","; ?>
                                                                                            <?php } ?>
                                                                                        ],
                                                                                        content: '<i class="fa fa-file-code-o" ng-click="scope.handleRowIconClick(row.model)"></i> {{row.model.name}}'
                                                                                    },
                                                                                    <?php
                                                                                    $query123 = $conn->query("select *,task_list.start_date as st_date from task_list LEFT JOIN project_list ON task_list.project_id = project_list.id where task_list.project_id='$projectid' ORDER BY project_id ASC");
                                                                                    while ($row123 = $query123->fetch()) {
                                                                                        $punchlist_id = $row123['id'];
                                                                                        $checklist = $row123['task'];
                                                                                        $progress = $row123['progress'];

                                                                                        //$clstart_date = date('Y/m/d', strtotime($row123["start_date"]));
                                                                                        //$clstart_date = date('Y/m/d',strtotime($row123["start_date"]->format('m/d/y')));
                                                                                        $clstart_date = $row123["st_date"];

                                                                                        //$clend_date = date('Y/m/d', strtotime($row123["due_date"]));
                                                                                        //$clend_date = date('Y/m/d',strtotime($row123["due_date"]->format('m/d/y')));
                                                                                        $clend_date = $row123["due_date"];

                                                                                    ?>

                                                                                        {
                                                                                            name: "<?php echo $checklist; ?>",
                                                                                            tooltips: true,
                                                                                            tasks: [{
                                                                                                name: "<?php echo $checklist; ?> - <?php echo $progress; ?>%",
                                                                                                color: '#F1C232',
                                                                                                from: new Date("<?php echo $clstart_date; ?>"),
                                                                                                to: new Date("<?php echo $clend_date; ?>"),
                                                                                                progress: "<?php echo $progress; ?>"
                                                                                            }]
                                                                                        },
                                                                                    <?php } ?>
                                                                                <?php } ?>

                                                                            ];
                                                                        },
                                                                    };
                                                                });
                                                        </script>

                                                        <gantt-tree enabled="options.sideMode === 'Tree' || options.sideMode === 'TreeTable'" header-content="options.treeHeaderContent" keep-ancestor-on-filter-row="true">
                                                        </gantt-tree>
                                                        <gantt-table enabled="options.sideMode === 'Table' || options.sideMode === 'TreeTable'" columns="options.sideMode === 'TreeTable' ? options.treeTableColumns : options.columns" headers="options.columnsHeaders" classes="options.columnsClasses" formatters="options.columnsFormatters" contents="options.columnsContents" header-contents="options.columnsHeaderContents">
                                                        </gantt-table>
                                                        <gantt-groups enabled="options.groupDisplayMode === 'group' || options.groupDisplayMode === 'overview' || options.groupDisplayMode === 'promote'" display="options.groupDisplayMode"></gantt-groups>
                                                        <gantt-tooltips></gantt-tooltips>
                                                        <gantt-bounds></gantt-bounds>
                                                        <gantt-progress></gantt-progress>
                                                        <gantt-sortable></gantt-sortable>
                                                        <gantt-movable enabled="!options.readOnly"></gantt-movable>
                                                        <gantt-draw-task enabled="options.canDraw" move-threshold="2" task-factory="options.drawTaskFactory">
                                                        </gantt-draw-task>
                                                        <gantt-overlap></gantt-overlap>
                                                        <gantt-resize-sensor></gantt-resize-sensor>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

    </div>

    </div>

</body>

</html>