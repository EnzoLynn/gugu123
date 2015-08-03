<?php
/**
 * Created by PhpStorm.
 * User: 周
 * Date: 2015/8/3
 * Time: 14:07
 */
class ModelCatalogProductGroup extends Model
{
    public function addProductGroup($data)
    {
        $product_group = array(
            'group_name' => $data['group_name'],
            'option_ids' => $data['option_ids']
        );
        $this->db_ci->insert('product_group', $product_group);

        $group_id = $this->db_ci->insert_id();
    }

    public function editProductGroup($group_id, $data)
    {
        $product_group = array(
            'group_name' => $data['group_name'],
            'option_ids' => $data['option_ids']
        );
        $this->db_ci->where('group_id', $group_id);
        $this->db_ci->update('product_group', $product_group);
    }

    public function deleteProductGroup($group_id)
    {
        return $this->db_ci->delete('product_group', array('group_id' => $group_id));
    }

    public function getProductGroup($group_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_group WHERE group_id = '" . (int)$group_id . "'");

        return $query->row;
    }

    public function getProductGroups($data = array())
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "product_group WHERE 1=1 ";

        if (!empty($data['filter_group_name'])) {
            $sql .= " AND group_name LIKE '%" . $this->db->escape($data['filter_group_name']) . "%'";
        }

        $sql .= 'ORDER BY group_id ASC ';

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function copyProductGroup($group_id) {
        $product_group = $this->getProductGroup($group_id);

        $product_group['group_name'] = $product_group['group_name'] . '_copy';
        return $this->addProductGroup($product_group);
    }
}