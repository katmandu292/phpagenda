<?php
require 'data_sn.php';
$insertedid = $_GET['id'] ?? null;

if (!$insertedid) {
  header('Location: index.php');
  exit;
}

$sql = 'select p.PATIENT_ID, u.SYSUSER_ID as PATIENT_OWNER, u.SYS_USERNAME,
 p.PATIENT_NAME, p.PATIENT_SURNAME, p.PATIENT_AGE, p.PATIENT_TEL, p.PATIENT_EMAIL,
 p.PATIENT_WHATSAPPNR, DATE_FORMAT(p.PATIENT_IN, "%e %b %Y") AS REGISTERED_AT,
 c.DETAIL_ID, c.PATIENT_DETS, u.SYSUSER_ID
 from TBL_PATIENTS p JOIN TBL_USERS u ON (p.PATIENT_OWNER = u.SYSUSER_ID)
 JOIN DET_PATIENTS c ON (c.PATIENT_ID = p.PATIENT_ID)
 where p.PATIENT_ID = :id';

$stmt = $pdo->prepare($sql);
$params = ['id' => $insertedid];
$stmt->execute($params);

      $pcnrecord = $stmt->fetch();  
//catch (PDOException $except) {
//    $postErr = $except->message();
//}

$databsid = (int)$pcnrecord['PATIENT_ID'];
$userid = $pcnrecord['SYSUSER_ID'];
$detailid = $pcnrecord['DETAIL_ID'];
$usernme = $pcnrecord['SYS_USERNAME'];
$usremail = $pcnrecord['PATIENT_EMAIL'];
$usrtel = $pcnrecord['PATIENT_TEL'];
$userinit = $pcnrecord['REGISTERED_AT'];

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['GOFORIT'])) {

   $PATIENT_NAME = htmlspecialchars($_POST['PATNAME']);
   $PATIENT_SURNAME = htmlspecialchars($_POST['PATSURN']);
   $PATIENT_EMAIL = htmlspecialchars($_POST['PATMAIL']);
   $PATIENT_TEL = htmlspecialchars($_POST['PATPHN']);
   $WHATSAPPNR = htmlspecialchars($_POST['PATWHATS']);
   $PT_DETAILS = htmlspecialchars($_POST['PATDETAILS']);

   $updatePatientQry = "CALL Updatepatient(:patsid, :famname, :selfname, :email, :telnr, :whatsappnr, :patsdet)";
 
   $stmnt = $pdo->prepare($updatePatientQry);

   $stmnt->bindParam(':patsid',$databsid,PDO::PARAM_INT);
   $stmnt->bindParam(':famname',$PATIENT_SURNAME,PDO::PARAM_STR);
   $stmnt->bindParam(':selfname',$PATIENT_NAME,PDO::PARAM_STR);
   $stmnt->bindParam(':email',$PATIENT_EMAIL,PDO::PARAM_STR);
   $stmnt->bindParam(':telnr',$PATIENT_TEL,PDO::PARAM_STR);
   $stmnt->bindParam(':whatsappnr',$WHATSAPPNR,PDO::PARAM_STR);
   $stmnt->bindParam(':patsdet',$PT_DETAILS,PDO::PARAM_STR);

// $params = [ 'patsid' => $databsid, 'famname' => $PATIENT_SURNAME, 'selfname' => $PATIENT_NAME, 'email' => $PATIENT_EMAIL, 'telnr' => $PATIENT_TEL, 'whatsappnr' => $WHATSAPPNR, 'patsdet' => $PT_DETAILS ];

   try { $stmnt->execute(); }
   catch (PDOException $exc) {
      echo $exc->getMessage();
   }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Blog Post</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  <header class="bg-blue-500 text-white p-4">
    <div class="container mx-auto">
      <h1 class="text-3xl font-semibold">My Blog - <?= $_SERVER['REQUEST_METHOD'] ?></h1>
    </div>
  </header>
  <div class="flex justify-center mt-10">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
      <h1 class="text-2xl font-semibold mb-6">Update Patient Profile</h1>
      <form method="post">
        <div class="mb-4">
<!--       input type="hidden" name="id" value="<?= $insertedid ?>" / -->
<!-- this user was created at <?= $userinit ?> -->
          <label for="PAT_NAME" class="block text-gray-700 font-medium">Patient&#39;s Name</label>
          <input type="text" id="PAT_NAME" name="PATNAME" placeholder="Enter First Name" class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none" value="<?= $pcnrecord['PATIENT_NAME'] ?>" />
        </div>
        <div class="mb-4">
          <label for="PAT_SURNAME" class="block text-gray-700 font-medium">Family Name</label>
          <input type="text" id="PAT_SURNAME" name="PATSURN" placeholder="Enter Patient's Family Name" class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none" value="<?= $pcnrecord['PATIENT_SURNAME'] ?>" />
        </div>
        <div class="mb-4">
          <label for="PAT_AGE" class="block text-gray-700 font-medium">Age (at the moment of Registration):</label>
          <input type="text" id="PAT_AGE" name="PATAGE" value="<?= $pcnrecord['PATIENT_AGE'] ?>" class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none" />
        </div>
        <div class="mb-4">
          <label for="PAT_EMAIL" class="block text-gray-700 font-medium">Email Address:</label>
          <input type="text" id="PAT_EMAIL" name="PATMAIL" value="<?= $usremail ?>" class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none" />
        </div>
        <div class="mb-4">
          <label for="PAT_TEL" class="block text-gray-700 font-medium">Telephone Nr:</label>
          <input type="text" id="PAT_TEL" name="PATPHN" value="<?= $usrtel ?>" class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none" />
        </div>
        <div class="mb-4">
          <label for="PAT_WHT" class="block text-gray-700 font-medium">WhatsApp Nr:</label>
          <input type="text" id="PAT_WHT" name="PATWHATS" value="<?= $pcnrecord['PATIENT_WHATSAPPNR'] ?>" class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none" />
        </div>

        <div class="mb-6">
          <label for="detail" class="block text-gray-700 font-medium">Body of Details</label>
          <textarea id="detail" name="PATDETAILS" placeholder="Enter Details" class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none" maxlength="1200"><?= $pcnrecord['PATIENT_DETS'] ?></textarea>
        </div>
        <div class="flex items-center justify-between">
          <button type="submit" name="GOFORIT" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">
            Submit
          </button>
          <a href="index.php" class="text-blue-500 hover:underline">Back to Posts</a>
        </div>
      </form>

    </div>
  </div>
</body>

</html>

