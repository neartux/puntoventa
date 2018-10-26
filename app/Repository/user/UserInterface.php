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

    public function existUserName($id, $userName);

    public function saveUser($userData);

    public function updateUser($userData);

    public function deleteUser($id);

    public function findRolesNoAdmin();

    public function addRolesToUser($userId, $roles);
}