<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigTextmebotModel extends Model
{
    protected $table            = 'config_textmebot';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['api_key'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    public function getApiKey()
    {
        // Assuming there's only one row in your table with the API key
        $result = $this->first();

        // Check if a row was returned
        if ($result) {
            // Return the API key
            return $result['api_key'];
        }

        // No row was found, return null
        return null;
    }
}
