<?php

defined( 'ABSPATH' ) or exit;
if ( !class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
class BULLETINWP_Bulletins_Table extends WP_List_Table {
    private static $menu_page_base_slug = BULLETINWP_PLUGIN_SLUG . '-options';

    private static $bulletins_table_name = 'bulletinwp_bulletins';

    public function __construct() {
        parent::__construct( [
            'singular' => __( 'Bulletin', 'bulletinwp' ),
            'plural'   => __( 'Bulletins', 'bulletinwp' ),
            'ajax'     => false,
        ] );
    }

    /**
     * Message if bulletin results is empty
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function no_items() {
        echo __( 'No bulletins available', 'bulletinwp' );
    }

    /**
     * Display bulletins on the table
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function prepare_items() {
        $user = get_current_user_id();
        $screen = get_current_screen();
        $option = $screen->get_option( 'per_page', 'option' );
        $per_page = get_user_meta( $user, $option, true );
        if ( empty( $per_page ) || $per_page < 1 ) {
            $per_page = $screen->get_option( 'per_page', 'default' );
        }
        $current_page = $this->get_pagenum();
        $total_items = BULLETINWP::instance()->sql->get_all_bulletins_count();
        $columns = $this->get_columns();
        $hidden_columns = $this->get_hidden_columns();
        $sortable_columns = $this->get_sortable_columns();
        $this->set_pagination_args( [
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ] );
        $this->_column_headers = [$columns, $hidden_columns, $sortable_columns];
        $this->process_bulk_action();
        $this->items = $this->get_bulletins( $per_page, $current_page );
    }

    /**
     * Get bulk actions options
     *
     * @param void
     *
     * @return array
     * @since 1.0.0
     *
     */
    public function get_bulk_actions() {
        return [
            'activate'   => __( 'Activate', 'bulletinwp' ),
            'deactivate' => __( 'Deactivate', 'bulletinwp' ),
            'delete'     => __( 'Delete', 'bulletinwp' ),
        ];
    }

    /**
     * Get table columns
     *
     * @param void
     *
     * @return array
     * @since 1.0.0
     *
     */
    public function get_columns() {
        $columns = [
            'cb'             => '<input type="checkbox" />',
            'bulletin_title' => __( 'Title', 'bulletinwp' ),
            'display_type'   => __( 'Display Type', 'bulletinwp' ),
        ];
        $columns['status'] = __( 'Status', 'bulletinwp' );
        return $columns;
    }

    /**
     * Get table hidden columns
     *
     * @param void
     *
     * @return array
     * @since 1.0.0
     *
     */
    public function get_hidden_columns() {
        return [
            'id'           => 'ID',
            'is_activated' => 'Activated',
        ];
    }

    /**
     * Get table sortable columns
     *
     * @param void
     *
     * @return array
     * @since 1.0.0
     *
     */
    public function get_sortable_columns() {
        return [
            'bulletin_title' => ['bulletin_title', true],
        ];
    }

    /**
     * Get all types of bulletins list
     *
     * @param void
     *
     * @return array
     * @since 1.0.0
     *
     */
    public function get_views() {
        $views = [];
        $current = ( !empty( $_REQUEST['status'] ) ? sanitize_text_field( $_REQUEST['status'] ) : 'all' );
        // All
        $class = ( $current == 'all' ? ' class="current"' : '' );
        $all_url = remove_query_arg( 'status' );
        $views['all'] = "<a href='{$all_url}' {$class}>All (" . BULLETINWP::instance()->sql->get_all_bulletins_count() . ")</a>";
        // Active
        $active_url = add_query_arg( 'status', 'active' );
        $class = ( $current == 'active' ? ' class="current"' : '' );
        $views['active'] = "<a href='{$active_url}' {$class}>Active (" . BULLETINWP::instance()->sql->get_all_active_bulletins_count() . ")</a>";
        // Inactive
        $inactive_url = add_query_arg( 'status', 'inactive' );
        $class = ( $current == 'inactive' ? ' class="current"' : '' );
        $views['inactive'] = "<a href='{$inactive_url}' {$class}>Inactive (" . BULLETINWP::instance()->sql->get_all_inactive_bulletins_count() . ")</a>";
        return $views;
    }

    /**
     * Get bulletins data
     *
     * @param int $per_page
     * @param int $current_page
     *
     * @return array
     * @since 1.0.0
     *
     */
    private function get_bulletins( $per_page = 20, $current_page = 1 ) {
        global $table_prefix, $wpdb;
        $table_name = $table_prefix . self::$bulletins_table_name;
        $columns = '`id`, `bulletin_title`, `is_activated`, `placement`';
        $order_by = 'id';
        $order = 'DESC';
        $limit = $per_page;
        $offset = ($current_page - 1) * $per_page;
        if ( !empty( $_REQUEST['orderby'] ) ) {
            $order_by = esc_sql( sanitize_text_field( $_REQUEST['orderby'] ) );
            if ( !empty( $_REQUEST['order'] ) ) {
                $allowed_orders = ['asc', 'desc'];
                $order_request = sanitize_text_field( $_REQUEST['order'] );
                if ( in_array( strtolower( $order_request ), $allowed_orders ) ) {
                    $order = esc_sql( $order_request );
                } else {
                    $order = 'ASC';
                }
            } else {
                $order = 'ASC';
            }
        }
        if ( !empty( $_REQUEST['status'] ) ) {
            $status = sanitize_text_field( $_REQUEST['status'] );
            $is_activated = strtolower( $status ) === 'active';
            if ( BULLETINWP::instance()->helpers->wp_version_is_equal_or_greater_than( '6.2' ) ) {
                $query = $wpdb->prepare(
                    "SELECT {$columns} FROM {$table_name} WHERE is_activated = %d ORDER BY %i {$order} LIMIT %d OFFSET %d;",
                    $is_activated,
                    $order_by,
                    $limit,
                    $offset
                );
            } else {
                $query = $wpdb->prepare(
                    "SELECT {$columns} FROM {$table_name} WHERE is_activated = %d ORDER BY {$order_by} {$order} LIMIT %d OFFSET %d;",
                    $is_activated,
                    $limit,
                    $offset
                );
            }
        } else {
            if ( BULLETINWP::instance()->helpers->wp_version_is_equal_or_greater_than( '6.2' ) ) {
                $query = $wpdb->prepare(
                    "SELECT {$columns} FROM {$table_name} ORDER BY %i {$order} LIMIT %d OFFSET %d;",
                    $order_by,
                    $limit,
                    $offset
                );
            } else {
                $query = $wpdb->prepare( "SELECT {$columns} FROM {$table_name} ORDER BY {$order_by} {$order} LIMIT %d OFFSET %d;", $limit, $offset );
            }
        }
        $bulletins = $wpdb->get_results( $query, 'ARRAY_A' );
        if ( !empty( $bulletins ) && is_array( $bulletins ) ) {
            $simplified_bulletins_data = [];
            foreach ( $bulletins as $key => $bulletin ) {
                $display_type = '';
                $is_activated = $bulletin['is_activated'];
                $scheduled = ( isset( $bulletin['add_schedule'] ) && $bulletin['add_schedule'] ? $bulletin['add_schedule'] : null );
                $status = '<div class="checkbox-wrapper toggle-switch"
                              data-checked-label="' . __( 'Active', 'bulletinwp' ) . '"
                              data-unchecked-label="' . __( 'Inactive', 'bulletinwp' ) . '"
                              data-status-action="' . (( $is_activated ? 'deactivate' : 'activate' )) . '"
                              data-bulletin-id="' . $bulletin['id'] . '"
                         >
                           <input type="checkbox" name="isActivated" ' . (( $is_activated ? 'checked' : '' )) . '/>
                           <span class="label">' . (( $is_activated ? __( 'Active', 'bulletinwp' ) : __( 'Inactive', 'bulletinwp' ) )) . '</span>
                         </div>';
                if ( isset( $bulletin['placement'] ) ) {
                    switch ( $bulletin['placement'] ) {
                        case 'top':
                            $display_type = 'Header';
                            break;
                        case 'sticky-footer':
                            $display_type = 'Sticky Footer';
                            break;
                        case 'float-bottom':
                            $display_type = 'Floating at bottom';
                            break;
                    }
                }
                $simplified_bulletins_data[$key] = [
                    'bulletin_title' => $bulletin['bulletin_title'],
                    'display_type'   => $display_type,
                ];
                $simplified_bulletins_data[$key]['status'] = $status;
                $simplified_bulletins_data[$key]['scheduled'] = $scheduled;
                $simplified_bulletins_data[$key]['id'] = $bulletin['id'];
                $simplified_bulletins_data[$key]['is_activated'] = $bulletin['is_activated'];
            }
            return array_values( $simplified_bulletins_data );
        }
        return [];
    }

    /**
     * Column cb display
     *
     * @param array $item
     *
     * @return string
     * @since 1.0.0
     *
     */
    public function column_cb( $item ) {
        return sprintf( '<input type="checkbox" name="bulletin[]" value="%s" />', $item['id'] );
    }

    /**
     * Column bulletin_title display
     *
     * @param array $item
     *
     * @return string
     * @since 1.0.0
     *
     */
    public function column_bulletin_title( $item ) {
        $bulletin_title = $item['bulletin_title'];
        $is_activated = $item['is_activated'];
        $edit_link = add_query_arg( [
            'page'     => self::$menu_page_base_slug . '-edit',
            'bulletin' => $item['id'],
        ], 'admin.php' );
        $activate_link = esc_url( wp_nonce_url( add_query_arg( [
            'page'     => self::$menu_page_base_slug,
            'action'   => 'activate',
            'bulletin' => $item['id'],
        ], 'admin.php' ) ) );
        $deactivate_link = esc_url( wp_nonce_url( add_query_arg( [
            'page'     => self::$menu_page_base_slug,
            'action'   => 'deactivate',
            'bulletin' => $item['id'],
        ], 'admin.php' ) ) );
        $delete_link = esc_url( wp_nonce_url( add_query_arg( [
            'page'     => self::$menu_page_base_slug,
            'action'   => 'delete',
            'bulletin' => $item['id'],
        ], 'admin.php' ) ) );
        $bulletin_link = BULLETINWP::instance()->helpers->get_bulletin_link( $item['id'] );
        if ( empty( $bulletin_title ) ) {
            $bulletin_title = '(no title)';
        }
        $title_status_class = 'title-status-' . $item['id'];
        $title_html = '<strong><a class="row-title" href="' . $edit_link . '">' . $bulletin_title . '</a> <span class="' . $title_status_class . '"> ' . (( !$is_activated ? '&ndash;&nbsp;' . __( 'Inactive', 'bulletinwp' ) : '' )) . ' </span> </strong>';
        $actions = [
            'edit'          => '<a href="' . $edit_link . '">' . __( 'Edit', 'bulletinwp' ) . '</a>',
            'change_status' => '<a href="' . (( $item['is_activated'] ? $deactivate_link : $activate_link )) . '">' . (( $item['is_activated'] ? __( 'Deactivate', 'bulletinwp' ) : __( 'Activate', 'bulletinwp' ) )) . '</a>',
            'delete'        => '<a href="' . $delete_link . '">' . __( 'Delete', 'bulletinwp' ) . '</a>',
            'view'          => '<a href="' . $bulletin_link . '" target="_blank">' . (( $item['is_activated'] ? __( 'View', 'bulletinwp' ) : __( 'Preview', 'bulletinwp' ) )) . '</a>',
        ];
        return sprintf( '%1$s %2$s', $title_html, $this->row_actions( $actions ) );
    }

    /**
     * Default columns display
     *
     * @param array $item
     * @param string $column_name
     *
     * @return string
     * @since 1.0.0
     *
     */
    public function column_default( $item, $column_name ) {
        if ( array_key_exists( $column_name, $item ) ) {
            return $item[$column_name];
        }
        return '';
    }

    /**
     * Get bulk actions options
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function process_bulk_action() {
        // Security check!
        if ( isset( $_GET['_wpnonce'] ) && !empty( $_GET['_wpnonce'] ) && isset( $_GET['bulletin'] ) ) {
            $nonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = -1;
            if ( is_array( $_GET['bulletin'] ) ) {
                $action = 'bulk-' . $this->_args['plural'];
            }
            if ( !wp_verify_nonce( $nonce, $action ) ) {
                wp_die( 'Nope! Security check failed!' );
            }
        }
        $bulletins = ( isset( $_GET['bulletin'] ) ? wp_parse_id_list( wp_unslash( $_GET['bulletin'] ) ) : array() );
        $bulletins = array_map( 'sanitize_text_field', $bulletins );
        if ( !empty( $bulletins ) ) {
            $action = $this->current_action();
            if ( !empty( $action ) ) {
                switch ( $action ) {
                    case 'activate':
                        foreach ( $bulletins as $bulletin_id ) {
                            BULLETINWP::instance()->sql->update_bulletin_data( $bulletin_id, 'is_activated', true );
                        }
                        break;
                    case 'deactivate':
                        foreach ( $bulletins as $bulletin_id ) {
                            BULLETINWP::instance()->sql->update_bulletin_data( $bulletin_id, 'is_activated', false );
                        }
                        break;
                    case 'delete':
                        foreach ( $bulletins as $bulletin_id ) {
                            BULLETINWP::instance()->sql->delete_bulletin( $bulletin_id );
                        }
                        break;
                    case 'duplicate':
                        break;
                    default:
                        break;
                }
            }
        }
        return;
    }

}
