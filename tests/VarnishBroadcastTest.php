<?php

use Emgag\VarnishBroadcast\Request;
use League\JsonGuard\Validator;
use PHPUnit\Framework\TestCase;

/**
 * Class VarnishBroadcastTest.
 */
class VarnishBroadcastTest extends TestCase
{
    /**
     * Test if request object correctly serialize to JSON.
     */
    public function testSerialize()
    {
        $hostname = 'example.org';
        $json = [];

        // ban
        $json[] = (string) (new Request\Ban($hostname, 'whatever'));
        $json[] = (string) (new Request\Ban($hostname, ['still', 'flying']));
        // ban.url
        $json[] = (string) (new Request\BanURL($hostname, 'whatever'));
        $json[] = (string) (new Request\BanURL($hostname, ['still', 'flying']));
        // purge
        $json[] = (string) (new Request\Purge($hostname, 'whatever'));
        $json[] = (string) (new Request\Purge($hostname, ['still', 'flying']));
        // xkey
        $json[] = (string) (new Request\Xkey($hostname, 'whatever'));
        $json[] = (string) (new Request\Xkey($hostname, ['still', 'flying']));
        // xkey.soft
        $json[] = (string) (new Request\XkeySoft($hostname, 'whatever'));
        $json[] = (string) (new Request\XkeySoft($hostname, ['still', 'flying']));

        // validate json
        $schema = json_decode(file_get_contents(__DIR__.'/files/request.json'));

        foreach ($json as $request) {
            $validator = new Validator(json_decode($request), $schema);
            $this->assertFalse($validator->fails());
        }
    }
}
