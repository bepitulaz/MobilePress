<?php
/**
 * This class handle the Magikube extention admin panel for Mobilepress
 *
 * @author Asep Bagja Priandana (twitter @bepitulaz)
 * @version 1.0
 */
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
         * render the 'Custom setting' page for magikube themes
         *
         * @package Magikube
         * @since Shopkube 1.0
         */
        function renderCustom() {
?>
            <div class="wrap">
                <h2>Setting Page for Magikube Theme</h2>
                <form id="form-setting" action="<?php $_SERVER['REQUEST_URI']; ?>" method="post">
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
