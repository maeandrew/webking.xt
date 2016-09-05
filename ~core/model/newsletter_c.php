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

    // Добавление категорий в рассылку
    public function addUserNewsletter($id_newsletter = false){
        $f['id_user'] = $_SESSION['member']['id_user'];
        $this->db->StartTrans();
        if(!empty($id_newsletter)){
            $f['id_newsletter'] = $id_newsletter;
            if(!$this->db->Insert(_DB_PREFIX_.'user_newsletter', $f)){
                $this->db->FailTrans();
                return false;
            }
        }else{
            $sql = "INSERT INTO "._DB_PREFIX_."user_newsletter
                    (id_user, id_newsletter) SELECT ".$_SESSION['member']['id_user'].", id
                    FROM "._DB_PREFIX_."newsletter WHERE active = 1";
            if (!$this->db->Query($sql)) {
                $this->db->FailTrans();
                return false;
            }
        }
        $this->db->CompleteTrans();
        return true;
    }

    // Удаление категорий из рассылки
    public function delUserNewsletter($id_newsletter = false){
        $this->db->StartTrans();
        if($id_newsletter === false){
            if(!$this->db->DeleteRowFrom(_DB_PREFIX_."user_newsletter", "id_user", $_SESSION['member']['id_user'])){
                $this->db->FailTrans();
                return false;
            }
        }else{
            if($this->db->DeleteRowsFrom(_DB_PREFIX_."user_newsletter", array('id_user = '.$_SESSION['member']['id_user'], 'id_newsletter = '.$id_newsletter))){
                $this->db->FailTrans();
                return false;
            }
        }
        $this->db->CompleteTrans();
        return true;
    }












}