<?php
class chats
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }


    public function fetch_user_chat_history($from_user_id, $to_user_id)
    {
        $this->db->query("SELECT * FROM chats WHERE (idFromUser = :fromUser AND idToUser = :toUser)
        OR (idFromUser = :toUser AND idToUser = :fromUser) ORDER BY timestamp DESC");

        $this->db->bind(':fromUser', $from_user_id);
        $this->db->bind(':toUser', $to_user_id);

        $result = $this->db->getData();

        $output = '<ul class="list-unstyled">';
        foreach ($result as $row) {
            $user_name = '';
            if ($row["idFromUser"] == $from_user_id) {
                $user_name = '<b class="text-success">Tu</b>';
            } else {
                $this->db->query("SELECT usuario FROM usuarios WHERE idusuario = :userId");
                $this->db->bind(':userId', $row['idFromUser']);
                $resultado = $this->db->getData();
                foreach ($resultado as $rowData) {
                    $user_name = '<b class="text-danger">' . $rowData['usuario'] . '</b>';
                }
            }

            $output .= '<li style="border-bottom:1px dotted #ccc">
                            <p>' . $user_name . ' - ' . $row["chatMessage"] . '
                                <div align="right"> - <small><em>' . $row['timestamp'] . '</em></small></div>
                            </p>
                        </li>';
        }
        $output .= '</ul>';

        $this->db->query("UPDATE chats SET status = '0' WHERE idFromUser = :fromUser AND idToUser = :toUser AND status = '1'");
        $this->db->bind(':fromUser', $from_user_id);
        $this->db->bind(':toUser', $to_user_id);
        $this->db->execute();

        return $output;
    }

    public function insertChat($toUser, $fromUser, $message)
    {
        $this->db->query("INSERT INTO chats (idToUser, idFromUser, chatMessage, status) VALUES (:toUser, :fromUser, :messagetext, '1')");
        $this->db->bind(':toUser', $toUser);
        $this->db->bind(':fromUser', $fromUser);
        $this->db->bind(':messagetext', $message);
        return $this->db->execute();
    }
}
