<?php

namespace App\Models;

use CodeIgniter\Model;

class SouvenirPlaceModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'souvenir_place';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields    = [
        'id', 'name', 'address', 'contact_person', 'open', 'close', 'description', 'status', 'geom'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function get_list_sp()
    {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.contact_person,{$this->table}.open,{$this->table}.close,{$this->table}.description,{$this->table}.status";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->get();
        return $query;
    }

    public function get_sp_by_id($id = null)
    {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.contact_person,{$this->table}.open,{$this->table}.close,{$this->table}.description,{$this->table}.status";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->where('id', $id)
            ->get();
        return $query;
    }
}
