<?php 

require_once(dirname(__FILE__) .'/SupraCsvDB.php');

class SupraCsvDBAL extends SupraCsvDB {

    public function find($table, $fields="*", $order = null) {

        $result = $this->query("SELECT ".$fields." FROM ".$table." $order");

        while($row = mysql_fetch_assoc($result)) {
           if($fields == "*")
               $all[] = $row;
           else
               $all[] = $row[$fields];
        }

        return $all;
    }

    public function findBy($table, $fields = "*", $conditions = null, $order = null, $debug=false) {

            if(is_array($fields))
                    $sqlfields = implode(",", $fields);
                else
                    $sqlfields = $fields;

            if(!empty($conditions)) {
                if(is_array($conditions))
                    $conditions = implode(" AND ", $conditions);

                $where = " WHERE ".$conditions." $order";
            }

            if($debug)
                echo "SELECT ".$sqlfields." FROM ".$table.$where."<br />";

            $result = $this->query("SELECT ".$sqlfields." FROM ".$table.$where);

            while($row = mysql_fetch_assoc($result)) {
                $values = null;

                    if($fields == "*") {
                        $all[] = $row;
                    }
                    else if(is_array($fields)) {
                        foreach($fields as $field) {
                            $values[$field] = $row[$field];
                        }

                        $all[] = $values;
                    }
                    else {
                        $all[] = $row[$fields];
                    }
                }
            return $all;
    }

    public function findOneBy($table, $fields, $conditions=null, $order = null, $debug=false) {
            $result = $this->findBy($table, $fields, $conditions, $order, $debug);

            return $result[0];
    }
}
