<?php
require_once('db.php');
require_once('manager.php');
class dead_manager extends Manager
{

    public static function get_necrologio()
    {
        return db::run_query("SELECT * FROM dead ORDER BY death_date desc LIMIT 15");

    }
    public static function get_by_name_surname($search_text)
    {
        $search_text = $search_text . '%';
        return db::run_query("SELECT * FROM dead WHERE name LIKE UPPER(?) OR surname LIKE UPPER(?) ORDER BY death_date desc", $search_text, $search_text);

    }
    public static function delete($id = null)
    {
        $dead_img = dead_manager::get_by_id($id);
        if ($dead_img === False)
            return 'Errore nel database';
        $dead_img = $dead_img[0]['img'];
        db::run_query("delete FROM cordoglio where dead_id = ?", $id);
        db::run_query("delete FROM dead where id = ?", $id);
        if (file_exists($dead_img)) {
            unlink($dead_img);
            unlink(substr($dead_img, 0, -4) . "png");
        } else {
            return 'Immagine non trovata';
        }
        return '';
    }

    public static function add($name = null, $surname = null, $born_date = null, $death_date = null, $reminder_phrase = null, $img = null)
    {
        //get image type
        $img_type = $img['type'];

        if ($img_type == "image/jpeg") {
            $img_type = "jpg";
        } else if ($img_type == "image/png") {
            $img_type = "png";
        } else if ($img_type == "image/webp") {
            $img_type = "webp";
        }

        //upload image
        $name_s = str_replace(" ", "", $name);
        $surname_s = str_replace(" ", "", $surname);
        $img_name = $death_date . $name_s . $surname_s;
        $img_path = "necrologio/" . $img_name;
        $no_error = dead_manager::add_db($name, $surname, $born_date, $death_date, $reminder_phrase, $img_path . ".webp");
        if ($no_error !== True) {
            return $no_error;
        } else {
            move_uploaded_file($img['tmp_name'], ($img_path . '.' . $img_type));

            // Create and save
            if ($img_type == "png") {
                $img = imagecreatefrompng("necrologio/" . $img_name . '.' . $img_type);
            } else if ($img_type == "jpg") {
                $img = imagecreatefromjpeg("necrologio/" . $img_name . '.' . $img_type);
            } else if ($img_type == "webp") {
                $img = imagecreatefromwebp("necrologio/" . $img_name . '.' . $img_type);
            } else {
                return 'Formato immagine non supportato';
            }

            $img = imagescale($img, 512);
            imagewebp($img, $img_path . ".webp", 100);
            imagedestroy($img);
            if ($img_type != "webp") {
                unlink($img_path . '.' . $img_type);
            }

            $img = imagecrop($img, ['x' => 0, 'y' => floor(imagesy($img) / 4) - 125, 'width' => 512, 'height' => 256]);
            imagepng($img, $img_path . ".png", 9);
        }
        return '';
    }
    public static function update($id = null, $name = null, $surname = null, $born_date = null, $death_date = null, $reminder_phrase = null, $img = null)
    {
        //unlink image of same id in db
        if (isset($img)) {
            $dead_img = dead_manager::get_by_id($id);
            if ($dead_img && isset($img['tmp_name'])) {
                $dead_img = $dead_img[0]['img'];
                if (file_exists($dead_img))
                    unlink($dead_img);
            }
        } else {
            $dead_img = dead_manager::get_by_id($id);
            if ($dead_img) {
                $img = $dead_img[0]['img'];
                $no_error = dead_manager::update_db($id, $name, $surname, $born_date, $death_date, $reminder_phrase, $img);
                if ($no_error !== True)
                    return $no_error;
            }
            return null;
        }

        //get image type
        $img_type = $img['type'];
        if ($img_type == "image/jpeg") {
            $img_type = "jpg";
        } else if ($img_type == "image/png") {
            $img_type = "png";
        } else if ($img_type == "image/webp") {
            $img_type = "webp";
        }
        //upload image
        $name_s = str_replace(" ", "", $name);
        $surname_s = str_replace(" ", "", $surname);
        $img_name = $death_date . $name_s . $surname_s;
        $img_path = "necrologio/" . $img_name;
        $no_error = dead_manager::update_db($id, $name, $surname, $born_date, $death_date, $reminder_phrase, $img_path . ".webp");
        if ($no_error !== True)
            return $no_error;
        else {
            move_uploaded_file($img['tmp_name'], ($img_path . '.' . $img_type));
            // Create and save
            if ($img_type == "png") {
                $img = imagecreatefrompng("necrologio/" . $img_name . '.' . $img_type);
            } else if ($img_type == "jpg") {
                $img = imagecreatefromjpeg("necrologio/" . $img_name . '.' . $img_type);
            } else if ($img_type == "webp") {
                $img = imagecreatefromwebp("necrologio/" . $img_name . '.' . $img_type);
            } else if ($img == null) {
                return null;
            } else {
                return 'Formato immagine non supportato';
            }
            $img = imagescale($img, 512);
            imagewebp($img, $img_path . ".webp", 100);
            imagedestroy($img);
            if ($img_type != "webp") {
                unlink($img_path . '.' . $img_type);
            }
            $img = imagecrop($img, ['x' => 0, 'y' => floor(imagesy($img) / 4) - 125, 'width' => 512, 'height' => 256]);
            imagepng($img, $img_path . ".png", 9);
        }
        return null;
    }

