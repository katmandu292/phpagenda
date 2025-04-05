<?php
require 'data_sn.php';

$stmt = $pdo->prepare('select rc.CONSLT_ID, rc.CONSLT_SLOT, rc.PATIENT_ID,
rc.CONSLT_TYP, rc.CONSLT_DESCR_SHORT, rc.CREATED_AT, dt.CONSLT_FINAL,
pt.PATIENT_NAME, pt.PATIENT_SURNAME, ct.CONSLT_TYPE_NM
from TBL_CONSLT_RECS rc
join DET_CONSULTS dt on (rc.CONSLT_ID = dt.CONSLT_ID)
join TBL_PATIENTS pt on (pt.PATIENT_ID = rc.PATIENT_ID)
join TBL_CONSLT_TYPE ct on (ct.CONSLT_TYPE_ID = rc.CONSLT_TYP)');

$stmt->execute();
$consults = $stmt->fetchAll();

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
    <!-- Nav -->
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

    <!-- Showcase -->
    <section
      class="showcase relative bg-cover bg-center bg-no-repeat h-72 flex items-center"
    >
      <div class="overlay"></div>
      <div class="container mx-auto text-center z-10">
        <h2 class="text-4xl text-white font-bold mb-4">Find Your Dream Job</h2>
        <form class="mb-4 block mx-5 md:mx-auto">
          <input
            type="text"
            name="keywords"
            placeholder="Keywords"
            class="w-full md:w-auto mb-2 px-4 py-2 focus:outline-none"
          />
          <input
            type="text"
            name="location"
            placeholder="Location"
            class="w-full md:w-auto mb-2 px-4 py-2 focus:outline-none"
          />
          <button
            class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 focus:outline-none"
          >
          <i class="fa fa-search"></i> Search
          </button>
        </form>
      </div>
    </section>

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
        <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">Current Consults</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
<?php foreach($consults as $consult) : ?>
          <!-- Job Listing: <?= $consult['CONSLT_ID'] ?> -->
          <div class="rounded-lg shadow-md bg-white">
            <div class="p-4">
              <h2 class="text-xl font-semibold"><?= $consult['PATIENT_NAME'] ?>&nbsp;<?= $consult['PATIENT_SURNAME'] ?></h2>
              <p class="text-gray-700 text-lg mt-2">
                <?= $consult['CONSLT_DESCR_SHORT'] ?>
              </p>
              <ul class="my-4 bg-gray-100 p-4 rounded">
                <li class="mb-2"><strong>Slot:</strong> <?= $consult['CONSLT_SLOT'] ?></li>
                <li class="mb-2">
                  <strong>Location:</strong> New York
                  <span class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2"><?= $consult['CONSLT_TYPE_NM'] ?></span>
                </li>
                <li class="mb-2">
                  <strong>Tags:</strong> <span>Development</span>,
                  <span>Coding</span>
                </li>
              </ul>
              <a href="consult.php?id=<?= $consult['CONSLT_ID'] ?>"
                class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
              >
                Details
              </a>
            </div>
          </div>
<?php endforeach ?>
        </div>
        <a href="listings.html" class="block text-xl text-center">
          <i class="fa fa-arrow-alt-circle-right"></i>
          Show All Patients
        </a>
      </section>

       <!-- Bottom Banner -->
      <section class="container mx-auto my-6">
      <div
        class="bg-blue-800 text-white rounded p-4 flex items-center justify-between"
      >
        <div>
          <h2 class="text-xl font-semibold">Looking to hire?</h2>
          <p class="text-gray-200 text-lg mt-2">
            Post your job listing now and find the perfect candidate.
          </p>
        </div>
        <a
          href="post-job.html"
          class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"
        >
          <i class="fa fa-edit"></i> Post a Job
        </a>
      </div>
    </section>
     
  </body>
</html>
