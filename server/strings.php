<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17.04.2021
 * Time: 16:24
 */

$GLOBALS['strings'] = [

    'err_client_state' => 'Ошибка состояния. Попробуйте обновить страницу.',

    // user config screen
    'err_name_very_long' => 'Имя не должно быть больше 32 символов',
    'err_name_empty' => 'Ник не должен быть пустым.',
    'err_name_is_taken' => 'Данный ник уже занят.',

    // Handler_createParty_createNewParty
    'err_party_name_very_long' => 'Название партии не должно быть больше 32 символов.',
    'err_party_name_empty' => 'Название партии не должно быть пустое.',

    // Handler_parties_joinParty
    'err_party_with_id_not_exist' => 'Партии с указанным ид не существует.'

];

function str($key) {
    return $GLOBALS['strings'][$key];
}