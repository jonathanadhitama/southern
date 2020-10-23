<?php


namespace App\Services;

use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

/**
 * Class ImportCSVService Service class to quickly import CSV Data
 * @package App\Services
 */
class ImportCSVService
{
    /**
     * Importing CSV Data into a Collection Object
     * @param $path
     * @return \Illuminate\Support\Collection|null
     */
    public static function import($path)
    {
        try {
            return (new FastExcel)->import($path);
        } catch (IOException $e) {
            Log::error("Import CSV Service IOException triggered " . $e->getMessage());
        } catch (UnsupportedTypeException $e) {
            Log::error("Import CSV Service UnsupportedTypeException triggered " . $e->getMessage());
        } catch (ReaderNotOpenedException $e) {
            Log::error("Import CSV Service ReaderNotOpenedException triggered " . $e->getMessage());
        }
        return null;
    }
}
