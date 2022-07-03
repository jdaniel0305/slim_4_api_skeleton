<?php
/**
 *
 * @About:
 * @File:        Miscellaneous.php
 * @Date:        19/4/22
 * @Version:     di_api 1.0
 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
 *
 **/

namespace App\Utils;

use Entity\Settings;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;

/**
 * Class Miscellaneous
 * @package App\Utils
 */
class Miscellaneous {
    public static function getMontName(string $month, string $age) : string {
        switch ($month) {
            case '1':
                return 'Enero '.$age;

            case '2':
                return 'Febrero '.$age;

            case '3':
                return 'Marzo '.$age;

            case '4':
                return 'Abril '.$age;

            case '5':
                return 'Mayo '.$age;

            case '6':
                return 'Junio '.$age;

            case '7':
                return 'Julio '.$age;

            case '8':
                return 'Agosto '.$age;

            case '9':
                return 'Septiembre '.$age;

            case '10':
                return 'Octubre '.$age;

            case '11':
                return 'Noviembre '.$age;

            case '12':
                return 'Diciembre '.$age;
        }

        return '';
    }

    public static function getSettings(EntityManager $manager) {
        try {
            return $manager->find(Settings::class, '1');
        } catch (OptimisticLockException | TransactionRequiredException | ORMException $e) {
            return false;
        }
    }

    public static function createPassword(string $pass): ?string {
        return crypt($pass, '$2y$10$nfgnhgnfghGljHYIUidvds4fd2vvdvs');
    }
}