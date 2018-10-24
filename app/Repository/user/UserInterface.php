<?php
/**
 * User: ricardo
 * Date: 3/04/18
 */

namespace App\Repository\user;


interface UserInterface {

    public function updatePassword($userId, $password);

    public function findAllUsers();

    public function findStore();

    public function findPrintingTicketById($printingFormatId);
}