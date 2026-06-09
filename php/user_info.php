<?php 
// user class to get user info from database
class User {
    private $id = null;
    private $username = null;
    private $name = null;
    private $total_repo = 0;
    private $total_followers = 0;
    private $total_stars = 0;
    private $total_unread = 0;

    public function __construct($id, $conn){
        $this->id = $id;
        $query = "SELECT
                    u.name,
                    u.user_name,
                    (SELECT COUNT(*) FROM repo WHERE repo.creator = u.id) AS repo_count,
                    (SELECT COUNT(*) FROM stars WHERE stars.repo_id IN (SELECT id FROM repo WHERE creator = u.id)) AS stars_got,
                    (SELECT COUNT(*) FROM follower WHERE follower.who_is_being_followed = u.id) AS follower_count,
                    (SELECT COUNT(*) FROM notification WHERE notification.who_got = u.id AND notification.is_read = 0) AS unread_notif
                FROM user u
                WHERE u.id = '$id';";
        $result = mysqli_query($conn , $query);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $this->username = $row['user_name'];
            $this->name = $row['name'];
            $this->total_repo = $row['repo_count'];
            $this->total_followers = $row['follower_count'];
            $this->total_stars = $row['stars_got'];
            $this->total_unread = $row['unread_notif'];
        }

    }

    public function getUsername(){
        return $this->username;
    }

    public function getName(){
        return $this->name;
    }

    public function getTotalRepo(){
        return $this->total_repo;
    }

    public function getTotalFollowers(){
        return $this->total_followers;
    }

    public function getTotalStars(){
        return $this->total_stars;
    }

    public function getTotalUnread(){
        return $this->total_unread;
    }
}
?>