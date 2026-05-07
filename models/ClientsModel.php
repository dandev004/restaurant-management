<?php

class Client
{
    public static function createTableClient($data, $pdo)
    {
        $sql = "INSERT INTO table_clients (table_number, client_name, reservation_id, session_date, arrived_at, left_at) 
                VALUES (:table_number, :client_name, :reservation_id, :session_date, :arrived_at, :left_at)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':table_number' => $data['table_number'],
            ':client_name' => $data['client_name'],
            ':reservation_id' => $data['reservation_id'],
            ':session_date' => $data['session_date'],
            ':arrived_at' => $data['arrived_at'],
            ':left_at' => $data['left_at']
        ]);

        return $stmt->rowCount();
    }
}
