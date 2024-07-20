<?php

defined( 'ABSPATH' ) or exit;
class BULLETINWP_Import {
    private static $bulletins_table_name = 'bulletinwp_bulletins';

    private static $options_table_name = 'bulletinwp_options';

    /**
     * Validate csv data
     *
     * @param array $bulletins
     *
     * @return bool
     * @since 3.4.0
     *
     */
    private function maybe_csv_data_invalid( $bulletins ) {
        foreach ( $bulletins as $bulletin ) {
            if ( !is_numeric( $bulletin['id'] ) || !array_key_exists( 'id', $bulletin ) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Import CSV data
     *
     * @param array $bulletins
     *
     * @return bool
     * @since 3.4.0
     *
     */
    public function import_csv_data( $bulletins ) {
        if ( $this->maybe_csv_data_invalid( $bulletins ) ) {
            return false;
        }
        $column_names = BULLETINWP::instance()->sql->get_bulletins_table_column_names();
        foreach ( $bulletins as $bulletin ) {
            unset($bulletin['id']);
            foreach ( $column_names as $column_name ) {
                if ( !array_key_exists( $column_name, $bulletin ) ) {
                    unset($bulletin[$column_name]);
                }
            }
            $bulletin_id = BULLETINWP::instance()->sql->update_bulletin( [
                'id'   => '',
                'data' => $bulletin,
            ] );
        }
        return true;
    }

}
