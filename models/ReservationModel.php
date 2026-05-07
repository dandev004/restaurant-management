<?php
class Reservation
{
    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM reservations";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($clientName, $clientPhone, $numberPeople, $tableNumber, $reservationDate, $startTime, $endTime, $pdo)
    {
        $clientPhone = $clientPhone ?? '';
        $sql = "INSERT INTO reservations (client_name, client_phone, number_people, table_number, reservation_date, start_time , end_time ) VALUES
                                          (:client_name, :client_phone, :number_people, :table_number, :reservation_date, :start_time , :end_time)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':client_name', $clientName);
        $stmt->bindParam(':client_phone', $clientPhone);
        $stmt->bindParam(':number_people', $numberPeople);
        $stmt->bindParam(':table_number', $tableNumber);
        $stmt->bindParam(':reservation_date', $reservationDate);
        $stmt->bindParam(':start_time', $startTime);
        $stmt->bindParam(':end_time', $endTime);
        $stmt->execute();
    }

    public static function getReservationsByTableAndDate($tableNumber, $reservationDate, $pdo)
    {
        $sql = "SELECT start_time, end_time FROM reservations 
                WHERE table_number = :table_number 
                AND reservation_date = :reservation_date";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':table_number', $tableNumber);
        $stmt->bindParam(':reservation_date', $reservationDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data, $pdo)
    {
        $sql = "UPDATE reservations 
            SET client_name = :client_name,
                client_phone = :client_phone,
                number_people = :number_people,
                table_number = :table_number,
                reservation_date = :reservation_date,
                start_time = :start_time,
                end_time = :end_time,
                status = :status
            WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':client_name' => $data['client_name'],
            ':client_phone' => $data['client_phone'],
            ':number_people' => $data['number_people'],
            ':table_number' => $data['table_number'],
            ':reservation_date' => $data['reservation_date'],
            ':start_time' => $data['start_time'],
            ':end_time' => $data['end_time'],
            ':status' => $data['status']
        ]);
    }

    public static function delete($id, $pdo)
    {
        $sql = "DELETE FROM reservations WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public static function getById($id, $pdo)
    {
        $sql = "SELECT * FROM reservations WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
