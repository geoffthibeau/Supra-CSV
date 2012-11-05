<?php
class SupraCsvPostMeta {

    private function buildInputRow($metakey,$displayname,$num) {
            $input_row .= '<tr id="pm_info'.$num.'" class="pm_info">';
            $input_row .= '<td><input type="text" name="meta_key[]" id="meta_key'.$n.'" value="'.$metakey.'" size="40" maxlength="40" /></td>';
            $input_row .= '<td><input type="text" name="displayname[]" id="displayname'.$n.'" value="'.$displayname.'" size="40" maxlength="40" /></td>';
            $input_row .= '</tr>';

            return $input_row;
    }

    public function getFormContents($postmetas) {

        $form = <<<EOF
  <table>
    <tr id="labeling">
      <td>Post Meta Key</td>
      <td>Display Name</td>
    </tr>
EOF;

        if(is_array($postmetas) && count($postmetas)) {
            foreach($postmetas['meta_key'] as $i=>$metakey) {
                $displayname = $postmetas['displayname'][$i];
                $n = $i + 1;
                $form .= $this->buildInputRow($metakey,$displayname,$i);
            }
        }
        else {
            $form .= $this->buildInputRow(null,null,0);
        }   

        $form .= <<<EOF
    <tr id="pm_buttons">
        <td colspan="2">
            <button id="add_pmr">Add Post Meta</button>
            &nbsp; &nbsp;
            <button id="rem_pmr">Remove Post Meta</button>
        </td>
    </tr>
  </table>
EOF;

        return $form;

    }

    public function getSuggestions($post_type) {
        global $wpdb;

        $sql = "SELECT pm.meta_key, pm.`meta_value`
                FROM wp_postmeta AS pm
                LEFT JOIN wp_posts AS p ON p.ID = pm.post_id
                WHERE p.post_type =  '$post_type'
                GROUP BY pm.meta_key";

        return $wpdb->get_results($sql,OBJECT);
    }
}

