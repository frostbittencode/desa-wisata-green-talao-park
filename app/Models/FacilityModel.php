<?php

namespace App\Models;

use CodeIgniter\Model;

class FacilityModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'facility';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields    = ['id', 'name', 'type_id'];

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

    public function get_list_facility()
    {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.type_id";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->get();
        return $query;
    }

    public function get_facility_by_id($id = null)
    {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.type_id";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->where('id', $id)
            ->get();
        return $query;
    }

    // public function get_facility_by_track()
    // {
    //     $distance = "FLOOR(111045 * DEGREES(acos(cos(radians(ST_Y(ST_CENTROID({$this->table}.geom))))
    //                     * cos(radians(detail_facility.lat)) * cos(radians(detail_facility.long ) 
    //                     - radians(ST_X(ST_CENTROID({$this->table}.geom)))) 
    //                     + sin(radians(ST_Y(ST_CENTROID({$this->table}.geom))))
    //                     * sin(radians(detail_facility.lat)))))";
    //     // $tes = "count($distance)";
    //     $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat2, ST_X(ST_Centroid({$this->table}.geom)) AS long2";
    //     $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.type_id";
    //     $query = $this->db->table($this->table)
    //         ->select("{$columns}, {$coords}, {$distance} as distance")
    //         ->join('detail_facility', 'facility_id = detail_facility.facility_id')
    //         ->where('detail_facility.attraction_id', 'A0001')
    //         ->orderBy('distance', 'ASC')
    //         // ->having(['distance <=' => $tes])
    //         ->get();
    //     return $query;
    // }

    public function get_facility_by_radius($data = null)
    {
        $type = (string)$data['ftype2'];
        $radius = (int)$data['radius'] / 1000;
        $lat = $data['lat'];
        $long = $data['long'];
        $distance = "(6371 * acos(cos(radians({$lat})) * cos(radians(ST_Y(ST_CENTROID({$this->table}.geom)))) 
                    * cos(radians(ST_X(ST_CENTROID({$this->table}.geom))) - radians({$long})) 
                    + sin(radians({$lat}))* sin(radians(ST_Y(ST_CENTROID({$this->table}.geom))))))";
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.type_id";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}, {$distance} as distance")
            ->where('type_id', $type)
            // ->orderBy('name', 'ASC')
            ->join('facility_type', 'facility.type_id = facility_type.id')
            ->having(['distance <=' => $radius])
            ->get();
        return $query;
    }
}
