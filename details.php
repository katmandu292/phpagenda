<?php
require 'data_sn.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  header('Location: index.php');
  exit;
}

$stmt = $pdo->prepare('select dp.DETAIL_ID,dp.PATIENT_DETS, tp.PATIENT_NAME,
tp.PATIENT_SURNAME, tp.PATIENT_ID, tp.PATIENT_NAME,
tp.PATIENT_SURNAME, tp.PATIENT_OWNER, tp.PATIENT_EMAIL,
tp.PATIENT_TEL, tp.PATIENT_IN, tp.PATIENT_AGE,
us.SYS_USERNAME from DET_PATIENTS dp
join TBL_PATIENTS tp on (dp.PATIENT_ID = tp.PATIENT_ID)
join TBL_USERS us on (tp.PATIENT_OWNER = us.SYSUSER_ID)
where tp.PATIENT_ID = :id');

$params = [ 'id' => $id ];

$stmt->execute($params);

$patient = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="css/style.css" />
    <title>Job Details - Workopia</title>
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
          <a href="register.html" class="text-white hover:underline"
            >Register</a
          >
          <a
            href="post-job.html"
            class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"
            ><i class="fa fa-edit"></i> Post a Job</a
          >
        </nav>
      </div>
    </header>

    <section class="container mx-auto p-4 mt-4">
      <div class="rounded-lg shadow-md bg-white p-3">
       <div class="flex justify-between items-center">
      <a class="block p-4 text-blue-700" href="/listings.php">
        <i class="fa fa-arrow-alt-circle-left"></i>
        Back To Listings
      </a>
      <div class="flex space-x-4 ml-4">
        <a href="/ed_patient.php?id=<?= $patient['PATIENT_ID'] ?>" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
        <!-- Delete Form -->
        <form method="POST">
          <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
        </form>
        <!-- End Delete Form -->
      </div>
    </div>
        <div class="p-4">
          <h2 class="text-xl font-semibold"><?= $patient['PATIENT_NAME'] ?></h2>
          <p class="text-gray-700 text-lg mt-2">
            We are seeking a skilled software engineer to develop high-quality
            software solutions.
          </p>
          <ul class="my-4 bg-gray-100 p-4">
            <li class="mb-2"><strong>Age:</strong> <?= $patient['PATIENT_AGE'] ?></li>
            <li class="mb-2">
              <strong>Email:</strong>&nbsp;<?= $patient['PATIENT_EMAIL'] ?>
              <span
                class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2"
                >by: <?= $patient['SYS_USERNAME'] ?></span
              >
            </li>
            <li class="mb-2">
              <strong>Tel:</strong>&nbsp;<span><?= $patient['PATIENT_TEL'] ?></span>
            </li>
            <li class="mb-2">
              <strong>Registered On:</strong>&nbsp;<span><?= $patient['PATIENT_IN'] ?></span>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <section class="container mx-auto p-4">
      <h2 class="text-xl font-semibold mb-4">Patient Details</h2>
      <div class="rounded-lg shadow-md bg-white p-4">
        <h3 class="text-lg font-semibold mb-2 text-blue-500">
          Details
        </h3>
        <p>
          <?= $patient['PATIENT_DETS'] ?>
        </p>
        <h3 class="text-lg font-semibold mt-4 mb-2 text-blue-500">Detail ID</h3>
        <p><?= $patient['DETAIL_ID'] ?></p>
      </div>
      <p class="my-5">
        Put "Job Application" as the subject of your email and attach your
        resume.
      </p>
      <a
        href="mailto:manager@company.com"
        class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium cursor-pointer text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
      >
        Apply Now
      </a>
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
