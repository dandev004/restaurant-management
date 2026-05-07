
<?php
class ReservationController
{
    public static function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public static function validate($data)
    {
        $errors = [];
        if (empty($data['client_name']))
            $errors['client_name'] = 'name is required';
        elseif (!preg_match("/^[a-zA-Z\s]{3,50}$/", $data['client_name'])) {
            $errors['client_name'] = 'Name must contain only letters and spaces (min 3)';
        }
        if (!empty($data['client_phone'])) {
            if (!preg_match("/^\+?[0-9\s]{10,15}$/", $data['client_phone'])) {
                $errors['client_phone'] = 'Invalid phone number';
            }
        }
        if (empty($data['number_people']))
            $errors['number_people'] = 'number people is required';
        elseif (!preg_match("/^(?:[1-9]|[1-4][0-9]|50)$/", $data['number_people'])) {
            $errors['number_people'] = 'Must be between 1 and 50';
        }

        if (empty($data['table_number']))
            $errors['table_number'] = 'table number is required';
        elseif (!preg_match("/^(?:[1-9]|1[0-3])$/", $data['table_number'])) {
            $errors['table_number'] = 'Table must be between 1 and 13';
        }

        if (empty($data['reservation_date']))
            $errors['reservation_date'] = 'reservation date is required';
        elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data['reservation_date'])) {
            $errors['reservation_date'] = 'Invalid date format';
        }

        if (empty($data['start_time']))
            $errors['start_time'] = 'start time is required';
        elseif (!preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $data['start_time'])) {
            $errors['start_time'] = 'Invalid start time';
        }

        if (empty($data['end_time']))
            $errors['end_time'] = 'end time is required';
        elseif (!preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $data['end_time'])) {
            $errors['end_time'] = 'Invalid end time';
        }
        if (empty($errors['start_time']) && empty($errors['end_time'])) {
            if ($data['start_time'] >= $data['end_time']) {
                $errors['time_conflict'] = 'End time must be after start time';
            }
        }
        return $errors;
    }
}
