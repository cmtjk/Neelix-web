$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'top'
    });

    $('[value="Unabhängig"]').parent().button('toggle');

    tinymce.init({selector:'textarea.richtText'});

});

function saveRequest() {
  document.requestform.submit();
}
function deleteRequest(rowID) {
  if (confirm("Anfrage löschen?")) {
    document.getElementById(rowID).submit();
  }
}
function deleteNote(rowID) {
  if(confirm("Eintrag löschen?")) {
    document.getElementById(rowID).submit();
  }
}

window.setTimeout(function() {
  $(".vanish").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();
  });
}, 2000);

function newNote() {
  $("#noteModal").modal('show');
}

function newEvent() {
  $("#eventModal").modal('show');
}

function newNotebookEntry() {
  $("#notebookModal").modal('show');
}

function deleteNotebookEntry(rowID) {
  if(confirm("Eintrag löschen?")) {
    document.getElementById(rowID).submit();
  }
}

function saveEditedNote() {
  $("#editNotebookEntryForm").submit();
}
