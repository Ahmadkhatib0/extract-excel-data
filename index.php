<!DOCTYPE html>
<html>

<head>
  <title>Load Excel Sheet in Browser using PHPSpreadsheet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>

<body>
  <div class="container">
    <br />
    <h3 align="center">Load Excel Sheet in Browser using PHPSpreadsheet</h3>
    <br />
    <div class="table-responsive">
      <span id="message"></span>
      <form method="post" id="load_excel_form" enctype="multipart/form-data">
        <table class="table">
          <tr>
            <td width="25%" align="right">Select Excel File</td>
            <td width="50%"><input type="file" name="select_excel" /></td>
            <td width="25%"><input type="submit" name="load" class="btn btn-primary" /></td>
          </tr>
        </table>
      </form>
      <br />
      <div id="excel_area"></div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</body>

</html>


<script>
  $(document).ready(function() {
    $("#load_excel_form").on("submit", function(event) {
      event.preventDefault();
      $ajax({
        url: "import.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false, //to send non-process data file to server
        beforeSend: function() {
          $("#import").attr('disabled', "disabled");
          $("#import").val("Importing....");
        },
        success: function(data) {
          $("#message").html(data);
          $("#load_excel_form")[0].reset();
          $("import").attr("disabled", false);
          $("import").val("import");
        }
      })
    });
  })
</script>
