<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $first_name = $_POST['first_name'] ?? '';
  $last_name = $_POST['last_name'] ?? '';
  $email = $_POST['email'] ?? '';
  $username = $_POST['username'] ?? '';

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    $errors = [];
    if(is_post_request()) {
      if(is_blank($first_name)) {
        $errors[] = 'First name cannot be blank.';
      } else if ( !preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $first_name) ) {
        $errors[] = 'First name should only contain letters, spaces, or symbols: (- , . \')';
      } else if (!has_length($first_name, ['min' => 2, 'max' => 255])) {
        $errors[] = 'First name must be between 2 and 255 characters.';
      }

      if(is_blank($last_name)) {
        $errors[] = 'Last name cannot be blank.';
      } else if ( !preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $last_name) ) {
        $errors[] = 'Last name should only contain letters, spaces, or symbols: (- , . \')';
      } else if (!has_length($last_name, ['min' => 2, 'max' => 255])) {
        $errors[] = 'Last name must be between 2 and 255 characters.';
      }

      if(is_blank($username)) {
        $errors[] = 'Username cannot be blank.';
      } else if ( !preg_match('/\A[A-Za-z0-9\_]+\Z/', $username) ) {
        $errors[] = 'Username should only contain letters, numbers, or symbol: (_)';
      } else if (!has_length($username, ['min' => 8, 'max' => 255])) {
        $errors[] = 'Username must be between 8 and 255 characters.';
      }

      if(is_blank($email)) {
        $errors[] = 'Email cannot be blank.';
      } else if ( !preg_match('/\A[A-Za-z0-9\_\@\.]+\Z/', $email) ) {
        $errors[] = 'Email should only contain letters, numbers, or symbols: (_ @ .)';
      } else if (!has_length($email, ['min' => 1, 'max' => 255])) {
        $errors[] = 'Email must be between 1 and 255 characters.';
      } else if (!has_valid_email_format($email)) {
        $errors[] = 'Email must contain a @ symbol';
      }
      $selectUser = "SELECT * FROM users WHERE username = '". addslashes($username) ."'";
      $user = mysqli_fetch_assoc(db_query($db, $selectUser));

      if($user) {
        $errors[] = 'Username is already taken';
      }
      // if there were no errors, submit data to database
      if(empty($errors)) {
        // Write SQL INSERT statement



        $sql = "INSERT INTO users (first_name, last_name, email, username, created_at) VALUES ('". addslashes($first_name) . "', '" . addslashes($last_name) . "', '" . addslashes($email) . "', '". addslashes($username) . "', NOW())";

        // For INSERT statments, $result is just true/false
        $result = db_query($db, $sql);
        if($result) {
          db_close($db);

        //   TODO redirect user to success page
          redirect_to('/public/registration_success.php');
        } else {
        //   // The SQL INSERT statement failed.
        //   // Just show the error, not the form
          echo db_error($db);
          db_close($db);
          exit;
        }
      }
    }



?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <div class="col-md-offset-2 col-md-10">
    <h1>Register</h1>
    <p>Register to become a Globitek Partner.</p>
  </div>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    echo display_errors($errors);
  ?>

  <!-- TODO: HTML form goes here -->
  <form class="form-horizontal" novalidate action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="form-group">
      <label for="first_name" class="col-sm-2 control-label">First Name</label>
      <div class="col-sm-10">
        <input id="first_name" name="first_name" type="text" class="form-control" placeholder="John" value="<?php echo $first_name; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="last_name" class="col-sm-2 control-label">Last Name</label>
      <div class="col-sm-10">
        <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Doe" value="<?php echo $last_name; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input id="email" name="email" type="email" class="form-control" placeholder="johndoe@example.com" value="<?php echo $email; ?>" />
      </div>
    </div>
    <div class="form-group">
      <label for="username" class="col-sm-2 control-label">Username</label>
      <div class="col-sm-10">
        <input id="username" name="username" type="text" class="form-control" placeholder="johndoe" value="<?php echo $username; ?>"/>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Register</button>
      </div>
    </div>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
