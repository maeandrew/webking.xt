<?php
class Newsletter{
    public $db;
    public function __construct(){
        $this->db =& $GLOBALS['db'];
    }

    public function getNewsletterByIdUser($id_user){
        $sql = "SELECT n.id, n.title,
                (CASE WHEN un.id_user IS NOT NULL THEN 1 ELSE 0 END) AS enable
                FROM "._DB_PREFIX_."newsletter n
                LEFT JOIN "._DB_PREFIX_."user_newsletter un
                ON n.id = un.id_newsletter AND un.id_user = ".$id_user."
                WHERE n.active = 1
                ORDER BY n.id";
        $arr = $this->db->GetArray($sql);
        if(!$arr){
            return false;
        }
        return $arr;
    }

    public function addUserNewsletter(){
        $sql = "";

    }













}