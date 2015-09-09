<?php
class ModelDesignBanner extends Model {
	public function addBanner($data) {
		$this->event->trigger('pre.admin.banner.add', $data);

        $banner = array(
            'name'           => $data['name'],
            'image_desc'    => $data['image_desc'],
            'description'  => $data['description'],
            'status'        => (int)$data['status']
        );

        $this->db_ci->insert('banner', $banner);

        $banner_id = $this->db_ci->insert_id();

		if (isset($data['banner_image'])) {
			foreach ($data['banner_image'] as $banner_image) {

                $banner_image_info = array(
                    'banner_id'         => (int)$banner_id,
                    'background'        => $banner_image['background'],
                    'link'              => $banner_image['link'],
                    'is_blank'              => $banner_image['is_blank'],
                    'image'             => $banner_image['image'],
                    'image2'            => $banner_image['image2'],
                    'sort_order'       => $banner_image['sort_order']
                );
                $this->db_ci->insert('banner_image', $banner_image_info);
                $banner_image_id = $this->db_ci->insert_id();

				foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {

                    $banner_image_description = array(
                        'banner_image_id' => (int)$banner_image_id,
                        'language_id'      => (int)$language_id,
                        'banner_id'        => (int)$banner_id,
                        'title'            => $banner_image_description['title']
                    );
                    $this->db_ci->insert('banner_image_description', $banner_image_description);

				}
			}
		}

		$this->event->trigger('post.admin.banner.add', $banner_id);

		return $banner_id;
	}

	public function editBanner($banner_id, $data) {
		$this->event->trigger('pre.admin.banner.edit', $data);

        $banner = array(
            'name'           => $data['name'],
            'image_desc'    => $data['image_desc'],
            'description'  => $data['description'],
            'status'        => (int)$data['status']
        );
        $this->db_ci->where('banner_id', $banner_id);
        $this->db_ci->update('banner', $banner);

		$this->db->query("DELETE FROM " . DB_PREFIX . "banner_image WHERE banner_id = '" . (int)$banner_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "banner_image_description WHERE banner_id = '" . (int)$banner_id . "'");

		if (isset($data['banner_image'])) {
			foreach ($data['banner_image'] as $banner_image) {

                $banner_image_info = array(
                    'banner_id'         => (int)$banner_id,
                    'background'        => $banner_image['background'],
                    'link'              => $banner_image['link'],
                    'is_blank'              => (int)$banner_image['is_blank'],
                    'image'             => $banner_image['image'],
                    'image2'            => $banner_image['image2'],
                    'sort_order'       => $banner_image['sort_order']
                );
                $this->db_ci->insert('banner_image', $banner_image_info);
                $banner_image_id = $this->db_ci->insert_id();

				foreach ($banner_image['banner_image_description'] as $language_id => $banner_image_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "banner_image_description SET banner_image_id = '" . (int)$banner_image_id . "', language_id = '" . (int)$language_id . "', banner_id = '" . (int)$banner_id . "', title = '" .  $this->db->escape($banner_image_description['title']) . "'");
				}
			}
		}

		$this->event->trigger('post.admin.banner.edit', $banner_id);
	}

	public function deleteBanner($banner_id) {
		$this->event->trigger('pre.admin.banner.delete', $banner_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "banner WHERE banner_id = '" . (int)$banner_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "banner_image WHERE banner_id = '" . (int)$banner_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "banner_image_description WHERE banner_id = '" . (int)$banner_id . "'");

		$this->event->trigger('post.admin.banner.delete', $banner_id);
	}

	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "banner WHERE banner_id = '" . (int)$banner_id . "'");

		return $query->row;
	}

	public function getBanners($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "banner";

		$sort_data = array(
			'name',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getBannerImages($banner_id) {
		$banner_image_data = array();

		$banner_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image WHERE banner_id = '" . (int)$banner_id . "' ORDER BY sort_order ASC");

		foreach ($banner_image_query->rows as $banner_image) {
			$banner_image_description_data = array();

			$banner_image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image_description WHERE banner_image_id = '" . (int)$banner_image['banner_image_id'] . "' AND banner_id = '" . (int)$banner_id . "'");

			foreach ($banner_image_description_query->rows as $banner_image_description) {
				$banner_image_description_data[$banner_image_description['language_id']] = array('title' => $banner_image_description['title']);
			}

			$banner_image_data[] = array(
				'banner_image_description' => $banner_image_description_data,
				'link'                     => $banner_image['link'],
                'is_blank'                     => $banner_image['is_blank'],
				'image'                    => $banner_image['image'],
                'image2'                    => $banner_image['image2'],
                'background'              => $banner_image['background'],
				'sort_order'               => $banner_image['sort_order']
			);
		}

		return $banner_image_data;
	}

	public function getTotalBanners() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "banner");

		return $query->row['total'];
	}
}