    public static function update_db($id = null, $name = null, $surname = null, $born_d = null, $death_d = null, $rem = null, $img = null)
    {
        if (self::is_name_surname($name) !== true)
            return self::is_name_surname($name);
        if (self::is_name_surname($surname) !== true)
            return self::is_name_surname($surname);
        if (self::is_date($born_d) !== true)
            return self::is_date($born_d);
        if (self::is_date($death_d) !== true)
            return self::is_date($death_d);
        if (self::is_description($rem) !== true)
            return self::is_description($rem);
        if (self::is_img($img) !== true)
            return self::is_img($img);
        if (self::is_date_before_second($death_d, $born_d) !== true)
            return self::is_date_before_second($death_d, $born_d);

        db::run_query("UPDATE dead SET name = ?, surname = ?, born_date = ?, death_date = ?, reminder_phrase = ?, img = ? WHERE id = ?", $name, $surname, $born_d, $death_d, $rem, $img, $id);
        return True;
    }

    private static function add_db($name, $surname, $born_d, $death_d, $rem, $img)
    {
        if (self::is_name_surname($name) !== true)
            return self::is_name_surname($name);
        if (self::is_name_surname($surname) !== true)
            return self::is_name_surname($surname);
        if (self::is_date($born_d) !== true)
            return self::is_date($born_d);
        if (self::is_date($death_d) !== true)
            return self::is_date($death_d);
        if (self::is_description($rem) !== true)
            return self::is_description($rem);
        if (self::is_img($img) !== true)
            return self::is_img($img);
        if (self::is_date_before_second($death_d, $born_d) !== true)
            return self::is_date_before_second($death_d, $born_d);

        db::run_query("INSERT INTO dead (name,surname,born_date,death_date,reminder_phrase,img) values (?,?,?,?,?,?);", $name, $surname, $born_d, $death_d, $rem, $img);
        return True;
    }

    public static function get_by_id($id)
    {
        return db::run_query("SELECT * FROM dead where id = ?", $id);
    }
    public static function get()
    {
        return db::run_query("SELECT * FROM dead");
    }
    public static function get_first()
    {
        return db::run_query("SELECT * FROM dead ORDER BY death_date desc, id desc LIMIT 1");
    }

    public static function get_last_id()
    {
        return db::run_query("SELECT * FROM dead ORDER BY id desc LIMIT 1");
    }

