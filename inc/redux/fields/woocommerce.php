<?php
// Cek apakah WooCommerce aktif
if (!class_exists('WooCommerce')) {
    Redux::setSection($opt_name, array(
        'title'      => 'Woocommerce Settings',
        'id'         => 'woocommerce_settings',
        'icon'       => 'el el-shopping-cart',
        'desc'       => __('<div class="redux-notice">Please install and activate WooCommerce plugin first to use these settings.</div>', 'gusviradigital'),
        'fields'     => array()
    ));
    return;
}

Redux::setSection($opt_name, array(
    'title'      => 'Woocommerce Settings',
    'id'         => 'woocommerce_settings',
    'icon'       => 'el el-shopping-cart',
    'desc'       => __('Pengaturan toko online WooCommerce', 'gusviradigital'),
    'fields'     => array(

        // 1. Shop Layout Settings
        array(
            'id'       => 'shop_layout',
            'type'     => 'section',
            'title'    => __('Shop Layout', 'gusviradigital'),
            'subtitle' => __('Pengaturan tampilan halaman toko', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'products_per_page',
            'type'     => 'spinner',
            'title'    => __('Products Per Page', 'gusviradigital'),
            'subtitle' => __('Jumlah produk per halaman', 'gusviradigital'),
            'default'  => '12',
            'min'      => '1',
            'max'      => '100'
        ),

        array(
            'id'       => 'shop_columns',
            'type'     => 'select',
            'title'    => __('Shop Columns', 'gusviradigital'),
            'subtitle' => __('Jumlah kolom produk', 'gusviradigital'),
            'options'  => array(
                '2' => '2 Columns',
                '3' => '3 Columns',
                '4' => '4 Columns',
                '5' => '5 Columns'
            ),
            'default'  => '4'
        ),

        // 2. Product Display Settings
        array(
            'id'       => 'product_display',
            'type'     => 'section',
            'title'    => __('Product Display', 'gusviradigital'),
            'subtitle' => __('Pengaturan tampilan produk', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'show_price',
            'type'     => 'switch',
            'title'    => __('Show Price', 'gusviradigital'),
            'subtitle' => __('Tampilkan harga produk', 'gusviradigital'),
            'default'  => true
        ),

        array(
            'id'       => 'show_stock',
            'type'     => 'switch',
            'title'    => __('Show Stock Status', 'gusviradigital'),
            'subtitle' => __('Tampilkan status stok', 'gusviradigital'),
            'default'  => true
        ),

        // 3. Cart Settings
        array(
            'id'       => 'cart_settings',
            'type'     => 'section',
            'title'    => __('Cart Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan keranjang belanja', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'cart_redirect',
            'type'     => 'select',
            'title'    => __('Add to Cart Redirect', 'gusviradigital'),
            'subtitle' => __('Redirect setelah tambah ke keranjang', 'gusviradigital'),
            'options'  => array(
                'cart'     => 'Cart Page',
                'checkout' => 'Checkout Page',
                'none'     => 'Stay on Page'
            ),
            'default'  => 'none'
        ),

        // 4. Checkout Settings
        array(
            'id'       => 'checkout_settings',
            'type'     => 'section',
            'title'    => __('Checkout Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan halaman checkout', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'checkout_fields',
            'type'     => 'sorter',
            'title'    => __('Checkout Fields', 'gusviradigital'),
            'subtitle' => __('Atur field checkout', 'gusviradigital'),
            'options'  => array(
                'enabled'  => array(
                    'first_name' => 'First Name',
                    'last_name'  => 'Last Name',
                    'email'      => 'Email',
                    'phone'      => 'Phone'
                ),
                'disabled' => array(
                    'company'    => 'Company',
                    'address_2'  => 'Address 2'
                )
            )
        ),

        // 5. Payment Settings
        array(
            'id'       => 'payment_settings',
            'type'     => 'section',
            'title'    => __('Payment Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan pembayaran', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'currency_position',
            'type'     => 'select',
            'title'    => __('Currency Position', 'gusviradigital'),
            'options'  => array(
                'left'        => 'Left ($99)',
                'right'       => 'Right (99$)',
                'left_space'  => 'Left with space ($ 99)',
                'right_space' => 'Right with space (99 $)'
            ),
            'default'  => 'left'
        ),

        // 6. Product Image Settings
        array(
            'id'       => 'product_images',
            'type'     => 'section',
            'title'    => __('Product Images', 'gusviradigital'),
            'subtitle' => __('Pengaturan gambar produk', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'image_quality',
            'type'     => 'slider',
            'title'    => __('Image Quality', 'gusviradigital'),
            'subtitle' => __('Kualitas gambar produk', 'gusviradigital'),
            'default'  => 90,
            'min'      => 0,
            'max'      => 100
        ),

        // 7. Inventory Settings
        array(
            'id'       => 'inventory_settings',
            'type'     => 'section',
            'title'    => __('Inventory Settings', 'gusviradigital'),
            'subtitle' => __('Pengaturan inventori', 'gusviradigital'),
            'indent'   => true
        ),

        array(
            'id'       => 'stock_management',
            'type'     => 'switch',
            'title'    => __('Stock Management', 'gusviradigital'),
            'subtitle' => __('Aktifkan manajemen stok', 'gusviradigital'),
            'default'  => true
        ),

        // 8. Email Settings
        array(
            'id'       => 'woo_email_settings',
            'type'      => 'section',
            'title'     => __('Email Settings', 'gusviradigital'),
            'subtitle'  => __('Pengaturan email WooCommerce', 'gusviradigital'),
            'indent'    => true
        ),

        array(
            'id'       => 'email_from_name',
            'type'     => 'text',
            'title'    => __('From Name', 'gusviradigital'),
            'subtitle' => __('Nama pengirim email', 'gusviradigital'),
            'default'  => get_bloginfo('name')
        ),

        array(
            'id'       => 'email_from_address',
            'type'     => 'text',
            'title'    => __('From Email', 'gusviradigital'),
            'subtitle' => __('Alamat email pengirim', 'gusviradigital'),
            'default'  => get_option('admin_email'),
            'validate' => 'email'
        )

    )
));