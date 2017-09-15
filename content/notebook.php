<?php
  include('content/modals.php');
  include('content/mysql_handler.php');
  $sql_handler = new MySqlHandler;
?>
  <div class="row">
    <div class="col-sm-12">
      <?php
        if(isset($_GET['success'])) {
          echo '<div class="alert alert-success fade in vanish"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Hinweis: </strong>'.$_GET['success'].'</div>';
        }?>
      <div id="notebook-section" class="panel panel-default">
          <div class="panel-heading">Notizblock
            <a href="javascript:newNotebookEntry();" class="pull-right btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> Neu</a>
          </div>
          <div class="panel-content addMargin">

			<!-- Notizbuch -->
            <div class="table-responsiv">
              <table class="table table-hover">
                <thead>
                  <tr>
                      <th></th>
                      <th>Datum</th>
                      <th>Notiz</th>
                      <th>Verfasser</th>
                      <th></th>
                  </tr>
              </thead>
            <tbody>
              <?php
                $result = $sql_handler->getNotebookEntries();
                foreach ($result as $row)  {
                  $entryId = "2000".$row->Id;
                  switch ($row->Priority) {
                    case 3: echo '<tr><td><span style="color:red" class="glyphicon glyphicon-fire"></span></td>'; break;
                    case 2: echo '<tr><td><span style="color:orange" class="glyphicon glyphicon-warning-sign"></span></td>'; break;
                    default: echo '<tr><td><span style="color:green" class="glyphicon glyphicon-info-sign"></span></td>'; break;
                  }
                  echo "<td>$row->Date</td>";

                  if(isset($_GET["editEntry"]) && $_GET["editEntry"] == $row->Id) {
                    echo "<td id='entryNote'>";
                    echo "<form id='editNotebookEntryForm' name='EditNotebookEntry' action='content/mysql_handler.php' method='post'>";
                    echo "<input type='hidden' name='NotebookEntryToEdit' value='$row->Id'>";
                    echo "<textarea name='EditedNotebookEntryNote' class='form-control richtText' rows='5' maxlength='255'>$row->Note</textarea>";
                    echo '<select name="NotebookEntryPriority">';
                    echo '<option class="form-control" value="1">Info</option>';
                    echo '<option class="form-control" value="2">Wichtig</option>';
                    echo '<option class="form-control" value="3">Kritisch</option>';
                    echo '</select>';
                    echo "</form></td>";
                  } else {
                    echo "<td id='entryNote'>$row->Note</td>";
                  }
                  echo "<td>$row->Author</td>";

                  if(isset($_GET["editEntry"]) && $_GET["editEntry"] == $row->Id) {
                    echo "<td>";
                    echo "<a href='javascript:saveEditedNote()' class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> </a>";
                    echo "<a href='index.php?content=notebook' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> </a>";
                    echo "</td></tr>";
                  } else {
                    echo "<td><form id='$entryId' method='post' action='content/mysql_handler.php'><input type='hidden' name='NotebookEntryToDelete' value='$row->Id'>";
                    echo "<a href='javascript:deleteNotebookEntry($entryId)' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span> </a>";
                    echo "<a href='index.php?content=notebook&editEntry=$row->Id' class='btn btn-info btn-sm'><span class='glyphicon glyphicon-edit'></span> </a>";
                    echo "</form></td></tr>";
                  }

                }
              ?>
            </tbody>
          </table>
        </div>
          </div>
      </div>
    </div>
</div>
