<?php
/*
Plugin Name: Mediclaim
Plugin URI: https://yourwebsite.com
Description: A plugin to manage mediclaim data.
Version: 1.0.0
Author: Ravi Kumar Singh
Author URI: https://yourwebsite.com
*/

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode to display data form
function display_data_form() {
    if (!is_user_logged_in()) {
        return 'You must be logged in to view this form.';
    }

    $current_user = wp_get_current_user();
    $email = $current_user->user_email;

    global $wpdb;

    // Query to get name and code_number from v_emp_name_code_map
    $emp_data = $wpdb->get_row($wpdb->prepare(
        "SELECT name, code_number FROM v_emp_name_code_map WHERE email = %s",
        $email
    ));

    if (!$emp_data) {
        return 'It seems you are not added in the HRMS, please contact HR to do the needful.';
    }

    // Query to check if data is already submitted
    $mediclaim_data = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM mediclaim_dependant_details WHERE email_id = %s",
        $email
    ));

    if ($mediclaim_data) {

        $return_message = "<p>Welcome <b>".$emp_data->name.",</b><br><br>Please find your submitted dependant details for the medical insurance as below, if you wish to update your data click on the <i>Click here to Update Submitted Dependant Details</i> button on the bottom of the page</p>";

        $return_message .= "<table>";
        $return_message .= "<tr><td colspan='2' style='text-align: center; background: #2c3370; color: #ffffff'>Dependant 1</td></tr>";
        $return_message .= "<tr><td>Name</td><td>".$mediclaim_data->dep1_name."</td></tr>";
        $return_message .= "<tr><td>Relationship</td><td>".$mediclaim_data->dep1_relation."</td></tr>";
        $return_message .= "<tr><td>Gender</td><td>".$mediclaim_data->dep1_gender."</td></tr>";
        $return_message .= "<tr><td>DOB</td><td>".$mediclaim_data->dep1_dob."</td></tr>";

        if(strlen($mediclaim_data->dep2_name)>2) {
            $return_message .= "<tr><td colspan='2' style='text-align: center; background: #2c3370; color: #ffffff'>Dependant 2</td></tr>";
            $return_message .= "<tr><td>Name</td><td>" . $mediclaim_data->dep2_name . "</td></tr>";
            $return_message .= "<tr><td>Relationship</td><td>" . $mediclaim_data->dep2_relation . "</td></tr>";
            $return_message .= "<tr><td>Gender</td><td>" . $mediclaim_data->dep2_gender . "</td></tr>";
            $return_message .= "<tr><td>DOB</td><td>" . $mediclaim_data->dep2_dob . "</td></tr>";
        }

        if(strlen($mediclaim_data->dep3_name)>2) {
            $return_message .= "<tr><td colspan='2' style='text-align: center; background: #2c3370; color: #ffffff'>Dependant 3</td></tr>";
            $return_message .= "<tr><td>Name</td><td>" . $mediclaim_data->dep3_name . "</td></tr>";
            $return_message .= "<tr><td>Relationship</td><td>" . $mediclaim_data->dep3_relation . "</td></tr>";
            $return_message .= "<tr><td>Gender</td><td>" . $mediclaim_data->dep3_gender . "</td></tr>";
            $return_message .= "<tr><td>DOB</td><td>" . $mediclaim_data->dep3_dob . "</td></tr>";
        }

        if(strlen($mediclaim_data->dep4_name)>2) {
            $return_message .= "<tr><td colspan='2' style='text-align: center; background: #2c3370; color: #ffffff'>Dependant 4</td></tr>";
            $return_message .= "<tr><td>Name</td><td>" . $mediclaim_data->dep4_name . "</td></tr>";
            $return_message .= "<tr><td>Relationship</td><td>" . $mediclaim_data->dep4_relation . "</td></tr>";
            $return_message .= "<tr><td>Gender</td><td>" . $mediclaim_data->dep4_gender . "</td></tr>";
            $return_message .= "<tr><td>DOB</td><td>" . $mediclaim_data->dep4_dob . "</td></tr>";
        }

        if(strlen($mediclaim_data->dep5_name)>2) {
            $return_message .= "<tr><td colspan='2' style='text-align: center; background: #2c3370; color: #ffffff'>Dependant 5</td></tr>";
            $return_message .= "<tr><td>Name</td><td>" . $mediclaim_data->dep5_name . "</td></tr>";
            $return_message .= "<tr><td>Relationship</td><td>" . $mediclaim_data->dep5_relation . "</td></tr>";
            $return_message .= "<tr><td>Gender</td><td>" . $mediclaim_data->dep5_gender . "</td></tr>";
            $return_message .= "<tr><td>DOB</td><td>" . $mediclaim_data->dep5_dob . "</td></tr>";
        }
        $return_message .= "</table>";

        $return_message .= '<p align="center"><a href="/mediclaim/update-dependant-details" class="elementor-button elementor-button-link elementor-size-sm">Click here to Update Submitted Dependant Details</a></p>';;
        return $return_message;
    } else {
        return do_shortcode('[quform id="1" name="Dependant Details Form"]');
    }
}

