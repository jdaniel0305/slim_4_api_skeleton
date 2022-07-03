<?php
    /**
     *
     * @About:
     * @File:        FileUploader.php
     * @Date:        30/1/22
     * @Version:     di_api 1.0
     * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
     *
     **/

    namespace App\Utils;

    use Dotenv\Dotenv;

    /**
     * Class FileUploader
     * @package App\Utils
     */
    class FileUploader {
        public static function uploadImage(string $path, string $image, string $file_name) : object {
            $dotenv = Dotenv::createImmutable(__DIR__ .'/../..');
            $dotenv->load();

            //$resp = (object) array();
            $upload_dir = $_ENV['IMAGE_PATH'].$path.'/';
            $name_g = $file_name;
            $name = strtolower($name_g);
            $mal = array('á', 'é', 'í', 'ó', 'ú', 'ñ', '\'', ' ');
            $bien = array('a', 'e', 'i', 'o', 'u', 'n', '', '_');
            $name = str_replace($mal, $bien, $name);
            $name .= '_' . substr(str_shuffle("0123456789"), 0, 6) . '.png';
            $uploaded_file = base64_decode($image);

            if(file_put_contents($upload_dir.$name, $uploaded_file) !== FALSE) {
                $resp = (object) array('is_uploaded' => true, 'url' => LinksHelper::getImageLink($path.'/'.$name), 'error' => null);
            }
            else {
                $resp = (object) array('is_uploaded' => false, 'error' => 'Fail to upload image', 'dir' => $upload_dir, 'writable' => empty($uploaded_file));
            }

            return $resp;
        }
    }