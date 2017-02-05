<?php

  // is_blank('abcd')
  function is_blank($value='') {
    if(!is_string($value)) {
      throw new Exception('The first argument must be a string.');
    }
    return trim($value) === '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value = '', $options=array()) {
    if(!is_string($value)) {
      throw new Exception('The first argument must be a string.');
    }
    $length = strlen(trim($value));
    if(isset($options['max']) && ($length > $options['max']) ||
      isset($options['min']) && ($length < $options['min']) ||
      isset($options['exact']) && ($length != $options['exact'])
      ) {
      return false;
    }

    return true;

  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    return strpos($value, '@') !== false;
  }

?>
