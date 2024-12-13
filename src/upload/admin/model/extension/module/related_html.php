<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */

class ModelExtensionModuleRelatedHTML extends Model {

	public function install() {
		$this->db->query("CREATE TABLE `" . DB_PREFIX . "related_html` (
			`html_id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			`code` text NOT NULL,
			`sort_order` int(11) NOT NULL,
			`date_added` datetime NOT NULL,
			`date_edited` datetime NOT NULL,
			`status` int(1) NOT NULL,
			PRIMARY KEY (`html_id`),
			KEY `sort_order` (`sort_order`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

		$this->db->query("CREATE TABLE `" . DB_PREFIX . "category_to_related_html` (
			`category_id` int(11) NOT NULL,
			`html_id` int(11) NOT NULL,
			KEY `category_id` (`category_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

		$this->db->query("CREATE TABLE `" . DB_PREFIX . "manufacturer_to_related_html` (
			`manufacturer_id` int(11) NOT NULL,
			`html_id` int(11) NOT NULL,
			KEY `manufacturer_id` (`manufacturer_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

		$this->db->query("CREATE TABLE `" . DB_PREFIX . "product_to_related_html` (
			`product_id` int(11) NOT NULL,
			`html_id` int(11) NOT NULL,
			KEY `product_id` (`product_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

		return true;
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "related_html`;");

		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "category_to_related_html`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "manufacturer_to_related_html`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "product_to_related_html`;");
		return true;
	}

	public function addRelatedHTML($data) {
		$data['code'] = json_encode($data['code']);
		$this->db->query("INSERT INTO " . DB_PREFIX . "related_html SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', sort_order = '" . (int) $data['sort_order'] . "', status = '" . (int) $data['status'] . "', date_added = NOW(), date_edited = NOW()");
		return $this->db->getLastId();
	}

	public function editRelatedHTML($html_id, $data) {
		$data['code'] = json_encode($data['code']);
		$this->db->query("UPDATE " . DB_PREFIX . "related_html SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', sort_order = '" . (int) $data['sort_order'] . "', status = '" . (int) $data['status'] . "', date_edited = NOW() WHERE html_id = '" . (int) $html_id . "'");
	}

	public function multipleEditRelatedHTML($htmls) {
		foreach ($htmls as $html_id => $value) {
			$value['code'] = json_encode($value['code']);
			$this->db->query("UPDATE " . DB_PREFIX . "related_html SET name = '" . $this->db->escape($value['name']) . "', code = '" . $this->db->escape($value['code']) . "', sort_order = '" . (int) $value['sort_order'] . "', date_edited = NOW() WHERE html_id = '" . (int) $html_id . "'");
		}
	}

	public function deleteRelatedHTML($html_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "related_html WHERE html_id = '" . (int) $html_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_related_html WHERE html_id = '" . (int) $html_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_related_html WHERE html_id = '" . (int) $html_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_related_html WHERE html_id = '" . (int) $html_id . "'");
	}

	public function cloneRelatedHTML($html_id) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "related_html (`name`, code, sort_order, date_added, date_edited, status) SELECT `name`, code, sort_order, NOW(), NOW(), 0 FROM " . DB_PREFIX . "related_html WHERE html_id = '" . (int) $html_id . "'");
	}

	public function getRelatedHTML($html_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "related_html WHERE html_id = '" . (int) $html_id . "'");

		$query->row['code'] = json_decode($query->row['code'], true);
		return $query->row;	
	}

	public function changeStatus($html_id, $value) {
		$this->db->query("UPDATE " . DB_PREFIX . "related_html SET status = '" . (int) $value . "' WHERE html_id = '" . (int) $html_id . "'");
	}

	public function getAllRelatedHTMLs($enabled_only = true) {
		$sql = "SELECT html_id, `name` FROM " . DB_PREFIX . "related_html " . (($enabled_only) ? "WHERE status = 1" : "") . " ORDER BY sort_order ASC";

		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getRelatedHTMLs($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "related_html ";

		$sort_data = array(
			'name',
			'sort_order',
			'date_added',
			'date_edited',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getTotalRelatedHTMLs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "related_html");

		return $query->row['total'];
	}

	public function getRelatedHTMLsByRelatedParam($table, $column, $value) {
		$query = $this->db->query("SELECT html_id FROM " . DB_PREFIX . $table . " WHERE " . $column . " = " . $value);

		$results = [];
		foreach ($query->rows as $key => $value) {
			$results[] = $value['html_id'];
		}
		return $results;
	}

	public function relateHTMLs($table, $column, $value, $related_htmls) {
		$this->db->query("DELETE FROM " . DB_PREFIX . $table . " WHERE " . $column . " = " . (int) $value);

		foreach ($related_htmls as $key => $html_id) {
			$this->db->query("INSERT INTO " . DB_PREFIX . $table . " VALUES (" . (int) $value . ", " . (int) $html_id . ")");
		}
	}

}