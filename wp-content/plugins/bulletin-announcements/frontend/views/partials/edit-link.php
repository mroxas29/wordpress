<?php

defined( 'ABSPATH' ) or exit;
$bulletin_edit_link = add_query_arg( [
    'page'     => "{$plugin_slug}-options-edit",
    'bulletin' => $bulletin['id'],
], admin_url( 'admin.php' ) );
?>
<a href="<?php 
echo esc_url( $bulletin_edit_link );
?>"
   class="<?php 
echo esc_attr( "{$plugin_slug}-bulletin-admin-edit-link" );
?>"
>
  <?php 
esc_html_e( 'edit', 'bulletinwp' );
?>
</a>
