<?php


namespace Tests\Feature\Traits;


use App\Traits\ExceptionTrait;
use Tests\TestCase;

class ExceptionTraitTest extends TestCase
{
    /**
     * @covers App\Traits\ExceptionTrait::apiException
     */
    public function testApiException()
    {
        $message = 'Error message';
        $code = rand(200, 500);
        $expected = json_encode(['error' => $message]);

        $trait = $this->getMockForTrait(ExceptionTrait::class);
        $response = $trait->apiException($message, $code);

        $this->assertEquals($code, $response->getStatusCode());
        $this->assertEquals($expected, $response->getContent());
    }
}
