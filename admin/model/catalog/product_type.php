<?php
/**
 * Created by PhpStorm.
 * User: hui.zhou
 * Date: 2015/7/2
 * Time: 10:24
 */
class ModelCatalogProductType extends Model
{
    public function addProductType($data)
    {
        $product_type = array(
            'type_name' => $data['type_name'],
            'filter_group_ids' => $data['filter_group_ids'],
            'attribute_ids' => $data['attribute_ids']
        );
        $this->db_ci->insert('product_type', $product_type);

        $type_id = $this->db_ci->insert_id();
    }

    public function editProductType($type_id, $data)
    {
        $product_type = array(
            'type_name' => $data['type_name'],
            'filter_group_ids' => $data['filter_group_ids'],
            'attribute_ids' => $data['attribute_ids']
        );
        $this->db_ci->where('type_id', $type_id);
        $this->db_ci->update('product_type', $product_type);
    }

    public function deleteProductType($type_id)
    {
        return $this->db_ci->delete('product_type', array('type_id' => $type_id));
    }

    public function getProductType($type_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_type WHERE type_id = '" . (int)$type_id . "'");

        return $query->row;
    }

    public function getProductTypes()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_type ORDER BY type_id");

        return $query->rows;
    }

    public function copyProductType($type_id) {
        $product_type = $this->getProductType($type_id);

        $product_type['type_name'] = $product_type['type_name'] . '_copy';
        return $this->addProductType($product_type);
    }
}