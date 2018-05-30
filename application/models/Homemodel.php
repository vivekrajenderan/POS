<?php

class Homemodel extends CI_Model {

    public function gettotal_sales($employee_id) {
        $this->db->select("case when sum(sales_payments.payment_amount) IS NULL THEN 0 else sum(sales_payments.payment_amount) end as total");
        $this->db->from('sales as sales');
        $this->db->join('sales_payments as sales_payments', 'sales_payments.sale_id = sales.sale_id', 'left');
        $this->db->where('sales.employee_id', $employee_id);
        $this->db->where('date(sales.sale_time)', date('Y-m-d'));
        //$this->db->group_by('sales.sale_id');
        $this->db->limit(10, 0);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row()->total;
        }
        return FALSE;
    }

    public function gettotal_pay_supplier($employee_id) {
        $this->db->select('case when sum(receivings_items.receiving_quantity*item_cost_price) IS NULL THEN 0 else sum(receivings_items.receiving_quantity*item_cost_price) end as total');
        $this->db->from('receivings as receivings');
        $this->db->join('receivings_items as receivings_items', 'receivings_items.receiving_id = receivings.receiving_id', 'left');
        $this->db->where('receivings.employee_id', $employee_id);
        $this->db->where('date(receivings.receiving_time)', date('Y-m-d'));
        $this->db->where('receivings.receiving_mode', 'receive');
        //$this->db->group_by('receivings.supplier_id');
        $this->db->limit(10, 0);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row()->total;
        }
        return FALSE;
    }

    public function getItemsCounts() {
        $this->db->select('count(' . $this->db->dbprefix('items') . '.item_id) as counts');
        $this->db->from('items');
        $this->db->join('item_quantities', 'items.item_id = item_quantities.item_id');
        $this->db->join('stock_locations', 'item_quantities.location_id = stock_locations.location_id');
        $this->db->where('items.deleted', 0);
        $this->db->where('stock_locations.deleted', 0);
        $this->db->where('items.stock_type', 0);
        $this->db->where('item_quantities.quantity <= items.reorder_level');
        $counts = $this->db->get()->row()->counts;
        return $counts;
    }

    public function getHandCounts() {
        $this->db->select('sum(' . $this->db->dbprefix('inventory') . '.trans_inventory) as counts');
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->where('items.deleted', 0);
        $this->db->where('items.stock_type', 0);
        return $this->db->get()->row()->counts;
    }

    public function getToBeReceived() {
        $this->db->select('sum(' . $this->db->dbprefix('receivings_items') . '.balance_quantity) as counts');
        $this->db->from('receivings_items');
        $this->db->join('receivings', 'receivings.receiving_id = receivings_items.receiving_id');
        $this->db->where_in('receivings.receiving_status', array('open', 'partially'));
        $this->db->where('receivings.receiving_mode', 'po');
        return $this->db->get()->row()->counts;
    }

    public function getTotalStockValue() {
        $this->db->select('sum(' . $this->db->dbprefix('inventory') . '.trans_inventory * ' . $this->db->dbprefix('inventory') . '.price) as total');
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->where('items.deleted', 0);
        $this->db->where('items.stock_type', 0);
        $this->db->where('date(' . $this->db->dbprefix('inventory') . '.trans_date)', date('Y-m-d'));
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            if ($q->row()->total)
                return $q->row()->total;
            else
                return 0;
        }else {
            return 0;
        }
    }

    public function getTotalPayables() {
        $this->db->select('sum(' . $this->db->dbprefix('inventory') . '.trans_inventory * ' . $this->db->dbprefix('inventory') . '.price) as counts');
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->where('items.deleted', 0);
        $this->db->where('inventory.trans_inventory >', 0);
        $this->db->where('items.stock_type', 0);
        $this->db->where('date(' . $this->db->dbprefix('inventory') . '.trans_date)', date('Y-m-d'));
        return $this->db->get()->row()->counts;
    }

    public function getTotalReceivables() {
        $this->db->select('sum(' . $this->db->dbprefix('inventory') . '.trans_inventory * ' . $this->db->dbprefix('inventory') . '.price) as counts');
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->where('items.deleted', 0);
        $this->db->where('inventory.trans_inventory <', 0);
        $this->db->where('items.stock_type', 0);
        $this->db->where('date(' . $this->db->dbprefix('inventory') . '.trans_date)', date('Y-m-d'));
        return $this->db->get()->row()->counts;
    }

    public function getProfitLossValue() {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('inventories');
        $returndata = array('purchase' => 0, 'stock' => 0, 'sale' => 0, 'profit' => 0, 'damage' => 0);

        $this->db->select($this->db->dbprefix('inventory') . ".trans_type as actions,SUM(" . $this->db->dbprefix('inventory') . ".trans_inventory * " . $this->db->dbprefix('inventory') . ".price) as amount");
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->where('items.deleted', 0);
        $this->db->where('items.stock_type', 0);
        $this->db->where_in('inventory.trans_location', $employee_ids_all);
        $this->db->group_by($this->db->dbprefix('inventory') . ".trans_type", "", false);
        $re = $this->db->get()->result_array();
        foreach ($re as $key => $value) {
            if ($value['amount'] < 0)
                $value['amount'] = $value['amount'] * -1;
            $returndata[$value['actions']] = $value['amount'];
        }

        $this->db->select("sum(" . $this->db->dbprefix('item_quantities') . ".quantity) as quantity");
        $this->db->from('item_quantities');
        $this->db->join('items', 'items.item_id = item_quantities.item_id');
        $this->db->where('items.deleted', 0);
        $this->db->where('items.stock_type', 0);
        $this->db->where_in('item_quantities.location_id', $employee_ids_all);
        $re_quantity = $this->db->get()->row()->quantity;


        $this->db->select("inventory.trans_inventory,inventory.price,inventory.trans_type");
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->where('items.deleted', 0);
        $this->db->where('items.stock_type', 0);
        $this->db->where_in('inventory.trans_location', $employee_ids_all);
        $this->db->where('inventory.trans_type', 'purchase');
        $this->db->order_by('inventory.trans_id', 'DESC');
        $re = $this->db->get()->result_array();
        $purchaseed = array();
        foreach ($re as $key => $value) {
            if ($re_quantity < $value['trans_inventory']) {
                $returndata['stock'] += $re_quantity * $value['price'];
                break;
            } else {
                $returndata['stock'] += $value['trans_inventory'] * $value['price'];
                $re_quantity -=$value['trans_inventory'];
            }
        }

        $returndata['profit'] = (($returndata['sale'] + $returndata['stock']) - $returndata['purchase']);

        return $returndata;
    }

    public function sales_report($start_date, $end_date) {
        $srequest = $this->db->query("SELECT mydate, IFNULL(total_count,0) as total
FROM
  (
    SELECT a.Date AS mydate
    FROM (
           SELECT date('" . $end_date . "') - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS Date
           FROM (SELECT 0 AS a
                 UNION ALL SELECT 1
                 UNION ALL SELECT 2
                 UNION ALL SELECT 3
                 UNION ALL SELECT 4
                 UNION ALL SELECT 5
                 UNION ALL SELECT 6
                 UNION ALL SELECT 7
                 UNION ALL SELECT 8
                 UNION ALL SELECT 9) AS a
             CROSS JOIN (SELECT 0 AS a
                         UNION ALL SELECT 1
                         UNION ALL SELECT 2
                         UNION ALL SELECT 3
                         UNION ALL SELECT 4
                         UNION ALL SELECT 5
                         UNION ALL SELECT 6
                         UNION ALL SELECT 7
                         UNION ALL SELECT 8
                         UNION ALL SELECT 9) AS b
             CROSS JOIN (SELECT 0 AS a
                         UNION ALL SELECT 1
                         UNION ALL SELECT 2
                         UNION ALL SELECT 3
                         UNION ALL SELECT 4
                         UNION ALL SELECT 5
                         UNION ALL SELECT 6
                         UNION ALL SELECT 7
                         UNION ALL SELECT 8
                         UNION ALL SELECT 9) AS c
         ) a
    WHERE a.Date BETWEEN '" . $start_date . "' AND '" . $end_date . "'
  ) dates
  LEFT JOIN
  (
    SELECT COUNT( * ) as total_count , DATE( sale_time ) as sale_time
    FROM
      " . $this->db->dbprefix('sales') . " WHERE DATE(sale_time) BETWEEN '" . $start_date . "' AND '" . $end_date . "' GROUP BY DATE( sale_time )
  ) datas ON DATE_FORMAT(dates.mydate, '%Y%m%d') = DATE_FORMAT(datas.sale_time, '%Y%m%d') group by  mydate order by mydate asc");
        return $srequest->result_array();
    }

    public function sales_store_report($start_date, $end_date) {
        $srequest = $this->db->query("SELECT mydate, SUM(IFNULL(total_count,0)) as total,group_concat(concat(location_name,'(',IFNULL(total_count,0) ,')')) as location_name
FROM
  (
    SELECT a.Date AS mydate
    FROM (
           SELECT date('" . $end_date . "') - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS Date
           FROM (SELECT 0 AS a
                 UNION ALL SELECT 1
                 UNION ALL SELECT 2
                 UNION ALL SELECT 3
                 UNION ALL SELECT 4
                 UNION ALL SELECT 5
                 UNION ALL SELECT 6
                 UNION ALL SELECT 7
                 UNION ALL SELECT 8
                 UNION ALL SELECT 9) AS a
             CROSS JOIN (SELECT 0 AS a
                         UNION ALL SELECT 1
                         UNION ALL SELECT 2
                         UNION ALL SELECT 3
                         UNION ALL SELECT 4
                         UNION ALL SELECT 5
                         UNION ALL SELECT 6
                         UNION ALL SELECT 7
                         UNION ALL SELECT 8
                         UNION ALL SELECT 9) AS b
             CROSS JOIN (SELECT 0 AS a
                         UNION ALL SELECT 1
                         UNION ALL SELECT 2
                         UNION ALL SELECT 3
                         UNION ALL SELECT 4
                         UNION ALL SELECT 5
                         UNION ALL SELECT 6
                         UNION ALL SELECT 7
                         UNION ALL SELECT 8
                         UNION ALL SELECT 9) AS c
         ) a
    WHERE a.Date BETWEEN '" . $start_date . "' AND '" . $end_date . "'
  ) dates
  LEFT JOIN
  (
    SELECT COUNT( * ) as total_count , DATE( sale_time ) as sale_time," . $this->db->dbprefix('stock_locations') . ".location_name
    FROM
      " . $this->db->dbprefix('sales') . " INNER JOIN " . $this->db->dbprefix('sales_items') . " ON " . $this->db->dbprefix('sales') . ".sale_id=" . $this->db->dbprefix('sales_items') . ".sale_id INNER JOIN " . $this->db->dbprefix('stock_locations') . " ON " . $this->db->dbprefix('sales_items') . ".item_location=" . $this->db->dbprefix('stock_locations') . ".location_id WHERE DATE(sale_time) BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND ospos_stock_locations.location_type='store' GROUP BY DATE( sale_time )," . $this->db->dbprefix('stock_locations') . ".location_name
  ) datas ON DATE_FORMAT(dates.mydate, '%Y%m%d') = DATE_FORMAT(datas.sale_time, '%Y%m%d') group by  mydate order by mydate asc");
        return $srequest->result_array();
    }

    public function purchase_report($start_date, $end_date) {
        $srequest = $this->db->query("SELECT mydate, IFNULL(total_count,0) as total
FROM
  (
    SELECT a.Date AS mydate
    FROM (
           SELECT date('" . $end_date . "') - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS Date
           FROM (SELECT 0 AS a
                 UNION ALL SELECT 1
                 UNION ALL SELECT 2
                 UNION ALL SELECT 3
                 UNION ALL SELECT 4
                 UNION ALL SELECT 5
                 UNION ALL SELECT 6
                 UNION ALL SELECT 7
                 UNION ALL SELECT 8
                 UNION ALL SELECT 9) AS a
             CROSS JOIN (SELECT 0 AS a
                         UNION ALL SELECT 1
                         UNION ALL SELECT 2
                         UNION ALL SELECT 3
                         UNION ALL SELECT 4
                         UNION ALL SELECT 5
                         UNION ALL SELECT 6
                         UNION ALL SELECT 7
                         UNION ALL SELECT 8
                         UNION ALL SELECT 9) AS b
             CROSS JOIN (SELECT 0 AS a
                         UNION ALL SELECT 1
                         UNION ALL SELECT 2
                         UNION ALL SELECT 3
                         UNION ALL SELECT 4
                         UNION ALL SELECT 5
                         UNION ALL SELECT 6
                         UNION ALL SELECT 7
                         UNION ALL SELECT 8
                         UNION ALL SELECT 9) AS c
         ) a
    WHERE a.Date BETWEEN '" . $start_date . "' AND '" . $end_date . "'
  ) dates
  LEFT JOIN
  (
    SELECT COUNT( * ) as total_count , DATE( receiving_time ) as receiving_time
    FROM
      " . $this->db->dbprefix('receivings') . " WHERE DATE(receiving_time) BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND receiving_mode='receive' AND receiving_status IN('open','partially','closed')  GROUP BY DATE( receiving_time )
  ) datas ON DATE_FORMAT(dates.mydate, '%Y%m%d') = DATE_FORMAT(datas.receiving_time, '%Y%m%d') group by  mydate order by mydate asc");
        return $srequest->result_array();
    }

}

?>
