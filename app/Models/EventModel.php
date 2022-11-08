<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'event';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields    = [
        'id', 'name', 'type', 'description', 'price',
        'contact_person', 'video_url', 'geom'
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

    public function get_list_event()
    {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.type,{$this->table}.description,
                        {$this->table}.price,{$this->table}.contact_person,{$this->table}.video_url";
        // $gtpGeom = "gtp.id = 'GTP01' AND ST_Contains(gtp.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            // ->from('gtp')
            // ->where($gtpGeom)
            ->get();
        return $query;
    }

    public function get_event_by_id($id = null)
    {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.type,{$this->table}.description,
                        {$this->table}.price,{$this->table}.contact_person,{$this->table}.video_url";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $gtpGeom = "gtp.id = 'GTP01' AND ST_Contains(gtp.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}, {$geoJson}")
            ->from('gtp')
            ->where('event.id', $id)
            ->where($gtpGeom)
            ->get();
        return $query;
    }

    public function get_new_id()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        $count = (int)substr($lastId['id'], 2);
        $id = sprintf('EV%03d', $count + 1);
        return $id;
    }

    public function add_new_event($event = null, $geojson = null)
    {
        // $event['created_at'] = Time::now();
        // $event['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($event);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $event['id'])
            ->update();
        return $insert && $update;
    }
}
