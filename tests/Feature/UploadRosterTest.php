<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UploadRosterTest extends TestCase
{
    /**
     * Test can upload a roster
     */
    public function test_can_upload_roster(): void
    {
        $fileContent = $this->generate_valid_roster_content();

        // Save the file content to a fake file
        $file = UploadedFile::fake()->createWithContent('roster.html', $fileContent);

        $response = $this->postJson(route('api.roster.upload'), ['roster' => $file]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'message']);
    }

    /**
     * Generate valid roster content for upload
     */
    private function generate_valid_roster_content()
    {
        $dates = ['Mon 10', 'Tue 11', 'Wed 12', 'Thu 13', 'Fri 14', 'Sat 15', 'Sun 16', 'Mon 17', 'Tue 18', 'Wed 19', 'Thu 20'];

        $tableContent = [
            ['Date', 'From', 'To', 'STD(Z)', 'STA(Z)', 'Activity', 'ACReg']
        ];
        
        foreach ($dates as $date) {
            $tableContent[] = [
                $date,
                fake()->city,
                fake()->city,
                fake()->time('H:i', 'now'),
                fake()->time('H:i', 'now'),
                'DX' . fake()->numberBetween(70, 89),
                strtoupper(fake()->lexify('???')) . fake()->numberBetween(100, 999)
            ];
        }

        $content = '<select><option selected="" value="2022-01-10|2022-01-23">WEEK 2/3 (10Jan22..23Jan22)</option></select>';
        
        $content .= '<table>';
        foreach ($tableContent as $row) {
            $content.= '<tr>';
            foreach ($row as $cell) {
                $content .= '<td>' . $cell . '</td>';
            }
            $content .= '</tr>';
        }
        $content .= '</table>';

        return $content;
    }
}
