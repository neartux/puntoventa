<?php
/**
 * User: ricardo
 * Date: 28/04/18
 * Time: 11:03 AM
 */

namespace App\Repository\client;


interface ClientInterface {

    public function findAllClients();

    public function createClient($clientValues);

    public function updateClient($clientValues);

    public function deleteClient($id);

    public function findClientById($clientId);

    public function findClientByNameOrLastName($re);

}