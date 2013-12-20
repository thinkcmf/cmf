<?php
class ShopModel extends Model
{
	/**
	 * 添加店铺
	 * @param unknown_type $number
	 * @param unknown_type $addr
	 * @param unknown_type $phone
	 * @param unknown_type $cell_phone
	 * @param unknown_type $email
	 * @param unknown_type $leader
	 * @param unknown_type $jion_date
	 * @param unknown_type $end_date
	 * @param unknown_type $type
	 */
	
	public function addshop($number, $addr, $phone, $cell_phone, $email, $leader, $jion_date, $end_date, $type=1)
	{
		$bool = $this->where('number='.$number)->find();
		if($bool == NULL)
		{
			$date['number'] = $number;
			$date['address'] = $addr;
			$date['phone'] = $phone;
			$date['cell_phone'] = $cell_phone;
			$date['email'] = $email;
			$date['leader'] = $leader;
			$date['jion_date'] = $jion_date;
			$date['end_date'] = $end_date;
			$date['	type'] = $type;
			$result = $this->add($date);
			return $result;
		}
		return NULL;
		
	}
	
	public function search($number, $addr, $phone, $cell_phone, $email, $leader, $join_date, $end_date)
	{
		$sql = "";
		if($number != NULL && trim($number) != '')
		{
			$sql = $sql."number = ".$number ." AND ";
		}
		if($addr !=NULL && trim($addr) != '')
		{
			$sql = $sql."address = '".$addr."' AND ";
		}
		if($phone != NULL && trim($phone) != '')
		{
			$sql = $sql."phone = ".$phone." AND ";
		}
		if($cell_phone != NULL && trim($cell_phone) != '')
		{
			$sql = $sql."cell_phone=".$cell_phone." AND ";
		}
		if($email != NULL && trim($email) != '')
		{
			$sql = $sql."email='".$email."' AND ";
		}
		if($leader != NULL && trim($leader) != '')
		{
			$sql = $sql."leader='".$leader."' AND ";
		}
		if($join_date != NULL && trim($join_date) != '')
		{
			$sql = $sql."jion_date='".$join_date."' AND ";
		}
		if($end_date != NULL && trim($end_date) != '')
		{
			$sql = $sql."end_date='".$end_date."' AND ";
		}
		
		
		if($sql == "")
		{
			return $this->searchAll();
		}
		else
		{
		    $sql = rtrim($sql, " AND ");
	        $result = $this->where($sql)->select();
	        return $result;
		}
	}
	
	public function getCount()
	{
		$result = $this->count();
		return $result;
	}
	
	
	
	
	public function searchAll()
	{
		$result = $this->select();
		return $result;
	}
	
	public function getShopByCity($addre)
	{
		return $this->where("city ='".$addre."'")->select();
	}
}
?>