<?php

defined( 'ABSPATH' ) or exit;
class BULLETINWP_SQL {
    private static $bulletins_table_name = 'bulletinwp_bulletins';

    private static $options_table_name = 'bulletinwp_options';

    public function __construct() {
        if ( $this->maybe_bulletins_table_insert_columns_needed() ) {
            add_action( 'init', array($this, 'bulletins_table_insert_columns') );
        }
    }

    /**
     * Check if needed to create bulletins table
     *
     * @param void
     *
     * @return void
     * @since 3.8.0
     *
     */
    public function maybe_create_bulletins_table() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $table_query = $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name );
        return $wpdb->get_var( $table_query ) !== $table_name;
    }

    /**
     * Create bulletins table
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function create_bulletins_table() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $default = '';
        $query = $wpdb->prepare( "CREATE TABLE {$table_name} (\n      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n      `bulletin_title` LONGTEXT DEFAULT %s,\n      PRIMARY KEY (`id`)\n    );", $default );
        $wpdb->query( $query );
    }

    /**
     * Delete bulletins table
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function delete_bulletins_table() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $query = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query( $query );
    }

    /**
     * Check if needed to create options table
     *
     * @param void
     *
     * @return void
     * @since 3.8.0
     *
     */
    public function maybe_create_options_table() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$options_table_name;
        $table_query = $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name );
        return $wpdb->get_var( $table_query ) !== $table_name;
    }

    /**
     * Create options table
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function create_options_table() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$options_table_name;
        $default = '';
        $query = $wpdb->prepare( "CREATE TABLE {$table_name} (\n      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n      `meta_key` varchar(255) DEFAULT %s,\n      `meta_value` LONGTEXT DEFAULT %s,\n      PRIMARY KEY (`id`)\n    );", $default, $default );
        $wpdb->query( $query );
    }

    /**
     * Delete options table
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function delete_options_table() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$options_table_name;
        $query = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query( $query );
    }

    /**
     * Check if needed to insert columns on bulletins table
     *
     * @param void
     *
     * @return bool
     * @since 1.0.0
     *
     */
    private function maybe_bulletins_table_insert_columns_needed() {
        $plugin_version = $this->get_option( 'plugin_version' );
        $latest_plugin_version = BULLETINWP_PLUGIN_VERSION;
        return empty( $plugin_version ) || $plugin_version !== $latest_plugin_version;
    }

    /**
     * Insert columns to bulletins table
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function bulletins_table_insert_columns() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $column_names = [
            'is_activated',
            'content',
            'mobile_content',
            'background_color',
            'font_color',
            'placement',
            'header_banner_style',
            'header_banner_scroll',
            'content_max_width',
            'text_alignment',
            'font_size',
            'font_size_mobile',
            'text_vertical_padding'
        ];
        $utf8mb4_column_names = ['content', 'mobile_content'];
        if ( !empty( $column_names ) ) {
            foreach ( $column_names as $column_name ) {
                if ( !$this->bulletins_column_exists( $column_name ) ) {
                    $default = '';
                    $query = "ALTER TABLE {$table_name} ADD `{$column_name}` LONGTEXT";
                    if ( in_array( $column_name, $utf8mb4_column_names ) ) {
                        $query .= " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
                    }
                    $query .= " DEFAULT %s;";
                    $wpdb->query( $wpdb->prepare( $query, $default ) );
                }
            }
        }
        // Set plugin version on options table
        $latest_plugin_version = BULLETINWP_PLUGIN_VERSION;
        BULLETINWP::instance()->sql->update_option( 'plugin_version', $latest_plugin_version );
    }

    /**
     * Check if bulletins table's column exists
     *
     * @param string $column_name
     *
     * @return bool
     * @since 1.0.0
     *
     */
    private function bulletins_column_exists( $column_name ) {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $query = $wpdb->prepare(
            "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = %s AND table_name = %s AND column_name = %s",
            $wpdb->dbname,
            $table_name,
            $column_name
        );
        $row = $wpdb->get_results( $query );
        return !empty( $row );
    }

    /**
     * Check if bulletin exists on the table by id
     *
     * @param string $bulletin_id
     *
     * @return bool
     * @since 1.0.0
     *
     */
    public function maybe_get_bulletin( $bulletin_id ) {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $query = $wpdb->prepare( "SELECT COUNT(1)\n      FROM {$table_name}\n      WHERE id = %s;", sanitize_text_field( $bulletin_id ) );
        $row = $wpdb->get_var( $query );
        return !empty( $row );
    }

    /**
     * Get bulletin table column names
     *
     * @return array
     * @since 3.4.0
     *
     */
    public function get_bulletins_table_column_names() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $column_names = $wpdb->get_col( "DESC {$table_name}", 0 );
        return $column_names;
    }

    /**
     * Insert / Update bulletin
     *
     * @param array $args
     *
     * @return string
     * @since 1.0.0
     *
     */
    public function update_bulletin( $args ) {
        $args = wp_parse_args( $args, [
            'id'   => '',
            'data' => [],
        ] );
        if ( !empty( $args['data'] ) ) {
            global $table_prefix, $wpdb;
            $table_name = $table_prefix . self::$bulletins_table_name;
            if ( empty( $args['id'] ) ) {
                $wpdb->insert( $table_name, $args['data'] );
                return $wpdb->insert_id;
            } elseif ( $this->maybe_get_bulletin( $args['id'] ) ) {
                $wpdb->update( $table_name, $args['data'], [
                    'id' => $args['id'],
                ] );
                return $args['id'];
            }
        }
        return '';
    }

    /**
     * Update specific bulletin data
     *
     * @param string $bulletin_id
     * @param string $column_name
     * @param string $value
     *
     * @return bool
     * @since 1.0.0
     *
     */
    public function update_bulletin_data( $bulletin_id, $column_name, $value ) {
        if ( !$this->maybe_get_bulletin( $bulletin_id ) ) {
            return false;
        }
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $data[$column_name] = $value;
        $wpdb->update( $table_name, $data, [
            'id' => sanitize_text_field( $bulletin_id ),
        ] );
        return true;
    }

    /**
     * Get bulletin by id
     *
     * @param string $bulletin_id
     *
     * @return bool|array
     * @since 1.0.0
     *
     */
    public function get_bulletin( $bulletin_id, $corner_position = null ) {
        if ( !$this->maybe_get_bulletin( $bulletin_id ) ) {
            return false;
        }
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        if ( $corner_position !== null ) {
            $query = $wpdb->prepare( "SELECT * FROM {$table_name} WHERE id = %d AND placement_corner_options = %s;", sanitize_text_field( $bulletin_id ), $corner_position );
        } else {
            $query = $wpdb->prepare( "SELECT * FROM {$table_name} WHERE id = %d;", sanitize_text_field( $bulletin_id ) );
        }
        $results = $wpdb->get_results( $query, 'ARRAY_A' );
        $bulletin_data = array_values( $results );
        if ( count( $bulletin_data ) === 1 ) {
            return $bulletin_data[0];
        }
        return [];
    }

    /**
     * Get specific bulletin data
     *
     * @param string $bulletin_id
     * @param string/array $column_name
     *
     * @return array|bool
     * @since 1.0.0
     *
     */
    public function get_bulletin_data( $bulletin_id, $column_name ) {
        if ( !$this->maybe_get_bulletin( $bulletin_id ) ) {
            return false;
        }
        global $table_prefix, $wpdb;
        $column_name_string = '';
        if ( is_array( $column_name ) ) {
            $column_name_string = implode( ", ", $column_name );
        } elseif ( is_string( $column_name ) ) {
            $column_name_string = $column_name;
        }
        $table_name = $table_prefix . self::$bulletins_table_name;
        $query = $wpdb->prepare( "SELECT {$column_name_string} FROM {$table_name} WHERE id = %s;", sanitize_text_field( $bulletin_id ) );
        $results = $wpdb->get_results( $query, 'ARRAY_A' );
        $bulletin_data = array_values( $results );
        if ( count( $bulletin_data ) === 1 ) {
            if ( is_array( $column_name ) ) {
                return $bulletin_data[0];
            }
            return $bulletin_data[0][$column_name];
        }
        return [];
    }

    /**
     * Delete bulletin by id
     *
     * @param string $bulletin_id
     *
     * @return bool
     * @since 1.0.0
     *
     */
    public function delete_bulletin( $bulletin_id ) {
        if ( !$this->maybe_get_bulletin( $bulletin_id ) ) {
            return false;
        }
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $wpdb->delete( $table_name, [
            'id' => sanitize_text_field( $bulletin_id ),
        ] );
        BULLETINWP::instance()->customizer->reset_values( $bulletin_id );
        return true;
    }

    /**
     * Get all bulletins count
     *
     * @param void
     *
     * @return int
     * @since 1.0.0
     *
     */
    public function get_all_bulletins_count() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $query = "SELECT COUNT(*) FROM {$table_name};";
        return $wpdb->get_var( $query );
    }

    /**
     * Get all active bulletins count
     *
     * @param void
     *
     * @return int
     * @since 1.0.0
     *
     */
    public function get_all_active_bulletins_count() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $is_activated = 1;
        $query = $wpdb->prepare( "SELECT COUNT(*) FROM {$table_name} WHERE is_activated = %d;", $is_activated );
        return $wpdb->get_var( $query );
    }

    /**
     * Get last bulletin id
     *
     * @return string
     * @since 1.0.0
     *
     */
    public function get_last_bulletin_id() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $query = "SELECT MAX(id) as id FROM {$table_name}";
        $results = $wpdb->get_results( $query, 'ARRAY_A' );
        if ( !empty( $results ) ) {
            $last_bulletin = array_pop( $results );
            return $last_bulletin['id'];
        }
        return '';
    }

    /**
     * Get all inactive bulletins count
     *
     * @param void
     *
     * @return int
     * @since 1.0.0
     *
     */
    public function get_all_inactive_bulletins_count() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $is_activated = 0;
        $query = $wpdb->prepare( "SELECT COUNT(*) FROM {$table_name} WHERE is_activated = %d;", $is_activated );
        return $wpdb->get_var( $query );
    }

    /**
     * Get all bulletins
     *
     * @return array
     * @since 3.0.0
     *
     */
    public function get_all_bulletins() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $query = "SELECT * FROM {$table_name};";
        $results = $wpdb->get_results( $query, 'ARRAY_A' );
        $bulletins = array_values( $results );
        return $bulletins;
    }

    /**
     * Get all active bulletins
     *
     * @return array
     * @since 2.0.0
     *
     */
    public function get_all_active_bulletins() {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $is_activated = 1;
        $query = $wpdb->prepare( "SELECT * FROM {$table_name} WHERE is_activated = %d;", $is_activated );
        $results = $wpdb->get_results( $query, 'ARRAY_A' );
        $bulletins = array_values( $results );
        return $bulletins;
    }

    /**
     * Get all active bulletins by placement
     *
     * @param string $placement
     *
     * @return array
     * @since 1.0.0
     *
     */
    public function get_all_active_bulletins_by_placement( $placement, $corner_position = '' ) {
        if ( empty( $placement ) ) {
            return [];
        }
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $is_activated = 1;
        $query = $wpdb->prepare( "SELECT * FROM {$table_name} WHERE is_activated = %d AND placement = %s;", $is_activated, $placement );
        $results = $wpdb->get_results( $query, 'ARRAY_A' );
        $bulletins = array_values( $results );
        return $bulletins;
    }

    /**
     * Check if option name exists
     *
     * @param string $selector
     *
     * @return bool
     * @since 1.0.0
     *
     */
    public function maybe_get_option( $selector ) {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$options_table_name;
        $query = $wpdb->prepare( "SELECT COUNT(1)\n      FROM {$table_name}\n      WHERE meta_key = %s;", $selector );
        $row = $wpdb->get_var( $query );
        return !empty( $row );
    }

    /**
     * Insert / Update option
     *
     * @param string $selector
     * @param mixed $value
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function update_option( $selector, $value ) {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$options_table_name;
        if ( !$this->maybe_get_option( $selector ) ) {
            $wpdb->insert( $table_name, [
                'meta_key'   => $selector,
                'meta_value' => $value,
            ] );
        } else {
            $wpdb->update( $table_name, [
                'meta_value' => $value,
            ], [
                'meta_key' => $selector,
            ] );
        }
    }

    /**
     * Get option
     *
     * @param string $selector
     *
     * @return mixed
     * @since 1.0.0
     *
     */
    public function get_option( $selector ) {
        if ( !$this->maybe_get_option( $selector ) ) {
            return false;
        }
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$options_table_name;
        $query = $wpdb->prepare( "SELECT meta_value FROM {$table_name} WHERE meta_key = %s", $selector );
        $meta_value = $wpdb->get_var( $query );
        if ( is_serialized( $meta_value ) ) {
            return unserialize( $meta_value );
        }
        return ( !empty( $meta_value ) ? $meta_value : '' );
    }

}