// Register the shortcode
add_shortcode('display_data_form', 'display_data_form');



add_action('quform_pre_display_1', function($form) {
    global $wpdb;


    $current_user = wp_get_current_user();
    $email = $current_user->user_email;

    global $wpdb;

    // Query to get name and code_number from v_emp_name_code_map
    $emp_data = $wpdb->get_row($wpdb->prepare(
        "SELECT name, code_number FROM v_emp_name_code_map WHERE email = %s",
        $email
    ));

    $form->setValue('quform_1_109', $emp_data->name);
    $form->setValue('quform_1_110', $emp_data->code_number);

    //
});


add_action('quform_pre_display_2', function($form) {
    global $wpdb;


    $current_user = wp_get_current_user();
    $email = $current_user->user_email;

    global $wpdb;

    // Query to get name and code_number from v_emp_name_code_map
    $emp_data = $wpdb->get_row($wpdb->prepare(
        "SELECT name, code_number FROM v_emp_name_code_map WHERE email = %s",
        $email
    ));

    $form->setValue('quform_2_109', $emp_data->name);
    $form->setValue('quform_2_110', $emp_data->code_number);

    // Select data for update form

    $dep_data = $wpdb->get_row($wpdb->prepare(
       "select * from mediclaim_dependant_details where email_id = %s",
       $email
    ));

    if(strlen($dep_data->dep1_name)>2){
        $form->setValue('quform_2_12', $dep_data->dep1_name);
        $form->setValue('quform_2_13', $dep_data->dep1_relation);
        $form->setValue('quform_2_17', $dep_data->dep1_gender);
        $dob = $dep_data->dep1_dob;
        $d = new DateTime($dob);
        $form->setValue('quform_2_18', $d->format('Y-m-d'));
    }
    if(strlen($dep_data->dep2_name)>2){
        $form->setValue('quform_2_38','Yes');
        $form->setValue('quform_2_54', $dep_data->dep2_name);
        $form->setValue('quform_2_56', $dep_data->dep2_relation);
        $form->setValue('quform_2_59', $dep_data->dep2_gender);
        $dob = $dep_data->dep2_dob;
        $d = new DateTime($dob);
        $form->setValue('quform_2_61', $d->format('Y-m-d'));
    }
    if(strlen($dep_data->dep3_name)>2){
        $form->setValue('quform_2_62','Yes');
        $form->setValue('quform_2_66', $dep_data->dep3_name);
        $form->setValue('quform_2_68', $dep_data->dep3_relation);
        $form->setValue('quform_2_71', $dep_data->dep3_gender);
        $dob = $dep_data->dep3_dob;
        $d = new DateTime($dob);
        $form->setValue('quform_2_73', $d->format('Y-m-d'));
    }
    if(strlen($dep_data->dep4_name)>2){
        $form->setValue('quform_2_74','Yes');
        $form->setValue('quform_2_78', $dep_data->dep4_name);
        $form->setValue('quform_2_80', $dep_data->dep4_relation);
        $form->setValue('quform_2_83', $dep_data->dep4_gender);
        $dob = $dep_data->dep4_dob;
        $d = new DateTime($dob);
        $form->setValue('quform_2_85', $d->format('Y-m-d'));
    }
    if(strlen($dep_data->dep5_name)>2){
        $form->setValue('quform_2_86','Yes');
        $form->setValue('quform_2_90', $dep_data->dep5_name);
        $form->setValue('quform_2_92', $dep_data->dep5_relation);
        $form->setValue('quform_2_95', $dep_data->dep5_gender);
        $dob = $dep_data->dep5_dob;
        $d = new DateTime($dob);
        $form->setValue('quform_2_97', $d->format('Y-m-d'));
    }

});

