<?php
require 'data_sn.php';
$sql = "select SYSUSER_ID, SYS_USERNAME from TBL_USERS";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$owners = $stmt->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (isset($_POST['submit'])) {
   $PATIENT_OWNER = htmlspecialchars($_POST['POWN']);
   $PATIENT_NAME = htmlspecialchars($_POST['PNAME']);
   $PATIENT_SURNAME = htmlspecialchars($_POST['PSURN']);
   $INPUT_YEAR = date("Y");
   $PATIENT_AGE = htmlspecialchars($_POST['PAGE']);
   $PATIENT_EMAIL = htmlspecialchars($_POST['PEMAIL']);
   $PATIENT_TEL = htmlspecialchars($_POST['PATTEL']);
   $WHATSAPPNR = htmlspecialchars($_POST['PATWHATS']);

   $addUserSQL = "INSERT INTO TBL_PATIENTS (PATIENT_OWNER, PATIENT_NAME, PATIENT_SURNAME, PATIENT_AGE, PATIENT_EMAIL, PATIENT_TEL, PATIENT_WHATSAPPNR) VALUES (:owner, :selfname, :famname, :age, :email, :telnr, :whatsappnr)";

   $stmnt = $pdo->prepare($addUserSQL);

   $params = [
    'owner' => $PATIENT_OWNER,
    'selfname' => $PATIENT_NAME,
    'famname' => $PATIENT_SURNAME,
    'age' => $PATIENT_AGE,
    'email' => $PATIENT_EMAIL,
    'telnr' => $PATIENT_TEL,
    'whatsappnr' => $WHATSAPPNR
];

   $stmnt->execute($params);

   header('Location: index.php');
   exit;
 }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new Patient</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"><!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>
<body>
<header class="bg-blue-500 text-black p-4">
<div class="container mx-auto">
<h1 class="text-3xl font-semibold">Add New Patient</h1>
</div>
</header>

<div class="container mt-4">
    <div class="form-container">
       <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group col-md-4">
                    <label for="PATIENT_OWNER">Patient Owner:</label>
                    <select id="PATIENT_OWNER" name="POWN">
<?php foreach($owners as $owner) : ?>
                         <option value="<?= $owner['SYSUSER_ID'] ?>"><?= $owner['SYS_USERNAME'] ?></option>
<?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="PATIENT_NAME">Pacient Name:</label>
                    <input type="text" class="form-control" id="PATIENT_NAME" name="PNAME" placeholder="Enter First Name of the Patient">
                </div>
                <div class="form-group col-md-4">
                    <label for="PATIENT_SURNAME">Patient Surname:</label>
                    <input type="text" class="form-control" id="PATIENT_SURNAME" name="PSURN">
                </div>
                <div class="form-group col-md-4">
                    <label for="PATIENT_AGE">Patient Age:</label>
                    <input type="text" class="form-control" id="PATIENT_AGE" name="PAGE">
                </div>
                <div class="form-group col-md-4">
                    <label for="PATIENT_EMAIL">Patient Email Address:</label>
                    <input type="text" class="form-control" id="PATIENT_EMAIL" name="PEMAIL">
                </div>
                <div class="form-group col-md-4">
                    <label for="PATIENT_TEL">Telephone Nbr</label>
                    <input type="text" class="form-control" id="PATIENT_TEL" name="PATTEL">
                </div>
                <div class="form-group col-md-4">
                    <label for="PATIENT_WHATSAPPNR">WhatsApp Nbr</label>
                    <input type="text" class="form-control" id="PATIENT_WHATSAPPNR" name="PATWHATS">&nbsp;
                </div>
            <br /><br /><button type="submit" name="submit" class="btn btn-primary">Add</button>
       </form>
    </div>
</div>
</body>
</html>

