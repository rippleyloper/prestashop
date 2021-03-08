<?php

class State extends StateCore {

    /**

     * Get states by Country ID.

     *

     * @param int $idCountry Country ID

     * @param bool $active true if the state must be active

     *

     * @return array|false|mysqli_result|PDOStatement|resource|null

     */

    public static function getStatesByIdCountry($idCountry, $active = false)

    {

        if (empty($idCountry)) {

            die(Tools::displayError());

        }

        return Db::getInstance()->executeS(

            'SELECT *

            FROM `' . _DB_PREFIX_ . 'state` s

            WHERE s.`id_country` = ' . (int) $idCountry . ($active ? ' AND s.active = 1' : '') . '

            ORDER BY `name` ASC'

        );

    }

}

