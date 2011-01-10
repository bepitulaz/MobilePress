<?php
/**
 * This class handle the Magikube extention admin panel for Mobilepress
 *
 * @author Asep Bagja Priandana (twitter @bepitulaz)
 * @version 1.0
 */
include_once "core.php";

if(!class_exists('Magikube_Ext')) {
    class Magikube_Ext {

        //load Magikube extention
        function loadMagikube() {
            add_action('admin_menu', array(&$this, 'createMagikubeMenu'));
        }

        /**
         * setup the Magikube control panel
         *
         * @package Magikube
         * @since Shopkube 1.0
         */
        function createMagikubeMenu() {
            //Add the 'Custom' submenu to the MobilePress menu and render the page
            add_submenu_page('mobilepress', 'Magikube Setting', 'Magikube Setting', 10, 'custom-setting', array(&$this, 'renderCustom'));
        }

        /**
         * Process the data from form in renderCustom function
         *
         * @param $data is an array from $_FILES in renderCustom()
         */
        function processTheForm($data) {
            $upload = new Magikube_core;
            $path = wp_upload_dir();

            if(!empty($data['name'])) {
                $image = $upload->readData();
                
                foreach ($image as $image) {
                    $delete_path = $path['basedir'] . '/magikube-uploads/' . $image->option_value;
                }

                unlink($delete_path);

                $status = $upload->uploadImage($data);

                if($status == TRUE) {
                    $upload->insertData($data);
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        }

        /**
         * render the 'Custom setting' page for magikube themes
         *
         * @package Magikube
         * @since Shopkube 1.0
         */
        function renderCustom() {

            if(!empty($_FILES['upload-background'])) {
                $this->processTheForm($_FILES['upload-background']);
            }

            $render = new Magikube_core;
            $check_data = $render->readData();

            foreach ($check_data as $check) {
                if(!empty($check->option_value)) {
                    $image_path = wp_upload_dir();
                    $show_image = "<img src='".  $image_path['baseurl']."/magikube-uploads/".$check->option_value."' width='150' alt='".$check->option_value."' />";
                }
            }
?>
            <div class="wrap">
                <h2>Setting Page for Magikube Theme</h2>
                <?php echo $show_image; ?>
                <form id="form-setting" action="" method="post" enctype="multipart/form-data">
                    <table class="form-table">
                        <tbody>
                            <th scope="row">Change Background</th>
                            <td>
                                <label for="upload-image">
                                    <input type="file" name="upload-background" id="upload-image" />
                                </label>
                            </td>
                        </tbody>
                    </table>
                    <p class="submit">
                        <input type="submit" class="button-primary" value="Save" name="submit" />
                    </p>
                </form>
            </div>
<?php
        }
    }
}
?>
