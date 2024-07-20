<?php

defined( 'ABSPATH' ) or exit;


class BULLETINWP_Export {
  private static $bulletins_table_name = 'bulletinwp_bulletins';

  /**
   * Wrap and escape a cell for CSV export.
   *
   * @param string $string    Content of a cell.
   *
   * @return string Wrapped string for CSV export
   * @since 3.4.0
   *
   */
  protected function wrap_and_escape_data( $string ) {
    // Escape CSV delimiter for RegExp (e.g. '|').
    $delimiter = ',';
    $delimiter = preg_quote( $delimiter, '#' );

    if ( 1 === preg_match( '#' . $delimiter . '|"|\n|\r#i', $string ) || ' ' === substr( $string, 0, 1 ) || ' ' === substr( $string, -1 ) ) {
      // Escape single " as double "".
      $string = str_replace( '"', '""', $string );
      // Wrap string in "".
      $string = '"' . $string . '"';
    }

    return $string;
  }

  /**
   * Get export bulletins
   *
   * @param void $selector
   *
   * @return string
   * @since 3.4.0
   *
   */
  public function get_export_data() {
    $bulletins = BULLETINWP::instance()->sql->get_all_bulletins();

    if ( ! empty( $bulletins ) ) {
      $output .= implode( ",", array_keys( $bulletins[0] ) ) . "\n";

      foreach ( $bulletins as $bulletin ) {
        array_walk( $bulletin, 'wrap_and_escape_data' );
        $output .= implode( ",", array_values( $bulletin ) ) . "\n";
      }

      return $output;
    }

    return '';
  }
}
