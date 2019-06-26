<?php

namespace backend\components;

use League\Csv\Reader;
use League\Csv\Exception;
use League\Csv\Statement;

/**
 * Class ParserCsvService
 * @package backend\components
 */
class ParserCsvService
{
    /**
     * @param string $file
     * @param int $subdomain
     * @return bool
     * @throws Exception
     */
    public function parse(string $file, int $subdomain): bool
    {
        $csv = Reader::createFromPath($file);
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        $records = (new Statement())->process($csv);

        foreach ($records->getRecords() as $record) {
            $product = new ProductRecordCsv($record, $subdomain);
            $product->save();
        }

        return true;
    }
}
