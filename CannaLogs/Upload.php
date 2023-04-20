<?php
  $result = '';

  // Read the file with the last number to use
  if( file_exists( 'number.php' ) )
  {
    include 'number.php';
  }
  else
  {
    // Save settings to file
    file_put_contents( 'number.php', '<?php $number = 1; ?>' );
  }

  if( isset( $_FILES['image'] ) )
  {
    $errors     = array();
    $file_tmp   = $_FILES['image']['tmp_name'];
    $file_type  = $_FILES['image']['type'];
    $file_size  = $_FILES['image']['size'];
    $extension  = explode( '.', $_FILES['image']['name'] );
    $file_ext   = strtolower( end( $extension ) );
    
    $file_name  = $number.".".$file_ext;
    
    $extensions = array("jpeg","jpg","png");
    
    if( in_array( $file_ext, $extensions ) === false )
    {
        $errors[] ="Extension not allowed, please choose a JPG, JPEG, or PNG file.";
    }
    
    if( $file_size > 2097152 )
    {
        $errors[] = 'File size must be less than 2 MB.  Please resize using an online tool like 
        <a href="https://www.iloveimg.com/resize-image#resize-options,percentage">this one</a>.';
    }
  }
?>

<html>
  <body>
    <form action="" method="POST" enctype="multipart/form-data">
      <input type="file" name="image" />
      <input type="submit" value="Upload"/>
      <p style="color: red;">Maximum Size: 2 MB.<br>Extensions allowed: JPG, JPEG, PNG.</p>      
    </form>
      
<?php

  if( isset( $_FILES['image'] ) && ( empty( $errors ) == True ) )
  {
    move_uploaded_file( $file_tmp, "photos/".$file_name );
    echo "Successfully uploaded the image.<br><br>";
    echo '<label id="url"><a href="https://' . $_SERVER['SERVER_NAME'] . '/photos/' . $file_name . '">https://' . $_SERVER['SERVER_NAME'] . '/photos/' . $file_name . '</a></label>';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="copyClipboard()" value="Copy URL to Clipboard">';
    $number++;
    file_put_contents( 'number.php', '<?php $number = ' . $number . '; ?>' );
  }
  if( isset( $_FILES['image'] ) && ( empty( $errors ) == False ) )
  {
    echo 'Errors occurred while uploading the image:<br> <ol>';
    foreach( $errors as $one )
    {
      echo '<li>' . $one . '</li>';
    }
    echo '</ol>';
  }

?>

  <script>
    function copyClipboard()
    {
      var elm = document.getElementById("url");
      // for Internet Explorer
      if( document.body.createTextRange )
      {
        var range = document.body.createTextRange();
        range.moveToElementText(elm);
        range.select();
        document.execCommand("Copy");
      }
      // other browsers
      else if( window.getSelection )
      {
        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(elm);
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand("Copy");
      }
    }
  </script>

  </body>
</html>