//Pre process update form to delete existing data
add_filter('quform_pre_process_2', function (array $result, Quform_Form $form) {
    // Custom code
    $current_user = wp_get_current_user();
    $email = $current_user->user_email;

    global $wpdb;

    $wpdb->delete('mediclaim_dependant_details', array('email_id' => $email));

    return $result;
}, 10, 2);

// Shortcode to display logout button
function logout_button_shortcode() {
    if (is_user_logged_in()) {
        $logout_url = wp_logout_url(home_url());
        return '<p align="center"><a href="' . esc_url($logout_url) . '" class="elementor-button elementor-button-link elementor-size-sm">Logout and Close</a></p>';
    } else {
        return '';
    }
}

// Register the logout button shortcode
add_shortcode('logout_button', 'logout_button_shortcode');


// Add the Sync Users menu to the admin panel
function mediclaim_admin_menu() {
    add_menu_page(
        'Sync Users',
        'Sync Users',
        'manage_options',
        'mediclaim-sync-users',
        'mediclaim_sync_users_page',
        'dashicons-update',
        20
    );
}
add_action('admin_menu', 'mediclaim_admin_menu');

// Display the Sync Users admin page
function mediclaim_sync_users_page() {
    ?>
    <div class="wrap">
        <h1>Sync Users</h1>
        <form method="post" action="">
            <input type="hidden" name="mediclaim_sync_users" value="1" />
            <?php submit_button('Sync Users'); ?>
        </form>
        <?php
        if (isset($_POST['mediclaim_sync_users']) && $_POST['mediclaim_sync_users'] == '1') {
            mediclaim_sync_users();
        }
        ?>
    </div>
    <?php
}

// Function to sync users from v_emp_name_code_map
function mediclaim_sync_users()
{
    global $wpdb;

// Query to get name, code_number, email from v_emp_name_code_map
    $results = $wpdb->get_results("SELECT name, code_number, email FROM v_emp_name_code_map");

    if ($results) {
        foreach ($results as $row) {
            $username = $row->code_number;
            $email = $row->email;
            $first_name = $row->name;

            // Check if user already exists
            if (!username_exists($username) && !email_exists($email)) {
                // Create a new user
                $random_password = wp_generate_password();
                $user_id = wp_create_user($username, $random_password, $email);

                // Update user meta data
                if (!is_wp_error($user_id)) {
                    wp_update_user([
                        'ID' => $user_id,
                        'first_name' => $first_name
                    ]);
                    echo '<div class="updated"><p>User ' . esc_html($username) . ' created successfully.</p></div>';
                } else {
                    echo '<div class="error"><p>Failed to create user ' . esc_html($username) . '. Error: ' . esc_html($user_id->get_error_message()) . '</p></div>';
                }
            } else {
                echo '<div class="updated"><p>User ' . esc_html($username) . ' already exists. Skipping...</p></div>';
            }
        }
    } else {
        echo '<div class="error"><p>No data found in v_emp_name_code_map.</p></div>';
    }
}

?>
