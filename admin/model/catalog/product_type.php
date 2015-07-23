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
        $this->event->trigger('pre.admin.product_type.add', $data);

        $this->db->query("INSERT INTO " . DB_PREFIX . "product_type SET type_name = '" . $this->db->escape($data['type_name']) . "', filter_group_ids = '" .  $this->db->escape($data['filter_group_ids']) . "', attribute_ids = '" .  $this->db->escape($data['attribute_ids']) . "'");

        $customize_id = $this->db->getLastId();

        $this->event->trigger('post.admin.product_type.add', $customize_id);

        return $customize_id;
    }

    public function editProductType($type_id, $data)
    {
        $this->event->trigger('pre.admin.product_type.edit', $data);

        $this->db->query("UPDATE " . DB_PREFIX . "product_type SET type_name = '" . $this->db->escape($data['type_name']) . "', filter_group_ids = '" .  $this->db->escape($data['filter_group_ids']) . "', attribute_ids = '" .  $this->db->escape($data['attribute_ids']) . "' WHERE type_id = '" . (int)$type_id . "'");

        $this->event->trigger('post.admin.product_type.edit', $type_id);
    }

    public function deleteProductType($type_id)
    {
        $this->event->trigger('pre.admin.product_type.delete', $type_id);

        $this->db->query("DELETE FROM " . DB_PREFIX . "product_type WHERE attribute_id = '" . (int)$type_id . "'");

        $this->event->trigger('post.admin.product_type.delete', $type_id);
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
}