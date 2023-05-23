<?php


class Notification{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllNotificationsByUserId($user_id){
        $this->db->query("SELECT * FROM notification LEFT JOIN notification_type on notification_type.id = notification.type WHERE receiver_id = :receiver_id ORDER BY notification.id DESC;");
        $this->db->bind(':receiver_id', $user_id);
        $result = $this->db->resultSet();
        return $result;
    }

    public function checkNotifications($user_id){
        $this->db->query("SELECT * FROM notification WHERE receiver_id = :receiver_id AND status = 0");
        $this->db->bind(':receiver_id', $user_id);
        $result = $this->db->resultSet();
        return $result;
    }

    public function saveNotification($data){
        $this->db->query("INSERT INTO notification (receiver_id, sender_id, type, tweet_id) VALUES(:receiver_id, :sender_id, (SELECT id FROM notification_type WHERE type = :type), :tweet_id)");

        $this->db->bind(':receiver_id', $data['receiver_id']);
        $this->db->bind(':sender_id', $data['sender_id']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':tweet_id', $data['tweet_id']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }

    }
}