    public static function is_name_surname($name)
    {
        // Check if the name is not empty
        if (!empty($name)) {
            // Check if the name only contains letters and spaces
            if (preg_match('/^[a-zA-Z ]*$/', $name)) {
                // Check if the name is no longer than 20 characters
                if (strlen($name) <= 20) {
                    return true;
                } else {
                    return 'The name cannot be longer than 20 characters';
                }
            } else {
                return 'The name can only contain letters and spaces name: ' . $name . " |";
            }
        } else {
            return 'The name cannot be empty';
        }
    }

    public static function is_date($dateString)
    {
        // Match the date against a list of possible formats
        $formats = array(
            'Y-m-d',
            'm/d/Y',
            'd/m/Y',
            'Y/m/d',
            'd.m.Y',
            'Y.m.d',
        );

        // Iterate over the formats and try to parse the date
        foreach ($formats as $format) {
            // Use the DateTime::createFROMFormat() function to parse the date
            $date = DateTime::createFROMFormat($format, $dateString);
            if ($date !== false) {
                // The date was successfully parsed
                return true;
            }
        }

        // If we reach this point, the date was not successfully parsed
        return 'The date is not a valid format';
    }
    public static function is_date_before_second($firstDateString, $secondDateString)
    {
        // Match the dates against a list of possible formats
        $formats = array(
            'Y-m-d',
            'm/d/Y',
            'd/m/Y',
            'Y/m/d',
            'd.m.Y',
            'Y.m.d',
        );

        // Iterate over the formats and try to parse the dates
        foreach ($formats as $format) {
            // Use the DateTime::createFROMFormat() function to parse the first date
            $firstDate = DateTime::createFROMFormat($format, $firstDateString);
            if ($firstDate === false) {
                // The first date was not successfully parsed, try the next format
                continue;
            }

            // Use the DateTime::createFROMFormat() function to parse the second date
            $secondDate = DateTime::createFROMFormat($format, $secondDateString);
            if ($secondDate === false) {
                // The second date was not successfully parsed, try the next format
                continue;
            }

            // If we reach this point, the dates were both successfully parsed
            // Use the DateTime::diff() function to compare the dates
            $difference = $firstDate->diff($secondDate);

            // Check if the difference is negative (i.e. the first date is before the second date)
            if ($difference->invert === 1 || $firstDate == $secondDate) {
                return true;
            } else {
                return 'The first date is not before the second date';
            }
        }

        // If we reach this point, the dates were not successfully parsed
        return 'The dates are not a valid format';
    }

    public static function timestamp_to_date_italian($date)
    {
        $months = array(
            '01' => 'Gennaio',
            '02' => 'Febbraio',
            '03' => 'Marzo',
            '04' => 'Aprile',
            '05' => 'Maggio',
            '06' => 'Giugno',
            '07' => 'Luglio',
            '08' => 'Agosto',
            '09' => 'Settembre',
            '10' => 'Ottobre',
            '11' => 'Novembre',
            '12' => 'Dicembre'
        );
        $day = date_format($date, 'd');
        $month = $months[date_format($date, 'm')];
        $year = date_format($date, 'Y');
        return $day . " " . $month . " " . $year;
    }


    public static function is_description($description)
    {
        if (strlen($description) > 500)
            return "La descrizione può essere lunga al massimo 500 caratteri";
        return True;
    }
    public static function is_img($path)
    {
        //if (preg_match('/^\.{1,2}\//', $path) || preg_match('/^\/.*/', $path) || preg_match('/^[a-zA-Z]:\\\\.*/', $path)) {
        // The path is a relative or absolute path
        // Check if the path has a valid image extension
        if (preg_match('/\.(webp|jpg|png)$/i', $path)) {
            // The path has a valid image extension
            return true;
        } else {
            return "Inserisci un immagine valida";
        }
        //} else {
        //    return "Inserisci un percorso valido";
        //}
    }



}

?>