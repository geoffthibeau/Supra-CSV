<?php
require_once("Debug.php");
require_once("CsvLib.php");
class SupraCsvPreset extends SupraCsvParser {

    private $debug_queries = false;

    protected $preset_id,$preset_name,$preset_type,$preset;

    public function setPreset($params) {
        extract($params);
        if($preset_id) $this->preset_id   = $preset_id;
        if($preset_name) $this->preset_name = $preset_name;
        if($preset_type) $this->preset_type = $preset_type;
        if($preset) $this->preset = $preset;
    }

    public function getPresets($params) {
        if(!empty($params))
            $conditions = $params['field'] . ' = "' . $params['value'].'"';
        else
            $conditions = null;

        $presets = $this->dbal->findBy($this->getPresetsTable(),'*',$conditions,null,$this->debug_queries);
        foreach((array)$presets as $k=>$preset) {
            $presets[$k]['preset'] = unserialize(base64_decode($preset['preset']));
        }
        return $presets;   
    }

    public function getPreset($params) {

       if(!is_array($params)) {
           $arg['value'] = $params;
           $arg['field'] = 'id';
       } else if(empty($params['field'])) {
           $arg['field'] = 'id';
           $arg['value'] = $params['value'];
       } else {
           $arg = $params;
       }

       $conditions = $arg['field'] . ' = ' . $arg['value'];

       $preset = $this->dbal->findOneBy($this->getPresetsTable(),'*',$conditions,null,$this->debug_queries);

       $preset['preset'] = unserialize(base64_decode($preset['preset']));

       $this->setPreset($preset);

       return $preset;
    }

    public function savePreset($params) {

        if(is_array($params) && count($params))
            $this->setPreset($params);

        $msg = '<span class="error">Something went wrong</span>';

        if($this->preset) {
            $this->preset = base64_encode(serialize($this->preset));
        }

        if($this->preset_id) {
            $this->dbal->execute("UPDATE ".$this->getPresetsTable()."
                                SET preset_name = '".$this->preset_name."',
                                    preset_type = '".$this->preset_type."',
                                    preset      = '".$this->preset."'
                                WHERE id = ".$this->preset_id.";");
            $id = $this->preset_id;
            $msg = '<span class="success">Updating preset '.$this->preset_name.' was successful</span>';
        }
        else {
            $this->dbal->execute("
                                INSERT INTO ".$this->getPresetsTable()."
                                (`id`,`preset_name`,`preset_type`,`preset`) 
                                VALUES (NULL,'".$this->preset_name."','".$this->preset_type."','".$this->preset."')
                               ");
            $id = $this->dbal->lastInsertedId();
            $msg = '<span class="success">Creating preset '.$this->preset_name.' was successful</span>';
        }

        return array('id'=>$id,'name'=>$this->preset_name,'msg'=>$msg);
    }

    public function deletePreset($preset_id=null) {
       if(empty($preset_id)) $preset_id = $this->preset_id;

       if(!empty($preset_id))
       $this->dbal->execute("DELETE FROM ".$this->getPresetsTable()."
                             WHERE id=".$preset_id);
    }

    public function getBaseForm($presets) {
          $input[0] = '<span id="label">'.ucfirst($this->preset_type).' Presets</span>';
          $input[0] .= '<select id="select_'.$this->preset_type.'_preset" name="'.$this->preset_type.'_preset">';
          $input[0] .= '<option value=""> </option>';
          foreach((array)$presets as $preset) {
              $input[0] .= '<option value="'.$preset['id'].'">'.$preset['preset_name'].'</option>';
          }
          $input[0] .= '</select>';

          $input[1] = '<span id="label">Preset Name</span>';
          $input[1] .= '<input type="text" id="supra_csv_preset_name" name="preset_name" />';

          foreach($input as $i) {
              $form .= '<div id="input">' . $i . "</div>";
          }

          $form .= '<button id="create_'.$this->preset_type.'_preset">Create Preset</button>';
          $form .= '<button id="update_'.$this->preset_type.'_preset">Update Preset</button>';
          $form .= '<button id="delete_'.$this->preset_type.'_preset">Delete Preset</button>';

          return $form;
    }

}

class SupraCsvPostMetaPreset extends SupraCsvPreset {

    public function __construct() {
        $this->preset_type = 'postmeta';
        parent::__construct();
    }

    public function getForm() {
        $params = array('field'=>'preset_type','value'=>$this->preset_type);
        $presets = $this->getPresets($params);
        return $this->getBaseForm($presets);
    } 

}

class SupraCsvMappingPreset extends SupraCsvPreset {

    public function __construct($filename) {
        $this->preset_type = 'mapping';
        parent::__construct($filename);
    }

    public function doesConform($mapping) {
        $conform = true;

        if(!is_array($mapping)) return false;

        $mapping_selected_columns = array_filter(array_values($mapping));

        $cols = (array) $this->getColumns();
 
        foreach($mapping_selected_columns as $msc) {
            if(!in_array($msc,$cols))
                $conform = false;
        }

        return $conform;
    }

    public function getConformingPresets() {
        $params = array('field'=>'preset_type','value'=>$this->preset_type);
        $presets = $this->getPresets($params);
        $selected = array();

        foreach((array)$presets as $preset) {
            $conforms = $this->doesConform($preset['preset']);
            if($conforms)
                $selected[] = $preset;
        }

        return $selected;
    }

    public function getForm() {
          $presets = $this->getConformingPresets();
          return $this->getBaseForm($presets);
    }
}
