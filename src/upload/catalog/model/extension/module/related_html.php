<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */

class ModelExtensionModuleRelatedHTML extends Model {

	public function getRelatedHTMLsByRelatedParam($table, $column, $value) {
		$query = $this->db->query("SELECT ah.html_id, ah.code, ah.sort_order FROM " . DB_PREFIX . $table . " 2ah LEFT JOIN " . DB_PREFIX . "related_html ah ON (ah.html_id = 2ah.html_id) WHERE 2ah." . $column . " = " . $value . " AND status = 1 ORDER BY sort_order ASC");

		foreach ($query->rows as $key => $value) {
			$query->rows[$key]['code'] = json_decode($query->rows[$key]['code'], true);
		}
		return $query->rows;
	}
}
