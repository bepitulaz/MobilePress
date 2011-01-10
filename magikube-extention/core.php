<?php
/* 
 * Core class for magikube setting page
 *
 * @package Magikube
 * @since Shopkube 1.0
 */
if(!class_exists('Magikube_core')) {
    class Magikube_core {
        
        /**
         * This function is used for uploading the image in Magikube
         *
         * @param $data is an array that contain data image
         */
        function uploadImage($data) {
            $path = wp_upload_dir();
            $targetpath = $path['basedir'].'/magikube-uploads/';
            $name = $this->sanitizeName($data['name']);
            $targetpath = $targetpath . basename($name);

            if($data['size'] < 300000) {
                if($data['type'] == 'image/jpeg' || $data['type'] == 'image/png' || $data['type'] == 'image/gif') {
                    if(move_uploaded_file($data['tmp_name'], $targetpath)) {
                        echo "<div id='message' class='updated below-h2'><p>";
                        _e('Your image was uploaded successfully');
                        echo "</p></div>";

                        return TRUE;
                    } else {
                        echo "<div id='message' class='updated below-h2'><p>";
                        _e('Fail to upload your image. Please try again');
                        echo "</p></div>";

                        return FALSE;
                    }
                } else {
                    echo "<div id='message' class='updated below-h2'><p>";
                    _e('Only image allowed. Please try again.');
                    echo "</p></div>";

                    return FALSE;
                }
            } else {
                echo "<div id='message' class='updated below-h2'><p>";
                _e('Please upload image smaller than 300KB');
                echo "</p></div>";

                return FALSE;
            }
        }

        /**
         * function to insert the data to database
         *
         * @param $data containing image array uploaded from renderCustom()
         */
        function insertData($data) {
            global $wpdb;
            
            $name = $this->sanitizeName($data['name']);
            $wpdb->update($wpdb->prefix."mobilepress", array('option_value' => $name), array('option_name' => 'magikube_background_image'));

            return TRUE;
        }

        /**
         * This function purpose is checking whether the background image exist or not
         *
         */
        function readData() {
           global $wpdb;

           $sql = 'SELECT option_value FROM '.$wpdb->prefix.'mobilepress WHERE option_name = "magikube_background_image";';

           $result = $wpdb->get_results($sql);

           return $result;
        }

        /**
         * function to sanitize the name of file uploaded
         *
         * @param $name is a basename of the file
         */
        function sanitizeName($name) {
            $new_name = str_replace(' ', '-', $name);
            $new_name = strtolower($new_name);

            return $new_name;
        }

    }
}
?>