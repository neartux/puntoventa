<?php
/**
 * User: ricardo
 * Date: 24/10/18
 * Time: 09:59 PM
 */

namespace App\Repository\provider;


interface ProviderInterface {

    public function findAllProviders();

    public function createProvider($providerValues);

    public function updateProvider($providerValues);

    public function deleteProvider($id);

    public function findProviderById($providerId);
}