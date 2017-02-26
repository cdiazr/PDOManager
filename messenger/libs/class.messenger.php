<?php

class Messenger extends PDOManager 
{
	const USERTABLE = 'usuarios';
	const MSGTABLE = 'messages';

	function __construct()
	{
		parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_CONN);
	}

	public function getIndex($id, $way)
	{
		$subSelect = ['Username'];

		$this->where('UserID', 'messages.ToUserID');
		$subQueryColumn1 = $this->subQueryAsColumn(self::USERTABLE, $subSelect, 'ToUser');

		$this->where('UserID', 'messages.FromUserID');
		$subQueryColumn2 = $this->subQueryAsColumn(self::USERTABLE, $subSelect, 'FromUser');

		$field = ($way == 'e')? 'ToUserID' : 'FromUserID';

		$this->where($field, $id);
		$select = ['MsgID', $subQueryColumn1, $subQueryColumn2, 'MsgRead', 'date', 'subject', 'msg'];
		return $this->get(self::MSGTABLE, $select);
	}

	public function postStore($data)
	{
		unset($data['enviar']);

		$user = $this->checkUserExist($data['ToUserID']);

		$rawDate = new Datetime(date("Y-m-d H:i:s"));
		$data = array_merge($data, [
			'ToUserID' => $user['UserID'],
			'date' => $rawDate->format('Y-m-d h:m:s')
		]);

		$this->insert(self::MSGTABLE, $data);
	}

	public function showMessage($id)
	{	
		$subSelect = ['Username'];

		$this->where('UserID', 'messages.ToUserID');
		$subQueryColumn1 = $this->subQueryAsColumn(self::USERTABLE, $subSelect, 'ToUser');

		$this->where('UserID', 'messages.FromUserID');
		$subQueryColumn2 = $this->subQueryAsColumn(self::USERTABLE, $subSelect, 'FromUser');

		$select = [$subQueryColumn1, $subQueryColumn2, 'date', 'subject', 'msg'];
		$this->where('MsgID', $id);
		return $this->get(self::MSGTABLE, $select)[0];
	}	

	public function getMessages($id, $all = 1, $count = 0, $debug = null)
	{
		$this->where('toUserID', $id);

		if($all == 0)
			$this->where('MsgRead', 0);

		$msgs = $this->get(self::MSGTABLE, null, $debug);

		if(!empty($msgs)) {
			if($count == 0)
				return $msgs;

			return count($msgs);
		} else
			return 0;
	}

	public function checkUserExist($username, $debug = null)
	{
		$this->where('Username', $username);
		return $this->get(self::USERTABLE, null, $debug)[0];
	}

	public function getUsers()
	{
		$select = ['Username'];
		$r = $this->get(self::USERTABLE, $select);
		$qty = count($r);

		$i = 1;
		$users = '';
		foreach($r as $user) {
			foreach($user as $key => $value) {
				$users .= $i == $qty ? $value : $value . ', ';
				$i++;
			}
		}

		return $users;
	}
}