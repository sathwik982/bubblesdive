<?php
session_start();
if (!isset($_SESSION["auth"])) {
    header('Location: login.php');
    exit;
}

include '../app/database/Connection.php';
$db = new Connection();

if (empty($_SERVER['HTTP_REFERER'])) {
    echo "You don't have access to this page directly.";
    exit;
}

$userData = $_SESSION["auth"];

?>

<?php include '../layout/_assign.php';




$error_message = '';
$success_message = '';

if (!empty($_GET['roleId'])) {
    $roleId = filter_input(INPUT_GET, 'roleId', FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT r.roleId, 
    r.roleName, 
    ar.assign_add, 
    ar.assign_edit, 
    ar.assign_view, 
    ar.assign_delete, 
    ar.assign_SelectAll, 
    ar.assign_dashboard, 
    ar.assign_about, 
    ar.assign_gallery,
    ar.assign_sites, 
    ar.assign_travel, 
    ar.assign_courses, 
    ar.assign_coursebookings,
    ar.assign_booking,
    ar.assign_products,
    ar.assign_orders, 
    ar.assign_team, 
    ar.assign_blog, 
    ar.assign_tc, 
    ar.assign_faq, 
    ar.assign_customers, 
    ar.assign_reports, 
    ar.assign_users, 
    ar.assign_contact, 
    ar.assign_testomonials, 
    ar.assign_Select,
    ar.assign_gallery_add, 
    ar.assign_gallery_edit, 
    ar.assign_gallery_view, 
    ar.assign_gallery_delete, 
    ar.assign_tripbookings_view, 
    ar.assign_coursebookings_view, 
    ar.assign_products_add, 
    ar.assign_products_edit, 
    ar.assign_products_view, 
    ar.assign_products_delete, 
    ar.assign_productorders_view, 
    ar.assign_producttype_add, 
    ar.assign_producttype_edit, 
    ar.assign_producttype_view, 
    ar.assign_producttype_delete, 
    ar.assign_sites_add, 
    ar.assign_sites_edit, 
    ar.assign_sites_delete, 
    ar.assign_sites_view, 
    ar.assign_teams_add, 
    ar.assign_teams_edit, 
    ar.assign_teams_view, 
    ar.assign_teams_delete, 
    ar.assign_courses_add,
    ar.assign_courses_edit,
    ar.assign_courses_view,
    ar.assign_courses_delete,
    ar.assign_trips_add,
    ar.assign_trips_edit,
    ar.assign_trips_view,
    ar.assign_trips_delete,
    ar.assign_testimonials_add, 
    ar.assign_testimonials_edit, 
    ar.assign_testimonials_delete, 
    ar.assign_testimonials_view, 
    ar.assign_roles_add, 
    ar.assign_roles_edit, 
    ar.assign_roles_view, 
    ar.assign_roles_delete, 
    ar.assign_users_register, 
    ar.assign_users_edit, 
    ar.assign_users_view, 
    ar.assign_users_delete, 
    ar.assign_contactform_view, 
    ar.assign_contactform_delete, 
    ar.assign_blogs_add, 
    ar.assign_blogs_edit, 
    ar.assign_blogs_delete, 
    ar.assign_blogs_view, 
    ar.assign_terms_conditions_add, 
    ar.assign_terms_conditions_edit, 
    ar.assign_terms_conditions_view, 
    ar.assign_terms_conditions_delete, 
    ar.assign_faq_add, 
    ar.assign_faq_edit, 
    ar.assign_faq_delete, 
    ar.assign_faq_view, 
    ar.assign_customers_edit,
    ar.assign_customers_view
FROM 
    roles r 
LEFT JOIN 
    assign_roles ar ON r.roleId = ar.roleId 
WHERE 
    ar.roleId = :roleId
ORDER BY 
    ar.createdDate DESC";
    $stmt = $db->getConnection()->prepare($sql);
    $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $assign_roles = $result;
    } else {
        $error_message = "Role not found.";
    }
} else {
    $error_message = "Role ID not provided.";
}

