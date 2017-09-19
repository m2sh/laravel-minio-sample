<?php

namespace Tests\Unit;

use Aws\StorageGateway\StorageGatewayClient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Storage;

class MinioStorageTest extends TestCase
{
    /**
     * test create new file.
     *
     * @return void
     */
    public function testCreateNewFile()
    {
        $created = Storage::disk('minio')->put('/test.txt','Hello World!');
        $this->assertTrue($created);
    }

    public function textCheckFileExists()
    {
        $exists = Storage::disk('minio')->exists('/test.txt');
        $this->assertTrue($exists);
    }

    public  function testFileSize()
    {
        $size = Storage::disk('minio')->size('/test.txt');
        $this->assertEquals($size,12);
    }

    public function testReadFile()
    {
        $text = 'Hello World!';

        $readedFile = Storage::disk('minio')->get('/test.txt');

        $this->assertEquals($text, $readedFile);
    }

    public function testGetFiles()
    {
        $files = Storage::disk('minio')->files('/');

        $this->assertCount(1,$files);
        $this->assertNotNull($files);
    }

    public function testGetUrl()
    {
        $url = Storage::disk('minio')->url('/test.txt');

        $this->assertContains('http://', $url);
    }

    public function testDeleteFile()
    {
        $deleted = Storage::disk('minio')->delete('/test.txt');
        $this->assertTrue($deleted);

        $notExistsFile = Storage::disk('minio')->exists('/test.txt');
        $this->assertFalse($notExistsFile);
    }


}
