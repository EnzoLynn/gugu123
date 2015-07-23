<?php
/**
 * Created by PhpStorm.
 * User: hui.zhou
 * Date: 2015/7/2
 * Time: 10:24
 */
class ModelCatalogAttributeGroupCustomize extends Model
{
    public function addAttributeGroupCustomize($data)
    {
        $this->event->trigger('pre.admin.attribute_group_customize.add', $data);

        $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group_customize SET customize_name = '" . $this->db->escape($data['customize_name']) . "', filter_group_ids = '" .  $this->db->escape($data['filter_group_ids']) . "', attribute_ids = '" .  $this->db->escape($data['attribute_ids']) . "'");

        $customize_id = $this->db->getLastId();

        $this->event->trigger('post.admin.attribute_group_customize.add', $customize_id);

        return $customize_id;
    }

    public function editAttributeGroupCustomize($customize_id, $data)
    {
        $this->event->trigger('pre.admin.attribute_group_customize.edit', $data);

        $this->db->query("UPDATE " . DB_PREFIX . "attribute_group_customize SET customize_name = '" . $this->db->escape($data['customize_name']) . "', filter_group_ids = '" .  $this->db->escape($data['filter_group_ids']) . "', attribute_ids = '" .  $this->db->escape($data['attribute_ids']) . "' WHERE customize_id = '" . (int)$customize_id . "'");

        $this->event->trigger('post.admin.attribute_group_customize.edit', $customize_id);
    }

    public function deleteAttributeGroupCustomize($customize_id)
    {
        $this->event->trigger('pre.admin.attribute.delete', $customize_id);

        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_group_customize WHERE attribute_id = '" . (int)$customize_id . "'");

        $this->event->trigger('post.admin.attribute.delete', $customize_id);
    }

    public function getAttributeGroupCustomize($customize_id)
    {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_group_customize WHERE customize_id = '" . (int)$customize_id . "'");

        return $query->row;
    }

    public function getAttributeGroupsCustomizes()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_group_customize ORDER BY customize_id");

        return $query->rows;
    }
}