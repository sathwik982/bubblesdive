<?php
session_start();
if (!isset($_SESSION["auth"])) {
   header('Location: login.php');
   exit;
}

$userData = $_SESSION["auth"];

include '../app/database/Connection.php';
$db = new Connection();


require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (empty($_SERVER['HTTP_REFERER'])) {
   echo "You don't have access to this page directly.";
   exit;
}

include '../layout/_assign.php';

$sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` FROM `about` ORDER BY createdDate DESC";

$result = $db->run($sql);
if ($result["status"] == "success") {
   $data = $result["data"];
} else {
   $data = [];
}

if (isset($_GET['export']) && $_GET['export'] == 'excel') {
   $sql = "SELECT *, DATE_FORMAT(createdDate,'%d-%b-%Y') as `cdate` FROM `about` ORDER BY createdDate DESC";
   $result = $db->run($sql);

   if ($result["status"] == "success") {
      $about = $result["data"];
   } else {
      $about = [];
   }

   $spreadsheet = new Spreadsheet();

   $spreadsheet->getProperties()->setCreator("Your Name")
      ->setLastModifiedBy("Your Name")
      ->setTitle("About")
      ->setSubject("About Data")
      ->setDescription("About Data")
      ->setKeywords("about")
      ->setCategory("About");

   $spreadsheet->setActiveSheetIndex(0);

   $spreadsheet->getActiveSheet()->setCellValue('A1', 'Name');
   $spreadsheet->getActiveSheet()->setCellValue('B1', 'Established Date');
   $spreadsheet->getActiveSheet()->setCellValue('C1', 'Location');
   $spreadsheet->getActiveSheet()->setCellValue('D1', 'Banner Image');
   $spreadsheet->getActiveSheet()->setCellValue('E1', 'Status');

   $row = 2;
   foreach ($about as $details) {
      $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $details['name']);
      $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $details['establishedDate']);
      $spreadsheet->getActiveSheet()->setCellValue('C' . $row, $details['location']);
      $spreadsheet->getActiveSheet()->setCellValue('D' . $row, $details['bannerImage']);
      $spreadsheet->getActiveSheet()->setCellValue('E' . $row, $details['status']);

      $row++;
   }

   ob_clean();

   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   header('Content-Disposition: attachment;filename="about.xlsx"');
   header('Cache-Control: max-age=0');

   $writer = new Xlsx($spreadsheet);
   $writer->save('php://output');
   exit;
}
?>


<!--TEMPLATE STARTS -->
<?php include '../layout/_header.php'; ?>
<!-- styles -->
<?php include '../layout/_style.header.php'; ?>
<?php include '../layout/_permissions.php'; ?>
<!-- Page Container START -->
<div class="page-container">
   <!-- Content Wrapper START -->
   <div class="main-content">
      <div class="page-headers">
         <h2 class="header-title">About</h2>
         <div class="header-sub-title">
         </div>
      </div>
      <div class="container">
         <div class="row">
            <div class="card-title" style="margin-bottom:10px;">
               <div class="row">
                  <div class="col-lg-12">
                     <!-- Start accordion -->
                     <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="flush-headingOne">
                              <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" style="padding-top:5px; padding-bottom:5px;">
                                 <i class="fa fa-filter" style="font-size:20px;"></i> &nbsp; Filters
                              </button>
                           </h2>
                           <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                              <!-- Data Filter -->
                              <div class="row" style="padding-top:10px;">
                                 <div class="col-md-2">
                                    <label style="color:#000000; font-size:12px;" for="fromDate">From Date</label>
                                    <input type="date" class="form-control" id="fromDate" name="fromDate" value="<?= date("Y-m-d") ?>" placeholder="From Date" max="<?php echo date("Y-m-d"); ?>">
                                 </div>
                                 <div class="col-md-2">
                                    <label style="color:#000000; font-size:12px;" for="toDate">To Date</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate" value="<?= date("Y-m-d") ?>" placeholder="To Date" max="<?php echo date("Y-m-d"); ?>">
                                 </div>
                                 <div class="col-md-2">
                                    <label style="color:#000000; font-size:12px;" for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                       <option value="">Show All</option>
                                       <option value="UNPUBLISH">UNPUBLISH</option>
                                       <option value="PUBLISH">PUBLISH</option>
                                    </select>
                                 </div>
                              </div>
                              <!-- Data Filter -->
                           </div>
                        </div>
                     </div>
                     <div class="accordion accordion-flush" id="accordionFlushSorting">
                        <div class="accordion-item">
                           <h2 class="accordion-header" id="flush-headingSorting">
                              <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSorting" aria-expanded="false" aria-controls="flush-collapseSorting" style="padding-top:5px; padding-bottom:5px;">
                                 <i class="fa fa-sort" style="font-size:20px;"></i> &nbsp; Sorting
                              </button>
                           </h2>
                           <div id="flush-collapseSorting" class="accordion-collapse collapse" aria-labelledby="flush-headingSorting" data-bs-parent="#accordionFlushSorting" style="">
                              <!-- Sorting Options -->
                              <div class="row" style="padding-top:10px;">
                                 <div class="col-md-2">
                                    <label style="color:#000000; font-size:12px;" for="sortBy">Sort By</label>
                                    <select class="form-control" id="sortBy" name="sortBy">
                                       <option value="tripName">Trip Name</option>
                                       <option value="price">Price</option>
                                       <!-- Add more sorting options as needed -->
                                    </select>
                                 </div>
                                 <div class="col-md-2">
                                    <label style="color:#000000; font-size:12px;" for="sortOrder">Sort Order</label>
                                    <select class="form-control" id="sortOrder" name="sortOrder">
                                       <option value="asc">Ascending</option>
                                       <option value="desc">Descending</option>
                                    </select>
                                 </div>
                              </div>
                              <!-- Sorting Options -->
                           </div>
                        </div>
                     </div>

                     <!-- end accordion -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <?php if ($displayAdd) : ?>
            <a href="add.php" class="btn btn-success mb-3">Add</a>
            <a href="?export=excel" class="btn btn-success mb-3" id="exportExcelBtn">Export to Excel</a>
         <?php endif; ?>
         <div class="table-responsive">
            <table id="aboutTable" class="table table-hover">
               <thead>
                  <tr>
                     <th>Sl.No</th>
                     <th>Name</th>
                     <th>Established Date</th>
                     <th>Location</th>
                     <th>Banner Image</th>
                     <th>Status</th>
                     <?php if ($displayEdit || $displayView || $displayDelete) : ?>
                        <th>Action</th>
                     <?php endif; ?>
                  </tr>
               </thead>
               <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($data as $details) : ?>
                     <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $details["name"] ?></td>
                        <td><?= $details["establishedDate"] ?></td>
                        <td><?= $details["location"] ?></td>
                        <td>
                           <?php if (!empty($details["bannerImage"])) : ?>
                              <a href="<?= $details["bannerImage"] ?>" target="_blank" style="text-decoration:none;">Click me</a>
                           <?php else : ?>
                              <span class="-">-</span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php
                           $status = $details["status"];
                           if ($status == "PUBLISH") {
                              echo '<span class="badge badge-success">PUBLISH</span>';
                           } else {
                              echo '<span class="badge badge-danger">UNPUBLISH</span>';
                           }
                           ?>
                        </td>
                        <td>
                           <?php if ($displayEdit) : ?>
                              <a href="edit.php?id=<?= $details['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                           <?php endif; ?>
                           <?php if ($displayView) : ?>
                              <a href="view.php?id=<?= $details['id'] ?>" class="btn btn-sm btn-info">View</a>
                           <?php endif; ?>
                           <?php if ($displayDelete) : ?>
                              <a href="delete.php?id=<?= $details['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                           <?php endif; ?>
                        </td>
                     </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
      <!-- Footer START -->
      <?php include '../layout/_footer.php'; ?>
      <?php include '../layout/_scripts.php'; ?>
      <!-- Include XLSX library -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
      <script>
         $(document).ready(function() {
            $('#aboutTable').DataTable();
         });


         function fetchFilteredData() {
            var fromDate = document.getElementById("fromDate").value;
            var toDate = document.getElementById("toDate").value;
            var status = document.getElementById("status").value;

            $.ajax({
               url: 'about.php',
               method: 'POST',
               data: {
                  fromDate: fromDate,
                  toDate: toDate,
                  status: status
               },
               success: function(response) {
                  $('#aboutTable tbody').html(response);
               },
               error: function(xhr, status, error) {
                  console.error(xhr.responseText);
               }
            });
         }



         $(document).ready(function() {
            $('#fromDate, #toDate, #status').change(function() {
               fetchFilteredData();
            });
         });
      </script>
      </body>

      </html>