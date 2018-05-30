<?php
class Item_price extends CI_Model
{
    public function exists($item_id, $location_id)
    {
        $this->db->from('item_price');
        $this->db->where('item_id', $item_id);
        $this->db->where('location_id', $location_id);

        return ($this->db->get()->num_rows() == 1);
    }
    
    public function save($location_detail, $item_id, $location_id)
    {
        if(!$this->exists($item_id, $location_id))
        {
            return $this->db->insert('item_price', $location_detail);
        }

        $this->db->where('item_id', $item_id);
        $this->db->where('location_id', $location_id);

        return $this->db->update('item_price', $location_detail);
    }
    
    public function get_item_price($item_id, $location_id)
    {     
        $this->db->from('item_price');
        $this->db->where('item_id', $item_id);
        $this->db->where('location_id', $location_id);
        $result = $this->db->get()->row();
        if(empty($result) == TRUE)
        {
            //Get empty base parent object, as $item_id is NOT an item
            $result = new stdClass();

            //Get all the fields from items table (TODO to be reviewed)
            foreach($this->db->list_fields('item_price') as $field)
            {
                $result->$field = '';
            }

            $result->price = 0;
        }
		
        return $result;   
    }
	
	/*
	 * changes to price of an item according to the given amount.
	 * if $price_change is negative, it will be subtracted,
	 * if it is positive, it will be added to the current price
	 */
	public function change_price($item_id, $location_id, $price_change)
	{
		$price_old = $this->get_item_price($item_id, $location_id);
		$price_new = $price_old->price + intval($price_change);
		$location_detail = array('item_id' => $item_id, 'location_id' => $location_id, 'price' => $price_new);

		return $this->save($location_detail, $item_id, $location_id);
	}
	
	/*
	* Set to 0 all price in the given item
	*/
	public function reset_price($item_id)
	{
        $this->db->where('item_id', $item_id);

        return $this->db->update('item_price', array('price' => 0));
	}
	
	/*
	* Set to 0 all price in the given list of items
	*/
	public function reset_price_list($item_ids)
	{
        $this->db->where_in('item_id', $item_ids);

        return $this->db->update('item_price', array('price' => 0));
	}
}
?>