<?php
$sql = "SELECT assign_add, assign_edit, assign_delete, assign_view, assign_dashboard, assign_about, assign_gallery, assign_sites, assign_travel, assign_courses, assign_booking, assign_products, assign_orders, assign_team, assign_blog, assign_tc, assign_faq, assign_customers, assign_reports, assign_users, assign_contact, assign_testomonials, assign_coursebookings, assign_gallery_add, assign_gallery_edit, assign_gallery_view, assign_gallery_delete, assign_tripbookings_view, assign_coursebookings_view, assign_products_add, assign_products_edit, assign_products_delete, assign_products_view, assign_productorders_view, assign_producttype_add, assign_producttype_edit, assign_producttype_delete, assign_producttype_view, assign_sites_add, assign_sites_edit, assign_sites_view, assign_sites_delete, assign_teams_add, assign_teams_edit, assign_teams_delete, assign_teams_view, assign_customers_edit, assign_testimonials_add, assign_testimonials_edit, assign_testimonials_view, assign_testimonials_delete, assign_roles_add, assign_roles_edit, assign_roles_delete, assign_roles_view, assign_users_register, assign_users_edit, assign_users_delete, assign_users_view, assign_contactform_view, assign_contactform_delete, assign_blogs_add, assign_blogs_edit, assign_blogs_delete, assign_blogs_view, assign_terms_conditions_add, assign_terms_conditions_delete, assign_terms_conditions_delete,assign_terms_conditions_edit, assign_terms_conditions_view, assign_faq_add, assign_faq_edit, assign_faq_delete, assign_faq_view, assign_customers_view, assign_courses_add,assign_courses_edit, assign_courses_view, assign_courses_delete, assign_trips_add,assign_trips_edit,assign_trips_view,assign_trips_delete FROM assign_roles WHERE roleId = :roleId";
$stmt = $db->getConnection()->prepare($sql);
$stmt->bindValue(':roleId', $userData->roleId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$permissions = [
    'add' => $result['assign_add'] ?? 0,
    'edit' => $result['assign_edit'] ?? 0,
    'delete' => $result['assign_delete'] ?? 0,
    'view' => $result['assign_view'] ?? 0,
    'dashboard' => $result['assign_dashboard'] ?? 0,
    'about' => $result['assign_about'] ?? 0,
    'gallery' => $result['assign_gallery'] ?? 0,
    'sites' => $result['assign_sites'] ?? 0,
    'travel' => $result['assign_travel'] ?? 0,
    'courses' => $result['assign_courses'] ?? 0,
    'booking' => $result['assign_booking'] ?? 0,
    'products' => $result['assign_products'] ?? 0,
    'orders' => $result['assign_orders'] ?? 0,
    'team' => $result['assign_team'] ?? 0,
    'blog' => $result['assign_blog'] ?? 0,
    'tc' => $result['assign_tc'] ?? 0,
    'faq' => $result['assign_faq'] ?? 0,
    'customers' => $result['assign_customers'] ?? 0,
    'reports' => $result['assign_reports'] ?? 0,
    'users' => $result['assign_users'] ?? 0,
    'contact' => $result['assign_contact'] ?? 0,
    'coursebookings' => $result['assign_coursebookings'] ?? 0,
    'testomonials' => $result['assign_testomonials'] ?? 0,
    'gallery_add' => $result['assign_gallery_add'] ?? 0,
    'gallery_edit' => $result['assign_gallery_edit'] ?? 0,
    'gallery_view' => $result['assign_gallery_view'] ?? 0,
    'gallery_delete' => $result['assign_gallery_delete'] ?? 0,
    'sites_add' => $result['assign_sites_add'] ?? 0,
    'sites_edit' => $result['assign_sites_edit'] ?? 0,
    'sites_delete' => $result['assign_sites_delete'] ?? 0,
    'sites_view' => $result['assign_sites_view'] ?? 0,
    'trips_add' => $result['assign_trips_add'] ?? 0,
    'trips_edit' => $result['assign_trips_edit'] ?? 0,
    'trips_delete' => $result['assign_trips_delete'] ?? 0,
    'trips_view' => $result['assign_trips_view'] ?? 0,
    'coursebookings_view' => $result['assign_coursebookings_view'] ?? 0,
    'tripbookings_view' => $result['assign_tripbookings_view'] ?? 0,
    'courses_add' => $result['assign_courses_add'] ?? 0,
    'courses_edit' => $result['assign_courses_edit'] ?? 0,
    'courses_delete' => $result['assign_courses_delete'] ?? 0,
    'courses_view' => $result['assign_courses_view'] ?? 0,
    'terms_conditions_add' => $result['assign_terms_conditions_add'] ?? 0,
    'terms_conditions_delete' => $result['assign_terms_conditions_delete'] ?? 0,
    'terms_conditions_edit' => $result['assign_terms_conditions_edit'] ?? 0,
    'terms_conditions_view' => $result['assign_terms_conditions_view'] ?? 0,
    'faq_add' => $result['assign_faq_add'] ?? 0,
    'faq_edit' => $result['assign_faq_edit'] ?? 0,
    'faq_delete' => $result['assign_faq_delete'] ?? 0,
    'faq_view' => $result['assign_faq_view'] ?? 0,
    'products_add' => $result['assign_products_add'] ?? 0,
    'products_edit' => $result['assign_products_edit'] ?? 0,
    'products_view' => $result['assign_products_view'] ?? 0,
    'products_delete' => $result['assign_products_delete'] ?? 0,
    'producttype_add' => $result['assign_producttype_add'] ?? 0,
    'producttype_edit' => $result['assign_producttype_edit'] ?? 0,
    'producttype_view' => $result['assign_producttype_view'] ?? 0,
    'producttype_delete' => $result['assign_producttype_delete'] ?? 0,
    'producttype_delete' => $result['assign_producttype_delete'] ?? 0,
    'productorders_view' => $result['assign_productorders_view'] ?? 0,
    'teams_add' => $result['assign_teams_add'] ?? 0,
    'teams_edit' => $result['assign_teams_edit'] ?? 0,
    'teams_delete' => $result['assign_teams_delete'] ?? 0,
    'teams_view' => $result['assign_teams_view'] ?? 0,
    'contactform_delete' => $result['assign_contactform_delete'] ?? 0,
    'contactform_view' => $result['assign_contactform_view'] ?? 0,
    'blogs_add' => $result['assign_blogs_add'] ?? 0,
    'blogs_edit' => $result['assign_blogs_edit'] ?? 0,
    'blogs_delete' => $result['assign_blogs_delete'] ?? 0,
    'blogs_view' => $result['assign_blogs_view'] ?? 0,
    'terms_conditions_add' => $result['assign_terms_conditions_add'] ?? 0,
    'terms_conditions_edit' => $result['assign_terms_conditions_edit'] ?? 0,
    'terms_conditions_view' => $result['assign_terms_conditions_view'] ?? 0,
    'terms_conditions_delete' => $result['assign_terms_conditions_delete'] ?? 0,
    'faq_add' => $result['assign_faq_add'] ?? 0,
    'faq_edit' => $result['assign_faq_edit'] ?? 0,
    'faq_delete' => $result['assign_faq_delete'] ?? 0,
    'faq_view' => $result['assign_faq_view'] ?? 0,
    'customers_view' => $result['assign_customers_view'] ?? 0,
    'customers_edit' => $result['assign_customers_edit'] ?? 0,
    'testimonials_add' => $result['assign_testimonials_add'] ?? 0,
    'testimonials_view' => $result['assign_testimonials_view'] ?? 0,
    'testimonials_edit' => $result['assign_testimonials_edit'] ?? 0,
    'testimonials_delete' => $result['assign_testimonials_delete'] ?? 0,
    'roles_add' => $result['assign_roles_add'] ?? 0,
    'roles_edit' => $result['assign_roles_edit'] ?? 0,
    'roles_delete' => $result['assign_roles_delete'] ?? 0,
    'roles_view' => $result['assign_roles_view'] ?? 0,
    'users_register' => $result['assign_users_register'] ?? 0,
    'users_edit' => $result['assign_users_edit'] ?? 0,
    'users_delete' => $result['assign_users_delete'] ?? 0,
    'users_view' => $result['assign_users_view'] ?? 0,



];

$displayAdd = $permissions['add'] == 1;
$displayEdit = $permissions['edit'] == 1;
$displayDelete = $permissions['delete'] == 1;
$displayView = $permissions['view'] == 1;
$displayDashboard = $permissions['dashboard'] == 1;
$displayGallery = $permissions['gallery'] == 1;
$displayAbout = $permissions['about'] == 1;
$displaySites = $permissions['sites'] == 1;
$displayTravel = $permissions['travel'] == 1;
$displayCourses = $permissions['courses'] == 1;
$displayBooking = $permissions['booking'] == 1;
$displayProducts = $permissions['products'] == 1;
$displayOrders = $permissions['orders'] == 1;
$displayTeam = $permissions['team'] == 1;
$displayBlog = $permissions['blog'] == 1;
$displayFAQ = $permissions['faq'] == 1;
$displayTC = $permissions['tc'] == 1;
$displayCustomers = $permissions['customers'] == 1;
$displayReports = $permissions['reports'] == 1;
$displayUsers = $permissions['users'] == 1;
$displayContact = $permissions['contact'] == 1;
$displayCourseBookings = $permissions['coursebookings'] == 1;
$displayTestomonials = $permissions['testomonials'] == 1;
$displayGalleryAdd = $permissions['gallery_add'] == 1;
$displayGalleryEdit = $permissions['gallery_edit'] == 1;
$displayGalleryView = $permissions['gallery_view'] == 1;
$displayGalleryDelete = $permissions['gallery_delete'] == 1;
$displaySitesAdd = $permissions['sites_add'] == 1;
$displaySitesEdit = $permissions['sites_edit'] == 1;
$displaySitesDelete = $permissions['sites_delete'] == 1;
$displaySitesView = $permissions['sites_view'] == 1;
$displayTripsAdd = $permissions['trips_add'] == 1;
$displayTripsEdit = $permissions['trips_edit'] == 1;
$displayTripsDelete = $permissions['trips_delete'] == 1;
$displayTripsView = $permissions['trips_view'] == 1;
$displayCourseBookingsView = $permissions['coursebookings_view'] == 1;
$displayTripBookingsView = $permissions['tripbookings_view'] == 1;
$displayCoursesAdd = $permissions['courses_add'] == 1;
$displayCoursesEdit = $permissions['courses_edit'] == 1;
$displayCoursesDelete = $permissions['courses_delete'] == 1;
$displayCoursesView = $permissions['courses_view'] == 1;
$displayTermsConditionsAdd = $permissions['terms_conditions_add'] == 1;
$displayTermsConditionsEdit = $permissions['terms_conditions_edit'] == 1;
$displayTermsConditionsView = $permissions['terms_conditions_view'] == 1;
$displayTermsConditionsDelete = $permissions['terms_conditions_delete'] == 1;
$displayFAQAdd = $permissions['faq_add'] == 1;
$displayFAQEdit = $permissions['faq_edit'] == 1;
$displayFAQDelete = $permissions['faq_delete'] == 1;
$displayFAQView = $permissions['faq_view'] == 1;
$displayProductsAdd = $permissions['products_add'] == 1;
$displayProductsEdit = $permissions['products_edit'] == 1;
$displayProductsView = $permissions['products_view'] == 1;
$displayProductsDelete = $permissions['products_delete'] == 1;
$displayProductTypeAdd = $permissions['producttype_add'] == 1;
$displayProductTypeEdit = $permissions['producttype_edit'] == 1;
$displayProductTypeView = $permissions['producttype_view'] == 1;
$displayProductTypeDelete = $permissions['producttype_delete'] == 1;
$displayProductOrdersView = $permissions['productorders_view'] == 1;
$displayTeamsAdd = $permissions['teams_add'] == 1;
$displayTeamsEdit = $permissions['teams_edit'] == 1;
$displayTeamsDelete = $permissions['teams_delete'] == 1;
$displayTeamsView = $permissions['teams_view'] == 1;
$displayContactFormDelete = $permissions['contactform_delete'] == 1;
$displayContactFormView = $permissions['contactform_view'] == 1;
$displayBlogsAdd = $permissions['blogs_add'] == 1;
$displayBlogsEdit = $permissions['blogs_edit'] == 1;
$displayBlogsDelete = $permissions['blogs_delete'] == 1;
$displayBlogsView = $permissions['blogs_view'] == 1;
$displayTermsConditionsAdd = $permissions['terms_conditions_add'] == 1;
$displayTermsConditionsEdit = $permissions['terms_conditions_edit'] == 1;
$displayTermsConditionsView = $permissions['terms_conditions_view'] == 1;
$displayTermsConditionsDelete = $permissions['terms_conditions_delete'] == 1;
$displayFAQAdd = $permissions['faq_add'] == 1;
$displayFAQEdit = $permissions['faq_edit'] == 1;
$displayFAQDelete = $permissions['faq_delete'] == 1;
$displayFAQView = $permissions['faq_view'] == 1;
$displayCustomersView = $permissions['customers_view'] == 1;
$displayCustomersEdit = $permissions['customers_edit'] == 1;
$displayTestimonialsAdd = $permissions['testimonials_add'] == 1;
$displayTestimonialsView = $permissions['testimonials_view'] == 1;
$displayTestimonialsEdit = $permissions['testimonials_edit'] == 1;
$displayTestimonialsDelete = $permissions['testimonials_delete'] == 1;
$displayRolesAdd = $permissions['roles_add'] == 1;
$displayRolesEdit = $permissions['roles_edit'] == 1;
$displayRolesDelete = $permissions['roles_delete'] == 1;
$displayRolesView = $permissions['roles_view'] == 1;
$displayUsersRegister = $permissions['users_register'] == 1;
$displayUsersEdit = $permissions['users_edit'] == 1;
$displayUsersDelete = $permissions['users_delete'] == 1;
$displayUsersView = $permissions['users_view'] == 1;
