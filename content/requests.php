<?php
  include('content/modals.php');
  include('content/mysql_handler.php');
  $sql_handler = new MySqlHandler;
?>
  <div class="row">
    <div class="col-sm-9">
      <?php
        if(isset($_GET['success'])) {
          echo '<div class="alert alert-success fade in vanish"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Hinweis: </strong>'.$_GET['success'].'</div>';
        }?>
      <div id="requests-section" class="panel panel-default" style="background-color: rgb(178, 180, 177);">
          <div class="panel-heading">Neelix</div>
          <div class="panel-content addMargin">

			<!-- Anfragen-Formular -->
				<form name='requestform' class="form-horizontal" action='content/mysql_handler.php' method='post'>
          <div class="row">
            <div class="col-sm-5">
					<?php
						echo "<select class='form-control' id='type_selector' name='RequestType'>";
						$result = $sql_handler->getRequestTypes();
						foreach ($result as $row)  {
							echo "<option value='$row->Name' title='$row->Description'>$row->Name</option>";
						}
						echo "</select>";
					?>
        </div>
        <div class="col-sm-7">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-sm btn-default"><input type="radio" name="OperatingSystem" value="Unabhängig">Unabhängig</label>
						<label class="btn btn-sm btn-default"><input type="radio" name="OperatingSystem" value="Windows">Windows</label>
						<label class="btn btn-sm btn-default"><input type="radio" name="OperatingSystem" value="Mac OS">Mac OS</label>
						<label class="btn btn-sm btn-default"><input type="radio" name="OperatingSystem" value="Linux">Linux</label>
						<label class="btn btn-sm btn-default"><input type="radio" name="OperatingSystem" value="Android">Android</label>
						<label class="btn btn-sm btn-default"><input type="radio" name="OperatingSystem" value="Andere">Andere</label>
					</div>
        </div>
      </div>
					<div>
						<label for="comment">Kommentar (optional):</label>
						<textarea class="form-control richText" name="Comment" rows="5"></textarea>
					</div>

					<div class="row">
            <div class="col-sm-3">
              <select id="location_selector" class="form-control" name="Location">
                <option class="form-control-sm" value='RZ'>Rechenzentrum</option>
                <option class="form-control-sm" value='TB4LOCAL'>TB4: Lokal</option>
                <option class="form-control-sm" value='TB4TEL/OTRS'>TB4: Tel/OTRS</option>
              </select>
            </div>
            <div class="col-sm-6">
            </div>
						<div class="col-sm-3">
							<a href="javascript:saveRequest()" class="pull-right btn btn-lg btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Speichern</a>
						</div>
					</div>
				</form>
      </div>
    </div>
      <div id="history-section" class="panel panel-default">
        <!-- Request Liste -->
        <div class="panel-heading">Verlauf - letzten 10 Anfragen</div>
          <div class="panel-content">
            <div class="table-responsiv">
            <table class="table table-hover">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Datum</th>
                    <th>Zeit</th>
                    <th>Typ</th>
                    <th>Betr.-System</th>
                    <th>Kommentar</th>
                    <th>Ort</th>
                    <th></th>
                </tr>
            </thead>
          <tbody>
      			<?php
      				$result = $sql_handler->getLastTenRequests();
      				foreach ($result as $row)  {
                $requestId = "1000".$row->Id;
      					echo "<tr>";
      					echo "<td>$row->Id</td><td>$row->Date</td><td>$row->Time</td><td>$row->Type</td><td>$row->Operating_System</td>";
      					if($row->Comment != null) {
      						echo "<td><button type='button' class='btn-sm btn btn-primary' data-toggle='popover' data-trigger='hover' title='' data-content='$row->Comment'>Kommentar</button></td>";
      					} else {
      						echo "<td></td>";
      					}
      					echo "<td>$row->Location</td>";
                echo "<td><form id='$requestId' method='post' action='content/mysql_handler.php'><input type='hidden' name='RequestToDelete' value='$row->Id'>";
                echo "<a href='javascript:deleteRequest($requestId)' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span> </a>";
                echo "</form></td></tr>";
      				}
      			?>
          </tbody>
        </table>
      </div>
        <div id="gradient"></div>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="panel panel-default">
        <div class="panel-heading">Termine
          <a href="javascript:newEvent()" class="pull-right btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> Neu</a>
        </div>
        <div class="panel-content addMargin">
          <?php
            $result = $sql_handler->getEvents();
            foreach($result as $row) {
              $eventId = "6000".$row->Id;
              $datetimestring = $row->Date." ".$row->Time;
              $datetime = new Datetime($datetimestring);
              echo "<div>";
              echo "<strong>".date_format($datetime, "d. M y \u\m\ H:i")." Uhr</strong>";
              echo "<p>".$row->Title."</p>";
              echo "<form id='$eventId' method='post' action='content/mysql_handler.php'><input type='hidden' name='EventToDelete' value='$row->Id'>";
              echo "<button type='button' class='btn-xs btn btn-info' data-toggle='popover' data-trigger='hover' title='' data-content='$row->Description'>mehr</button>";
              echo "<a href='javascript:deleteNote($eventId)' class='btn btn-danger btn-xs pull-right'><span class='glyphicon glyphicon-trash'></span></a>";
              echo "</form></span></div>";
            }
           ?>
  </div>
  </div>
  <div class="panel panel-default">
      <div class="panel-heading">Notizen
        <a href="javascript:newNote()" class="pull-right btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> Neu</a>
      </div>
      <div class="panel-content addMargin">
        <?php
          $result = $sql_handler->getNotes();
          foreach($result as $row) {
            $noteId = "7000".$row->Id;
            echo "<div>";
            echo "<strong>".$_SESSION['user']."</strong><p class='small'><code>($row->Date, $row->Time)</code></p>";
            echo "<p>".$row->Note."</p>";
            echo "<form id='$noteId' method='post' action='content/mysql_handler.php'><input type='hidden' name='NoteToDelete' value='$row->Id'>";
            echo "<a href='javascript:deleteNote($noteId)' class='btn btn-warning btn-xs'>erledigt?</a>";
            echo "</form></div>";
          }
         ?>
      </div>
    </div>
  </div>
</div>