include '../layout/_header.php';
?>
<?php include '../layout/_permissions.php'; ?>


<!-- Page Container START -->
<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">

        <div class="page-headers">
            <h2 class="header-title">View Record</h2>
            <div class="header-sub-title"></div>
        </div>

        <div class="container">
            <div class="table-responsive">
                <?php if (empty($assign_roles)) : ?>
                    <h5>No data found</h5>
                <?php else : ?>
                    <form method="POST" action="assign.php">
                        <table class="table table-hover" style="width:100%">
                            <tbody>
                                <?php foreach ($assign_roles as $assign) : ?>
                                    <tr>
                                        <td><?= $assign['roleName'] ?></td>
                                        <?php
                                        $roleId = $assign["roleId"];
                                        $addChecked = $assign["assign_add"] == 1 ? 'checked' : '';
                                        $editChecked = $assign["assign_edit"] == 1 ? 'checked' : '';
                                        $viewChecked = $assign["assign_view"] == 1 ? 'checked' : '';
                                        $deleteChecked = $assign["assign_delete"] == 1 ? 'checked' : '';
                                        $selectAllChecked = $assign["assign_SelectAll"] == 1 ? 'checked' : '';
                                        $galleryAddChecked = $assign["assign_gallery_add"] == 1 ? 'checked' : '';
                                        $galleryEditChecked = $assign["assign_gallery_edit"] == 1 ? 'checked' : '';
                                        $galleryViewChecked = $assign["assign_gallery_view"] == 1 ? 'checked' : '';
                                        $galleryDeleteChecked = $assign["assign_gallery_delete"] == 1 ? 'checked' : '';
                                        $tripbookingsViewChecked = $assign["assign_tripbookings_view"] == 1 ? 'checked' : '';
                                        $coursebookingsViewChecked = $assign["assign_coursebookings_view"] == 1 ? 'checked' : '';
                                        $productsAddChecked = $assign["assign_products_add"] == 1 ? 'checked' : '';
                                        $productsEditChecked = $assign["assign_products_edit"] == 1 ? 'checked' : '';
                                        $productsViewChecked = $assign["assign_products_view"] == 1 ? 'checked' : '';
                                        $productsDeleteChecked = $assign["assign_products_delete"] == 1 ? 'checked' : '';
                                        $productordersViewChecked = $assign["assign_productorders_view"] == 1 ? 'checked' : '';
                                        $producttypeAddChecked = $assign["assign_producttype_add"] == 1 ? 'checked' : '';
                                        $producttypeEditChecked = $assign["assign_producttype_edit"] == 1 ? 'checked' : '';
                                        $producttypeViewChecked = $assign["assign_producttype_view"] == 1 ? 'checked' : '';
                                        $producttypeDeleteChecked = $assign["assign_producttype_delete"] == 1 ? 'checked' : '';
                                        $sitesAddChecked = $assign["assign_sites_add"] == 1 ? 'checked' : '';
                                        $sitesEditChecked = $assign["assign_sites_edit"] == 1 ? 'checked' : '';
                                        $sitesDeleteChecked = $assign["assign_sites_delete"] == 1 ? 'checked' : '';
                                        $sitesViewChecked = $assign["assign_sites_view"] == 1 ? 'checked' : '';
                                        $teamsAddChecked = $assign["assign_teams_add"] == 1 ? 'checked' : '';
                                        $teamsEditChecked = $assign["assign_teams_edit"] == 1 ? 'checked' : '';
                                        $teamsViewChecked = $assign["assign_teams_view"] == 1 ? 'checked' : '';
                                        $teamsDeleteChecked = $assign["assign_teams_delete"] == 1 ? 'checked' : '';

                                        $testimonialsAddChecked = $assign["assign_testimonials_add"] == 1 ? 'checked' : '';
                                        $testimonialsEditChecked = $assign["assign_testimonials_edit"] == 1 ? 'checked' : '';
                                        $testimonialsDeleteChecked = $assign["assign_testimonials_delete"] == 1 ? 'checked' : '';
                                        $testimonialsViewChecked = $assign["assign_testimonials_view"] == 1 ? 'checked' : '';
                                        $rolesAddChecked = $assign["assign_roles_add"] == 1 ? 'checked' : '';
                                        $rolesEditChecked = $assign["assign_roles_edit"] == 1 ? 'checked' : '';
                                        $rolesViewChecked = $assign["assign_roles_view"] == 1 ? 'checked' : '';
                                        $rolesDeleteChecked = $assign["assign_roles_delete"] == 1 ? 'checked' : '';
                                        $usersRegisterChecked = $assign["assign_users_register"] == 1 ? 'checked' : '';
                                        $usersEditChecked = $assign["assign_users_edit"] == 1 ? 'checked' : '';
                                        $usersViewChecked = $assign["assign_users_view"] == 1 ? 'checked' : '';
                                        $usersDeleteChecked = $assign["assign_users_delete"] == 1 ? 'checked' : '';
                                        $contactformViewChecked = $assign["assign_contactform_view"] == 1 ? 'checked' : '';
                                        $contactformDeleteChecked = $assign["assign_contactform_delete"] == 1 ? 'checked' : '';
                                        $blogsAddChecked = $assign["assign_blogs_add"] == 1 ? 'checked' : '';
                                        $blogsEditChecked = $assign["assign_blogs_edit"] == 1 ? 'checked' : '';
                                        $blogsDeleteChecked = $assign["assign_blogs_delete"] == 1 ? 'checked' : '';
                                        $blogsViewChecked = $assign["assign_blogs_view"] == 1 ? 'checked' : '';
                                        $termsConditionsAddChecked = $assign["assign_terms_conditions_add"] == 1 ? 'checked' : '';
                                        $termsConditionsEditChecked = $assign["assign_terms_conditions_edit"] == 1 ? 'checked' : '';
                                        $termsConditionsViewChecked = $assign["assign_terms_conditions_view"] == 1 ? 'checked' : '';
                                        $termsConditionsDeleteChecked = $assign["assign_terms_conditions_delete"] == 1 ? 'checked' : '';
                                        $faqAddChecked = $assign["assign_faq_add"] == 1 ? 'checked' : '';
                                        $faqEditChecked = $assign["assign_faq_edit"] == 1 ? 'checked' : '';
                                        $faqDeleteChecked = $assign["assign_faq_delete"] == 1 ? 'checked' : '';
                                        $faqViewChecked = $assign["assign_faq_view"] == 1 ? 'checked' : '';
                                        $customersEditChecked = $assign["assign_customers_edit"] == 1 ? 'checked' : '';
                                        $customersViewChecked = $assign["assign_customers_view"] == 1 ? 'checked' : '';
                                        $tripsAddChecked = $assign["assign_trips_add"] == 1 ? 'checked' : '';
                                        $tripsEditChecked = $assign["assign_trips_edit"] == 1 ? 'checked' : '';
                                        $tripsViewChecked = $assign["assign_trips_view"] == 1 ? 'checked' : '';
                                        $tripsDeleteChecked = $assign["assign_trips_delete"] == 1 ? 'checked' : '';
                                        $coursesAddChecked = $assign["assign_courses_add"] == 1 ? 'checked' : '';
                                        $coursesEditChecked = $assign["assign_courses_edit"] == 1 ? 'checked' : '';
                                        $coursesViewChecked = $assign["assign_courses_view"] == 1 ? 'checked' : '';
                                        $coursesDeleteChecked = $assign["assign_courses_delete"] == 1 ? 'checked' : '';

                                        ?>
                                        <td>
                                            <label for="selectAll<?= $roleId ?>" class="mr-2">Select All</label>
                                            <input type="checkbox" id="selectAll<?= $roleId ?>" class="role-select-all-checkbox" name="assign_SelectAll" value="1" <?= $selectAllChecked ?> disabled>
                                        </td>
                                        <td class="d-flex flex-column gap-4">
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="add" class="mr-2">About Add</label>
                                                <input id="add" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_add]" value="1" <?= $addChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="edit" class="mr-2">About Edit</label>
                                                <input id="edit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_edit]" value="1" <?= $editChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="view" class="mr-2"> About View</label>
                                                <input id="view" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_view]" value="1" <?= $viewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="delete" class="mr-2"> About Delete</label>
                                                <input id="delete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_delete]" value="1" <?= $deleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="galleryAdd" class="mr-2">Gallery Add</label>
                                                <input id="galleryAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_gallery_add]" value="1" <?= $galleryAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="galleryEdit" class="mr-2">Gallery Edit</label>
                                                <input id="galleryEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_gallery_edit]" value="1" <?= $galleryEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="galleryView" class="mr-2">Gallery View</label>
                                                <input id="galleryView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_gallery_view]" value="1" <?= $galleryViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="galleryDelete" class="mr-2">Gallery Delete</label>
                                                <input id="galleryDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_gallery_delete]" value="1" <?= $galleryDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="tripbookingsView" class="mr-2">Trip Bookings View</label>
                                                <input id="tripbookingsView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_tripbookings_view]" value="1" <?= $tripbookingsViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="coursebookingsView" class="mr-2">Course Bookings View</label>
                                                <input id="coursebookingsView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_coursebookings_view]" value="1" <?= $coursebookingsViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Products Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="productsAdd" class="mr-2">Products Add</label>
                                                <input id="productsAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_products_add]" value="1" <?= $productsAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Products Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="productsEdit" class="mr-2">Products Edit</label>
                                                <input id="productsEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_products_edit]" value="1" <?= $productsEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Products View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="productsView" class="mr-2">Products View</label>
                                                <input id="productsView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_products_view]" value="1" <?= $productsViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Products Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="productsDelete" class="mr-2">Products Delete</label>
                                                <input id="productsDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_products_delete]" value="1" <?= $productsDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Product Orders View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="productordersView" class="mr-2">Product Orders View</label>
                                                <input id="productordersView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_productorders_view]" value="1" <?= $productordersViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Product Type Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="producttypeAdd" class="mr-2">Product Type Add</label>
                                                <input id="producttypeAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_producttype_add]" value="1" <?= $producttypeAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Product Type Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="producttypeEdit" class="mr-2">Product Type Edit</label>
                                                <input id="producttypeEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_producttype_edit]" value="1" <?= $producttypeEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Product Type View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="producttypeView" class="mr-2">Product Type View</label>
                                                <input id="producttypeView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_producttype_view]" value="1" <?= $producttypeViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Product Type Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="producttypeDelete" class="mr-2">Product Type Delete</label>
                                                <input id="producttypeDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_producttype_delete]" value="1" <?= $producttypeDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Sites Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="sitesAdd" class="mr-2">Sites Add</label>
                                                <input id="sitesAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_sites_add]" value="1" <?= $sitesAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Sites Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="sitesEdit" class="mr-2">Sites Edit</label>
                                                <input id="sitesEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_sites_edit]" value="1" <?= $sitesEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Sites Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="sitesDelete" class="mr-2">Sites Delete</label>
                                                <input id="sitesDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_sites_delete]" value="1" <?= $sitesDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Sites View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="sitesView" class="mr-2">Sites View</label>
                                                <input id="sitesView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_sites_view]" value="1" <?= $sitesViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Add the rest of the fields -->
                                            <!-- Example: Teams Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="teamsAdd" class="mr-2">Teams Add</label>
                                                <input id="teamsAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_teams_add]" value="1" <?= $teamsAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Teams Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="teamsEdit" class="mr-2">Teams Edit</label>
                                                <input id="teamsEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_teams_edit]" value="1" <?= $teamsEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Teams View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="teamsView" class="mr-2">Teams View</label>
                                                <input id="teamsView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_teams_view]" value="1" <?= $teamsViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Teams Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="teamsDelete" class="mr-2">Teams Delete</label>
                                                <input id="teamsDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_teams_delete]" value="1" <?= $teamsDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Customers Edit -->

                                            <!-- Example: Testimonials Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="testimonialsAdd" class="mr-2">Testimonials Add</label>
                                                <input id="testimonialsAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_testimonials_add]" value="1" <?= $testimonialsAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Testimonials Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="testimonialsEdit" class="mr-2">Testimonials Edit</label>
                                                <input id="testimonialsEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_testimonials_edit]" value="1" <?= $testimonialsEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Testimonials Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="testimonialsDelete" class="mr-2">Testimonials Delete</label>
                                                <input id="testimonialsDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_testimonials_delete]" value="1" <?= $testimonialsDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Testimonials View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="testimonialsView" class="mr-2">Testimonials View</label>
                                                <input id="testimonialsView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_testimonials_view]" value="1" <?= $testimonialsViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Roles Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="rolesAdd" class="mr-2">Roles Add</label>
                                                <input id="rolesAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_roles_add]" value="1" <?= $rolesAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Roles Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="rolesEdit" class="mr-2">Roles Edit</label>
                                                <input id="rolesEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_roles_edit]" value="1" <?= $rolesEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Roles View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="rolesView" class="mr-2">Roles View</label>
                                                <input id="rolesView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_roles_view]" value="1" <?= $rolesViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Roles Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="rolesDelete" class="mr-2">Roles Delete</label>
                                                <input id="rolesDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_roles_delete]" value="1" <?= $rolesDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Users Register -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="usersRegister" class="mr-2">Users Register</label>
                                                <input id="usersRegister" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_users_register]" value="1" <?= $usersRegisterChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Users Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="usersEdit" class="mr-2">Users Edit</label>
                                                <input id="usersEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_users_edit]" value="1" <?= $usersEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Users View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="usersView" class="mr-2">Users View</label>
                                                <input id="usersView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_users_view]" value="1" <?= $usersViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Users Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="usersDelete" class="mr-2">Users Delete</label>
                                                <input id="usersDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_users_delete]" value="1" <?= $usersDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Contact Form View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="contactformView" class="mr-2">Contact Form View</label>
                                                <input id="contactformView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_contactform_view]" value="1" <?= $contactformViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Contact Form Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="contactformDelete" class="mr-2">Contact Form Delete</label>
                                                <input id="contactformDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_contactform_delete]" value="1" <?= $contactformDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Blogs Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="blogsAdd" class="mr-2">Blogs Add</label>
                                                <input id="blogsAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_blogs_add]" value="1" <?= $blogsAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Blogs Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="blogsEdit" class="mr-2">Blogs Edit</label>
                                                <input id="blogsEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_blogs_edit]" value="1" <?= $blogsEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Blogs Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="blogsDelete" class="mr-2">Blogs Delete</label>
                                                <input id="blogsDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_blogs_delete]" value="1" <?= $blogsDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Blogs View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="blogsView" class="mr-2">Blogs View</label>
                                                <input id="blogsView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_blogs_view]" value="1" <?= $blogsViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Terms & Conditions Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="termsConditionsAdd" class="mr-2">Terms & Conditions Add</label>
                                                <input id="termsConditionsAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_terms_conditions_add]" value="1" <?= $termsConditionsAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Terms & Conditions Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="termsConditionsEdit" class="mr-2">Terms & Conditions Edit</label>
                                                <input id="termsConditionsEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_terms_conditions_edit]" value="1" <?= $termsConditionsEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Terms & Conditions View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="termsConditionsView" class="mr-2">Terms & Conditions View</label>
                                                <input id="termsConditionsView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_terms_conditions_view]" value="1" <?= $termsConditionsViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Terms & Conditions Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="termsConditionsDelete" class="mr-2">Terms & Conditions Delete</label>
                                                <input id="termsConditionsDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_terms_conditions_delete]" value="1" <?= $termsConditionsDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: FAQ Add -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="faqAdd" class="mr-2">FAQ Add</label>
                                                <input id="faqAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_faq_add]" value="1" <?= $faqAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: FAQ Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="faqEdit" class="mr-2">FAQ Edit</label>
                                                <input id="faqEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_faq_edit]" value="1" <?= $faqEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: FAQ Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="faqDelete" class="mr-2">FAQ Delete</label>
                                                <input id="faqDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_faq_delete]" value="1" <?= $faqDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: FAQ View -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="faqView" class="mr-2">FAQ View</label>
                                                <input id="faqView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_faq_view]" value="1" <?= $faqViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Customers Delete -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="customersEdit" class="mr-2">Customers Edit</label>
                                                <input id="customersEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_customers_edit]" value="1" <?= $customersEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Customers Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="customersView" class="mr-2">Customers View</label>
                                                <input id="customersView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_customers_view]" value="1" <?= $customersViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="coursesAdd" class="mr-2">Courses Add</label>
                                                <input id="coursesAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_courses_add]" value="1" <?= $coursesAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Customers Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="coursesEdit" class="mr-2">Courses Edit</label>
                                                <input id="coursesEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_courses_edit]" value="1" <?= $coursesEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="coursesView" class="mr-2">Courses View</label>
                                                <input id="coursesView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_courses_view]" value="1" <?= $coursesViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Customers Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="coursesDelete" class="mr-2">Courses Delete</label>
                                                <input id="coursesDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_courses_delete]" value="1" <?= $coursesDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="tripsAdd" class="mr-2">Trips Add</label>
                                                <input id="tripsAdd" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_trips_add]" value="1" <?= $tripsAddChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Customers Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="tripsEdit" class="mr-2">Trips Edit</label>
                                                <input id="tripsEdit" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_trips_edit]" value="1" <?= $tripsEditChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="tripsView" class="mr-2">Trips View</label>
                                                <input id="tripsView" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_trips_view]" value="1" <?= $tripsViewChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <!-- Example: Customers Edit -->
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="tripsDelete" class="mr-2">Trips Delete</label>
                                                <input id="tripsDelete" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_trips_delete]" value="1" <?= $tripsDeleteChecked ?> class="role-checkbox" disabled>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><?= $assign['roleName'] ?></td>
                                        <?php
                                        $roleId = $assign["roleId"];
                                        $DashboardChecked = $assign["assign_dashboard"] == 1 ? 'checked' : '';
                                        $AboutChecked = $assign["assign_about"] == 1 ? 'checked' : '';
                                        $GalleryChecked = $assign["assign_gallery"] == 1 ? 'checked' : '';
                                        $SitesChecked = $assign["assign_sites"] == 1 ? 'checked' : '';
                                        $TravelChecked = $assign["assign_travel"] == 1 ? 'checked' : '';
                                        $CoursesChecked = $assign["assign_courses"] == 1 ? 'checked' : '';
                                        $CoursesBookingsChecked = $assign["assign_coursebookings"] == 1 ? 'checked' : '';
                                        $BookingChecked = $assign["assign_booking"] == 1 ? 'checked' : '';
                                        $ProductsChecked = $assign["assign_products"] == 1 ? 'checked' : '';
                                        $OrdersChecked = $assign["assign_orders"] == 1 ? 'checked' : '';
                                        $TeamChecked = $assign["assign_team"] == 1 ? 'checked' : '';
                                        $BlogChecked = $assign["assign_blog"] == 1 ? 'checked' : '';
                                        $TermsChecked = $assign["assign_tc"] == 1 ? 'checked' : '';
                                        $FAQChecked = $assign["assign_faq"] == 1 ? 'checked' : '';
                                        $CustomersChecked = $assign["assign_customers"] == 1 ? 'checked' : '';
                                        $ReportsChecked = $assign["assign_reports"] == 1 ? 'checked' : '';
                                        $UsersChecked = $assign["assign_users"] == 1 ? 'checked' : '';
                                        $ContactChecked = $assign["assign_contact"] == 1 ? 'checked' : '';
                                        $TestimonialsChecked = $assign["assign_testomonials"] == 1 ? 'checked' : '';
                                        $selectChecked = $assign["assign_Select"] == 1 ? 'checked' : '';
                                        ?>
                                        <td>
                                            <label for="selectAll<?= $roleId ?>" class="mr-2">Select All</label>
                                            <input type="checkbox" id="selectAll<?= $roleId ?>" class="role-select-all-checkbox" name="assign_Select" value="1" <?= $selectChecked ?> disabled>
                                        </td>
                                        <td class="d-flex flex-column gap-4">
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="dashboard" class="mr-2">Dashboard</label>
                                                <input id="dashboard" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_dashboard]" value="1" <?= $DashboardChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="about" class="mr-2">About</label>
                                                <input id="about" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_about]" value="1" <?= $AboutChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="gallery" class="mr-2">Gallery</label>
                                                <input id="gallery" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_gallery]" value="1" <?= $GalleryChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="sites" class="mr-2">Diving Sites</label>
                                                <input id="sites" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_sites]" value="1" <?= $SitesChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="travel" class="mr-2">Travel</label>
                                                <input id="travel" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_travel]" value="1" <?= $TravelChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="coursesbookings" class="mr-2">Courses</label>
                                                <input id="coursesbookings" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_coursebookings]" value="1" <?= $CoursesChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="courses" class="mr-2">Course Bookings</label>
                                                <input id="courses" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_courses]" value="1" <?= $CoursesBookingsChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="booking" class="mr-2">Trip Bookings</label>
                                                <input id="booking" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_booking]" value="1" <?= $BookingChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="products" class="mr-2">Products</label>
                                                <input id="products" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_products]" value="1" <?= $ProductsChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="orders" class="mr-2">Product Orders</label>
                                                <input id="orders" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_orders]" value="1" <?= $OrdersChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="team" class="mr-2">Teams</label>
                                                <input id="team" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_team]" value="1" <?= $TeamChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="blog" class="mr-2">Articles</label>
                                                <input id="blog" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_blog]" value="1" <?= $BlogChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="terms" class="mr-2">Terms</label>
                                                <input id="terms" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_tc]" value="1" <?= $TermsChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="faq" class="mr-2">FAQ</label>
                                                <input id="faq" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_faq]" value="1" <?= $FAQChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="customers" class="mr-2">Customers</label>
                                                <input id="customers" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_customers]" value="1" <?= $CustomersChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="reports" class="mr-2">Reports</label>
                                                <input id="reports" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_reports]" value="1" <?= $ReportsChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="users" class="mr-2">Users</label>
                                                <input id="users" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_users]" value="1" <?= $UsersChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="contact" class="mr-2">Contact</label>
                                                <input id="contact" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_contact]" value="1" <?= $ContactChecked ?> class="role-checkbox" disabled>
                                            </div>
                                            <div class="flex align-items-center justify-content-center">
                                                <label for="testomonials" class="mr-2">Testimonials</label>
                                                <input id="testomonials" type="checkbox" name="assign_roles[<?= $roleId ?>][assign_testomonials]" value="1" <?= $TestimonialsChecked ?> class="role-checkbox" disabled>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="index.php" class="btn btn-success">Back</a>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php
        include '../layout/_footer.php';
        include '../layout/_scripts.php';
        ?>

        <script>
            $(document).ready(function() {
                <?php if (!empty($error_message) || !empty($success_message) || !empty($no_changes_message)) : ?>
                    $('#messageModal').modal('show');
                <?php endif; ?>
            });
        </script>
        </body>

        </html>