<?php 

namespace App\Services;

use App\Exceptions\UnableToParseRoster;
use App\Interfaces\RosterParserInterface;
use App\Interfaces\ParserInterface;
use Exception;
use Illuminate\Http\UploadedFile;

class RosterParser implements RosterParserInterface
{
    private string $format;
    private ParserInterface $subParser;

    private function getSubParser()
    {
        switch ($this->format) {
            case 'CCNX':    
                return app()->make(CCNXParser::class);
            // Add more cases for other formats
            default:
                throw new Exception("Unsupported format");
        }
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $format
     *
     * @return array
     */
    public function parseFile(UploadedFile $uploadedFile, string $format = "CCNX"): array
    {
        $this->format = $format;
        $this->subParser = $this->getSubParser();

        $fileContent = $uploadedFile->get();
        $type = $uploadedFile->guessClientExtension();
  
        try {
            $parsedContent = match ($type) {
                'html' => $this->subParser->parseHtml($fileContent),
                'txt' => $this->subParser->parseTxt($fileContent),
                'pdf' => $this->subParser->parsePdf($fileContent),
                'csv' => $this->subParser->parseCsv($fileContent),
            };
        } catch (\Exception $th) {
           throw new UnableToParseRoster($th->getMessage());
        }

        return $parsedContent;
    }
}