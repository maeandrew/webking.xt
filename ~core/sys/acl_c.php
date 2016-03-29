<?php
class _acl {
	private static $rights = array(), $groups = array(), $perms = array(), $isAdmin = false;
	public static function load($gid){
		$cfg = $GLOBALS['ACL_PERMS'];
		self::$isAdmin = ($gid == 1);
		self::$rights = $cfg['rights'];
		self::$groups = $cfg['groups'];
		self::setGroup($gid); // select group
	}
	public static function isAllow($perm) {
		return self::$isAdmin ? self::$isAdmin : (isset(self::$perms[$perm]) ? (self::$perms[$perm] === 1) : false);
	}
	public static function isAdmin(){
		return self::$isAdmin;
	}
	private static function setGroup($gid){
		$group = self::$groups[$gid];
		if(is_array($group['permissions'])){
			$permissions = isset($group['inherit'])?self::inheritPerms($group['permissions'], $group['inherit']):$group['permissions'];
			// generate ACL
			for($i = 0, $c = count(self::$rights); $i < $c; $i++){
				self::$perms[self::$rights[$i]] = in_array(self::$rights[$i], $permissions)?1:0;
			}
		}else{
			// generate ACL
			for($i = 0, $c = count(self::$rights); $i < $c; $i++){
				self::$perms[self::$rights[$i]] = $group['permissions'];
			}
		}
	}
	private static function inheritPerms($perms, $gid){
		if(isset(self::$groups[$gid]['inherit'])){
			return array_merge($perms, self::inheritPerms(self::$groups[$gid]['permissions'], self::$groups[$gid]['inherit']));
		}else{
			return array_merge($perms, self::$groups[$gid]['permissions']);
		}
	}
}?>