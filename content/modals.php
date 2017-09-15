
<!-- New Note -->
<div id="noteModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Neue Notiz</h4>
          </div>
          <div class="modal-body">
            <form id="noteForm" name="NewNote" action="content/mysql_handler.php" method="post">
              <textarea name="NewNote" class="form-control" rows="5" maxlength="255" placeholder="max. 255 Zeichen"></textarea>
            </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
              <button type="submit" form="noteForm" class="btn btn-primary">Speichern</button>
          </div>
      </div>
  </div>
</div>

<!-- New Event -->
<div id="eventModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Neuer Termin</h4>
          </div>
          <div class="modal-body">
            <form id="eventForm" name="NewNote" action="content/mysql_handler.php" method="post">
              <label for="datepicker">Datum: </label>
              <input class="form-control" type="date" id="datepicker" name="EventDate"/>
              <label for="timepicker">Uhrzeit (AM = 0-12, PM = 12-24): </label>
              <input class="form-control" type="time" id="timepicker" name="EventTime" />
              <label for="eventTitle">Titel: </label>
              <input class="form-control" type="text" id="eventTitle" name="EventTitle" />
              <label for="eventTitle">Beschreibung: </label>
              <textarea class="form-control" name="EventDescription" id="eventDescription" rows="5" maxlength="255" placeholder="max. 255 Zeichen"></textarea>
            </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
              <button type="submit" form="eventForm" class="btn btn-primary">Speichern</button>
          </div>
      </div>
  </div>
</div>

<!-- New NotebookEntry -->
<div id="notebookModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Neuer Eintrag</h4>
          </div>
          <div class="modal-body">
            <form id="notebookForm" name="NewNotebookEntry" action="content/mysql_handler.php" method="post">
              <textarea class="form-control richtText" name="NotebookEntryNote" id="notbookEntryNote" rows="5" maxlength="255" placeholder="max. 255 Zeichen"></textarea>
              <label for="author">Name: </label>
              <input class="form-control" type="text" id="author" name="NotebookEntryAuthor"/>
              <select name="NotebookEntryPriority">
                <option class="form-control" value='1'>Info</option>
                <option class="form-control" value='2'>Wichtig</option>
                <option class="form-control" value='3'>Kritisch</option>
              </select>
            </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
              <button type="submit" form="notebookForm" class="btn btn-primary">Speichern</button>
          </div>
      </div>
  </div>
</div>
