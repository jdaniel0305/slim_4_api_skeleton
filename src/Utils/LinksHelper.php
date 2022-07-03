<?php
    /**
     *
     * @About:
     * @File:        LinksHelper.php
     * @Date:        30/1/22
     * @Version:     di_api 1.0
     * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
     *
     **/
    
    namespace App\Utils;
    
    use Dotenv\Dotenv;

    /**
     * Class LinksHelper
     * @package App\Utils
     */
    class LinksHelper {
        public static function getLink($params) : string {
            $dotenv = Dotenv::createImmutable(__DIR__ .'/../..');
            $dotenv->load();

            $isHttps = $_ENV['IS_HTTPS'];

            $sName = str_replace('api.', '', $_SERVER['SERVER_NAME']);

            return $isHttps === '1' ? 'https://'.$sName.'/'.$params : 'http://'.$sName.'/'.$params;
        }

        public static function getSocketLik($port) : string {
            $dotenv = Dotenv::createImmutable(__DIR__ .'/../..');
            $dotenv->load();

            $isHttps = $_ENV['IS_HTTPS'];

            return $isHttps === '1' ? 'https://socket.'.$_SERVER['SERVER_NAME'].':'.$port : 'http://socket.'.$_SERVER['SERVER_NAME'].':'.$port;
        }

        public static function getImageLink(string $params) : string {
            $dotenv = Dotenv::createImmutable(__DIR__ .'/../..');
            $dotenv->load();

            $isHttps = $_ENV['IS_HTTPS'];

            $sName = str_replace('api.', '', $_SERVER['SERVER_NAME']);

            return $isHttps === '1' ? 'https://'.$sName.'/assets/img/'.$params : 'http://'.$sName.'/assets/img/'.$params;
        }

        public static function getContractLink(string $params) : string {
            $dotenv = Dotenv::createImmutable(__DIR__ .'/../..');
            $dotenv->load();

            $isHttps = $_ENV['IS_HTTPS'];

            return $isHttps === '1' ? 'https://'.$_SERVER['SERVER_NAME'].'/assets/contracts/'.$params : 'http://'.$_SERVER['SERVER_NAME'].'/assets/contracts/'.$params;
        }

        public static function getPayrollLink(string $params) : string {
            $dotenv = Dotenv::createImmutable(__DIR__ .'/../..');
            $dotenv->load();

            $isHttps = $_ENV['IS_HTTPS'];

            return $isHttps === '1' ? 'https://'.$_SERVER['SERVER_NAME'].'/assets/payrolls/'.$params : 'http://'.$_SERVER['SERVER_NAME'].'/assets/payrolls/'.$params;
        }
    }