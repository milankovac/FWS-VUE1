<?php

/**
 * Class RestApi
 */
class RestApi
{
    /**
     * RestApi constructor.
     */
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    /**
     * Create rest Api point
     */
    public function register_routes()
    {
        register_rest_route('wp/v2', '/custom_product', array(
            'methods' => 'GET',
            'callback' => array($this, 'generate_data')
        ));

        register_rest_route('fws', '/all_users', array(
            'methods' => 'post',
            'callback' => array($this, 'all_users')
        ));

        register_rest_route('fws', '/change_password', array(
            'methods' => 'post',
            'callback' => array($this, 'change_password'),
            'args' => [
                'new_password' => [
                    'required' => true,
                    'type' => 'string'
                ]
            ]
        ));
        register_rest_route('wp/v2', '/email_reset', array(
            'methods' => 'post',
            'callback' => array($this, 'send_email_reset_password'),
            'args' => [
                'email' => [
                    'required' => true,
                    'type' => 'string'
                ], 'email' => [
                    'required' => true,

                ]]
        ));
        register_rest_route('wp/v2', '/password_reset', array(
            'methods' => 'post',
            'callback' => array($this, 'forgot_change_password_and_send_mail'),
            'args' => [
                'email' => [
                    'required' => true,
                    'type' => 'string'
                ], 'password' => [
                    'required' => true,

                ]]
        ));
        register_rest_route('wp/v2', '/make_order', array(
            'methods' => 'post',
            'callback' => array($this, 'make_order'),
            'args' => [
                'order', 'total', 'id']
        ));
    }

    /**
     * Generate Rest Api Data
     * @return array
     */
    public function generate_data()
    {
        $all_data = array();
        $atribute_and_value = array();
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );

        $loop = new WP_Query($args);
        while ($loop->have_posts()) : $loop->the_post();
            global $product;
            $gallery_id = $product->get_gallery_image_ids();
            $gallery_url = array();
            if (count($gallery_id) > 0) {
                for ($i = 0; count($gallery_id) > $i; $i++) {
                    array_push($gallery_url, wp_get_attachment_url($gallery_id[$i]));
                }

            }
            array_push($all_data, array(
                'id' => $product->get_id(),
                'title' => $product->get_title(),
                'category' => get_the_category_by_ID($product->get_category_ids()),
                'main_image' => wp_get_attachment_url($product->get_image_id()),
                'gallery_images' => $gallery_url,
                'sku' => $product->get_sku(),
                'regular_price' => $product->get_regular_price(),
                'sale_price' => $product->get_sale_price(),
                'atributes' => $product->get_attributes(),
                'qty' => 1

            ));

        endwhile;

        wp_reset_query();

        return $all_data;
    }

    public function all_users()
    {
        $all_users = array();
        global $wpdb;
        $results = $wpdb->get_results('SELECT*FROM wp_users ');

        foreach ($results as $result) {

            array_push($all_users, array(
                'id' => $result->ID,
                'username' => $result->user_login,
                'password' => $result->user_pass
            ));
        }

        return $all_users;
    }

    //Change passwrod
    public function change_password(WP_REST_Request $request)
    {
        $new_password = $request['new_password'];

        wp_set_password($new_password, get_current_user_id());

        return [
            'status' => true
        ];
    }

//Send mail with link for restart password
    public function send_email_reset_password(WP_REST_Request $request)
    {
        $email = $request['email'];
        $email_exists = email_exists($email);

        if ($email_exists) {
            //$ID=get_user_by( "email",$email)->ID;
            //$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            //$new_password=substr(str_shuffle($data), 0, 8);
            $to = $email;
            $subject = 'Restart Password';
            $message = "<html>
                                <head>
                                
                                </head>
                                <body >
                                <h4>To restart the password click on the link </h4>
                                <a href='http://localhost:8080/forgotPassword{$request['random']}'>Link</a>
                                <p>{$request['random']}</p>
                                </body>
                                </html>
                                ";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <orient@shop.com>' . "\r\n";
            $headers .= 'Cc: orient@shop.com' . "\r\n";
            mail($to, $subject, $message, $headers);
        }
        return $email_exists;
    }

    //Forgot password
    public function forgot_change_password_and_send_mail(WP_REST_Request $request)
    {
        $email = $request['email'];
        $new_password = $request['password'];
        $email_exists = email_exists($email);
        if ($email_exists) {
            $ID = get_user_by("email", $email)->ID;
            wp_set_password($new_password, $ID);
            $to = $email;
            $subject = 'Confirm password change';
            $message = "Your password has changed;";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <orient@shop.com>' . "\r\n";
            $headers .= 'Cc: orient@shop.com' . "\r\n";
            mail($to, $subject, $message, $headers);

        }
        return $email_exists;
    }

    //Make order
    public function make_order(WP_REST_Request $request)
    {
        $orders = $request['order'];
        $total = $request['total'];
        $id = $request['id'];
        $user = get_user_by('login', $id);
        $address = array(
            'first_name' => $id,
            'last_name' => 'Conlin',
            'company' => 'Speed Society',
            'email' => $user->user_email,

        );
       $my_order=wc_create_order();

       foreach ($orders as $order)
       {
           $my_order->add_product(get_product($order['id']), $order['qty']);


       }
       $my_order->set_address($address);
       $my_order->set_total($total);
       $my_order->update_status("Completed", 'Imported order', TRUE);
        return $orders;
    }

}