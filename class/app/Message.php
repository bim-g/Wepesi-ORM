<?php
class Message{
    private $db;

    function __construct()
    {
        $this->db=DB::getInstance();
    }
    function getMessage()
    {
        try {
            $req = $this->db->get("message")->fields(['userid','message'])->where(['userid',"=",1]);
            return [
                "result"=>$req->result(),
                "total"=>$req->count()
            ];
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    function sendMessage(array $data)
    {
        try {
            $this->db->insert("message")->fields($data)->result();
            if ($this->db->error()) {
                throw new Exception("impossible d'enregister ce message");
            }
            return $this->db->lastId();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    function deleteMessage(array $data)
    {
        try {
            $req=$this->db->delete("message")->where($data)->result();
            if ($this->db->error()) {
                throw new Exception($this->db->error());
            }
            return ["row deleted"=>$this->db->count()];
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    function SelectOneMessage(){
        try{
            $req = $this->db->query("select * from message join users on users.id=message.userid");
            if($req->error()){
                throw new Exception($req->error());
            }
            return $req->result();
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }
    function updateMessage(array $data,array $where){
        try{
            $req = $this->db->update("message")->fields($data)->where($where)->result();
            if($this->db->error()){
                throw new Exception($req->error());
            }
            return ["row updated"=>$this->db->count()];
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }
}