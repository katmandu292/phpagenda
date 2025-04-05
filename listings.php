<?php
require 'data_sn.php';

$stmt = $pdo->prepare('select dp.DETAIL_ID, SUBSTR(dp.PATIENT_DETS,1,162) as PATIENT_DETS,
tp.PATIENT_NAME, tp.PATIENT_SURNAME, tp.PATIENT_ID, tp.PATIENT_EMAIL, tp.PATIENT_TEL,
us.SYS_USERNAME, ut.USER_TYPE_NM, tp.PATIENT_WHATSAPPNR,
tp.PATIENT_OWNER, tp.PATIENT_AGE from DET_PATIENTS dp join TBL_PATIENTS tp
on (dp.PATIENT_ID = tp.PATIENT_ID) join TBL_USERS us on (tp.PATIENT_OWNER = us.SYSUSER_ID)
join TBL_USER_TYPE ut on (us.SYSUSER_TYP = ut.USER_TYPE_ID)');

$stmt->execute();
$users = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Workopia</title>
  </head>
  <body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-900 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
          <a href="index.html">Workopia</a>
        </h1>
        <nav class="space-x-4">
          <a href="login.html" class="text-white hover:underline">Login</a>
          <a href="register.html" class="text-white hover:underline">Register</a>
          <a
            href="post-job.html"
            class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"
            ><i class="fa fa-edit"></i> Post a Job</a
          >
        </nav>
      </div>
    </header>

    <!-- Top Banner -->
    <section class="bg-blue-900 text-white py-6 text-center">
      <div class="container mx-auto">
        <h2 class="text-3xl font-semibold">Unlock Your Career Potential</h2>
        <p class="text-lg mt-2">
          Discover the perfect job opportunity for you.
        </p>
      </div>
    </section>

    <!-- Job Listings -->
    <section>
      <div class="container mx-auto p-4 mt-4">
        <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">All Patients</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
<?php foreach($users as $user) : ?>
          <!-- Job Listing 1: Software Engineer -->
          <div class="rounded-lg shadow-md bg-white">
            <div class="p-4">
              <h2 class="text-xl font-semibold"><?= $user['PATIENT_SURNAME'] ?>&nbsp;<?= $user['PATIENT_NAME'] ?></h2>
              <p class="text-gray-700 text-lg mt-2">
                <?= $user['PATIENT_DETS'] ?>&#46;&#46;&#46;
              </p>
              <ul class="my-4 bg-gray-100 p-4 rounded">
                <li class="mb-2"><strong>Age:</strong>&nbsp; <?= $user['PATIENT_AGE'] ?></li>
                <li class="mb-2">
                  <strong>Managed by:</strong>&nbsp;<?= $user['SYS_USERNAME'] ?>, <?= $user['USER_TYPE_NM'] ?>
                  <span
                    class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2"
                    >mailto: <?= $user['PATIENT_EMAIL'] ?></span
                  >
                </li>
                <li class="mb-2">
                  <strong>WhatsApp:</strong>&nbsp;<span><?= $user['PATIENT_WHATSAPPNR'] ?></span>
                </li>
                <li class="mb-2">
                  <strong>Tel:</strong>&nbsp;<span><?= $user['PATIENT_TEL'] ?></span>
                </li>
              </ul>
              <a href="details.php?id=<?= $user['PATIENT_ID'] ?>"
                class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
              >
                Details
              </a>
            </div>
          </div>
<?php endforeach ?>
      </section>

      <!-- Bottom Banner -->
      <section class="container mx-auto my-6">
        <div class="bg-blue-800 text-white rounded p-4 flex items-center justify-between">
          <div>
            <h2 class="text-xl font-semibold">Looking to hire?</h2>
            <p class="text-gray-200 text-lg mt-2">
              Post your job listing now and find the perfect candidate.
            </p>
          </div>
          <a href="post-job.html" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300">
            <i class="fa fa-edit"></i> Post a Job
          </a>
        </div>
      </section>
    </body>
</html>
