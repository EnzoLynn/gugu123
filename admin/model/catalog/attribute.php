<?php
class ModelCatalogAttribute extends Model {
	public function addAttribute($data) {
		$this->event->trigger('pre.admin.attribute.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$attribute_id = $this->db->getLastId();

		foreach ($data['attribute_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->event->trigger('post.admin.attribute.add', $attribute_id);

		return $attribute_id;
	}

	public function editAttribute($attribute_id, $data) {
		$this->event->trigger('pre.admin.attribute.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE attribute_id = '" . (int)$attribute_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

		foreach ($data['attribute_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->event->trigger('post.admin.attribute.edit', $attribute_id);
	}

	public function deleteAttribute($attribute_id) {
		$this->event->trigger('pre.admin.attribute.delete', $attribute_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

		$this->event->trigger('post.admin.attribute.delete', $attribute_id);
	}

	public function getAttribute($attribute_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE a.attribute_id = '" . (int)$attribute_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getAttributes($data = array()) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}

		$sort_data = array(
			'ad.name',
			'attribute_group',
			'a.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY attribute_group, ad.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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

	public function getAttributeDescriptions($attribute_id) {
		$attribute_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

		foreach ($query->rows as $result) {
			$attribute_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $attribute_data;
	}

	public function getAttributesByAttributeGroupId($data = array()) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}

		$sort_data = array(
			'ad.name',
			'attribute_group',
			'a.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			//$sql .= " ORDER BY ad.name";
            $sql .= " ORDER BY a.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

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

//	public function getTotalAttributes() {
//		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute");
//
//		return $query->row['total'];
//	}
    /**
     * 周辉
     * 添加一个参数
    */
    public function getTotalAttributes($filter_data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute WHERE 1=1 ";
        foreach($filter_data as $k=>$v){
            $sql .= "AND `". $k ."`='". $this->db->escape($v) ."'";
        }
        $query = $this->db->query($sql);

        return $query->row['total'];
    }

	public function getTotalAttributesByAttributeGroupId($attribute_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

		return $query->row['total'];
	}

    /**
     * 通过属性组名字模糊查询得到属性数组
     * @author 周辉
     * @access public
     * @param mixed $data 查询条件、排序等
     * @return array 属性数组
     */
    public function getAttributesByGroupName($data) {
        if (empty($data['filter_name'])) {
            return [];
        }

        $sql = "SELECT a.*, ad.language_id, ad.`name`, (SELECT name FROM " . DB_PREFIX . "attribute_group_description agd WHERE a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `attribute_group`
FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.attribute_group_id =
(SELECT agd.attribute_group_id
FROM " . DB_PREFIX . "attribute_group_description agd
WHERE agd.language_id = '1' AND agd.`name` LIKE '%" . $this->db->escape($data['filter_name']) ."%')";

        $sql .= " ORDER BY a.sort_order ASC";

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

    /**
     * 属性ID数组排序
     * @author 周辉
     * @access public
     * @param mixed $attribute_ids_array 属性ID数组
     * @return array 排序后的属性ID数组
    */
    public function orderListAttributes($attribute_ids_array) {
        if(!is_array($attribute_ids_array) || count($attribute_ids_array)==0) {
            return [];
        }

        $attribute_ids = implode(',', $attribute_ids_array);

        $attribute_ids_new = array();

        $sql = "SELECT attribute_group_id FROM " . DB_PREFIX . "attribute_group WHERE attribute_group_id IN(
SELECT DISTINCT attribute_group_id FROM " . DB_PREFIX . "attribute WHERE attribute_id IN(". $attribute_ids .")
) ORDER BY sort_order";
        $query = $this->db->query($sql);

        $result = $query->rows;

        foreach ($result as $row) {

            $sql = "SELECT attribute_id FROM " . DB_PREFIX . "attribute WHERE attribute_group_id='".$row['attribute_group_id']."' AND attribute_id IN(". $attribute_ids .") ORDER BY sort_order";
            $query = $this->db->query($sql);

            $result2 = $query->rows;
            foreach($result2 as $row2) {
                $attribute_ids_new[] = $row2['attribute_id'];
            }
        }
        return $attribute_ids_new;
    }
}