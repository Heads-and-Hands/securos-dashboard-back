<?php

namespace Database\Seeders;

use App\Models\ApiV1\VideoCamera;
use Illuminate\Database\Seeder;

class VideoCamerasSeeder extends Seeder
{
    private const IPS = [
        '172.217.22.14',
        '172.217.22.15',
        '172.217.22.16',
        '172.217.22.22',
        '172.217.22.44',
        '172.217.22.55',
        '172.217.22.77',
        '172.217.22.23',
    ];

    private const TYPE = [
        10, 20
    ];

    private const STATUS = [
        10, 20, 30, 40
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $i = 1;
        while ($i <= 100):
            $id = random_int(1, 500);
            $ip = self::IPS[array_rand(self::IPS)];
            $ipServer = self::IPS[array_rand(self::IPS)];
            VideoCamera::updateOrCreate(
                ['id' => $id],
                [
                    'id' => $id,
                    'name' => 'AHD 2Мп Ps-Link KIT-C204HD V-'.random_int(1, 50),
                    'ip' => $ip,
                    'type' => self::TYPE[array_rand(self::TYPE)],
                    'ip_decode' => $ip,
                    'ip_server' => $ipServer,
                    'ip_server_decode' => $ipServer,
                    'status' => self::STATUS[array_rand(self::STATUS)],
                    'status_exploitation' => self::TYPE[array_rand(self::TYPE)],
                ]
            );
            $i++;
        endwhile;
    }
}
